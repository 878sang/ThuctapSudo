<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientLoginRequest;
use App\Http\Requests\ClientRegisterRequest;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAuthController extends Controller
{
    protected UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'customer') {
            return redirect('/');
        }
        return view('client.auth.login');
    }

    public function login(ClientLoginRequest $request)
    {
        $data = $request->validated();
        $remember = $request->has('remember');

        if ($this->userService->login($data, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'Bạn đã nhập sai tên đăng nhập hoặc mật khẩu vui lòng kiểm tra lại',
        ])->withInput();
    }

    public function showRegisterForm()
    {
        if (Auth::check() && Auth::user()->role === 'customer') {
            return redirect('/');
        }
        return view('client.auth.register');
    }

    public function register(ClientRegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->userService->register($data);

        Auth::login($user);

        return redirect('/')->with('success', 'Đăng ký tài khoản thành công!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }
}
