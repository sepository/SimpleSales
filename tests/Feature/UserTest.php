<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorize();
    }

    /**
     * テストデータを作成し、作成した数だけ取得される事を確認する。
     */
    public function testIndex()
    {
        $count = 10;
        for ($i = 0; $i < $count - 1; $i++) {
            factory(User::class)->create();
        }

        $response = $this->json('GET', '/api/user/list');
        $response
            ->assertOk()
            ->assertJsonCount($count);
    }

    /**
     * キーワード検索のテスト
     */
    public function testSearchKeyword()
    {
        $keyword = 'keyword';
        factory(User::class)->create(['name' => $keyword]);
        factory(User::class)->create(['email' => "$keyword@example.com"]);

        $filter = $this->getFilter();
        $filter['keyword'] = $keyword;
        $this->assertSearchCount($filter, 2);
    }

    /**
     * 管理者フラグで検索
     */
    public function testSearchIsAdmin()
    {
        $count = 10;
        for ($i = 0; $i < $count; $i++) {
            factory(User::class)->create(['is_admin' => $i % 2]);
        }
        // 全てのユーザを検索
        $filter = $this->getFilter();
        $this->assertSearchCount($filter, $count + 1);

        // 管理者でないユーザを検索
        $filter['is_admin'] = 0;
        $this->assertSearchCount($filter, $count / 2 + 1);

        // 管理者のユーザを検索
        $filter['is_admin'] = 1;
        $this->assertSearchCount($filter, $count / 2);
    }

    /**
     * 利用停止フラグで検索
     */
    public function testSearchSuspendedUser()
    {
        $count = 10;
        for ($i = 0; $i < $count; $i++) {
            factory(User::class)->create(['is_suspended' => $i % 2]);
        }

        // 利用停止ユーザを含まない
        $filter = $this->getFilter();
        $this->assertSearchCount($filter, $count / 2 + 1);

        // 利用停止ユーザを含む
        $filter['include_suspended_user'] = 1;
        $this->assertSearchCount($filter, $count + 1);
    }

    /**
     * テストデータを作成し、それが取得できる事を確認する。
     */
    public function testShow()
    {
        $user = factory(User::class)->create();
        $response = $this->json('GET', '/api/user/profile/' . $user->id);
        $response
            ->assertOk()
            ->assertJson([
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }

    /**
     * フィルタの初期値を取得
     *
     * @return フィルタの初期値
     */
    private function getFilter() : array
    {
        return [
            'keyword' => '',
            'is_admin' => 2,
            'include_suspended_user' => 0,
        ];
    }

    /**
     * 検索の共通アサーション
     */
    private function assertSearchCount(array $filter, $count)
    {
        $response = $this->json('GET', '/api/user/search', $filter);
        $response
            ->assertOk()
            ->assertJsonCount($count);
    }
}
