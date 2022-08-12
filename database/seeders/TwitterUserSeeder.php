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
                'twitter_id' => Str::random(30),
                'animal_meow_user_id' => $user->id,
                'nickname' => Str::random(20),
                'access_token' => Str::random(50),
                'access_token_time_limit' => fake()->dateTimeBetween($startDate = 'now', $endDate = '+2 week'),
                'refresh_token' => Str::random(50),
            ]);
        }
    }
}
