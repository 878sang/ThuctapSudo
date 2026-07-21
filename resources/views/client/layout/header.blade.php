@inject('cartService', 'App\Services\Interfaces\CartServiceInterface')
<header class="w-full bg-white" x-data>
    <div class="border-b border-gray-300 py-6">
        <div class="max-w-[1440px] mx-auto flex flex-col lg:flex-row lg:items-start justify-between gap-4 lg:gap-6">
            <div class="flex items-center justify-between w-full lg:w-auto">
                <a href="{{ route('categories.showClient') }}" class="flex items-center">
                    <img src="{{ asset('storage/images/Group 1.png') }}" alt="Logo">
                </a>
            </div>
            <div class="flex-1 max-w-[580px] w-full flex flex-col">
                <div class="flex h-[45px] items-center border-1 border-gray-200 rounded-full  bg-white hover:border-gray-300">
                    <div class="bg-8 text-7 ml-3 my-2 px-3 py-2 rounded-full text-xs font-bold flex items-center gap-1.5 border border-blue-100 shrink-0">
                        <span>Sản phẩm</span>
                        <button class="hover:bg-blue-100 rounded-full p-0.5 transition-colors flex items-center justify-center">
                            <i class="fa-solid fa-xmark text-[10px]"></i>
                        </button>
                    </div>
                    <input type="text"
                        placeholder="Nhập từ khóa để tìm kiếm sản phẩm"
                        class="w-full bg-transparent px-3 py-1.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none" />
                    <button class="bg-7 hover:bg-blue-600 text-white w-[73px]  h-full rounded-r-full flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>
                </div>
                <div class="sm:flex items-center gap-2 mt-2 px-1 text-xs">
                    <span class="text-5 font-bold">Tìm kiếm nhiều nhất :</span>
                    <div class="flex flex-wrap gap-1">
                        <span class="bg-[#F2F2F2] text-[#B6B6B6] px-1.5 py-1 rounded-full cursor-pointer">Cảm biến áp suất</span>
                        <span class="bg-[#F2F2F2] text-[#B6B6B6] px-1.5 py-1 rounded-full cursor-pointer">Cảm biến quang</span>
                        <span class="bg-[#F2F2F2] text-[#B6B6B6] px-1.5 py-1 rounded-full cursor-pointer">Cảm biến tiệm cận</span>
                        <span class="bg-[#F2F2F2] text-[#B6B6B6] px-1.5 py-1 rounded-full cursor-pointer">Cảm biến cửa</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between sm:justify-end gap-6 lg:gap-8 shrink-0">
                <div class="md:flex items-center gap-2.5">
                    <div class="text-7">
                        <i class="fa-solid fa-phone text-lg"></i>
                    </div>
                    <div class="text-sm">
                        <span class="text-gray-800 font-bold block leading-tight text-sm">Hotline: 1900 6536</span>
                    </div>
                </div>
                <a href="#" class="md:flex items-center gap-2.5 group">
                    <div class="text-7 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-location-dot text-lg"></i>
                    </div>
                    <span class="text-gray-800 font-bold text-sm group-hover:text-7 transition-colors">Hệ thống chi nhánh</span>
                </a>
                <div class="flex items-center gap-3">
                    <div class="w-10.5 h-10.5 text-base rounded-full bg-8 text-7 flex items-center justify-center cursor-pointer hover:bg-blue-100 hover:scale-105 transition-all duration-200">
                        <div class="relative">
                            <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="45" height="45" rx="22.5" fill="#DDECFF" />
                                <path d="M31.2645 23.4539L29.827 18.6883C28.6864 14.5633 24.4051 12.1414 20.2645 13.2821C17.5145 14.0477 15.3895 16.2664 14.7645 19.0633L13.6551 23.6727C13.1082 25.9071 14.4832 28.1571 16.7176 28.7039C17.0457 28.7821 17.3739 28.8289 17.702 28.8289H27.2957C29.5926 28.8289 31.4676 26.9696 31.4676 24.6571C31.4676 24.2508 31.4051 23.8446 31.2957 23.4539H31.2645Z" fill="#006DF0" />
                                <path d="M18.6875 30.8291C19.6094 32.9385 22.0469 33.8916 24.1562 32.9854C25.125 32.5635 25.8906 31.7979 26.3125 30.8291H18.6875Z" fill="#006DF0" />
                            </svg>
                            <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-[8px] font-bold rounded-full w-3.5 h-3.5 flex items-center justify-center border border-white shadow-sm animate-pulse">1</span>
                        </div>
                    </div>
                    <a href="{{ route('cart.showClient') }}" class="w-10.5 h-10.5 text-base rounded-full bg-8 text-7 flex items-center justify-center cursor-pointer hover:bg-blue-100 hover:scale-105 transition-all duration-200">
                        <div class="relative">
                            <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="45" height="45" rx="22.5" fill="#DDECFF" />
                                <path d="M31.7014 15.6638C31.7014 15.6638 30.4792 14.8861 29.8125 14.8861H16.3681V14.6638C16.1458 13.3305 15.0347 12.5527 13.8125 12.5527H13.5903C13.5903 12.5527 12.8125 12.8861 12.8125 13.3305C12.8125 13.775 13.2569 14.1083 13.5903 14.1083H13.8125C13.8125 14.1083 14.5903 14.3305 14.5903 14.775L15.7014 23.6638C16.0347 25.6638 17.8125 27.1083 19.8125 26.9972H28.4792C28.4792 26.9972 29.2569 26.775 29.2569 26.3305C29.2569 25.8861 29.0347 25.5527 28.5903 25.5527C28.5903 25.5527 28.5903 25.5527 28.4792 25.5527H19.8125C18.8125 25.5527 17.8125 24.9972 17.4792 23.9972H27.3681C29.2569 23.9972 31.0347 22.775 31.4792 20.8861L32.1458 17.5527C32.2569 16.8861 32.1458 16.2194 31.5903 15.6638H31.7014Z" fill="#006DF0" />
                                <path d="M18.6089 32.4479C19.8362 32.4479 20.8312 31.4529 20.8312 30.2256C20.8312 28.9983 19.8362 28.0034 18.6089 28.0034C17.3816 28.0034 16.3867 28.9983 16.3867 30.2256C16.3867 31.4529 17.3816 32.4479 18.6089 32.4479Z" fill="#006DF0" />
                                <path d="M26.3863 32.4479C27.6136 32.4479 28.6085 31.4529 28.6085 30.2256C28.6085 28.9983 27.6136 28.0034 26.3863 28.0034C25.159 28.0034 24.1641 28.9983 24.1641 30.2256C24.1641 31.4529 25.159 32.4479 26.3863 32.4479Z" fill="#006DF0" />
                            </svg>
                            <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-[8px] font-bold rounded-full w-3.5 h-3.5 flex items-center justify-center border border-white shadow-sm animate-pulse" id="cart-count">{{ $cartService->getCartCount() }}</span>
                        </div>
                    </a>
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <div @click="open = !open" class="w-10.5 h-10.5 text-base rounded-full bg-8 text-7 flex items-center justify-center cursor-pointer hover:bg-blue-100 hover:scale-105 transition-all duration-200">
                                <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="45" height="45" rx="22.5" fill="#DDECFF" />
                                    <path d="M22.5004 22.7273C25.3245 22.7273 27.614 20.4378 27.614 17.6136C27.614 14.7895 25.3245 12.5 22.5004 12.5C19.6762 12.5 17.3867 14.7895 17.3867 17.6136C17.3867 20.4378 19.6762 22.7273 22.5004 22.7273Z" fill="#006DF0" />
                                    <path d="M22.5004 24.4316C18.2958 24.4316 14.8867 27.6135 14.8867 31.7044C14.8867 32.1589 15.2276 32.4998 15.6822 32.4998H29.3185C29.3185 32.4998 30.114 32.1589 30.114 31.7044C30.114 27.7271 26.7049 24.4316 22.5004 24.4316Z" fill="#006DF0" />
                                </svg>
                            </div>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-[100] text-xs text-gray-700 font-medium" x-cloak>
                                <div class="px-4 py-2 border-b border-gray-100 font-bold text-gray-800 truncate">
                                    Chào, {{ auth()->user()->name }}
                                </div>
                                <form action="{{ route('logout') }}" method="POST" class="w-full m-0">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-50 text-red-500 font-bold flex items-center gap-2 cursor-pointer bg-transparent border-none">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div @click="$dispatch('open-login-modal')" class="w-10.5 h-10.5 text-base rounded-full bg-8 text-7 flex items-center justify-center cursor-pointer hover:bg-blue-100 hover:scale-105 transition-all duration-200">
                            <svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="45" height="45" rx="22.5" fill="#DDECFF" />
                                <path d="M22.5004 22.7273C25.3245 22.7273 27.614 20.4378 27.614 17.6136C27.614 14.7895 25.3245 12.5 22.5004 12.5C19.6762 12.5 17.3867 14.7895 17.3867 17.6136C17.3867 20.4378 19.6762 22.7273 22.5004 22.7273Z" fill="#006DF0" />
                                <path d="M22.5004 24.4316C18.2958 24.4316 14.8867 27.6135 14.8867 31.7044C14.8867 32.1589 15.2276 32.4998 15.6822 32.4998H29.3185C29.3185 32.4998 30.114 32.1589 30.114 31.7044C30.114 27.7271 26.7049 24.4316 22.5004 24.4316Z" fill="#006DF0" />
                            </svg>
                        </div>
                    @endauth
                </div>

            </div>
        </div>
    </div>
    @include('client.layout.menu')
</header>