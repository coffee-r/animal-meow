<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\TwitterUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Scope;

/**
 * Twitterログインコントローラー
 * 主にSocialiteを利用して実装する
 * https://readouble.com/laravel/8.x/ja/socialite.html
 */
class TwitterLoginController extends Controller
{
    /**
     * twitterの認可画面にリダイレクトする
     *
     * @return void
     */
    public function redirectToProvider()
    {
        // 権限の指定
        // https://developer.twitter.com/en/docs/authentication/oauth-2-0/authorization-code
        // users.readとtweet.readがSocialite内部でデフォルト指定されている
        // tweet.writeはツイートする際に必要で、offline.accessはリフレッシュトークンを使用するのに必要
        return Socialite::driver('twitter')
                        ->scopes(['tweet.write', 'offline.access'])
                        ->redirect();
    }

    /**
     * Twitterの認可画面でエンドユーザーが許可した後に呼ばれる処理
     * 新規登録及びログインを行う
     *
     * @return void
     */
    public function handleProviderCallback()
    {
        // twitterのユーザーを取得
        $twitterUserFromSocialite = Socialite::driver('twitter')->user();

        // twitterのidを条件にユーザーを取得
        $user = User::join('twitter_users', 'users.id', '=', 'twitter_users.animal_meow_user_id')
                   ->where('twitter_users.twitter_id', $twitterUserFromSocialite->getId())
                   ->select('users.*')
                   ->first();

        // トランザクション
        DB::beginTransaction();

        // ユーザーが既に存在する場合は更新処理、存在しない場合は新規作成する
        // ユーザーが存在しない場合は、ユーザーとtokenレコードの新規作成を行う。
        if ($user) {
            // ユーザーの更新
            $user->name = $twitterUserFromSocialite->getName();
            $user->avatar_image_url = $twitterUserFromSocialite->getAvatar();
            $user->update();

            // Twitterユーザーの更新
            $twitterUser = TwitterUser::where('animal_meow_user_id', $user->id)->first();
            $twitterUser->nickname = $twitterUserFromSocialite->getNickname();
            $twitterUser->access_token = $twitterUserFromSocialite->token;
            $twitterUser->access_token_time_limit = new Carbon('+' . $twitterUserFromSocialite->expiresIn . ' seconds');
            $twitterUser->refresh_token = $twitterUserFromSocialite->refreshToken;
            $twitterUser->update();
        } else {
            // ユーザーの新規作成
            $user = new User();
            $user->name = $twitterUserFromSocialite->getName();
            $user->avatar_image_url = $twitterUserFromSocialite->getAvatar();
            $user->save();

            // Twitterユーザーの新規作成
            $twitterUser = new TwitterUser();
            $twitterUser->twitter_id = $twitterUserFromSocialite->getId();
            $twitterUser->animal_meow_user_id = $user->id;
            $twitterUser->nickname = $twitterUserFromSocialite->getNickname();
            $twitterUser->access_token = $twitterUserFromSocialite->token;
            $twitterUser->access_token_time_limit = new Carbon('+' . $twitterUserFromSocialite->expiresIn . ' seconds');
            $twitterUser->refresh_token = $twitterUserFromSocialite->refreshToken;
            $twitterUser->save();
        }

        // ログイン
        Auth::login($user);

        // コミット
        DB::commit();

        // ホーム画面にリダイレクト
        return redirect('/home')->with('flash_success_messages', ['ログインしました。']);
    }
}
