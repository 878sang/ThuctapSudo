@props(['title' => 'Sản phẩm nổi bật', 'products' => []])
<div class="flex items-center justify-between mb-5">
    <div class="text-[22px] font-bold text-2">{{ $title }}</div>
    <div class="flex items-center gap-1.5 rounded-[10px] text-sm text-2 bg-white px-4 py-2.5">
        <span>Sắp xếp:</span>
        <div class="relative flex items-center">
            <select onchange="document.getElementById('sort-input').value = this.value; document.getElementById('filter-form').submit();" class=" bg-transparent text-2 pr-6 py-1 border-none focus:outline-none focus:ring-0 cursor-pointer">
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá từ thấp đến cao</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá từ cao đến thấp</option>
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
            </select>
            <span class="absolute right-0 pointer-events-none flex items-center">
                <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.82283 7.70944C5.42892 8.31966 4.53641 8.31966 4.1425 7.70944L0.161558 1.54234C-0.267978 0.87692 0.209706 1.00444e-06 1.00172 9.35205e-07L8.96361 2.39154e-07C9.75562 1.69914e-07 10.2333 0.876917 9.80377 1.54234L5.82283 7.70944Z" fill="#006DF0" />
                </svg>
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-3">
    @foreach ($products as $product)
    <div class="w-full px-2.5 mb-5">
        <div class="bg-white rounded-[10px] p-4.5 flex flex-col relative transition-shadow duration-200 hover:shadow-md border border-gray-50">
            <a href="{{ route('products.detailClient', $product->id) }}" class="flex flex-col items-center mb-3">
                <img src="{{ $product->thumbnail ? $product->thumbnail_url : asset('storage/images/cambien.png') }}" class="h-40 object-contain mb-2" alt="Product Image">
            </a>
            <h3 class="text-sm font-bold text-5 line-clamp-2 mb-3 min-h-[40px] leading-snug">
                <a href="{{ route('products.detailClient', $product->id) }}" class="no-underline text-5 hover:text-[#006DF0]">
                    {{ $product->name }}
                </a>
            </h3>
            <div class="flex justify-between items-end mb-3">
                <div class="flex flex-col">
                    <span class="text-[#F30000] font-bold text-base leading-none">
                        {{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }} đ
                    </span>
                    @if($product->sale_price)
                    <span class="text-sm text-[#9C9D9E] line-through mt-1 leading-none">
                        {{ number_format($product->price, 0, ',', '.') }} đ
                    </span>
                    @else
                    <span class="text-sm text-transparent mt-1.5 leading-none">0 đ</span>
                    @endif
                </div>
                @if($product->sale_price)
                <div class="bg-[#FFEFDF] text-[#FF7A00] font-bold text-xs px-2 py-1.5 rounded-[5px] h-fit self-end">
                    -{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                </div>
                @endif
            </div>
            <div class="flex items-center gap-2 mb-4">
                <x-star-rating :stars="$product->stars ?? 5" class="text-yellow-400 text-xs gap-0.5" />
                <span class="text-xs text-gray-400 font-medium">({{ $product->reviews_count ?? 0 }} đánh giá)</span>
            </div>
            <div class="flex flex-col gap-2">
                <a href="{{ route('products.detailClient', $product->id) }}" class="w-full bg-[#006DF0] text-white text-center py-2.5 rounded-[5px] text-sm no-underline hover:bg-[#005ecf] transition-colors">
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
<x-pagination-client :items="$products" />
</div>