<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\TwitterUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    /**
     * 退会アクション
     *
     * @param Request $request
     * @return void
     */
    public function withdrawal(Request $request)
    {
        // フォームバリデーション
        $validated = $request->validate([
            'confirmText' => 'required|regex:/^退会する$/',
        ],[
            'confirmText.required' => '退会確認用メッセージを入力してください',
            'confirmText.regex' => '退会確認用メッセージを正しく入力してください',
        ]);

        // トランザクション
        DB::beginTransaction();

        // twitterのtokenを削除
        TwitterUser::where('animal_meow_user_id', Auth::id())->delete();

        // 投稿テーブルを削除
        Post::where('user_id', Auth::id())->delete();

        // ユーザーを削除
        User::where('id', Auth::id())->delete();

        // ログアウト
        Auth::logout();

        // コミット
        DB::commit();

        // 退会後画面にリダイレクト
        return redirect('/after_withdrawal')->with('successMessages', ['退会しました。']);
    }
}
