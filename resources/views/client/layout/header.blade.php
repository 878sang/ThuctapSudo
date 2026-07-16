@inject('cartService', 'App\Services\Interfaces\CartServiceInterface')
<header class="w-full bg-white">
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
                            <i class="fa-solid fa-bell"></i>
                            <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-[8px] font-bold rounded-full w-3.5 h-3.5 flex items-center justify-center border border-white shadow-sm animate-pulse">1</span>
                        </div>
                    </div>
                    <a href="{{ route('cart.showClient') }}" class="w-10.5 h-10.5 text-base rounded-full bg-8 text-7 flex items-center justify-center cursor-pointer hover:bg-blue-100 hover:scale-105 transition-all duration-200">
                        <div class="relative">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-[8px] font-bold rounded-full w-3.5 h-3.5 flex items-center justify-center border border-white shadow-sm animate-pulse" id="cart-count">{{ $cartService->getCartCount() }}</span>
                        </div>
                    </a>
                    <div class="w-10.5 h-10.5 text-base rounded-full bg-8 text-7 flex items-center justify-center cursor-pointer hover:bg-blue-100 hover:scale-105 transition-all duration-200">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('client.layout.menu')
</header>