<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ゲストユーザー
Route::middleware('guest')->group(function () {
    // トップ画
    Route::get('/', 'App\Http\Controllers\IndexController@index')->name('index');

    // Twitterでログイン
    Route::get('/login/twitter', 'App\Http\Controllers\TwitterLoginController@redirectToProvider')->name('twitter.login');

    // Twitterログイン時のコールバック
    Route::get('/login/twitter/callback', 'App\Http\Controllers\TwitterLoginController@handleProviderCallback');
});

// ログインユーザー
Route::middleware('auth')->group(function () {
    // ホーム
    Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

    // 自分の投稿一覧
    Route::get('/me', 'App\Http\Controllers\HomeController@me')->name('me');

    // 新規投稿
    Route::get('/post', 'App\Http\Controllers\PostController@create')->name('post.create');

    // 投稿処理
    Route::post('/post', 'App\Http\Controllers\PostController@store')->name('post.store');

    // その他
    Route::get('/others', function () {
        return Inertia::render('Others');
    })->name('others');

    // ログアウト処理
    Route::post('/logout', function(){
        Auth::logout();
        return redirect(route('index'));
    })->name('logout');

    // 退会処理
    Route::post('/withdrawal', 'App\Http\Controllers\WithdrawalController@withdrawal')->name('withdrawal');
});


// 退会後
Route::get('/after_withdrawal', function () {
    return Inertia::render('AfterWithdrawal');
})->name('withdrawal.after');


// 利用規約
Route::get('/terms', function () {
    return Inertia::render('Terms');
})->name('terms');

// プライバシーポリシー
Route::get('/privacy', function () {
    return Inertia::render('Privacy');
})->name('privacy');

// require __DIR__.'/auth.php';
