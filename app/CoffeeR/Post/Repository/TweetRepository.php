<?php

namespace App\CoffeeR\Post\Repository;

use App\CoffeeR\Post\Domain\Tweet;
use App\CoffeeR\Post\Domain\TweetRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\TwitterUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TweetRepository implements TweetRepositoryInterface
{
    private const TOKEN_ENDPOINT_URL = 'https://api.twitter.com/2/oauth2/token';
    private const TWEET_ENDPOINT_URL = 'https://api.twitter.com/2/tweets';

    /**
     * ツイートする
     *
     * @param string $message
     * @return array
     */
    public function tweet(string $message): Tweet
    {
        // twitterユーザー情報を取得
        $twitterUser = TwitterUser::where('animal_meow_user_id', Auth::id())->first();

        // 現在時刻を取得
        $now = Carbon::now();

        // アクセストークンの有効期限を取得
        $limit = (new Carbon($twitterUser->access_token_time_limit))->subSecond(5);

        // アクセストークンの有効期限が切れている場合(または切れそうな場合)は、
        // リフレッシュトークンを使いアクセストークンを再発行する。
        if ($now->gte($limit)) {
            $outhResponse = Http::withBasicAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'))
                                ->post(self::TOKEN_ENDPOINT_URL, [
                                    'refresh_token' => $twitterUser->refresh_token,
                                    'grant_type' => 'refresh_token',
                                    'client_id' => config('services.twitter.client_id'),
                                ]);
            $outhResponseArray = json_decode($outhResponse->getBody(), true);

            //新しいトークンをDBに保存
            $twitterUser->access_token = $outhResponseArray['access_token'];
            $twitterUser->access_token_time_limit = new Carbon('+' . $outhResponseArray['expires_in'] . ' seconds');
            $twitterUser->refresh_token = $outhResponseArray['refresh_token'];
            $twitterUser->update();
        }

        // ツイートする
        $tweetResponse = Http::withToken($twitterUser->access_token)
                             ->post(self::TWEET_ENDPOINT_URL, [
                                 'text' => $message,
                             ]);

        // レスポンスを配列に加工する
        $tweetResponseArray = json_decode($tweetResponse->getBody(), true);

        return new Tweet(
            $tweetResponseArray['data']['text'],
            "https://twitter.com/".$twitterUser->nickname."/status/".$tweetResponseArray['data']['id']
        );
    }
}
