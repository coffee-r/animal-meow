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

    public function upsert($post_id, Request $request)
    {
        // 投稿を取得
        $post = Post::find($post_id);

        // 投稿が存在しない場合は終了
        if(empty($post)){
            throw new Exception("post_id " . $post_id . " not found.");
        }

        // ユーザーのいいねを取得
        $like = Like::where('post_id', $post_id)
                    ->where('user_id', Auth::id())
                    ->first();

        DB::beginTransaction();

        // 投稿のtotalいいねを+1
        $post->like_total_count += 1;
        $post->update();

        // ユーザーのいいねが既にある場合はいいねを+1、
        // ユーザーのいいねが既にある場合は新規作成
        if($like){
            $like->like_count += 1;
            $like->update();
        }else{
            $like = new Like();
            $like->user_id = Auth::id();
            $like->post_id = $post_id;
            $like->like_count = 1;
            $like->save();
        }

        DB::commit();

        return response($like);
    }

}
