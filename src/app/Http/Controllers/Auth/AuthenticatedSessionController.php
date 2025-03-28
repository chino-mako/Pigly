<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyAuthenticatedSessionController;


class AuthenticatedSessionController extends Controller
{
    /**
     * ログイン処理
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            return redirect()->route('weight.index');  // ✅ ログイン後のリダイレクトを設定
        }

        return back()->withErrors([
            'email' => 'ログイン情報が正しくありません。',
        ]);
    }
}
