<?php

namespace App\Http\Controllers;

use App\CoffeeR\UseCases\UserUpsertWithTwitterAction;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Message;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


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
    public function handleProviderCallback(Request $request, UserUpsertWithTwitterAction $userUpsertWithTwitterAction)
    {
        // アクセストークンを取得
        // $token = Socialite::driver('twitter')->getAccessTokenResponse($request->input('code'));
        // echo '<pre>';
        // var_dump($token);
        // echo '</pre><br/><br/><pre>';
        
        // $client = new Client();
        // $user = $client->get('https://api.twitter.com/2/users/me', [
        //     'headers' => ['Authorization' => 'Bearer '.$token['access_token']],
        //     'query' => ['user.fields' => 'profile_image_url'],
        //     'debug' => true
        // ]);
        // echo '<br/><br/>';
        // var_dump($user);
        // echo '</pre><br/><br/><pre>';
        // exit();


//         try{
//             // twitterのユーザーを取得
//             $twitterUserFromSocialite = Socialite::driver('twitter')->user();
//             echo 'twitter socialite success token' . $twitterUserFromSocialite->token;
//         }catch(ClientException $e){
//             echo 'twitter callback exception';
//             echo (Message::toString($e->getRequest()));   
//             Log::error($e);
// exit();
//             return redirect(route('index'))->with('failMessages', ['何からの理由でログインに失敗しました。お手数ですがもう一度お試しください。']);
//         }
//         catch(Exception $e){
//             Log::error($e);
//             return redirect(route('index'))->with('failMessages', ['何からの理由でログインに失敗しました。お手数ですがもう一度お試しください。']);
//         }
//         exit();

        try{
            // twitterのユーザーを取得
            $twitterUserFromSocialite = Socialite::driver('twitter')->user();
        }
        catch(Exception $e){
            Log::error($e);
            return redirect(route('index'))->with('failMessages', ['何からの理由でログインに失敗しました。お手数ですがもう一度お試しください。']);
        }

        // twitterのユーザー情報を使って
        // ユーザーを新規登録・更新
        $user = $userUpsertWithTwitterAction($twitterUserFromSocialite);

        // ログイン
        Auth::login($user);

        // ホーム画面にリダイレクト
        return redirect(route('home'))->with('successMessages', ['ログインしました。']);
    }
}
