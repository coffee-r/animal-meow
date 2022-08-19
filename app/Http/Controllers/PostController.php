<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Animal;
use App\CoffeeR\UseCases\PostStoreAction;
use App\CoffeeR\UseCases\TweetAction;
use Exception;

class PostController extends Controller
{
    /**
     * 新規投稿画面
     *
     * @return void
     */
    public function create()
    {
        // 投稿に利用できる言葉を動物ごとに取得する
        $animals = Animal::all();

        return Inertia::render('Post', [
            'animals' => $animals,
        ]);
    }

    /**
     * 投稿アクション
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request, PostStoreAction $postStoreAction, TweetAction $tweetAction)
    {
        // フォームバリデーション
        $validated = $request->validate([
            'animalId' => 'required',
            'message' => 'required|max:120',
        ],[
            'animalId.required' => '動物を選択してください',
            'message.required' => '投稿メッセージを入力してください',
            'message.max' => '投稿メッセージは最大120文字までです',
        ]);

        // フラッシュメッセージ用変数
        $successMessages = [];
        $failMessages = [];

        // トランザクション
        // このサービスの投稿もツイートも成功 ⇨ コミット
        // このサービスの投稿が失敗 ⇨ ロールバック
        // このサービスの投稿は成功してツイートが失敗 ⇨ ロールバック
        DB::beginTransaction();

        try{
            // 新規投稿処理
            $postStoreAction($request->input('animalId'), $request->input('message'));
            $successMessages[] = "投稿しました。";

            // ツイート
            if ($request->input('withTweet')) {
                $tweet = $tweetAction($request->input('message'));
                $successMessages[] = "<a class='underline' href='".$tweet->url."' target='_blank'>Twitter</a>に投稿しました。";
            }
        }catch(Exception $e){
            // エラーログ書き込み
            Log::error($e->getMessage());

            // フラッシュメッセージ設定
            $failMessages[] = "投稿に失敗しました。";
            var_dump($e->getMessage());exit();
            
            // ホーム画面にリダイレクト
            return redirect('/home')->with('failMessages', $failMessages);
        }

        // コミット
        DB::commit();

        // ホーム画面にリダイレクト
        return redirect('/home')->with('successMessages', $successMessages);
    }

    /**
     * 投稿削除
     *
     * @param [type] $id posts.id
     * @return void
     */
    public function destroy($id)
    {
        // 投稿を取得
        $post = Post::find($id);

        // 存在しない投稿は削除できない
        if (!$post) {
            throw new Exception('post.id ' . $id . " not exist");
        }

        // 他人の投稿は削除できない
        if ($post->user_id !== Auth::id()) {
            throw new Exception('post.id ' . $id . " post can only be deleted user_id ".$post->user_id);
        }

        // 投稿を削除
        $post->delete();

        // ホーム画面にリダイレクト
        return redirect(url()->previous())->with('successMessages', ['投稿を削除しました。']);
    }
}
