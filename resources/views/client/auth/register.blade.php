<!DOCTYPE html>
<html lang="vi" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng ký tài khoản mới - Hoplong Industry Mall</title>
    
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

    <!-- Container Card đăng ký -->
    <div class="max-w-5xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[580px] border border-gray-100 animate-fade-in">
        
        <!-- Cột TRÁI: Form đăng ký -->
        <div class="w-full md:w-[48%] p-8 sm:p-10 flex flex-col justify-between">
            <div>
                <!-- Header Form -->
                <div class="mb-5">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        Tạo tài khoản mới 👋
                    </h2>
                    <p class="text-xs text-gray-400 mt-1.5 font-medium">Đăng ký thành viên để nhận ngay 3% giảm giá</p>
                </div>

                <!-- Form đăng ký chính -->
                <form action="{{ route('register.post') }}" method="POST" class="space-y-3.5">
                    @csrf

                    <!-- Nhập Họ và tên -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-gray-700 mb-1">Họ và tên</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required 
                            placeholder="Nguyễn Văn A"
                            class="w-full px-3.5 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-800 placeholder-gray-400">
                    </div>

                    <!-- Nhập Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 mb-1">Địa chỉ Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required 
                            placeholder="example@gmail.com"
                            class="w-full px-3.5 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-800 placeholder-gray-400">
                    </div>

                    <!-- Nhập Số điện thoại -->
                    <div>
                        <label for="phone" class="block text-xs font-bold text-gray-700 mb-1">Số điện thoại</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required 
                            placeholder="0988xxxxxx"
                            class="w-full px-3.5 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-800 placeholder-gray-400">
                    </div>

                    <!-- Nhập Mật khẩu -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 mb-1">Mật khẩu</label>
                        <input id="password" name="password" type="password" required 
                            placeholder="Tối thiểu 6 ký tự"
                            class="w-full px-3.5 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-800 placeholder-gray-400">
                    </div>

                    <!-- Xác nhận Mật khẩu -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-gray-700 mb-1">Xác nhận mật khẩu</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required 
                            placeholder="Nhập lại mật khẩu"
                            class="w-full px-3.5 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-800 placeholder-gray-400">
                    </div>

                    <!-- Nút Đăng ký -->
                    <button type="submit" class="w-full bg-[#0165FC] hover:bg-blue-600 text-white font-bold py-2.5 rounded-lg text-sm transition-all shadow-md hover:shadow-lg mt-3 cursor-pointer">
                        Đăng ký ngay
                    </button>
                </form>

                <!-- Khối thông báo lỗi (Error Alert) -->
                @if($errors->any())
                <div class="mt-3.5 p-3 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-start gap-2.5 text-xs text-red-700 leading-snug animate-fade-in">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5 grow-0 shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif
            </div>

            <!-- Footer Form -->
            <div class="text-center text-xs text-gray-500 mt-5 pt-3 border-t border-gray-100 font-medium">
                Bạn đã có tài khoản ? <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-bold">Đăng nhập ngay</a>
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
                            <a href="{{ route('login') }}" class="inline-block bg-[#0165FC] text-white px-4 py-1.5 rounded-full font-bold shadow hover:bg-blue-600 transition-colors">
                                ĐĂNG NHẬP NGAY!
                            </a>
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
