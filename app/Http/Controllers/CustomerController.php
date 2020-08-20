<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 一覧
    public function index()
    {
        return Customer::all();
    }

    // 新規登録
    public function create(Request $request)
    {
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->postal_code = $request->postal_code;
        $customer->address = $request->address;
        $customer->tel_no = $request->tel_no;
        $customer->save();
    }

    // 検索
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $customers = Customer::query();
        if ($keyword) {
            $customers->where(function($customers) use ($keyword) {
                $customers->where('name', 'like', "%$keyword%")
                    ->orWhere('address', 'like', "%$keyword%");
            });
        }
        return $customers->get();
    }
}
