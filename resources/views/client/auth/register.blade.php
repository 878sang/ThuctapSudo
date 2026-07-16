@extends('client.layout.main')

@section('content')
<!-- Breadcrumbs -->
<div class="max-w-[1440px] mx-auto px-4 py-4 text-xs text-gray-500 font-medium">
    <a href="{{ route('categories.showClient') }}" class="hover:underline">Trang chủ</a>
    <span class="mx-1.5"><i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i></span>
    <span class="text-gray-800">Đăng ký</span>
</div>

<!-- Main Content -->
<div class="max-w-[1200px] mx-auto px-4 pb-16 flex justify-center">
    <!-- Form Đăng ký -->
    <form action="{{ route('register.post') }}" method="POST" class="max-w-4xl w-full bg-white rounded-2xl border border-gray-100 shadow-[0_4px_25px_rgba(0,0,0,0.02)] p-6 sm:p-10 flex flex-col gap-6">
        @csrf
        
        <!-- Header Form -->
        <div class="border-b border-gray-100 pb-4">
            <h2 class="text-xl font-extrabold text-gray-800">Đăng ký thành viên</h2>
            <p class="text-xs text-gray-400 mt-1 font-medium">Đăng ký tài khoản ngay để nhận những ưu đãi đến từ Hợp Long</p>
        </div>

        <!-- Layout 2 cột chia nhỏ thông tin -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            
            <!-- CỘT 1: THÔNG TIN CÁ NHÂN -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold uppercase text-gray-400 tracking-wider">Thông tin cá nhân</h3>
                
                <!-- Họ và tên -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Họ và tên <span class="text-red-500">*</span></label>
                    <input name="name" type="text" value="{{ old('name') }}" required placeholder="Chu Tuấn Anh"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-800 placeholder-gray-400">
                </div>

                <!-- Sinh nhật -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Sinh nhật <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-3 gap-2">
                        <!-- Ngày -->
                        <select name="day" required class="px-2 py-2.5 rounded-lg border border-gray-200 text-xs focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700">
                            <option value="">Ngày</option>
                            @for ($d = 1; $d <= 31; $d++)
                                <option value="{{ $d }}" {{ old('day') == $d ? 'selected' : '' }}>{{ $d }}</option>
                            @endfor
                        </select>
                        <!-- Tháng -->
                        <select name="month" required class="px-2 py-2.5 rounded-lg border border-gray-200 text-xs focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700">
                            <option value="">Tháng</option>
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>Tháng {{ $m }}</option>
                            @endfor
                        </select>
                        <!-- Năm -->
                        <select name="year" required class="px-2 py-2.5 rounded-lg border border-gray-200 text-xs focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-700">
                            <option value="">Năm</option>
                            @for ($y = date('Y'); $y >= 1950; $y--)
                                <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Giới tính -->
                <div x-data="{ gender: '{{ old('gender', 'Nam') }}' }">
                    <label class="block text-xs font-bold text-gray-700 mb-2">Giới tính <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 text-xs font-semibold text-gray-600 cursor-pointer select-none">
                            <input type="radio" name="gender" value="Nam" x-model="gender" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            Nam
                        </label>
                        <label class="flex items-center gap-2 text-xs font-semibold text-gray-600 cursor-pointer select-none">
                            <input type="radio" name="gender" value="Nữ" x-model="gender" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            Nữ
                        </label>
                        <label class="flex items-center gap-2 text-xs font-semibold text-gray-600 cursor-pointer select-none">
                            <input type="radio" name="gender" value="Khác" x-model="gender" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            Khác
                        </label>
                    </div>
                </div>
            </div>

            <!-- CỘT 2: THÔNG TIN TÀI KHOẢN -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold uppercase text-gray-400 tracking-wider">Thông tin tài khoản</h3>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input name="email" type="email" value="{{ old('email') }}" required placeholder="example@hoaphat.com.vn"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-800 placeholder-gray-400">
                </div>

                <!-- Số điện thoại -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Số điện thoại <span class="text-red-500">*</span></label>
                    <input name="phone" type="text" value="{{ old('phone') }}" required placeholder="(+84) 988-038-291"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-800 placeholder-gray-400">
                </div>

                <!-- Mật khẩu -->
                <div x-data="{ showPass: false }">
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Mật khẩu <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input name="password" :type="showPass ? 'text' : 'password'" required placeholder="********"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm pr-10 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-800 placeholder-gray-400">
                        <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fa-regular" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Xác nhận Mật khẩu -->
                <div x-data="{ showPass: false }">
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Xác nhận lại mật khẩu <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input name="password_confirmation" :type="showPass ? 'text' : 'password'" required placeholder="********"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm pr-10 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-800 placeholder-gray-400">
                        <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                            <i class="fa-regular" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Điều khoản và chính sách Checkbox -->
        <div class="flex items-start gap-2 pt-2 border-t border-gray-100">
            <input type="checkbox" required checked id="agree" class="w-4.5 h-4.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 mt-0.5 cursor-pointer">
            <label for="agree" class="text-[11px] text-gray-500 leading-normal font-medium cursor-pointer select-none">
                Khi tạo tài khoản này bạn cần phải đồng ý với chúng tôi các, <a href="#" class="text-blue-600 hover:underline font-bold">Điều khoản và chính sách</a>
            </label>
        </div>

        <!-- Khối báo lỗi validate -->
        @if($errors->any())
        <div class="p-3 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-start gap-2.5 text-xs text-red-700 leading-snug animate-fade-in">
            <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5 grow-0 shrink-0"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <!-- Button Đăng ký -->
        <div class="mt-2">
            <button type="submit" class="w-full bg-[#0165FC] hover:bg-blue-600 text-white font-bold py-3 rounded-lg text-sm transition-all shadow-md hover:shadow-lg cursor-pointer">
                Đăng ký ngay
            </button>
        </div>

        <!-- Link về đăng nhập -->
        <div class="text-center text-xs text-gray-500 pt-3 border-t border-gray-100 font-medium">
            Bạn đã có tài khoản ? <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-bold">Đăng nhập ngay</a>
        </div>

    </form>
</div>
@endsection
