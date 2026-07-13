@props(['title' => 'Sản phẩm nổi bật', 'products' => []])
<div class="flex items-center justify-between mb-5">
    <div class="text-[22px] font-bold text-2">{{ $title }}</div>
    <div class="flex items-center gap-1.5 rounded-[10px] text-sm text-2 bg-white px-4 py-2.5">
        <span>Sắp xếp:</span>
        <div class="relative flex items-center">
            <select class="bg-transparent text-2 pr-6 py-1 border-none focus:outline-none focus:ring-0 cursor-pointer">
                <option value="price_asc">Giá từ thấp đến cao</option>
                <option value="price_desc">Giá từ cao đến thấp</option>
                <option value="newest">Mới nhất</option>
                <option value="best_selling">Bán chạy nhất</option>
            </select>
            <span class="absolute right-0 pointer-events-none flex items-center">
                <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.82283 7.70944C5.42892 8.31966 4.53641 8.31966 4.1425 7.70944L0.161558 1.54234C-0.267978 0.87692 0.209706 1.00444e-06 1.00172 9.35205e-07L8.96361 2.39154e-07C9.75562 1.69914e-07 10.2333 0.876917 9.80377 1.54234L5.82283 7.70944Z" fill="#006DF0" />
                </svg>
            </span>
        </div>
    </div>
</div>

<div class="grid-masonry -mx-2.5">
    <div class="grid-sizer w-full sm:w-1/2 lg:w-1/3"></div>
    @foreach ($products as $product)
    <div class="grid-item w-full sm:w-1/2 lg:w-1/3 px-2.5 mb-5">
        <div class="bg-white rounded-[10px] p-4.5 flex flex-col relative transition-shadow duration-200 hover:shadow-md border border-gray-50">
            <div class="flex flex-col items-center mb-3">
                <img src="{{ asset('storage/images/cambien.png') }}" class="h-40 object-contain mb-2" alt="Product Image">
            </div>
            <h3 class="text-sm font-bold text-5 line-clamp-2 mb-3 min-h-[40px] leading-snug">
                {{ $product['name'] }}
            </h3>
            <div class="flex justify-between items-end mb-3">
                <div class="flex flex-col">
                    <span class="text-[#F30000] font-bold text-base leading-none">{{ $product['price'] }} đ</span>
                    @if($product['old_price'])
                    <span class="text-sm text-[#9C9D9E] line-through mt-1 leading-none">{{ $product['old_price'] }} đ</span>
                    @else
                    <span class="text-sm text-transparent mt-1.5 leading-none">0 đ</span>
                    @endif
                </div>
                @if($product['discount'])
                <div class="bg-[#FFEFDF] text-[#FF7A00] font-bold text-xs px-2 py-1.5 rounded-[5px] h-fit self-end">
                    {{ $product['discount'] }}
                </div>
                @endif
            </div>
            <div class="flex items-center gap-2 mb-4">
                <x-star-rating :stars="$product['stars']" class="text-yellow-400 text-xs gap-0.5" />
                <span class="text-xs text-gray-400 font-medium">{{ $product['reviews'] }}</span>
            </div>
            <div class="flex flex-col gap-2">
                <a href="{{ route('products.detailClient', 1) }}" class="w-full bg-[#006DF0] text-white text-center py-2.5 rounded-[5px] text-sm no-underline hover:bg-[#005ecf] transition-colors">
                    Xem thêm
                </a>
                <a href="#" class="w-full bg-[#F0F6FF] text-[#006DF0] text-center py-2.5 rounded-[5px] text-sm no-underline flex items-center justify-center gap-2 hover:bg-[#e1eeff] transition-colors">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_4169_3295)">
                            <path d="M14.4065 9.79102L9 15.1975L3.59349 9.79102L4.58789 8.79662L8.29688 12.5056V0H9.70312V12.5056L13.4121 8.79662L14.4065 9.79102ZM18 16.5938H0V18H18V16.5938Z" fill="#0165FC" />
                        </g>
                        <defs>
                            <clipPath id="clip0_4169_3295">
                                <rect width="18" height="18" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                    Download tài liệu
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="flex items-center justify-between mt-4 rounded-[10px] bg-blue_bg">
    <div class="flex items-center gap-2.5">
        <a href="#" class="w-[40px] h-[40px] bg-9 hover:bg-[#d6e5ff] text-[#006DF0] flex items-center justify-center rounded-[10px] transition-colors no-underline">
            <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M16.5 7.5H1.5M1.5 7.5L7.5 1.5M1.5 7.5L7.5 13.5" stroke="#1F4388" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
        <a href="#" class="h-[40px] bg-[#006DF0] hover:bg-[#005ecf] text-white flex items-center gap-2.5 p-3 rounded-[5px] text-sm no-underline transition-colors">
            <span>Xem tiếp</span>
            <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.5 7.5H16.5M16.5 7.5L10.5 1.5M16.5 7.5L10.5 13.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
    </div>
    <div class="flex items-center gap-2 text-sm text-4">
        <span>Trang</span>
        <div class="w-[40px] h-[40px] border border-4 flex items-center justify-center rounded-[5px]">
            1
        </div>
        <span>của 10</span>
    </div>
</div>
</div>