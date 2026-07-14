@extends('client.layout.main')

@section('content')

<div class="pt-6 bg-blue_bg min-h-screen rounded-[5px] pb-10">
    <div class="max-w-[1440px] mx-auto mb-4">
        <x-breadcrumb :items="[['label' => 'Cảm biến']]" />
    </div>

    <div class="max-w-[1440px] mx-auto">
        <div class=" flex flex-col lg:flex-row gap-5 items-start">
            @include('client.layout.filters')
            <div class="w-full lg:w-3/4">
                <div>
                    <x-product-card title="Sản phẩm nổi bật" :products="$products" />
                </div>
            </div>
            <div class="mt-5 grid grid-cols-2 gap-4 w-full">
                <img class="w-full" src="{{asset('storage/images/bn1.jpg')}}" alt="">
                <img class="w-full" src="{{asset('storage/images/bn2.jpg')}}" alt="">
            </div>
            <div class="mt-5 w-full bg-white p-6 rounded-[10px] border border-gray-50">
                <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
                    <h2 class="text-[22px] font-bold text-2 leading-none">
                        Thương hiệu <span class="text-7">"Schneider"</span>
                    </h2>
                    <div class="flex items-center gap-2.5">
                        <button class="bg-8 hover:bg-[#e1eeff] text-7 px-5 py-2.5 rounded-[5px] text-sm transition-colors">
                            Nội dung
                        </button>
                        <button class="bg-7 hover:bg-[#005ecf] text-white px-5 py-2.5 rounded-[5px] text-sm transition-colors">
                            Download tài liệu
                        </button>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2.5 mb-6">
                    <label class="flex items-center gap-2 bg-8 hover:bg-[#e1eeff] border border-transparent px-4 py-2.5 rounded-[5px] cursor-pointer transition-colors text-sm text-2 select-none">
                        <input type="checkbox" class="rounded border-7 text-7 focus:ring-7 w-4 h-4">
                        <span>CAD, Bản vẽ &amp; Đường cong</span>
                        <span class="text-[#FF7A00]">(62)</span>
                    </label>
                    <label class="flex items-center gap-2 bg-8 hover:bg-[#e1eeff] border border-transparent px-4 py-2.5 rounded-[5px] cursor-pointer transition-colors text-sm text-2 select-none">
                        <input type="checkbox" class="rounded border-7 text-7 focus:ring-7 w-4 h-4">
                        <span>Catalog &amp; sách quảng cáo</span>
                        <span class="text-[#FF7A00]">(25)</span>
                    </label>
                    <label class="flex items-center gap-2 bg-8 hover:bg-[#e1eeff] border border-transparent px-4 py-2.5 rounded-[5px] cursor-pointer transition-colors text-sm text-2 select-none">
                        <input type="checkbox" class="rounded border-7 text-7 focus:ring-7 w-4 h-4">
                        <span>Cài đặt &amp; Hướng dẫn Sử dụng</span>
                        <span class="text-[#FF7A00]">(21)</span>
                    </label>
                </div>
                <div class=" flex flex-col gap-2.5">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="border-b border-[#D8D8D8] flex items-center justify-between py-5 first:pt-0 flex-wrap gap-4">
                        <div class="flex flex-col gap-1">
                            <h4 class="text-base text-2 hover:text-7 cursor-pointer transition-colors leading-snug">
                                TeSys Deca - auxiliary contact block (GV) (2.0)
                            </h4>
                            <div class="flex items-center gap-2 text-sm text-2">
                                <span>07 thg 2, 2024</span>
                                <span class="text-7">&bull;</span>
                                <span class="text-7 cursor-pointer">CAD, Bản vẽ &amp; Đường cong</span>
                            </div>
                        </div>

                        <a href="#" class="flex items-center gap-2 bg-[#F0F6FF] hover:bg-[#e1eeff] text-2 px-4 py-2.5 rounded-[5px] text-xs no-underline transition-colors">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_274_14516)">
                                    <path d="M14.4065 9.79102L9 15.1975L3.59349 9.79102L4.58789 8.79662L8.29688 12.5056V0H9.70312V12.5056L13.4121 8.79662L14.4065 9.79102ZM18 16.5938H0V18H18V16.5938Z" fill="#0165FC" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_274_14516">
                                        <rect width="18" height="18" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <span>PDF (616,7 Kb)</span>
                        </a>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>

</div>
@endsection