<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\TwitterUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Scope;

class TwitterLoginController extends Controller
{
    public function redirectToProvider()
    {
        // 使いたい認可情報を指定した上で、twitterの認可画面にリダイレクト
        // https://developer.twitter.com/en/docs/authentication/oauth-2-0/authorization-code
        // ・ users.read Socialite内部でデフォルト指定
        // ・ tweet.read Socialite内部でデフォルト指定
        // ・ tweet.write 投稿する際に必要
        // ・ offline.access エンドユーザーがアクセス権を取り消すまでアカウントにアクセスできる
        //    ※認可情報取得後のアクセストークンは2時間で有効期限切れとなり、それ以降はそのトークンではAPIを利用できない。
        //    リフレッシュトークンを使うことでアクセストークンを再発行できる。これにoffline.accessの認可が必要。
        return Socialite::driver('twitter')
                        ->scopes(['tweet.write', 'offline.access'])
                        ->redirect();
    }

    public function handleProviderCallback()
    {
        // twitterのユーザーを取得
        $twitterUserFromSocialite = Socialite::driver('twitter')->user();

        // twitterのidを条件にユーザーを取得
        $user = User::join('twitter_users', 'users.id', '=', 'twitter_users.animal_meow_user_id')
                   ->where('twitter_users.twitter_id', $twitterUserFromSocialite->getId())
                   ->select('users.*')
                   ->first();

        DB::beginTransaction();

        // ユーザーが既に存在する場合は、名前とtokenの更新を行う。
        // ユーザーが存在しない場合は、ユーザーとtokenレコードの新規作成を行う。
        if ($user) {
            $user->name = $twitterUserFromSocialite->getName();
            $user->avatar_image_url = $twitterUserFromSocialite->getAvatar();
            $user->update();
            
            $twitterUser = TwitterUser::where('animal_meow_user_id', $user->id)->first();
            $twitterUser->nickname = $twitterUserFromSocialite->getNickname();
            $twitterUser->access_token = $twitterUserFromSocialite->token;
            $twitterUser->access_token_time_limit = new Carbon('+' . $twitterUserFromSocialite->expiresIn . ' seconds');
            $twitterUser->refresh_token = $twitterUserFromSocialite->refreshToken;
            $twitterUser->update();
        } else {
            $user = new User();
            $user->name = $twitterUserFromSocialite->getName();
            $user->avatar_image_url = $twitterUserFromSocialite->getAvatar();
            $user->save();

            $twitterUser = new TwitterUser();
            $twitterUser->twitter_id = $twitterUserFromSocialite->getId();
            $twitterUser->animal_meow_user_id = $user->id;
            $twitterUser->nickname = $twitterUserFromSocialite->getNickname();
            $twitterUser->access_token = $twitterUserFromSocialite->token;
            $twitterUser->access_token_time_limit = new Carbon('+' . $twitterUserFromSocialite->expiresIn . ' seconds');
            $twitterUser->refresh_token = $twitterUserFromSocialite->refreshToken;
            $twitterUser->save();
        }

        // ログインする
        Auth::login($user);

        DB::commit();

        return redirect('/home')->with('flash_success_messages', ['ログインしました。']);
    }
}
