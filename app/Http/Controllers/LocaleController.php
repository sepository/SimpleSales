<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function setLocale(Request $request, $locale)
    {
        // セッションにロケールをセット
        $request->session()->put('locale', $locale);
    
        return ['result' => 'OK'];
    }
}
