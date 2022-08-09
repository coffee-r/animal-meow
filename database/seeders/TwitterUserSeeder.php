<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\TwitterUser;

class TwitterUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $key => $user) {
            TwitterUser::insert([
                'twitter_id' => Str::random(20),
                'user_id' => $user->id,
                'token' => Str::random(50),
                'token_secret' => Str::random(50),
            ]);
        }
    }
}
