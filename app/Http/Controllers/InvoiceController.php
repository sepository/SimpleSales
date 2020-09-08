<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Http\Requests\InvoiceRequest;
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
}
