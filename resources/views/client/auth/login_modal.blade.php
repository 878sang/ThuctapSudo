<!-- Login Modal Only -->
<div x-data="{ isOpen: {{ (($errors->has('login') || $errors->has('password')) && !old('register_attempt')) ? 'true' : 'false' }} || new URLSearchParams(window.location.search).has('login') }"
    @open-login-modal.window="isOpen = true"
    @close-login-modal.window="isOpen = false"
    x-show="isOpen"
    x-cloak
    class="fixed inset-0 z-[9999] flex items-center justify-center p-4">

    <!-- Nền mờ riêng biệt (Bấm vào đây để đóng modal) -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-all duration-300"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="isOpen = false"></div>

    <!-- Modal Content Card (z-10 nổi bật trên nền) -->
    <div class="max-w-[1176px] w-full bg-white rounded-2xl shadow-2xl flex flex-col md:flex-row min-h-[520px] border border-gray-100 relative z-10 animate-scale-up"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95">

        <!-- Nút Close (X) góc trên bên phải -->
        <button @click="isOpen = false" class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-10 z-50 h-10 flex items-center justify-center cursor-pointer transition-transform hover:scale-110 focus:outline-none">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="19.5864" cy="19.5864" r="19.5864" fill="#0165FC" />
                <path d="M13.0781 13.0776L26.0959 26.0954" stroke="white" stroke-width="2" stroke-linecap="round" />
                <path d="M13.0781 26.0942L26.0959 13.0765" stroke="white" stroke-width="2" stroke-linecap="round" />
            </svg>
        </button>

        <!-- CỘT TRÁI: FORM ĐĂNG NHẬP -->
        <div class="w-full md:w-[40%] p-8 sm:p-10 flex flex-col justify-between">
            <div>
                <div class="mb-5">
                    <h2 class="text-2xl font-bold text-2 flex justify-center items-center gap-2">
                        Chào mừng bạn quay trở lại
                        <svg width="38" height="36" viewBox="0 0 38 36" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <rect width="38" height="36" fill="url(#pattern0_276_10283)" />
                            <defs>
                                <pattern id="pattern0_276_10283" patternContentUnits="objectBoundingBox" width="1" height="1">
                                    <use xlink:href="#image0_276_10283" transform="matrix(0.0227273 0 0 0.0239899 0 -0.00378788)" />
                                </pattern>
                                <image id="image0_276_10283" width="44" height="42" preserveAspectRatio="none" xlink:href="data:image/png;base64,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" />
                            </defs>
                        </svg>
                    </h2>
                </div>
                <div class="space-y-2.5 text-[#494849]">
                    <a href="#" class="w-full flex items-center justify-center gap-2.5 py-2.5 px-4 border border-[#D9D9D9] rounded-lg hover:bg-gray-50 transition-colors text-sm">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.6364 10.146L13.6174 10.1455C13.175 10.1455 12.8164 10.5041 12.8164 10.9465V14.1471C12.8164 14.5894 13.175 14.9481 13.6174 14.9481H19.2595C18.6416 16.5514 17.4885 17.8942 16.0174 18.7474L18.4231 22.912C22.2823 20.6801 24.5638 16.764 24.5638 12.3802C24.5638 11.756 24.5178 11.3097 24.4258 10.8073C24.3559 10.4256 24.0245 10.146 23.6364 10.146Z" fill="#167EE6" />
                            <path d="M12.279 19.7571C9.51791 19.7571 7.10749 18.2485 5.8129 16.0161L1.64844 18.4165C3.7677 22.0895 7.73777 24.5629 12.279 24.5629C14.5068 24.5629 16.6089 23.9631 18.4197 22.9178V22.912L16.014 18.7474C14.9135 19.3856 13.6401 19.7571 12.279 19.7571Z" fill="#12B347" />
                            <path d="M18.422 22.9179V22.9122L16.0162 18.7476C14.9158 19.3858 13.6424 19.7573 12.2812 19.7573V24.5631C14.509 24.5631 16.6112 23.9632 18.422 22.9179Z" fill="#0F993E" />
                            <path d="M4.80578 12.2815C4.80578 10.9205 5.1772 9.64722 5.81531 8.54683L1.65085 6.14648C0.599775 7.95162 0 10.048 0 12.2815C0 14.515 0.599775 16.6114 1.65085 18.4165L5.81531 16.0162C5.1772 14.9158 4.80578 13.6425 4.80578 12.2815Z" fill="#FFD500" />
                            <path d="M12.279 4.80578C14.0796 4.80578 15.7334 5.44557 17.0252 6.50978C17.3439 6.7723 17.8071 6.75335 18.099 6.46143L20.3668 4.19368C20.698 3.86246 20.6744 3.3203 20.3206 3.01337C18.1562 1.1357 15.3401 0 12.279 0C7.73777 0 3.7677 2.47341 1.64844 6.14643L5.8129 8.54677C7.10749 6.31438 9.51791 4.80578 12.279 4.80578Z" fill="#FF4B26" />
                            <path d="M17.0274 6.50978C17.3461 6.7723 17.8094 6.75335 18.1013 6.46143L20.369 4.19368C20.7002 3.86246 20.6766 3.32031 20.3228 3.01337C18.1584 1.13565 15.3423 0 12.2812 0V4.80578C14.0817 4.80578 15.7356 5.44557 17.0274 6.50978Z" fill="#D93F21" />
                        </svg>
                        Đăng nhập bằng Google
                    </a>
                    <a href="#" class="w-full flex items-center justify-center gap-2.5 py-2.5 px-4 border border-[#D9D9D9] rounded-lg hover:bg-gray-50 transition-colors text-sm">
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12.28 24.56C19.0621 24.56 24.56 19.0621 24.56 12.28C24.56 5.49794 19.0621 0 12.28 0C5.49794 0 0 5.49794 0 12.28C0 19.0621 5.49794 24.56 12.28 24.56Z" fill="#3B5998" />
                            <path d="M15.3674 12.7609H13.1762V20.7885H9.85629V12.7609H8.27734V9.93967H9.85629V8.11403C9.85629 6.80849 10.4764 4.76416 13.2057 4.76416L15.6649 4.77445V7.51292H13.8806C13.5879 7.51292 13.1764 7.65915 13.1764 8.28193V9.9423H15.6574L15.3674 12.7609Z" fill="white" />
                        </svg>
                        Đăng nhập bằng Facebook
                    </a>
                </div>

                <!-- Phân cách "Hoặc" -->
                <div class="flex items-center my-5">
                    <div class="flex-grow border-t border-[#E9E9E9]"></div>
                    <span class="px-3 text-sm text-4">Hoặc</span>
                    <div class="flex-grow border-t border-[#E9E9E9]"></div>
                </div>

                <!-- Form Submit đăng nhập -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-base font-bold text-2 mb-2.5">Email/ Số điện thoại</label>
                        <div class="relative">
                            <input name="login" type="text" value="{{ old('login') }}" required
                                placeholder="Email hoặc Số điện thoại"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-[#D9D9D9] text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 pr-10 text-4">
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-4">
                                <svg width="17" height="15" viewBox="0 0 17 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.4963 2.93969L10.7029 8.37969C9.36103 9.63969 7.17785 9.63969 5.836 8.37969L0.0319489 2.93969C0.0319489 3.03969 0 3.13969 0 3.23969V10.9997C0 12.7797 1.5442 14.2297 3.43983 14.2297H13.0777C14.984 14.2297 16.5176 12.7797 16.5176 10.9997V3.22969C16.5176 3.12969 16.4963 3.03969 16.4856 2.92969L16.4963 2.93969Z" fill="#D4D4D4" />
                                    <path d="M9.7343 7.47L16.0176 1.56C15.3999 0.59 14.2817 0 13.0889 0H3.45102C2.24761 0 1.1294 0.59 0.511719 1.56L6.80565 7.47C7.61502 8.23 8.92493 8.23 9.72365 7.47H9.7343Z" fill="#D4D4D4" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div x-data="{ showPass: false }">
                        <label class="block text-base font-bold text-2 mb-1.5">Mật khẩu</label>
                        <div class="relative">
                            <input name="password" :type="showPass ? 'text' : 'password'" required
                                placeholder="********"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-[#D9D9D9] text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 pr-10 text-4">
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-4 hover:text-gray-600 transition-colors">
                                <i class="fa-regular" :class="showPass ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm pt-1">
                        <label class="flex items-center text-3 cursor-pointer font-medium select-none">
                            <input type="checkbox" name="remember" class="rounded border-[#D9D9D9] text-blue-600 focus:ring-blue-500 mr-1.5 w-4 h-4 cursor-pointer">
                            Nhớ mật khẩu
                        </label>
                        <a href="#" class="text-6 hover:underline">Bạn quên mật khẩu ?</a>
                    </div>

                    <button type="submit" class="w-full bg-7 hover:bg-blue-600 text-white font-bold py-3 rounded-lg text-lg transition-all shadow-md hover:shadow-lg mt-2 cursor-pointer">
                        Đăng nhập
                    </button>
                </form>

                <!-- Lỗi Đăng nhập -->
                @if(($errors->has('login') || $errors->has('password')) && !old('register_attempt'))
                <div class="mt-4 p-3 bg-red-50 border-l-4 border-red-500 rounded-r-lg flex items-start gap-2.5 text-xs text-red-700 leading-snug">
                    <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5 shrink-0"></i>
                    <span>{{ $errors->has('login') ? $errors->first('login') : $errors->first('password') }}</span>
                </div>
                @endif
            </div>

            <div class="text-center text-sm text-gray-500 mt-6 pt-4 font-medium">
                Bạn chưa có tài khoản ? <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-bold">Đăng ký ngay</a>
            </div>
        </div>

        <!-- CỘT PHẢI: BANNER BÊN TRONG MODAL -->
        <div class="hidden md:flex w-[60%] p-5">
            <img src="{{ asset('storage/images/bglogin.jpg') }}" alt="" class="rounded-[20px]">
        </div>

    </div>
</div>