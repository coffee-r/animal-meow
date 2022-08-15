<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Post;

class IndexController extends Controller
{
    /**
     * トップページアクション
     *
     * @return void
     */
    public function index()
    {
        // 最新の投稿を10件取得
        $posts = Post::join('users', 'users.id', '=', 'posts.user_id')
                     ->select(['posts.id as post_id', 'user_id', 'message', 'like_total_count', 'avatar_image_url', 'users.name as user_name', 'posts.created_at as post_created_at'])
                     ->orderBy('posts.id', 'desc')
                     ->take(10)
                     ->get();

        return Inertia::render('Index', [
            'posts' => $posts,
        ]);
    }
}
