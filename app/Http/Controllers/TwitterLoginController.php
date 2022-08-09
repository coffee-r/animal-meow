<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\TwitterUser;

class TwitterLoginController extends Controller
{
    public function redirectToProvider()
    {
        // twitterの認可画面にリダイレクト
        return Socialite::driver('twitter')->redirect();
    }

    public function handleProviderCallback()
    {
        // twitterのユーザーを取得
        $twitterUserFromSocialite = Socialite::driver('twitter')->user();

        // twitterのidを条件にユーザーを取得
        $user = User::join('twitter_users', 'users.id', '=', 'twitter_users.user_id')
                   ->where('twitter_users.twitter_id', $twitterUserFromSocialite->id)
                   ->select('users.*')
                   ->first();

        DB::beginTransaction();

        // ユーザーが既に存在する場合は、名前とtokenの更新を行う。
        // ユーザーが存在しない場合は、ユーザーとtokenレコードの新規作成を行う。
        if ($user) {
            $user->name = $twitterUserFromSocialite->name;
            $user->avatar_image_url = $twitterUserFromSocialite->avatar_original;
            $user->update();
            
            $twitterUser = TwitterUser::where('user_id', $user->id)->first();
            $twitterUser->token = $twitterUserFromSocialite->token;
            $twitterUser->token_secret = $twitterUserFromSocialite->tokenSecret;
            $twitterUser->update();
        } else {
            $user = new User();
            $user->name = $twitterUserFromSocialite->name;
            $user->avatar_image_url = $twitterUserFromSocialite->avatar_original;
            $user->save();

            $twitterUser = new TwitterUser();
            $twitterUser->twitter_id = $twitterUserFromSocialite->id;
            $twitterUser->user_id = $user->id;
            $twitterUser->token = $twitterUserFromSocialite->token;
            $twitterUser->token_secret = $twitterUserFromSocialite->tokenSecret;
            $twitterUser->save();
        }

        // ログインする
        Auth::login($user);

        DB::commit();

        return redirect('/home')->with('flash_success_messages', ['ログインしました。']);
    }
}
