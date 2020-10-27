<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        factory(User::class)->create([
            'email' => 'test@example.com',
        ]);
    }

    public function testLoginSuccess()
    {
        // ログインに成功する
        $response = $this->json('POST', '/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response->assertOk();

        // 認証ユーザが一致する
        $response = $this->json('GET', '/api/user');
        $response->assertJson([
            'email' => 'test@example.com',
        ]);
        $this->assertNotNull(Auth::user());

        // ログアウトして、認証ユーザが取得できない事を確認する
        $response = $this->json('POST', '/api/logout');
        $response->assertOk();
        $this->assertNull(Auth::user());
    }

    public function testLoginFailure()
    {
        // ログインに失敗して、認証ユーザが取得できない事を確認する
        $response = $this->json('POST', '/api/login', [
            'email' => 'test@example.com',
            'password' => 'p@ssword',
        ]);
        $response->assertStatus(422);
        $this->assertNull(Auth::user());
    }
}
