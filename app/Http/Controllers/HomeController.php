<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // 最新の投稿を100件取得
        $posts = Post::join('users', 'users.id', '=', 'posts.user_id')
                     ->orderBy('posts.id', 'desc')
                     ->take(100)
                     ->get();
        
        return Inertia::render('Home', [
            'posts' => $posts,
        ]);
    }

    public function me()
    {
        // 最新の自分の投稿を100件取得
        $posts = Post::join('users', 'users.id', '=', 'posts.user_id')
                     ->where('user_id', Auth::id())
                     ->orderBy('posts.id', 'desc')
                     ->take(100)
                     ->get();
        
        return Inertia::render('Home', [
            'posts' => $posts,
        ]);
    }
}
