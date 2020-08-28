<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 一覧
    public function index()
    {
        return Product::all();
    }

    // 登録
    public function create(ProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->unit_id = $request->unit_id;
        $product->summary = $request->summary;
        $product->save();
    }

    // 検索
    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $products = Product::query();
        if ($keyword) {
            $products->where(function($products) use ($keyword) {
                $products->where('name', 'like', "%$keyword%")
                    ->orWhere('summary', 'like', "%$keyword%");
            });
        }
        return $products->get();
    }

    // 取得
    public function show(Product $product)
    {
        return $product;
    }

    // 更新
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());

        return $product;
    }

    // 削除
    public function destroy(Product $product)
    {
        $product->delete();

        return $product;
    }
}
