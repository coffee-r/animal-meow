<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;
use App\Models\Post;
use App\CoffeeR\Post\Domain\AnimalMessageFactory;
use App\CoffeeR\Post\Domain\CatMessage;
use App\CoffeeR\Post\Domain\DogMessage;
use App\CoffeeR\Post\Domain\GoriraMessage;
use App\CoffeeR\Post\Repository\TweetRepository;
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
        $animals = [
            1 => ['name' => 'ネコ', 'availableWords' => CatMessage::AVAILABLE_WORDS],
            2 => ['name' => 'イヌ', 'availableWords' => DogMessage::AVAILABLE_WORDS],
            3 => ['name' => 'ゴリラ', 'availableWords' => GoriraMessage::AVAILABLE_WORDS],
        ];

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
    public function store(Request $request)
    {
        // フォームバリデーション
        $validated = $request->validate([
            'animalTypeId' => 'required',
            'message' => 'required|max:120',
        ],[
            'animalTypeId.required' => '動物を選択してください',
            'message.required' => '投稿メッセージを入力してください',
            'message.max' => '投稿メッセージは最大120文字までです',
        ]);

        // フラッシュメッセージ用変数
        $successMessages = [];

        // 値オブジェクトを通じて投稿メッセージをバリデーション
        $animalMessageFactory = new AnimalMessageFactory();
        $animalMessage = $animalMessageFactory->create($request->input('animalTypeId'), $request->input('message'));

        // トランザクション
        DB::beginTransaction();

        // 投稿
        $post = new Post();
        $post->user_id = Auth::id();
        $post->animal_type_id = $request->input('animalTypeId');
        $post->message = $animalMessage->toString();
        $post->save();
        $successMessages[] = "投稿しました。";

        // ツイート
        if ($request->input('withTweet')) {
            $tweetRepository = new TweetRepository();
            $tweetResult = $tweetRepository->tweet($animalMessage->toString() . " #あにまるにゃ〜ん");
            $successMessages[] = "<a class='underline' href='".$tweetResult['tweetLink']."' target='_blank'>Twitter</a>に投稿しました。";
        }

        // コミット
        DB::commit();

        // 削除元の画面にリダイレクト
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
