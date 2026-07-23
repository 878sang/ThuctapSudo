<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng Nhập Hệ Thống - Sudo Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="h-full bg-gradient-to-br from-slate-900 via-slate-950 to-indigo-950 flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8 antialiased">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-tr from-indigo-500 to-violet-600 text-white shadow-xl shadow-indigo-500/30">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
        </div>
        <h2 class="mt-6 text-center text-2xl font-bold tracking-tight text-white">SUDO ADMIN SYSTEM</h2>
        <p class="mt-2 text-center text-sm text-slate-400">
            Vui lòng đăng nhập tài khoản quản trị để tiếp tục
        </p>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[440px] px-4">
        <div class="bg-slate-900/60 backdrop-blur-md border border-slate-800/80 px-6 py-10 shadow-2xl rounded-3xl sm:px-10">
            <form class="space-y-6" action="/admin/login" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-200">Địa chỉ Email</label>
                    <div class="mt-2">
                        <input id="email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            value="{{ old('email') }}"
                            required
                            placeholder="admin@example.com"
                            class="block w-full rounded-xl border border-slate-800 bg-slate-950/80 px-4 py-3 text-slate-100 placeholder-slate-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm @error('email') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500 @enderror">
                    </div>
                    @error('email')
                    <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-200">Mật khẩu</label>
                    <div class="mt-2">
                        <input id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            placeholder="••••••••"
                            class="block w-full rounded-xl border border-slate-800 bg-slate-950/80 px-4 py-3 text-slate-100 placeholder-slate-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 focus:outline-none sm:text-sm @error('password') border-rose-500/80 focus:border-rose-500 focus:ring-rose-500 @enderror">
                    </div>
                    @error('password')
                    <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember"
                            name="remember"
                            type="checkbox"
                            class="h-4 w-4 rounded border-slate-800 bg-slate-950 text-indigo-600 focus:ring-indigo-500/30 focus:ring-offset-slate-900">
                        <label for="remember" class="ml-2 block text-sm text-slate-400 select-none">Ghi nhớ đăng nhập</label>
                    </div>

                    @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-semibold text-indigo-400 hover:text-indigo-300">Quên mật khẩu?</a>
                    </div>
                    @endif
                </div>
                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-3.5 text-sm font-semibold text-white shadow-lg hover:from-indigo-700 hover:to-violet-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-150 hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                        Đăng nhập
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>