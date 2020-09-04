<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 一覧
    public function index()
    {
        return User::all();
    }

    // 参照
    public function show(User $user)
    {
        return $user;
    }

    // 検索
    public function search(Request $request)
    {
        $users = User::query();

        $keyword = $request->keyword;
        if ($keyword) {
            $users->where(function($users) use ($keyword) {
                $users->where('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%");
            });
        }

        $is_admin = $request->is_admin;
        if ($is_admin != 2) {
            $users->where('is_admin', $is_admin);
        }

        $include_suspended_user = $request->include_suspended_user;
        if ($include_suspended_user == 0) {
            $users->where('is_suspended', 0);
        }

        return $users->get();
    }

    // 利用停止
    public function suspend(Request $request, User $user)
    {
        $user->is_suspended = 1;
        $user->save();
        return $user;
    }

    // 利用再開
    public function resume(Request $request, User $user)
    {
        $user->is_suspended = 0;
        $user->save();
        return $user;
    }
}
