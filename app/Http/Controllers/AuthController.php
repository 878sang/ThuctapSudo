<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email là bắt buộc',
                'email.email' => 'Email không hợp lệ',
                'password.required' => 'Mật khẩu là bắt buộc',
            ],
            ['message' => 'Thông tin đăng nhập không chính xác.']
        );

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if ($request->user()->role === 'staff') {
                return redirect()->intended('products');
            }
            return redirect()->intended('categories');
        }
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput();
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

