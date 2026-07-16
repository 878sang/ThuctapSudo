<!-- Login Modal Only -->
<div x-data="{ isOpen: {{ ($errors->any() && !old('register_attempt')) ? 'true' : 'false' }} || new URLSearchParams(window.location.search).has('login') }"
    @open-login-modal.window="isOpen = true"
    @close-login-modal.window="isOpen = false"
    @click="isOpen = false"
    x-show="isOpen"
    x-cloak
    class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm transition-all duration-300"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <!-- Modal Content Card -->
    <div class="max-w-4xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[520px] border border-gray-100 relative animate-scale-up"
        @click.stop>

        <!-- Nút Close (X) góc trên bên phải -->
        <button @click="isOpen = false" class="absolute top-4 right-4 z-50 text-gray-400 hover:text-gray-600 bg-gray-100 hover:bg-gray-200 w-8 h-8 rounded-full flex items-center justify-center transition-all cursor-pointer">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>

        <!-- CỘT TRÁI: FORM ĐĂNG NHẬP -->
        <div class="w-full md:w-[48%] p-8 sm:p-10 flex flex-col justify-between">
            <div>
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

                <!-- Form Submit đăng nhập -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Email/ Số điện thoại</label>
                        <div class="relative">
                            <input name="login" type="text" value="{{ old('login') }}" required
                                placeholder="Email hoặc Số điện thoại"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 pr-10 text-gray-800">
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400">
                                <i class="fa-regular fa-envelope"></i>
                            </span>
                        </div>
                    </div>

                    <div x-data="{ showPass: false }">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Mật khẩu</label>
                        <div class="relative">
                            <input name="password" :type="showPass ? 'text' : 'password'" required
                                placeholder="********"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 pr-10 text-gray-800">
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fa-regular" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center text-gray-500 cursor-pointer font-medium select-none">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-1.5 w-4 h-4 cursor-pointer">
                            Nhớ mật khẩu
                        </label>
                        <a href="#" class="text-blue-600 hover:underline font-semibold">Bạn quên mật khẩu ?</a>
                    </div>

                    <button type="submit" class="w-full bg-[#0165FC] hover:bg-blue-600 text-white font-bold py-3 rounded-lg text-sm transition-all shadow-md hover:shadow-lg mt-2 cursor-pointer">
                        Đăng nhập
                    </button>
                </form>

                <!-- Lỗi Đăng nhập -->
                @if($errors->any() && !old('register_attempt'))
                <div class="mt-4 p-3 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-start gap-2.5 text-xs text-red-700 leading-snug">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5 shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif
            </div>

            <div class="text-center text-xs text-gray-500 mt-6 pt-4 border-t border-gray-100 font-medium">
                Bạn chưa có tài khoản ? <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-bold">Đăng ký ngay</a>
            </div>
        </div>

        <!-- CỘT PHẢI: BANNER BÊN TRONG MODAL -->
        <div class="hidden md:flex w-[52%] bg-gradient-to-br from-[#0B3979] to-[#0165FC] p-8 text-white flex-col justify-between relative overflow-hidden select-none">
            <div class="absolute -top-12 -right-12 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -left-16 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex items-center gap-1.5 z-10">
                <span class="font-extrabold text-base tracking-wider italic text-white flex items-center gap-1">
                    <span class="bg-white text-[#0B3979] px-2 py-0.5 rounded not-italic font-black text-xs">hoplong</span>
                    INDUSTRY MALL
                </span>
            </div>

            <div class="my-auto space-y-5 z-10">
                <div class="space-y-1">
                    <h3 class="text-xl font-black uppercase tracking-wide leading-tight">
                        Đăng ký thành viên<br>nhận liền điểm thưởng
                    </h3>
                    <p class="text-xs font-bold text-yellow-300 flex items-center gap-1.5">
                        <span class="bg-yellow-300 text-blue-900 text-[9px] px-1.5 py-0.5 rounded font-black">GIẢM THÊM 3%</span>
                        Khi nhập mã HOPLONG
                    </p>
                </div>

                <!-- Mockup điện thoại -->
                <div class="w-[210px] mx-auto bg-slate-900 rounded-[28px] p-2 shadow-2xl border-2 border-slate-800 relative scale-95">
                    <div class="absolute top-3 left-1/2 transform -translate-x-1/2 w-20 h-3 bg-slate-800 rounded-full z-20 flex items-center justify-center">
                        <div class="w-1.5 h-1.5 rounded-full bg-slate-900 mr-2"></div>
                        <div class="w-6 h-0.5 rounded-full bg-slate-900"></div>
                    </div>

                    <div class="bg-white rounded-[20px] p-3 text-gray-800 text-[9px] space-y-2 pt-5 min-h-[170px]">
                        <p class="font-bold text-[#0B3979] text-center border-b pb-1">Lợi ích khi đăng ký:</p>
                        <div class="space-y-1.5 text-gray-600 font-medium">
                            <p class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-green-500"></i> Giá tốt nhất</p>
                            <p class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-green-500"></i> Tích điểm đổi quà</p>
                            <p class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-green-500"></i> Theo dõi đơn hàng dễ dàng</p>
                            <p class="flex items-center gap-1"><i class="fa-solid fa-circle-check text-green-500"></i> Lưu trữ lịch sử giao dịch</p>
                        </div>
                        <div class="pt-2 text-center">
                            <a href="{{ route('register') }}" class="inline-block bg-[#0165FC] text-white px-4 py-1.5 rounded-full font-bold shadow hover:bg-blue-600 transition-colors text-[8px] cursor-pointer">
                                ĐĂNG KÝ NGAY!
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center z-10 text-[9px] text-blue-200 font-medium border-t border-white/10 pt-2">
                <span>© Hoplong Industry Mall 2026</span>
                <span>Hotline: 1900 6536</span>
            </div>
        </div>

    </div>
</div>