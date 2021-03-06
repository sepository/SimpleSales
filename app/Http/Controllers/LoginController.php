<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
 
class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials['is_suspended'] = 0;
 
        if (Auth::attempt($credentials)) {
            return response()->json(['message' => 'Login successful', 'user' => Auth::user()], 200);
        }
 
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
 
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out'], 200);
    }
}
