<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Exception;
use Illuminate\Support\Facades\Auth;

class LikeApiController extends Controller
{
    /**
     * 投稿にいいねをする
     *
     * @param [type] $posts.id
     * @param Request $request
     * @return void
     */
    public function upsert($post_id, Request $request)
    {
        // 投稿を取得
        $post = Post::find($post_id);

        // 存在しない投稿にはいいねはできない
        if (empty($post)) {
            throw new Exception("post_id " . $post_id . " not found.");
        }

        // ユーザーのいいねを取得
        $like = Like::where('post_id', $post_id)
                    ->where('user_id', Auth::id())
                    ->first();

        // トランザクション
        DB::beginTransaction();

        // 投稿のtotalいいねを+1
        $post->like_total_count += 1;
        $post->update();

        // ユーザーのいいねが既にある場合はいいねを+1、
        // ユーザーのいいねが既にある場合は新規作成
        if ($like) {
            $like->like_count += 1;
            $like->update();
        } else {
            $like = new Like();
            $like->user_id = Auth::id();
            $like->post_id = $post_id;
            $like->like_count = 1;
            $like->save();
        }

        // コミット
        DB::commit();

        // レスポンス
        return response('', 200);
    }
}
