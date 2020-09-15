<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Http\Requests\InvoiceRequest;
use App\InvoiceItem;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // 一覧
    public function index(Request $request)
    {
        $invoices = Invoice::with('customer');

        $keyword = $request->keyword;
        if ($keyword) {
            $invoices->where(function($invoices) use ($keyword) {
                $invoices->where('invoice_no', 'like', "%$keyword%")
                    ->orWhere('remarks', 'like', "%$keyword%");
            });
        }

        $customer_id = $request->customer_id;
        if ($customer_id) {
            $invoices->where('customer_id', $customer_id);
        }

        $invoice_date_from = $request->invoice_date_from;
        if ($invoice_date_from) {
            $invoices->where('invoice_date', '>=', $invoice_date_from);
        }

        $invoice_date_to = $request->invoice_date_to;
        if ($invoice_date_to) {
            $invoices->where('invoice_date', '<=', $invoice_date_to);
        }

        $payment_due_date_from = $request->payment_due_date_from;
        if ($payment_due_date_from) {
            $invoices->where('payment_due_date', '>=', $payment_due_date_from);
        }

        $payment_due_date_to = $request->payment_due_date_to;
        if ($payment_due_date_to) {
            $invoices->where('payment_due_date', '<=', $payment_due_date_to);
        }

        return $invoices->get();
    }

    // 登録
    public function create(InvoiceRequest $request)
    {
        $invoice = new Invoice();
        $invoice->customer_id = $request->customer_id;
        $invoice->invoice_no = $request->invoice_no;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->payment_due_date = $request->payment_due_date;
        $invoice->remarks = $request->remarks;
        $invoice->save();
    }

    // 取得
    public function show(Invoice $invoice)
    {
        return $invoice->load('items.product');
    }

    // 更新
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->all());

        InvoiceItem::where('invoice_id', $invoice->id)->delete();
        $invoiceItemsInput = $request->items;
        foreach ($invoiceItemsInput as $item) {
            InvoiceItem::create($item);
        }

        return $invoice;
    }
}
