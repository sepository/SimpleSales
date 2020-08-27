<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 一覧
    public function index()
    {
        return Product::all();
    }

    // 登録
    public function create()
    {

    }

    // 検索
    public function search()
    {

    }

    // 取得
    public function show()
    {

    }

    // 更新
    public function update()
    {
        
    }

    // 削除
    public function destroy()
    {
        
    }
}
