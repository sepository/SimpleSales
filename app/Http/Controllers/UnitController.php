<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Http\Requests\UnitRequest;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    // 一覧
    public function index()
    {
        return Unit::all();
    }

    // 追加
    public function create(UnitRequest $request)
    {
        $unit = new Unit();
        $unit->name = $request->name;
        $unit->save();
    }

    // 更新
    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->all());

        return $unit;
    }
}
