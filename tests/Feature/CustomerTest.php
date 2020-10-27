<?php

namespace Tests\Feature;

use App\Customer;
use CustomerTableTestDataSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorize();
    }

    /**
     * テストデータを10件作成して10件取得される事を確認する。
     */
    public function testIndex()
    {
        $count = 10;
        factory(Customer::class, $count)->create();
        $response = $this->json('GET', '/api/customer');
        $response
            ->assertOk()
            ->assertJsonCount($count);
    }

    /**
     * 作成したデータがデータベースに存在する事を確認する。
     */
    public function testCreateSuccess()
    {
        $data = [
            'name' => 'Test Customer',
            'postal_code' => Str::random(10),
            'address' => Str::random(300),
            'tel_no' => Str::random(20),
        ];
        $response = $this->json('POST', '/api/customer', $data);
        $response->assertOk();
        $this->assertDatabaseHas('customers', $data);
    }

    /**
     * 各パラメータでエラーが出る事を確認する。
     */
    public function testCreateFailure()
    {
        $data = [
            'name' => '',
            'postal_code' => Str::random(11),
            'address' => Str::random(301),
            'tel_no' => Str::random(21),
        ];
        $response = $this->json('POST', '/api/customer', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'name', 'postal_code', 'address', 'tel_no',
            ]);
    }

    /**
     * キーワードを含むテストデータを作成し、それらが取得される事を確認する。
     */
    public function testSearch()
    {
        $keyword = '[KEYWORD]';
        factory(Customer::class)->create(['name' => $keyword]);
        factory(Customer::class)->create(['address' => $keyword]);
        $response = $this->json('GET', '/api/customer/search', [
            'keyword' => $keyword,
        ]);
        $response
            ->assertOk()
            ->assertJsonCount(2);
    }

    /**
     * テストデータを作成し、それが取得できる事を確認する。
     */
    public function testShow()
    {
        $customer = factory(Customer::class)->create();
        $response = $this->json('GET', '/api/customer/' . $customer->id);
        $response
            ->assertOk()
            ->assertJson([
                'name' => $customer->name,
                'postal_code' => $customer->postal_code,
                'address' => $customer->address,
                'tel_no' => $customer->tel_no,
            ]);
    }

    /**
     * テストデータを作成して更新し、データベースに反映されている事を確認する。
     */
    public function testUpdate()
    {
        $customer = factory(Customer::class)->create();
        $data = [
            'name' => 'Update Test',
            'postal_code' => '123-5678',
            'address' => 'Nagoya - Aichi, Japan',
            'tel_no' => '052-123-6789',
        ];
        $response = $this->json('PUT', '/api/customer/' . $customer->id, $data);
        $response->assertOk();
        $this->assertDatabaseHas('customers', $data);
    }

    /**
     * テストデータを作成して削除し、データベースから存在しなくなった事を確認する。
     */
    public function testDestroy()
    {
        $customer = factory(Customer::class)->create();
        $id = $customer->id;
        $response = $this->json('DELETE', '/api/customer/' . $id);
        $response->assertOk();
        $this->assertDatabaseMissing('customers', ['id' => $id]);
    }
}
