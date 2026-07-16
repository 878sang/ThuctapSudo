<!DOCTYPE html>
<html lang="vi" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng nhập tài khoản - Hoplong Industry Mall</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="h-full bg-slate-100 flex items-center justify-center p-4 antialiased">

    <!-- Container Card đăng nhập -->
    <div class="max-w-5xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[580px] border border-gray-100 animate-fade-in">
        
        <!-- Cột TRÁI: Form đăng nhập -->
        <div class="w-full md:w-[48%] p-8 sm:p-10 flex flex-col justify-between">
            <div>
                <!-- Header Form -->
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        Chào mừng bạn quay trở lại 👋
                    </h2>
                    <p class="text-xs text-gray-400 mt-1.5 font-medium">Đăng nhập tài khoản thành viên của bạn</p>
                </div>

                <!-- Nút Đăng nhập MXH -->
                <div class="space-y-2.5">
                    <a href="#" class="w-full flex items-center justify-center gap-2.5 py-2.5 px-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-xs font-semibold text-gray-700">
                        <img src="https://cdn-icons-png.flaticon.com/512/2991/2991148.png" alt="Google" class="w-4.5 h-4.5">
                        Đăng nhập bằng Google
                    </a>
                    <a href="#" class="w-full flex items-center justify-center gap-2.5 py-2.5 px-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-xs font-semibold text-gray-700">
                        <img src="https://cdn-icons-png.flaticon.com/512/124/124010.png" alt="Facebook" class="w-4.5 h-4.5">
                        Đăng nhập bằng Facebook
                    </a>
                </div>

                <!-- Phân cách "Hoặc" -->
                <div class="flex items-center my-5">
                    <div class="flex-grow border-t border-gray-200"></div>
                    <span class="px-3 text-xs text-gray-400 font-medium">Hoặc</span>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <!-- Form đăng nhập chính -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Nhập Email/Số điện thoại -->
                    <div>
                        <label for="login" class="block text-xs font-bold text-gray-700 mb-1.5">Email/ Số điện thoại</label>
                        <div class="relative">
                            <input id="login" name="login" type="text" value="{{ old('login') }}" required 
                                placeholder="Email hoặc Số điện thoại"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 pr-10 text-gray-800 placeholder-gray-400">
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400">
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Nhập Mật khẩu -->
                    <div x-data="{ showPass: false }">
                        <label for="password" class="block text-xs font-bold text-gray-700 mb-1.5">Mật khẩu</label>
                        <div class="relative">
                            <input id="password" name="password" :type="showPass ? 'text' : 'password'" required 
                                placeholder="********"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 pr-10 text-gray-800 placeholder-gray-400">
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fa-regular" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Ghi nhớ & Quên mật khẩu -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center text-gray-500 cursor-pointer font-medium select-none">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-1.5 w-4 h-4 cursor-pointer">
                            Nhớ mật khẩu
                        </label>
                        <a href="#" class="text-blue-600 hover:underline font-semibold">Bạn quên mật khẩu ?</a>
                    </div>

                    <!-- Nút Đăng nhập -->
                    <button type="submit" class="w-full bg-[#0165FC] hover:bg-blue-600 text-white font-bold py-3 rounded-lg text-sm transition-all shadow-md hover:shadow-lg mt-2 cursor-pointer">
                        Đăng nhập
                    </button>
                </form>

                <!-- Khối thông báo lỗi (Error Alert) -->
                @if($errors->any())
                <div class="mt-4 p-3 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-start gap-2.5 text-xs text-red-700 leading-snug">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5 grow-0 shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif
            </div>

            <!-- Footer Form -->
            <div class="text-center text-xs text-gray-500 mt-6 pt-4 border-t border-gray-100 font-medium">
                Bạn chưa có tài khoản ? <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-bold">Đăng ký ngay</a>
            </div>
        </div>

        <!-- Cột PHẢI: Banner quảng bá quyền lợi (CSS Gradient + Phone Mockup) -->
        <div class="hidden md:flex w-[52%] bg-gradient-to-br from-[#0B3979] to-[#0165FC] p-8 text-white flex-col justify-between relative overflow-hidden select-none">
            <!-- Vệt sáng nền tạo chiều sâu -->
            <div class="absolute -top-12 -right-12 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Logo góc trên -->
            <div class="flex items-center gap-1.5 z-10">
                <span class="font-extrabold text-lg tracking-wider italic text-white flex items-center gap-1">
                    <span class="bg-white text-[#0B3979] px-2 py-0.5 rounded not-italic font-black text-xs">hoplong</span>
                    INDUSTRY MALL
                </span>
            </div>

            <!-- Nội dung chính -->
            <div class="my-auto space-y-6 z-10">
                <div class="space-y-2">
                    <h3 class="text-2xl font-black uppercase tracking-wide leading-tight">
                        Đăng ký thành viên<br>nhận liền điểm thưởng
                    </h3>
                    <p class="text-sm font-bold text-yellow-300 flex items-center gap-1.5">
                        <span class="bg-yellow-300 text-blue-900 text-[10px] px-1.5 py-0.5 rounded font-black">GIẢM THÊM 3%</span>
                        Khi nhập mã HOPLONG
                    </p>
                </div>

                <!-- Thiết kế Mockup điện thoại bằng CSS -->
                <div class="w-[260px] mx-auto bg-slate-900 rounded-[32px] p-2.5 shadow-2xl border-4 border-slate-800 relative">
                    <!-- Notch tai thỏ -->
                    <div class="absolute top-4 left-1/2 transform -translate-x-1/2 w-24 h-4 bg-slate-800 rounded-full z-20 flex items-center justify-center">
                        <div class="w-3 h-3 rounded-full bg-slate-900 border border-slate-800 mr-2"></div>
                        <div class="w-8 h-1 rounded-full bg-slate-900"></div>
                    </div>
                    
                    <!-- Màn hình điện thoại -->
                    <div class="bg-white rounded-[24px] p-4 text-gray-800 text-[10px] space-y-3 pt-6 min-h-[220px]">
                        <p class="font-bold text-[#0B3979] text-center border-b pb-1.5">Lợi ích khi đăng ký:</p>
                        <div class="space-y-2 text-gray-600 font-medium">
                            <p class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-green-500"></i> Giá tốt nhất</p>
                            <p class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-green-500"></i> Tích điểm đổi quà</p>
                            <p class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-green-500"></i> Theo dõi đơn hàng dễ dàng</p>
                            <p class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-green-500"></i> Lưu trữ lịch sử giao dịch tiện ích</p>
                        </div>
                        <div class="pt-1.5 text-center">
                            <span class="inline-block bg-[#0165FC] text-white px-4 py-1.5 rounded-full font-bold shadow hover:bg-blue-600 transition-colors">
                                ĐĂNG KÝ NGAY!
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chân banner -->
            <div class="flex justify-between items-center z-10 text-[10px] text-blue-200 font-medium border-t border-white/10 pt-3">
                <span>© Hoplong Industry Mall 2026</span>
                <span>Hotline: 1900 6536</span>
            </div>
        </div>
        
    </div>

</body>
</html>
