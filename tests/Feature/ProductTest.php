<?php

namespace Tests\Feature;

use App\Product;
use App\Unit;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use UnitsTableSeeder;

class ProductTest extends TestCase
{
    use DatabaseMigrations;

    private $units;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UnitsTableSeeder::class);
        $this->units = Unit::all();

        $this->authorize();
    }

    /**
     * テストデータを作成し、作成した数だけ取得される事を確認する。
     */
    public function testIndex()
    {
        $count = 10;
        for ($i = 0; $i < $count; $i++) {
            factory(Product::class)->create();
        }

        $response = $this->json('GET', '/api/product');
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
            'name' => Str::random(100),
            'price' => 9999999,
            'unit_id' => rand(1, $this->units->count()),
            'summary' => Str::random(300),
        ];

        $response = $this->json('POST', '/api/product', $data);
        $response->assertOk();
        $this->assertDatabaseHas('products', $data);

        $data['unit_id'] = 0;

        $response = $this->json('POST', '/api/product', $data);
        $response->assertOk();
        $this->assertDatabaseHas('products', $data);
    }

    /**
     * テストデータの登録が失敗し、エラーメッセージが返ってくる事を確認する。
     */
    public function testCreateFailure()
    {
        $data = [
            'name' => Str::random(101),
            'price' => 10000000,
            'unit_id' => $this->units->count() + 1,
            'summary' => Str::random(301),
        ];

        $response = $this->json('POST', '/api/product', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name', 'price', 'unit_id', 'summary',
            ]);

        $data['name'] = null;
        $data['price'] = null;

        $response = $this->json('POST', '/api/product', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name', 'price', 'unit_id', 'summary',
            ]);
    }

    /**
     * キーワードを含むテストデータを登録し、検索して取得される事を確認する。
     */
    public function testSearch()
    {
        $keyword = '[KEYWORD]';
        factory(Product::class)->create(['name' => $keyword]);
        factory(Product::class)->create(['summary' => $keyword]);

        $response = $this->json('GET', '/api/product/search', ['keyword' => $keyword]);
        $response
            ->assertOk()
            ->assertJsonCount(2);
    }

    /**
     * テストデータを作成し、それが取得できる事を確認する。
     */
    public function testShow()
    {
        $product = factory(Product::class)->create();
        $response = $this->json('GET', '/api/product/' . $product->id);
        $response
            ->assertOk()
            ->assertJson([
                'name' => $product->name,
                'price' => $product->price,
                'unit_id' => $product->unit_id,
                'summary' => $product->summary,
            ]);
    }

    /**
     * テストデータを作成して更新が成功する事を確認する。
     */
    public function testUpdateSuccess()
    {
        $product = factory(Product::class)->create();
        $data = [
            'name' => Str::random(100),
            'price' => 9999999,
            'unit_id' => rand(1, $this->units->count()),
            'summary' => Str::random(300),
        ];

        $response = $this->json('PUT', '/api/product/' . $product->id, $data);
        $response->assertOk();
        $this->assertDatabaseHas('products', $data);
    }

    /**
     * テストデータを作成して更新が失敗する事を確認する。
     */
    public function testUpdateFailure()
    {
        $product = factory(Product::class)->create();
        $data = [
            'name' => Str::random(101),
            'price' => 10000000,
            'unit_id' => $this->units->count() + 1,
            'summary' => Str::random(301),
        ];

        $response = $this->json('PUT', '/api/product/' . $product->id, $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name', 'price', 'unit_id', 'summary',
            ]);
    }

    /**
     * テストデータを作成して削除し、データベースから存在しなくなった事を確認する。
     */
    public function testDestroy()
    {
        $product = factory(Product::class)->create();
        $response = $this->json('DELETE', '/api/product/' . $product->id);
        $response->assertOk();
        $this->assertDatabaseMissing('customers', ['id' => $product->id]);
    }
}
