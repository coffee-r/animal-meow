<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Post;

class IndexController extends Controller
{
    public function index()
    {
        // 最新の投稿を10件取得
        $posts = Post::join('users', 'users.id', '=', 'posts.user_id')
                     ->orderBy('posts.id', 'desc')
                     ->take(10)
                     ->get();
        
        return Inertia::render('Index', [
            'posts' => $posts,
        ]);
    }
}
