<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 参照
    public function show(User $user)
    {
        return $user;
    }
}
