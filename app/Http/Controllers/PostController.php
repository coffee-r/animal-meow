<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
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
    public function create()
    {
        $animals = [
            1 => ['name' => 'ネコ', 'availableWords' => CatMessage::AVAILABLE_WORDS],
            2 => ['name' => 'イヌ', 'availableWords' => DogMessage::AVAILABLE_WORDS],
            3 => ['name' => 'ゴリラ', 'availableWords' => GoriraMessage::AVAILABLE_WORDS],
        ];

        return Inertia::render('Post', [
            'animals' => $animals,
        ]);
    }

    public function store(Request $request)
    {
        // フォームバリデーション
        $validated = $request->validate([
            'animalTypeId' => 'required',
            'message' => 'required|max:120',
        ]);

        // フラッシュメッセージ用変数
        $successMessages = [];

        // 値オブジェクトを通じて投稿メッセージをバリデーション
        $animalMessageFactory = new AnimalMessageFactory();
        $animalMessage = $animalMessageFactory->create($request->input('animalTypeId'), $request->input('message'));

        // 投稿
        $post = new Post();
        $post->user_id = Auth::id();
        $post->animal_type_id = $request->input('animalTypeId');
        $post->message = $animalMessage->toString();
        $post->save();
        $successMessages[] = "投稿しました。";

        // ツイート
        if($request->input('withTweet')){
            $tweetRepository = new TweetRepository();
            $tweetResult = $tweetRepository->tweet($animalMessage->toString() . " #あにまるにゃ〜ん");
            $successMessages[] = "<a class='underline' href='".$tweetResult['tweetLink']."' target='_blank'>Twitter</a>に投稿しました。";
        }

        return redirect('/home')->with('successMessages', $successMessages);
    }

    public function destroy(Request $request)
    {
        // フォームバリデーション
        $validated = $request->validate([
            'post-id' => 'required'
        ]);

        // 投稿を取得
        $post = Post::find($request->input('post-id'));

        // 存在しない投稿は削除できない
        if(!$post){
            throw new Exception('post_id ' . $request->input('post-id') . " not exist");
        }

        // 他人の投稿は削除できない
        if($post->user_id !== Auth::id()){
            throw new Exception('post_id ' . $request->input('post-id') . " post can only be deleted user_id ".$post->user_id);
        }

        // 投稿を削除
        $post->delete();        

        return redirect('/home')->with('flash_success_messages', ['投稿を削除しました。']);
    }
}
