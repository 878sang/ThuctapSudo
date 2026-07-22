@extends('client.layout.main')

@section('content')
<div class="bg-blue_bg pb-12">
    <div class="max-w-[1440px] mx-auto px-4 pt-4">
        <x-breadcrumb :items="[['label' => 'Đăng ký']]" />
    </div>

    <!-- Main Content -->
    <div class="max-w-[1200px] mx-auto flex justify-center">
        <!-- Form Đăng ký -->
        <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" class="w-full rounded-2xl border border-gray-100 shadow-[0_4px_25px_rgba(0,0,0,0.02)] flex flex-col gap-6">
            @csrf

            <!-- Layout 2 cột chia nhỏ thông tin -->
            <div class="flex flex-col lg:flex-row gap-4">

                <div class="w-full lg:w-[42%] space-y-5 bg-white p-5 rounded-[5px]">
                    <div class="relative w-36 h-36 mx-auto mb-8" x-data="{
                        avatarPreview: null,
                        previewAvatar(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.avatarPreview = URL.createObjectURL(file);
                            }
                        }
                    }">
                        <div class="w-full h-full rounded-full bg-[#EDEDED] flex items-center justify-center overflow-hidden border border-gray-100">
                            <template x-if="avatarPreview">
                                <img :src="avatarPreview" class="w-full h-full object-cover" alt="Avatar Preview">
                            </template>
                            <template x-if="!avatarPreview">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#D4D4D4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                            </template>
                        </div>
                        <label for="avatar-input" class="absolute top-2 right-2 bg-white rounded-full p-2.5 border border-gray-200 shadow-sm cursor-pointer hover:bg-gray-50 flex items-center justify-center transition-transform hover:scale-110">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#202F36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z" />
                            </svg>
                            <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" @change="previewAvatar($event)">
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm text-2 mb-2">Tên hiển thị</label>
                        <input name="display_name" type="text" placeholder="Alex"
                            class="w-full px-4 py-3 rounded-[10px] border border-[#D9D9D9] text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-4 placeholder-4">
                    </div>
                    <div>
                        <label class="block text-sm text-2 mb-2">Tên đầy đủ <span class="text-red-500">*</span></label>
                        <input name="name" type="text" value="{{ old('name') }}" required placeholder="Chu Tuấn Anh"
                            class="w-full px-4 py-3 rounded-[10px] border border-[#D9D9D9] text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-4 placeholder-4">
                    </div>
                    <div>
                        <label class="block text-sm text-2 mb-2">Sinh nhật <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-3 gap-3">
                            <!-- Ngày -->
                            <select name="day" required class="w-full px-3 py-3 rounded-[10px] border border-[#D9D9D9] text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-4 bg-white cursor-pointer">
                                <option value="">Ngày</option>
                                @for ($d = 1; $d <= 31; $d++)
                                    <option value="{{ $d }}" {{ old('day') == $d ? 'selected' : '' }}>{{ $d }}</option>
                                    @endfor
                            </select>
                            <!-- Tháng -->
                            <select name="month" required class="w-full px-3 py-3 rounded-[10px] border border-[#D9D9D9] text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-4 bg-white cursor-pointer">
                                <option value="">Tháng</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>Tháng {{ $m }}</option>
                                    @endfor
                            </select>
                            <!-- Năm -->
                            <select name="year" required class="w-full px-3 py-3 rounded-[10px] border border-[#D9D9D9] text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-4 bg-white cursor-pointer">
                                <option value="">Năm</option>
                                @for ($y = date('Y'); $y >= 1950; $y--)
                                <option value="{{ $y }}" {{ old('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div x-data="{ gender: '{{ old('gender', 'Nam') }}' }">
                        <label class="block text-sm text-2 mb-2">Giới tính <span class="text-red-500">*</span></label>
                        <input type="hidden" name="gender" :value="gender">
                        <div class="flex items-center gap-3">
                            <button type="button" @click="gender = 'Nam'" class="flex items-center gap-2 px-3 py-2.5 rounded-[10px] text-sm font-bold text-[#3D3E3F] transition-all cursor-pointer bg-transparent">
                                <span class="w-8 h-8 rounded-[6px] border flex items-center justify-center border-[#D9D9D9] bg-white transition-colors">
                                    <svg x-show="gender === 'Nam'" width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.5 5.45267L6.58254 9.48324L13.6564 2.5" stroke="#0165FC" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                Nam
                            </button>
                            <button type="button" @click="gender = 'Nữ'" class="flex items-center gap-2 px-3 py-2.5 rounded-[10px] text-sm font-semibold transition-all cursor-pointer bg-transparent">
                                <span class="w-8 h-8 rounded-[6px] border flex items-center justify-center border-[#D9D9D9] bg-white transition-colors">
                                    <svg x-show="gender === 'Nữ'" width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.5 5.45267L6.58254 9.48324L13.6564 2.5" stroke="#0165FC" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                Nữ
                            </button>
                            <button type="button" @click="gender = 'Khác'" class="flex items-center gap-2 px-3 py-2.5 rounded-[10px] text-sm font-semibold transition-all cursor-pointer bg-transparent">
                                <span class="w-8 h-8 rounded-[6px] border flex items-center justify-center border-[#D9D9D9] bg-white transition-colors">
                                    <svg x-show="gender === 'Khác'" width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.5 5.45267L6.58254 9.48324L13.6564 2.5" stroke="#0165FC" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                Khác
                            </button>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-[58%] bg-white p-5 rounded-[5px] flex flex-col justify-between">
                    <div>
                        <div class="mb-6">
                            <h2 class="text-[22px] font-bold text-2">Đăng ký</h2>
                            <p class="text-sm text-4 mt-1">Đăng ký ngay để nhận những ưu đãi đến từ Hợp Long</p>
                        </div>

                        <!-- Layout 2 cột con -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                            <!-- CỘT CON TRÁI: Email, Số điện thoại, Checkbox, Lỗi -->
                            <div class="space-y-4">
                                <!-- Email * -->
                                <div>
                                    <label class="block text-sm text-2 mb-2">Email <span class="text-red-500">*</span></label>
                                    <input name="email" type="email" value="{{ old('email') }}" required placeholder="example@hoaphat.com.vn"
                                        class="w-full px-4 py-3 rounded-[10px] border border-[#D9D9D9] text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-4 placeholder-4">
                                </div>

                                <!-- Số điện thoại * -->
                                <div>
                                    <label class="block text-sm text-2 mb-2">Số điện thoại <span class="text-red-500">*</span></label>
                                    <input name="phone" type="text" value="{{ old('phone') }}" required placeholder="(+84) 988-038-291"
                                        class="w-full px-4 py-3 rounded-[10px] border border-[#D9D9D9] text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-4 placeholder-4">
                                </div>

                                <!-- Điều khoản và chính sách Checkbox -->
                                <div class="flex items-start gap-2.5 pt-4" x-data="{ agree: true }">
                                    <label class="relative flex items-center cursor-pointer mt-0.5 select-none">
                                        <input type="checkbox" required name="agree" x-model="agree" class="hidden">
                                        <span class="w-5 h-5 rounded-[5px] border border-[#D9D9D9] flex items-center justify-center transition-colors">
                                            <svg x-show="agree" width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1.5 3.35405C2.92109 4.75705 5.20599 4.7571 6.62714 3.35416L8.50537 1.5" stroke="#66D233" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </label>
                                    <span class="text-sm text-[#5D6F7A] leading-normal font-medium select-none cursor-pointer" @click="agree = !agree">
                                        Khi tạo tài khoản này bạn cần phải đồng ý với chúng tôi các, <a href="#" class="text-[#0165FC] hover:underline font-bold" @click.stop>Điền khoản và chính sách</a>
                                    </span>
                                </div>

                                <!-- Khối báo lỗi validate -->
                                @if($errors->any())
                                <div class="mt-4 p-3 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-start gap-2.5 text-xs text-red-700 leading-snug animate-fade-in">
                                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5 grow-0 shrink-0"></i>
                                    <span>{{ $errors->first() }}</span>
                                </div>
                                @endif
                            </div>

                            <!-- CỘT CON PHẢI: Mật khẩu, Xác nhận lại mật khẩu, Button Đăng ký -->
                            <div class="space-y-4 flex flex-col justify-between">
                                <div class="space-y-4">
                                    <!-- Mật khẩu * -->
                                    <div x-data="{ showPass: false }">
                                        <label class="block text-sm text-2 mb-2">Mật khẩu <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input name="password" :type="showPass ? 'text' : 'password'" required placeholder="********"
                                                class="w-full px-4 py-3 rounded-[10px] border border-[#D9D9D9] text-sm pr-10 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-4 placeholder-4">
                                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center hover:text-gray-600 transition-colors">
                                                <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_276_10327)">
                                                        <path d="M8.51308 9.4998C10.0801 9.4998 11.3504 8.22382 11.3504 6.6498C11.3504 5.07579 10.0801 3.7998 8.51308 3.7998C6.94608 3.7998 5.67578 5.07579 5.67578 6.6498C5.67578 8.22382 6.94608 9.4998 8.51308 9.4998Z" fill="#D4D4D4" />
                                                        <path d="M16.4972 4.81C14.8745 1.9 11.8281 0.07 8.51296 0C5.18785 0.07 2.15144 1.9 0.518754 4.81C-0.178126 5.94 -0.178126 7.36 0.518754 8.48C2.14149 11.39 5.17789 13.22 8.50301 13.3C11.8281 13.23 14.8645 11.4 16.4873 8.48C17.1841 7.35 17.1841 5.93 16.4873 4.81H16.4972ZM8.51296 10.92C6.16348 10.92 4.262 9.01 4.262 6.65C4.262 4.29 6.16348 2.38 8.51296 2.38C10.8624 2.38 12.7639 4.29 12.7639 6.65C12.7639 9.01 10.8624 10.92 8.51296 10.92Z" fill="#D4D4D4" />
                                                        <line x1="2" y1="2" x2="16" y2="12" stroke="#D4D4D4" stroke-width="1.5" x-show="showPass" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_276_10327">
                                                            <rect width="17.0138" height="13.31" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Xác nhận lại mật khẩu * -->
                                    <div x-data="{ showPass: false }">
                                        <label class="block text-sm text-2 mb-2">Xác nhận lại mật khẩu <span class="text-red-500">*</span></label>
                                        <div class="relative">
                                            <input name="password_confirmation" :type="showPass ? 'text' : 'password'" required placeholder="********"
                                                class="w-full px-4 py-3 rounded-[10px] border border-[#D9D9D9] text-sm pr-10 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-4 placeholder-4">
                                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center hover:text-gray-600 transition-colors">
                                                <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_276_10327)">
                                                        <path d="M8.51308 9.4998C10.0801 9.4998 11.3504 8.22382 11.3504 6.6498C11.3504 5.07579 10.0801 3.7998 8.51308 3.7998C6.94608 3.7998 5.67578 5.07579 5.67578 6.6498C5.67578 8.22382 6.94608 9.4998 8.51308 9.4998Z" fill="#D4D4D4" />
                                                        <path d="M16.4972 4.81C14.8745 1.9 11.8281 0.07 8.51296 0C5.18785 0.07 2.15144 1.9 0.518754 4.81C-0.178126 5.94 -0.178126 7.36 0.518754 8.48C2.14149 11.39 5.17789 13.22 8.50301 13.3C11.8281 13.23 14.8645 11.4 16.4873 8.48C17.1841 7.35 17.1841 5.93 16.4873 4.81H16.4972ZM8.51296 10.92C6.16348 10.92 4.262 9.01 4.262 6.65C4.262 4.29 6.16348 2.38 8.51296 2.38C10.8624 2.38 12.7639 4.29 12.7639 6.65C12.7639 9.01 10.8624 10.92 8.51296 10.92Z" fill="#D4D4D4" />
                                                        <line x1="2" y1="2" x2="16" y2="12" stroke="#D4D4D4" stroke-width="1.5" x-show="showPass" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_276_10327">
                                                            <rect width="17.0138" height="13.31" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <!-- Button Đăng ký -->
                                    <button type="submit" class="w-full bg-7 hover:bg-blue-600 text-white font-bold py-3.5 rounded-lg text-base transition-all shadow-md hover:shadow-lg cursor-pointer">
                                        Đăng ký ngay
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </form>
    </div>
</div>
@endsection