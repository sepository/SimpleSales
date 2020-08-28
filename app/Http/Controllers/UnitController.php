<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    // 一覧
    public function index()
    {
        return Unit::all();
    }
}
