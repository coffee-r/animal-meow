<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_ゲストユーザーが投稿にいいね()
    {
        // ユーザーと投稿を作成
        $postUser = User::factory()->create();
        $post = Post::factory()->create();
        
        $response = $this->postJson(route('post.like.upsert', $post->id));
        $response->assertStatus(401);
    }

    public function test_投稿にいいね()
    {
        // ユーザーと投稿を作成
        $postUser = User::factory()->create();
        $post = Post::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->postJson(route('post.like.upsert', $post->id));
        $response->assertStatus(200);
    }

    public function test_存在しない投稿にいいね()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->postJson(route('post.like.upsert', 0));
        $response->assertStatus(403);
    }
}