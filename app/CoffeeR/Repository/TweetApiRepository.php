<?php

namespace App\CoffeeR\Repository;

use App\CoffeeR\Domain\Tweet;
use App\CoffeeR\Domain\TweetRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\TwitterUser;
use Illuminate\Support\Facades\Http;

class TweetApiRepository implements TweetRepositoryInterface
{
    private const ENDPOINT_URL = 'https://api.twitter.com/2/tweets';

    private $twitterUser;

    public function __construct(TwitterUser $twitterUser)
    {
        $this->twitterUser = $twitterUser;
    }

    public function tweet(string $message): Tweet
    {
        // Twitterのユーザー情報を取得する
        $twitterUser = $this->twitterUser->where('animal_meow_user_id', Auth::id())->first();

        // ツイートする
        $response = Http::withToken($twitterUser->access_token)
                             ->post(self::ENDPOINT_URL, [
                                 'text' => $message,
                             ]);

        // レスポンスを配列に加工する
        $body = $response->object();

        return new Tweet(
            $body->data->text,
            'https://twitter.com/'.$twitterUser->nickname.'/status/'.$body->data->id
        );
    }
}
