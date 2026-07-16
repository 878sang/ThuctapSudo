<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\ClientLoginRequest;
use App\Http\Requests\ClientRegisterRequest;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Hiển thị Form đăng nhập cho Khách hàng
     */
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'customer') {
            return redirect('/');
        }
        return redirect('/categories?login=1');
    }

    /**
     * Hiển thị Form đăng nhập cho Admin
     */
    public function showAdminLoginForm()
    {
        if (Auth::check() && in_array(Auth::user()->role, ['super_admin', 'staff'])) {
            return redirect()->intended('admin/products');
        }
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập của Khách hàng
     */
    public function loginClient(ClientLoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $request->has('remember');

        if ($this->userService->loginClient($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/product');
        }

        return back()->withErrors([
            'login' => 'Bạn đã nhập sai tên đăng nhập hoặc mật khẩu vui lòng kiểm tra lại',
        ])->withInput();
    }

    /**
     * Xử lý đăng nhập của Admin
     */
    public function loginAdmin(AdminLoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $request->has('remember');

        if ($this->userService->loginAdmin($credentials, $remember)) {
            $request->session()->regenerate();
            if (Auth::user()->role === 'staff') {
                return redirect()->intended('admin/products');
            }
            return redirect()->intended('admin/categories');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác hoặc bạn không có quyền quản trị.',
        ])->withInput();
    }

    public function showRegisterForm()
    {
        if (Auth::check() && Auth::user()->role === 'customer') {
            return redirect('/');
        }
        return view('client.auth.register');
    }

    /**
     * Xử lý đăng ký cho Khách hàng
     */
    public function registerClient(ClientRegisterRequest $request)
    {
        $data = $request->validated();

        $user = $this->userService->registerClient($data);
        Auth::login($user);

        return redirect('/')->with('success', 'Đăng ký tài khoản thành công!');
    }

    /**
     * Xử lý Đăng xuất chung cho cả hệ thống
     */
    public function logout(Request $request)
    {
        $isAdmin = Auth::check() && in_array(Auth::user()->role, ['super_admin', 'staff']);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($isAdmin) {
            return redirect()->route('admin.login');
        }
        return redirect()->route('login');
    }
}
