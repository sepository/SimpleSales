<?php

namespace Tests\Feature;

use App\Invoice;
use App\InvoiceItem;
use DateTime;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorize();
    }

    /**
     * テストデータを作成し、それらが取得できる事を確認する。
     */
    public function testIndex()
    {
        $count = 10;
        for ($i = 0; $i < $count; $i++) {
            factory(Invoice::class)->create();
        }

        $response = $this->json('GET', '/api/invoice');
        $response
            ->assertOk()
            ->assertJsonCount($count);
    }

    /**
     * 登録が成功する事を確認する。
     */
    public function testCreateSuccess()
    {
        $data = $this->getInvoiceForSuccessfulCase();
        $response = $this->json('POST', '/api/invoice', $data);
        $response->assertOk();
        $this->assertDatabaseHas('invoices', $data);
    }

    /**
     * 入力必須の項目を空で送信し、エラーメッセージが返ってくる事を確認する。
     */
    public function testCreateFailureInRequiredColumn()
    {
        $data = [
            'customer_id' => '',
            'invoice_no' => '',
            'invoice_date' => '',
            'payment_due_date' => '',
            'remarks' => '',
        ];
        $response = $this->json('POST', '/api/invoice', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'customer_id', 'invoice_no', 'invoice_date', 'payment_due_date',
            ]);
    }

    /**
     * 境界値を超えた値を送信し、エラーメッセージが返ってくる事を確認する。
     */
    public function testCreateFailureInBoundaryValue()
    {
        $data = $this->getInvoiceForSuccessfulCase();
        $data['invoice_no'] = Str::random(51);
        $data['remarks'] = Str::random(301);
        $response = $this->json('POST', '/api/invoice', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'invoice_no', 'remarks',
            ]);
    }

    /**
     * 無効な値を送信し、エラーメッセージが返ってくる事を確認する。
     */
    public function testCreateFailureInInvalidValue()
    {
        $data = $this->getInvoiceForSuccessfulCase();
        $data['invoice_no'] = 1;
        $data['invoice_date'] = 'abc';
        $data['payment_due_date'] = 'xyz';
        $response = $this->json('POST', '/api/invoice', $data);
        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'invoice_no', 'invoice_date', 'payment_due_date',
            ]);
    }

    /**
     * テストデータを作成し、それが取得できる事を確認する。
     */
    public function testShow()
    {
        $invoice = factory(Invoice::class)->create();
        for ($i = 0; $i < 3; $i++) {
            $invoiceItem = factory(InvoiceItem::class)->create([
                'invoice_id' => $invoice->id,
                'item_id' => $i + 1,
            ]);
            $invoiceItems[$i] = [
                'invoice_id' => $invoiceItem->invoice_id,
                'item_id' => $invoiceItem->item_id,
                'product_id' => $invoiceItem->product_id,
                'quantity' => $invoiceItem->quantity,
                'amount' => $invoiceItem->amount,
                'remarks' => $invoiceItem->remarks,
            ];
        }
        $response = $this->json('GET', '/api/invoice/' . $invoice->id);
        $response
            ->assertOk()
            ->assertJson([
                'customer_id' => $invoice->customer_id,
                'invoice_no' => $invoice->invoice_no,
                'invoice_date' => $invoice->invoice_date,
                'payment_due_date' => $invoice->payment_due_date,
                'remarks' => $invoice->remarks,
                'items' => $invoiceItems,
            ]);
    }

    public function testUpdateSuccess()
    {
        $invoice = factory(Invoice::class)->create();
        for ($i = 0; $i < 3; $i++) {
            $invoiceItem = factory(InvoiceItem::class)->make([
                'invoice_id' => $invoice->id,
                'item_id' => $i + 1,
            ]);
            $invoiceItems[$i] = [
                'invoice_id'    => $invoiceItem->invoice_id,
                'item_id'       => $invoiceItem->item_id,
                'product_id'    => $invoiceItem->product_id,
                'quantity'      => $invoiceItem->quantity,
                'amount'        => $invoiceItem->amount,
                'remarks'       => $invoiceItem->remarks,
            ];
        }
        $data = [
            'invoice_id'        => $invoice->id,
            'customer_id'       => $invoice->customer_id,
            'invoice_no'        => 'IV-TEST-01',
            'invoice_date'      => Date::now()->format('Y-m-d'),
            'payment_due_date'  => Date::now()->addMonth()->format('Y-m-d'),
            'remarks'           => Str::random(300),
            'items'             => $invoiceItems,
        ];

        $response = $this->json('PUT', '/api/invoice/' . $invoice->id, $data);
        $response->assertOk();
    }

    public function getInvoiceForSuccessfulCase() : array
    {
        $invoice = factory(Invoice::class)->make();
        $data = [
            'customer_id' => $invoice->customer_id,
            'invoice_no' => $invoice->invoice_no,
            'invoice_date' => $invoice->invoice_date,
            'payment_due_date' => $invoice->payment_due_date,
            'remarks' => $invoice->remarks,
        ];

        return $data;
    }
}
