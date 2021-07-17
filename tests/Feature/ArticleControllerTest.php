<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get(route('articles.index'));

        $response->assertStatus(200)
            ->assertViewIs('articles.index');
    }

    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));

        $response->assertRedirect(route('login'));
    }

    public function testAuthCreate()
    {
        // テストに必要なUserモデルを「準備」 - Arrange
        $user = factory(User::class)->create();

        // ログインして記事投稿画面にアクセスすることを「実行」 - Act
        $response = $this->actingAs($user)
            ->get(route('articles.create'));
        
        // レスポンスを「検証」 - Assert
        $response->assertStatus(200)
            ->assertViewIs('articles.create');
    }
}
