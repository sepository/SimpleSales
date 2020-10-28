<?php

namespace Tests\Feature;

use App\Unit;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UnitTest extends TestCase
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
        for ($i = 0; $i < $count; $i++) {
            factory(Unit::class)->create();
        }

        $response = $this->json('GET', '/api/unit');
        $response
            ->assertOk()
            ->assertJsonCount($count);
    }

    /**
     * テストデータの登録が成功し、データベースに保存されている事を確認する。
     */
    public function testCreateSuccess()
    {
        $data = [
            'name' => Str::random(10),
        ];

        $response = $this->json('POST', '/api/unit', $data);
        $response->assertOk();
        $this->assertDatabaseHas('units', $data);
    }

    /**
     * テストデータの登録が失敗し、エラーメッセージが返ってくる事を確認する。
     */
    public function testCreateFailure()
    {
        // 境界値テスト
        $data = [
            'name' => Str::random(11),
        ];

        $response = $this->json('POST', '/api/unit', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name',
            ]);

        // 名称の一意テスト
        $name = Str::random(10);
        $data = [
            'name' => $name,
        ];
        factory(Unit::class)->create(['name' => $name]);

        $response = $this->json('POST', '/api/unit', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name'
            ]);

        // 入力必須テスト
        $data = [
            'name' => '',
        ];

        $response = $this->json('POST', '/api/unit', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name'
            ]);
    }

    /**
     * テストデータを作成して更新が成功する事を確認する。
     */
    public function testUpdateSuccess()
    {
        $unit = factory(Unit::class)->create();
        $data = [
            'name' => 'test',
        ];

        $response = $this->json('PUT', '/api/unit/' . $unit->id, $data);
        $response->assertOk();
        $this->assertDatabaseHas('units', $data);
    }

    /**
     * テストデータを作成して更新が失敗する事を確認する。
     */
    public function testUpdateFailure()
    {
        // 境界値テスト
        $unit = factory(Unit::class)->create();
        $data = [
            'name' => Str::random(11),
        ];

        $response = $this->json('PUT', '/api/unit/' . $unit->id, $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name'
            ]);

        // 名称の一意テスト
        $name = 'test';
        factory(Unit::class)->create(['name' => $name]);
        $data = [
            'name' => $name,
        ];

        $response = $this->json('PUT', '/api/unit/' . $unit->id, $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name'
            ]);

        // 入力必須テスト
        $data = [
            'name' => '',
        ];

        $response = $this->json('PUT', '/api/unit/' . $unit->id, $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name'
            ]);
    }
}
