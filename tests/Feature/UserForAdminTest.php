<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * ユーザの管理者専用機能をテスト
 */
class UserForAdminTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorize(1);
    }

    /**
     * 一般ユーザがアクセスできない事を確認する。
     */
    public function testUnauthorizedAccess()
    {
        // 一般ユーザで認証
        $this->authorize();

        // 更新用ユーザ作成
        $user = factory(User::class)->create();

        // ユーザ登録
        $response = $this->json('POST', '/api/user/register', $this->getUserForSuccessfulCase());
        $response->assertStatus(403);

        // 利用停止
        $response = $this->json('PUT', '/api/user/suspend/' . $user->id);
        $response->assertStatus(403);

        // 利用再開
        $response = $this->json('PUT', '/api/user/resume/' . $user->id);
        $response->assertStatus(403);
    }

    /**
     * ユーザの登録が成功する事を確認する。
     */
    public function testRegisterSuccess()
    {
        $data = $this->getUserForSuccessfulCase();
        $response = $this->json('POST', '/api/user/register', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    /**
     * 入力必須の項目を空で送信し、エラーメッセージが返ってくる事を確認する。
     */
    public function testRegisterFailureInRequiredColumn()
    {
        $data = [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
            'is_admin' => '',
        ];
        $response = $this->json('POST', '/api/user/register', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name', 'email', 'password', 'is_admin',
            ]);
    }

    /**
     * 一意の項目を重複するように送信し、エラーメッセージが返ってくる事を確認する。
     */
    public function testRegisterFailureInUniqueColumn()
    {
        $email = 'unique@example.com';
        factory(User::class)->create(['email' => $email]);
        $data = $this->getUserForSuccessfulCase();
        $data['email'] = $email;
        $response = $this->json('POST', '/api/user/register', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email',
            ]);
    }

    /**
     * 無効な値を送信し、エラーメッセージが返ってくる事を確認する。
     */
    public function testRegisterFailureInInvalidColumn()
    {
        $data = $this->getUserForSuccessfulCase();
        $data['email'] = 'aaa';
        $data['is_admin'] = 2;
        $response = $this->json('POST', '/api/user/register', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email', 'is_admin',
            ]);
    }

    /**
     * 境界値を超える値を送信し、エラーメッセージが返ってくる事を確認する。
     */
    public function testRegisterFailureInBoundaryValue()
    {
        $password = Str::random(7);
        $data = [
            'name' => Str::random(256),
            'email' => Str::random(244) . '@example.com',
            'password' => $password,
            'password_confirmation' => $password,
            'is_admin' => 0,
        ];
        $response = $this->json('POST', '/api/user/register', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name', 'email', 'password',
            ]);
    }

    /**
     * パスワード（確認）に異なる値を送信し、エラーメッセージが返ってくる事を確認する。
     */
    public function testRegisterFailureInPasswordConfirmationMissing()
    {
        $data = $this->getUserForSuccessfulCase();
        $data['password_confirmation'] = 'p@ssword';
        $response = $this->json('POST', '/api/user/register', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'password',
            ]);
    }

    /**
     * ユーザの利用停止が成功する事を確認する。
     */
    public function testSuspend()
    {
        $user = factory(User::class)->create(['is_suspended' => 0]);
        $response = $this->json('PUT', '/api/user/suspend/' . $user->id);
        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'is_suspended' => 1,
        ]);
    }

    /**
     * ユーザの利用再開が成功する事を確認する。
     */
    public function testResume()
    {
        $user = factory(User::class)->create(['is_suspended' => 1]);
        $response = $this->json('PUT', '/api/user/resume/' . $user->id);
        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
            'is_suspended' => 0,
        ]);
    }

    /**
     * 登録可能なユーザのデータ
     */
    private function getUserForSuccessfulCase() : array
    {
        $user = factory(User::class)->make();
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
            'is_admin' => $user->is_admin,
        ];

        return $data;
    }
}
