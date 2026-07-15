@extends('client.layout.main')

@section('content')

<div class="bg-blue_bg min-h-screen py-6 rounded-[5px]">
    <div class="max-w-[1440px] mx-auto px-4 mb-4">
        <x-breadcrumb :items="[
            ['label' => $product->category->name ?? 'Danh mục', 'url' => '#'],
            ['label' => $product->name]
        ]" />
    </div>

    <div class="max-w-[1440px] mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            <div class="w-full lg:w-[73%] flex flex-col gap-6">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-[55%]" x-data="{ 
                        activeIndex: 0,
                        activeTab: 'image',
                        images: [
                            '{{ $product->thumbnail ? $product->thumbnail_url : asset('storage/images/cambien.png') }}',
                            @foreach($product->gallery_urls as $img)
                            '{{ $img }}',
                            @endforeach
                        ]
                    }">
                        <div class="bg-white p-5 rounded-[10px]">
                            <div class="mt-11 mx-auto w-[420px] h-[420px] rounded-lg relative overflow-hidden group" :class="activeTab === 'image' ? 'flex items-center justify-center' : ''">
                                <template x-if="activeTab === 'image'">
                                    <div class="w-full h-full flex items-center justify-center">
                                        <img :src="images[activeIndex]" alt="Main Product Image" class="w-full h-full object-contain transition-transform duration-300">
                                    </div>
                                </template>
                                <template x-if="activeTab === 'video'">
                                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/z1X2t9iT9W0" title="Altivar 212 Variable Speed Drive Tutorial" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                </template>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex items-center gap-2">
                                    <button
                                        @click="activeTab = 'image'"
                                        :class="activeTab === 'image' ? 'border-7 text-7' : 'border-gray-200 text-gray-500 hover:bg-gray-50'"
                                        class="flex items-center gap-2 border px-4 py-2.5 rounded-lg text-sm bg-white cursor-pointer transition-colors">
                                        <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.5125 14.1031C12.1991 13.7894 11.8269 13.5406 11.4173 13.3709C11.0077 13.2011 10.5686 13.1138 10.1252 13.1138C9.68185 13.1138 9.2428 13.2011 8.83319 13.3709C8.42357 13.5406 8.05142 13.7894 7.73799 14.1031L0.0429688 21.7981C0.146987 23.2089 0.779742 24.5285 1.81471 25.493C2.84967 26.4575 4.21055 26.9957 5.62523 27.0001H21.3753C22.4775 26.9999 23.555 26.6738 24.4724 26.063L12.5125 14.1031Z" fill="#006DF0" />
                                            <path d="M20.25 9.00001C21.4927 9.00001 22.5 7.99265 22.5 6.75001C22.5 5.50736 21.4927 4.5 20.25 4.5C19.0074 4.5 18 5.50736 18 6.75001C18 7.99265 19.0074 9.00001 20.25 9.00001Z" fill="#006DF0" />
                                            <path d="M21.3751 0H5.62501C4.13372 0.00178634 2.70401 0.594994 1.6495 1.6495C0.594994 2.70401 0.00178634 4.13372 0 5.62501L0 18.6593L6.14702 12.5123C6.66937 11.9898 7.28953 11.5753 7.97208 11.2926C8.65464 11.0098 9.38621 10.8642 10.125 10.8642C10.8638 10.8642 11.5954 11.0098 12.278 11.2926C12.9605 11.5753 13.5807 11.9898 14.103 12.5123L26.0629 24.4722C26.6738 23.5548 26.9999 22.4772 27.0001 21.3751V5.62501C26.9983 4.13372 26.4051 2.70401 25.3506 1.6495C24.2961 0.594994 22.8664 0.00178634 21.3751 0ZM20.2501 11.25C19.36 11.25 18.49 10.9861 17.75 10.4916C17.01 9.99717 16.4332 9.29437 16.0926 8.4721C15.752 7.64983 15.6629 6.74503 15.8365 5.87211C16.0101 4.99919 16.4387 4.19737 17.0681 3.56803C17.6974 2.93869 18.4992 2.51011 19.3721 2.33647C20.2451 2.16284 21.1499 2.25195 21.9721 2.59255C22.7944 2.93314 23.4972 3.50992 23.9917 4.24995C24.4861 4.98997 24.7501 5.86 24.7501 6.75002C24.7501 7.9435 24.276 9.08809 23.432 9.93201C22.5881 10.7759 21.4435 11.25 20.2501 11.25Z" fill="#006DF0" />
                                        </svg>
                                        <span>Ảnh</span>
                                    </button>
                                    <button
                                        @click="activeTab = 'video'"
                                        :class="activeTab === 'video' ? 'border-7 text-7' : 'border-gray-200 text-gray-500 hover:bg-gray-50'"
                                        class="flex items-center gap-2 border px-4 py-2.5 rounded-lg text-sm bg-white cursor-pointer transition-colors">
                                        <svg width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M22.5 10.7987C24.5 11.9534 24.5 14.8402 22.5 15.9949L4.49999 26.3872C2.49999 27.5419 -3.04815e-06 26.0985 -2.9472e-06 23.7891L-2.03868e-06 3.00447C-1.93773e-06 0.695069 2.5 -0.748301 4.5 0.406399L22.5 10.7987Z" fill="#BEBEBE" />
                                        </svg>
                                        <span>Video</span>
                                    </button>
                                </div>
                                <div class="flex items-center gap-2">

                                    <button
                                        @click="if(activeIndex > 0) { activeIndex--; activeTab = 'image'; }"
                                        :class="activeIndex === 0 ? 'bg-[#EAEAEA] text-[#C4C4C4] cursor-not-allowed' : 'bg-7 text-white hover:bg-blue-600 cursor-pointer'"
                                        class="w-[45px] h-[40px] flex items-center justify-center rounded-lg transition-colors animate-fade-in">
                                        <i class="fa-solid fa-chevron-left text-sm"></i>
                                    </button>
                                    <button
                                        @click="if(activeIndex < images.length - 1) { activeIndex++; activeTab = 'image'; }"
                                        :class="activeIndex === images.length - 1 ? 'bg-[#EAEAEA] text-[#C4C4C4] cursor-not-allowed' : 'bg-7 text-white hover:bg-blue-600 cursor-pointer'"
                                        class="w-[45px] h-[40px] flex items-center justify-center rounded-lg transition-colors animate-fade-in">
                                        <i class="fa-solid fa-chevron-right text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center mt-5 gap-2.5 overflow-x-auto py-1 hide-scrollbar">

                            <div
                                @click="activeIndex = 0; activeTab = 'image';"
                                @mouseover="activeIndex = 0; activeTab = 'image';"
                                :class="activeIndex === 0 && activeTab === 'image' ? 'border-7 ring-1 ring-7' : 'border-gray-200 hover:border-gray-400'"
                                class="w-16 h-16 rounded p-1 cursor-pointer bg-white transition-all shrink-0 flex items-center justify-center">
                                <img src="{{ $product->thumbnail ? $product->thumbnail_url : asset('storage/images/cambien.png') }}" alt="Thumbnail" class="max-h-full object-contain">
                            </div>

                            @foreach($product->gallery_urls as $index => $img)
                            <div
                                @click="activeIndex = {{ $index + 1 }}; activeTab = 'image';"
                                @mouseover="activeIndex = {{ $index + 1 }}; activeTab = 'image';"
                                :class="activeIndex === {{ $index + 1 }} && activeTab === 'image' ? 'border-7 ring-1 ring-7' : 'border-gray-200 hover:border-gray-400'"
                                class="w-16 h-16 rounded p-1 cursor-pointer bg-white transition-all shrink-0 flex items-center justify-center">
                                <img src="{{ $img }}" alt="Thumbnail" class="max-h-full object-contain">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="p-6 rounded-[10px] bg-white w-full md:w-[45%] flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="flex text-[#FF7A00] text-sm gap-0.5">
                                        <i class="fa-solid fa-star text-[#F29F05]"></i>
                                        <i class="fa-solid fa-star text-[#F29F05]"></i>
                                        <i class="fa-solid fa-star text-[#F29F05]"></i>
                                        <i class="fa-solid fa-star text-[#F29F05]"></i>
                                        <i class="fa-solid fa-star text-[#F29F05] opacity-50"></i>
                                    </div>
                                    <span class="text-xs text-gray-400 font-semibold">{{ $product->reviews ?? 0 }} đánh giá</span>
                                </div>
                                <button class="text-[#FF7A00] hover:opacity-90 transition-opacity">
                                    <i class="fa-solid fa-bookmark text-2xl animate-fade-in"></i>
                                </button>
                            </div>
                            <h1 class="text-xl font-bold text-2 mb-2.5">
                                {{ $product->name }}
                            </h1>
                            <div class="flex items-center justify-between mb-4">
                                <span class="bg-8 text-6 px-4 py-2.5 rounded text-xs">
                                    {{ $product->category->name ?? 'Không danh mục' }}
                                </span>
                                <span class="text-sm text-4">
                                    Mã sản phẩm: {{ $product->sku }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between mb-4 flex-wrap gap-4">
                                <div class="flex flex-col">
                                    <div class="text-[28px] font-bold text-[#F86614] leading-none">
                                        {{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }}đ
                                    </div>
                                    @if($product->sale_price)
                                    <span class="text-base text-4 line-through mt-1">
                                        {{ number_format($product->price, 0, ',', '.') }}đ
                                    </span>
                                    @endif
                                </div>
                                <button class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                                    <i class="fa-solid fa-download text-lg text-7"></i>
                                    <span class="text-sm text-4">Download tài liệu</span>
                                </button>
                            </div>
                            @if($product->description)
                            <div class="bg-blue_button rounded-[10px] mb-6 py-4 px-5">
                                @foreach (explode("\n", $product->description) as $desc)
                                <div class="flex items-center gap-3 mb-3 text-sm text-3">
                                    <div class="w-6 h-6 rounded-full bg-7 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-bolt text-white text-[10px]"></i>
                                    </div>
                                    {{ $desc }}
                                </div>
                                @endforeach
                            </div>
                            @endif
                            <h3 class="text-sm font-bold text-2 mb-3">
                                Dịch vụ & Khuyến mãi
                            </h3>
                            <div class="bg-blue_button rounded-[10px] p-4.5 mb-5">
                                <ul class="text-sm text-3 space-y-2 list-disc pl-4">
                                    <li class="leading-relaxed">
                                        Quà tặng trị giá <span class="text-[#FF7A00] font-bold">200.000đ</span> (Áp dụng sản phẩm tự động hóa công nghiệp SCHNEIDER ELECTRIC)
                                    </li>
                                    <li class="leading-relaxed">
                                        Nhập mã <span class="text-[#FF7A00] font-bold">HOPLONG</span> giảm thêm 1% dành cho toàn bộ đơn hàng từ 01/01 đến 20/04/2020
                                    </li>
                                    <li class="leading-relaxed">
                                        Tặng voucher <span class="text-[#FF7A00] font-bold">20.000đ</span> khi đánh giá 5*(Áp dụng cho đơn hàng từ 200.000đ)
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <x-quantity-selector :qty="1" class="mb-4" />

                            <div class="flex flex-col gap-2.5">
                                <button type="submit" class="w-full bg-[#EDF3FF] hover:bg-[#d8e8ff] text-2 py-3.5 px-4 rounded-lg text-sm transition-colors flex items-center justify-center gap-2 cursor-pointer">
                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M23.0196 3.77326C22.4113 3.12444 21.5733 2.77299 20.6811 2.77299H4.29843L4.25788 2.44858C4.00106 1.00225 2.71693 -0.0520797 1.24357 0.00198863H1.01378C0.473098 -0.0250455 0.0270342 0.393984 0 0.934668C0.0270342 1.47535 0.473098 1.88086 1.01378 1.85383H1.24357C1.73019 1.84031 2.16273 2.17824 2.25735 2.66485L3.64961 13.492C4.06864 15.9251 6.21786 17.6688 8.69149 17.5742H19.2754C19.789 17.6283 20.2351 17.2498 20.2891 16.7361C20.3432 16.2225 19.9647 15.7764 19.4511 15.7224C19.397 15.7224 19.3294 15.7224 19.2754 15.7224H8.69149C7.44791 15.7494 6.31248 15.0195 5.82586 13.8705H17.9101C20.2621 13.9516 22.3437 12.3566 22.8979 10.0722L23.6955 6.04413C23.8577 5.21958 23.6143 4.38152 23.0331 3.77326H23.0196Z" fill="#0165FC" />
                                        <path d="M7.42021 24.3326C8.91327 24.3326 10.1236 23.1223 10.1236 21.6292C10.1236 20.1361 8.91327 18.9258 7.42021 18.9258C5.92716 18.9258 4.7168 20.1361 4.7168 21.6292C4.7168 23.1223 5.92716 24.3326 7.42021 24.3326Z" fill="#0165FC" />
                                        <path d="M16.8694 24.3326C18.3625 24.3326 19.5728 23.1223 19.5728 21.6292C19.5728 20.1361 18.3625 18.9258 16.8694 18.9258C15.3764 18.9258 14.166 20.1361 14.166 21.6292C14.166 23.1223 15.3764 24.3326 16.8694 24.3326Z" fill="#0165FC" />
                                    </svg>
                                    <span>Thêm vào giỏ hàng</span>
                                </button>
                                <button type="submit" class="w-full bg-7 hover:bg-blue-600 text-white py-3.5 px-4 rounded-lg text-sm transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 cursor-pointer uppercase">
                                    <span>MUA NGAY</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[5px]">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-2">Sản phẩm cùng Series</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead>
                                <tr class="bg-8 text-[#0165FC] font-bold">
                                    <th class="p-4 rounded-l border-r border-b border-[#E9E9E9] w-[28%]">Mã hàng</th>
                                    <th class="p-4 border-r border-b border-[#E9E9E9] w-[14%]">Giá niêm yết</th>
                                    <th class="p-4 border-r border-b border-[#E9E9E9] w-[10%]">Giá bán</th>
                                    <th class="p-4 border-r border-b border-[#E9E9E9] w-[14%]">Tình trạng</th>
                                    <th class="p-4 border-b border-[#E9E9E9] text-center w-[12%]">Số lượng</th>
                                    <th class="p-4 rounded-r border-b border-[#E9E9E9] text-center w-[22%]">Đặt hàng</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($seriesProducts as $sp)
                                <tr x-data="{ qty: 1 }">
                                    <td class="py-2 px-4 border border-[#E9E9E9]">
                                        <div class=" flex items-center gap-3">
                                            <img src="{{ $sp->thumbnail ? $sp->thumbnail_url : asset('storage/images/chitiet1.jpg') }}" class="w-18 h-18 object-contain shrink-0 rounded" alt="Product thumbnail">
                                            <div class="flex flex-col gap-0.5">
                                                <span class="text-sm text-2 leading-tight">{{ $sp->sku }}</span>
                                                <x-star-rating :stars="$sp->stars ?? 5" class="text-[16px]" />
                                                <span class="text-sm text-[#929B9E] font-medium leading-none">{{ $sp->weight ? $sp->weight . 'kg' : '0.75kW' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-sm border border-[#E9E9E9] text-2 text-center">
                                        @if($sp->price)
                                        {{ number_format($sp->price, 0, ',', '.') }} đ
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-sm border border-[#E9E9E9] text-2 font-extrabold text-center">{{ number_format($sp->sale_price ?? $sp->price, 0, ',', '.') }} đ</td>
                                    <td class="py-3.5 px-4 border border-[#E9E9E9] text-center">
                                        <span class="text-sm text-7">
                                            {{ $sp->stock > 0 ? 'Còn hàng' : 'Hết hàng' }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 border border-[#E9E9E9] text-center" @change="qty = $event.detail.qty">
                                        <x-quantity-selector :qty="1" :autoUpdate="true" />
                                    </td>
                                    <td class="py-3.5 px-4 border border-[#E9E9E9]">
                                        <div class="flex items-center justify-center gap-2">
                                            @if($sp->stock > 0)
                                            <form action="{{ route('cart.add') }}" method="POST" class="flex items-center justify-center gap-2">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $sp->id }}">
                                                <input type="hidden" name="quantity" :value="qty" value="1">
                                                <button class="w-[46px] h-[46px] bg-[#E8F1FF] hover:bg-[#d0e3ff] text-7 rounded flex items-center justify-center transition-colors cursor-pointer">
                                                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M23.0196 3.77326C22.4113 3.12444 21.5733 2.77299 20.6811 2.77299H4.29843L4.25788 2.44858C4.00106 1.00225 2.71693 -0.0520797 1.24357 0.00198863H1.01378C0.473098 -0.0250455 0.0270342 0.393984 0 0.934668C0.0270342 1.47535 0.473098 1.88086 1.01378 1.85383H1.24357C1.73019 1.84031 2.16273 2.17824 2.25735 2.66485L3.64961 13.492C4.06864 15.9251 6.21786 17.6688 8.69149 17.5742H19.2754C19.789 17.6283 20.2351 17.2498 20.2891 16.7361C20.3432 16.2225 19.9647 15.7764 19.4511 15.7224C19.397 15.7224 19.3294 15.7224 19.2754 15.7224H8.69149C7.44791 15.7494 6.31248 15.0195 5.82586 13.8705H17.9101C20.2621 13.9516 22.3437 12.3566 22.8979 10.0722L23.6955 6.04413C23.8577 5.21958 23.6143 4.38152 23.0331 3.77326H23.0196Z" fill="#0165FC" />
                                                        <path d="M7.42021 24.3327C8.91327 24.3327 10.1236 23.1224 10.1236 21.6293C10.1236 20.1363 8.91327 18.9259 7.42021 18.9259C5.92716 18.9259 4.7168 20.1363 4.7168 21.6293C4.7168 23.1224 5.92716 24.3327 7.42021 24.3327Z" fill="#0165FC" />
                                                        <path d="M16.8694 24.3327C18.3625 24.3327 19.5728 23.1224 19.5728 21.6293C19.5728 20.1363 8.3625 18.9259 7.42021 18.9259C5.92716 18.9259 4.7168 20.1363 4.7168 21.6293C4.7168 23.1224 5.92716 24.3327 7.42021 24.3327Z" fill="#0165FC" />
                                                    </svg>
                                                </button>
                                                <button class="bg-7 hover:bg-blue-600 text-white min-w-[140px] h-[46px] rounded-lg text-sm transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 cursor-pointer uppercase">
                                                    MUA NGAY
                                                </button>
                                            </form>
                                            @else
                                            <button class="w-[46px] h-[46px] bg-[#F3F3F3] text-gray-500 rounded flex items-center justify-center cursor-not-allowed">
                                                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M23.0196 3.77326C22.4113 3.12444 21.5733 2.77299 20.6811 2.77299H4.29843L4.25788 2.44858C4.00106 1.00225 2.71693 -0.0520797 1.24357 0.00198863H1.01378C0.473098 -0.0250455 0.0270342 0.393984 0 0.934668C0.0270342 1.47535 0.473098 1.88086 1.01378 1.85383H1.24357C1.73019 1.84031 2.16273 2.17824 2.25735 2.66485L3.64961 13.492C4.06864 15.9251 6.21786 17.6688 8.69149 17.5742H19.2754C19.789 17.6283 20.2351 17.2498 20.2891 16.7361C20.3432 16.2225 19.9647 15.7764 19.4511 15.7224C19.397 15.7224 19.3294 15.7224 19.2754 15.7224H8.69149C7.44791 15.7494 6.31248 15.0195 5.82586 13.8705H17.9101C20.2621 13.9516 22.3437 12.3566 22.8979 10.0722L23.6955 6.04413C23.8577 5.21958 23.6143 4.38152 23.0331 3.77326H23.0196Z" fill="#575859" />
                                                    <path d="M7.42021 24.3327C8.91327 24.3327 10.1236 23.1224 10.1236 21.6293C10.1236 20.1363 8.91327 18.9259 7.42021 18.9259C5.92716 18.9259 4.7168 20.1363 4.7168 21.6293C4.7168 23.1224 5.92716 24.3327 7.42021 24.3327Z" fill="#575859" />
                                                    <path d="M16.8694 24.3327C18.3625 24.3327 19.5728 23.1224 19.5728 21.6293C19.5728 20.1363 18.3625 18.9259 16.8694 18.9259C15.3764 18.9259 14.166 20.1363 14.166 21.6293C14.166 23.1224 15.3764 24.3327 16.8694 24.3327Z" fill="#575859" />
                                                </svg>
                                            </button>
                                            <button class="bg-[#F3F3F3] min-w-[140px] text-#575859 h-[46px] p rounded text-xs cursor-not-allowed uppercase text-[10px] tracking-wide">
                                                LIÊN HỆ
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="flex items-center gap-2.5 mt-5">
                        <button class="w-[45px] h-[45px] bg-[#DDECFF] hover:bg-[#cbe2ff] text-7 flex items-center justify-center rounded-[5px] transition-colors cursor-pointer">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                        <button class="bg-7 hover:bg-blue-600 text-white p-3 rounded-[5px] text-sm flex items-center gap-2.5 transition-colors cursor-pointer">
                            <span>Xem tiếp</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="rounded-[10px]" x-data="{ tab: 'overview', expanded: false }">
                    <div class="flex items-center gap-4 text-base border-b border-[#DDDDDD] pb-4">
                        <button @click="tab = 'overview'" :class="tab === 'overview' ? 'text-7 font-bold' : 'text-gray-500'" class="cursor-pointer transition-colors">
                            Tổng quan
                        </button>
                        <span class="text-gray-300 font-normal">|</span>
                        <button @click="tab = 'specs'" :class="tab === 'specs' ? 'text-7 font-bold' : 'text-gray-500'" class="cursor-pointer transition-colors">
                            Thông số kỹ thuật
                        </button>
                    </div>
                    <template x-if="tab === 'overview'">
                        <div class="mt-5 p-6 bg-white  space-y-4 animate-fade-in">
                            @if($product->detail)
                            <div class="flex items-center gap-3 mb-3 text-sm text-3">
                                {!! $product->detail !!}
                            </div>
                            @endif
                            <div class="relative rounded-lg overflow-hidden border border-gray-100 bg-[#fdfdfd] transition-all duration-500" :class="expanded ? 'max-h-none pb-16' : 'max-h-[500px]'">
                                <template x-if="!expanded">
                                    <div class="absolute inset-x-0 bottom-0 h-36 bg-gradient-to-t from-white to-transparent flex items-end justify-center pb-6 z-10">
                                        <button @click="expanded = true" class="bg-white border border-7 hover:bg-blue-50 text-7 font-bold py-2.5 px-6 rounded-full text-xs transition-colors cursor-pointer shadow-md">
                                            Xem thêm
                                        </button>
                                    </div>
                                </template>
                                <template x-if="expanded">
                                    <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-white to-white/90 flex items-center justify-center pb-4 z-10 border-t border-gray-50">
                                        <button @click="expanded = false" class="bg-white border border-7 hover:bg-blue-50 text-7 font-bold py-2.5 px-6 rounded-full text-xs transition-colors cursor-pointer shadow-md">
                                            Thu gọn
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                    <template x-if="tab === 'specs'">
                        <div class="mt-5 p-6 bg-white space-y-4 animate-fade-in">
                            <h3 class="text-[20px] font-bold text-2">
                                Thông số kỹ thuật <span class="text-7 font-bold">“ATV212 Series”</span>
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-0">
                                    <div class="py-4 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Tên sản phẩm</div>
                                        <div class="text-7 font-semibold mt-1">Cầu dao LV429541 Schneider</div>
                                    </div>
                                    <div class="py-4 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Dòng</div>
                                        <div class="text-7 font-semibold mt-1">NSX</div>
                                    </div>
                                    <div class="py-4 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Loại</div>
                                        <div class="text-7 font-semibold mt-1">NSX100B</div>
                                    </div>
                                    <div class="py-4 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Điện áp hoạt động</div>
                                        <div class="text-7 font-semibold mt-1">690 VAC</div>
                                    </div>
                                    <div class="py-4 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Điện áp định mức</div>
                                        <div class="text-7 font-semibold mt-1">800 VAC</div>
                                    </div>
                                    <div class="py-4 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Điện áp định mức</div>
                                        <div class="text-7 font-semibold mt-1">800 VAC</div>
                                    </div>
                                    <div class="py-3.5 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Tần số</div>
                                        <div class="text-7 font-semibold mt-1">50/60 Hz</div>
                                    </div>
                                    <div class="py-3.5 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Cấp độ bảo vệ</div>
                                        <div class="text-7 font-semibold mt-1">IP40</div>
                                    </div>
                                </div>

                                <div class="space-y-0">
                                    <div class="py-3.5 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Hiệu điện thế</div>
                                        <div class="text-7 font-semibold mt-1">8kV</div>
                                    </div>
                                    <div class="py-3.5 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Dòng định mức</div>
                                        <div class="text-7 font-semibold mt-1">80A</div>
                                    </div>
                                    <div class="py-3.5 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Số cực</div>
                                        <div class="text-7 font-semibold mt-1">3P</div>
                                    </div>
                                    <div class="py-3.5 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Khả năng ngắt mạch</div>
                                        <div class="text-7 font-semibold mt-1">25 kA 415 VAC</div>
                                    </div>
                                    <div class="py-3.5 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Độ bền cơ học</div>
                                        <div class="text-7 font-semibold mt-1">50.000 chu kỳ</div>
                                    </div>
                                    <div class="py-3.5 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Kích thước</div>
                                        <div class="text-7 font-semibold mt-1">105 x 161 x 86mm</div>
                                    </div>
                                    <div class="py-3.5 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Nhiệt độ môi trường</div>
                                        <div class="text-7 font-semibold mt-1">-35-70°C</div>
                                    </div>
                                    <div class="py-3.5 border-b border-gray-100 text-sm">
                                        <div class="text-2 font-bold">Trọng lượng</div>
                                        <div class="text-7 font-semibold mt-1">2.05 kg</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="bg-white p-6 rounded-[10px] border border-gray-50">
                    <h2 class="text-[20px] font-bold text-2 mb-6">Đánh giá & Nhận xét</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8 pb-6 border-b border-gray-100">
                        <div class="flex flex-col gap-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2.5">
                                <div>
                                    <textarea class="w-full border border-[#CCCCCC] rounded-[5px] p-3 text-sm focus:outline-none focus:border-7 h-[104px] resize-none" placeholder="Nhập nội dung"></textarea>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <input type="text" class="w-full border border-[#CCCCCC] rounded-[5px] px-3 py-2.5 text-sm focus:outline-none focus:border-7" placeholder="Nhập tiêu đề">
                                    <input type="text" class="w-full border border-[#CCCCCC] rounded-[5px] px-3 py-2.5 text-sm focus:outline-none focus:border-7" placeholder="Nhập tên">
                                </div>
                            </div>
                            <button class="w-full bg-6 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded-[5px] text-sm transition-colors cursor-pointer">
                                Đánh giá ngay
                            </button>
                        </div>
                        <div class="flex-1 w-full space-y-2">
                            <span class="text-xs text-gray-500 block font-semibold mb-3">
                                <span class="text-7 font-bold">(1)</span> Đánh giá
                            </span>
                            <div class="flex items-center gap-3 text-xs">
                                <div class="flex text-[#FF7A00] text-xs gap-0.5 shrink-0 w-24">
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                </div>
                                <div class="flex-1 h-1 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#F29F05] rounded-full w-full"></div>
                                </div>
                                <span class="w-8 text-3">100%</span>
                            </div>
                            <div class="flex items-center gap-3 text-xs">
                                <div class="flex text-[#FF7A00] text-xs gap-0.5 shrink-0 w-24">
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                </div>
                                <div class="flex-1 h-1 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#F29F05] rounded-full w-0"></div>
                                </div>
                                <span class="w-8 text-3 text-right">0%</span>
                            </div>
                            <!-- 3 Star Row -->
                            <div class="flex items-center gap-3 text-xs">
                                <div class="flex text-[#FF7A00] text-xs gap-0.5 shrink-0 w-24">
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                </div>
                                <div class="flex-1 h-1 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#F29F05] rounded-full w-0"></div>
                                </div>
                                <span class="w-8 text-3 text-right">0%</span>
                            </div>
                            <!-- 2 Star Row -->
                            <div class="flex items-center gap-3 text-xs">
                                <div class="flex text-[#FF7A00] text-xs gap-0.5 shrink-0 w-24">
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                </div>
                                <div class="flex-1 h-1 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#F29F05] rounded-full w-0"></div>
                                </div>
                                <span class="w-8 text-3 text-right">0%</span>
                            </div>
                            <!-- 1 Star Row -->
                            <div class="flex items-center gap-3 text-xs">
                                <div class="flex text-[#FF7A00] text-xs gap-0.5 shrink-0 w-24">
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                    <i class="fa-solid fa-star text-[#E4E4E4]"></i>
                                </div>
                                <div class="flex-1 h-1 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#F29F05] rounded-full w-0"></div>
                                </div>
                                <span class="w-8 text-3 text-right">0%</span>
                            </div>
                        </div>
                    </div>

                    <h3 class="text-[20px] font-bold text-2 mb-6">Nhận xét</h3>

                    <div class="space-y-6 ml-10">
                        @foreach($reviews as $rev)
                        <div class="flex flex-col pb-6 mb-6 last:border-b-0 last:pb-0 last:mb-0">
                            <div class="flex items-center gap-2.5 text-xs mb-3">
                                <span class="font-bold text-base text-2">{{ $rev['user'] }}</span>
                                <span class="text-4 font-semibold">&bull;</span>
                                <span class="text-4 text-xs">{{ $rev['time'] }}</span>
                                <x-star-rating :stars="$rev['stars']" class="text-[10px] ml-1" />
                                <a href="#" class="text-6 ml-2 hover:underline">Sửa đánh giá</a>
                            </div>
                            @if(!empty($rev['title']))
                            <h4 class="text-base font-bold text-2 mb-1.5 leading-snug">
                                {{ $rev['title'] }}
                            </h4>
                            @endif

                            <div>
                                @foreach(explode("\n", $rev['comment']) as $p)
                                <p class="text-sm text-4">
                                    {{ $p }}
                                </p>
                                @endforeach
                            </div>
                            <div class="flex items-center justify-end gap-5 text-sm text-4 mt-2.5">
                                <button class="flex items-center gap-1.5 hover:text-7 transition-colors cursor-pointer">
                                    <i class="fa-regular fa-thumbs-up"></i>
                                    <span>Hữu ích</span>
                                </button>
                                <button class="flex items-center gap-1.5 hover:text-7 transition-colors cursor-pointer">
                                    <i class="fa-solid fa-reply text-[10px]"></i>
                                    <span>Phản hồi</span>
                                </button>
                            </div>
                            @if(count($rev['replies']) > 0)
                            <div class="mt-4 border-l-[6px] border-solid border-l-[#C8C8C8] pl-4 space-y-4">
                                @foreach($rev['replies'] as $reply)
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2.5 text-xs mb-2">
                                        <span class="font-bold text-base text-2">{{ $reply['user'] }}</span>
                                        <span class="text-4 font-semibold">&bull;</span>
                                        <span class="text-4 text-xs">{{ $reply['time'] }}</span>
                                    </div>
                                    <div>
                                        @foreach(explode("\n", $reply['comment']) as $rp_para)
                                        <p class="text-sm text-4">
                                            {{ $rp_para }}
                                        </p>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-[27%] flex flex-col gap-6">
                <div class="bg-white p-5 rounded-[10px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                    <h3 class="text-[20px] font-bold text-2 mb-4">
                        Liên hệ hỗ trợ 24/7
                    </h3>
                    <div class="flex flex-col gap-1.5 text-sm">
                        <div class="flex items-center gap-3 py-1">
                            <i class="fa-solid fa-phone text-7 text-base shrink-0"></i>
                            <span class="text-5">1900 6536</span>
                        </div>
                        <div class="flex items-center gap-3 py-1">
                            <i class="fa-solid fa-at text-7 text-base shrink-0"></i>
                            <span class="text-5">info@hoplong.com</span>
                        </div>
                        <div class="flex items-center justify-between py-1">
                            <div class="flex items-center gap-3">
                                <i class="fa-regular fa-map text-7 text-base shrink-0"></i>
                                <span class="text-5">Hệ thống chi nhánh</span>
                            </div>
                            <a href="#" class="text-7 text-xs hover:underline">Xem thêm</a>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-[10px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-2">
                            Tùy chọn giao hàng
                        </h3>
                        <a href="#" class="text-7 text-lg hover:opacity-85 transition-opacity" title="Thông tin giao hàng">
                            <i class="fa-regular fa-circle-question"></i>
                        </a>
                    </div>
                    <div class="flex flex-col text-sm divide-y divide-gray-100">
                        <div class="flex items-start gap-3 py-3.5 first:pt-0">
                            <i class="fa-solid fa-location-dot text-7 text-base shrink-0 mt-0.5"></i>
                            <div class="flex-1 pr-2">
                                <p class="text-5 leading-relaxed">
                                    Tầng 3, HHO1 A, 87 Lĩnh Nam, Hoàng Mai, Hà Nội
                                </p>
                            </div>
                            <a href="#" class="text-7 text-xs font-semibold hover:underline shrink-0">Thay đổi</a>
                        </div>
                        <div class="flex items-center justify-between py-3.5">
                            <div class="flex items-center gap-3">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.20311 10.6249C2.3024 10.6249 2.40158 10.6316 2.49998 10.6449V3.12498C2.49998 2.6277 2.30244 2.15079 1.95081 1.79916C1.59918 1.44753 1.12227 1.24999 0.624995 1.24999C0.459236 1.24999 0.300267 1.18414 0.183058 1.06693C0.0658484 0.949725 0 0.790754 0 0.624995C0 0.459236 0.0658484 0.300266 0.183058 0.183057C0.300267 0.0658476 0.459236 0 0.624995 0C1.45349 0.000992404 2.24776 0.330549 2.83359 0.916381C3.41942 1.50221 3.74898 2.29649 3.74997 3.12498V10.1743L5.45871 10.7443C5.45558 10.5319 5.48855 10.3206 5.55621 10.1193L6.52683 6.93182C6.67862 6.45872 7.01159 6.06498 7.4529 5.8367C7.89422 5.60843 8.40798 5.56421 8.88181 5.71371L13.0693 7.04495C13.5372 7.19648 13.9273 7.52509 14.1561 7.96051C14.3849 8.39593 14.4343 8.90359 14.2936 9.37493L13.2724 12.733C13.2057 12.9204 13.1092 13.0957 12.9868 13.2524L14.5718 13.7805C14.7292 13.8329 14.8595 13.9457 14.9338 14.0941C15.0081 14.2425 15.0204 14.4143 14.968 14.5718C14.9156 14.7292 14.8028 14.8595 14.6545 14.9338C14.5061 15.0081 14.3342 15.0204 14.1768 14.968L4.00997 11.5793C4.28539 11.9828 4.41778 12.467 4.38603 12.9546C4.35429 13.4421 4.16022 13.905 3.83479 14.2694C3.50935 14.6339 3.07128 14.8789 2.59041 14.9653C2.10953 15.0518 1.61355 14.9748 1.18152 14.7467C0.749497 14.5185 0.406301 14.1522 0.206653 13.7063C0.00700378 13.2603 -0.0376053 12.7604 0.079936 12.2862C0.197478 11.8119 0.470405 11.3907 0.855204 11.0896C1.24 10.7885 1.71452 10.6249 2.20311 10.6249ZM9.44431 8.53119L10.9849 9.02118C11.1429 9.07141 11.3143 9.05682 11.4616 8.98064C11.6088 8.90445 11.7197 8.77291 11.7699 8.61494C11.8201 8.45697 11.8056 8.28552 11.7294 8.1383C11.6532 7.99109 11.5216 7.88017 11.3637 7.82994L9.82305 7.33995C9.74484 7.31508 9.66249 7.30586 9.5807 7.31282C9.49892 7.31977 9.41931 7.34277 9.34642 7.38049C9.27353 7.41822 9.20878 7.46993 9.15587 7.53267C9.10296 7.59542 9.06293 7.66797 9.03806 7.74619C9.01319 7.82441 9.00397 7.90676 9.01093 7.98854C9.01789 8.07032 9.04088 8.14993 9.07861 8.22283C9.11633 8.29572 9.16804 8.36047 9.23079 8.41338C9.29354 8.46629 9.36609 8.50632 9.44431 8.53119Z" fill="#0165FC" />
                                </svg>
                                <span class="text-5">Giao hàng tiêu chuẩn</span>
                            </div>
                            <span class="text-7 font-bold text-xs shrink-0">20.000 vnđ</span>
                        </div>
                        <div class="flex items-start gap-3 py-3.5 last:pb-0">
                            <i class="fa-solid fa-wallet text-7 text-base shrink-0 mt-0.5"></i>
                            <span class="text-xs text-5 leading-relaxed">
                                Thanh toán khi nhận hàng (không được đồng kiểm)
                            </span>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-[10px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-2">
                            Đổi trả và bảo hành
                        </h3>
                        <a href="#" class="text-7 text-lg hover:opacity-85 transition-opacity" title="Chính sách đổi trả">
                            <i class="fa-regular fa-circle-question"></i>
                        </a>
                    </div>
                    <div class="flex flex-col text-sm divide-y divide-gray-100">
                        <div class="flex items-center gap-3 py-3.5 first:pt-0">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.80866 4.81667C0.564296 4.57231 0.564296 4.17733 0.80866 3.93296L2.05861 2.68301C2.23735 2.50365 2.50609 2.45115 2.73983 2.54739C2.97357 2.64426 3.12544 2.87238 3.12544 3.12487V8.74964C3.12544 9.09462 2.84608 9.37461 2.50046 9.37461C2.15485 9.37461 1.87549 9.09462 1.87549 8.74964V4.63356L1.69237 4.81667C1.44801 5.06104 1.05303 5.06104 0.80866 4.81667ZM14.9849 8.61089C14.9081 8.27403 14.5712 8.06091 14.2368 8.14029L0.486799 11.2652C0.150563 11.342 -0.0606784 11.6764 0.0155685 12.0132C0.0811907 12.3032 0.33993 12.4995 0.624918 12.4995C0.670541 12.4995 0.717414 12.4945 0.764287 12.4839L14.5137 9.35898C14.8499 9.28211 15.0612 8.94775 14.9849 8.61089ZM14.2437 11.8883L5.49409 13.7632C5.1566 13.8357 4.94161 14.1675 5.01411 14.5056C5.07723 14.7988 5.33597 15 5.62471 15C5.66783 15 5.71221 14.9956 5.75658 14.9863L14.5062 13.1113C14.8437 13.0388 15.0587 12.707 14.9862 12.3689C14.9137 12.0314 14.5843 11.8158 14.2437 11.8883ZM10.0002 4.6873V2.18741C10.0002 0.981209 10.9814 0 12.1876 0C13.3938 0 14.375 0.981209 14.375 2.18741V4.6873C14.375 5.8935 13.3938 6.87471 12.1876 6.87471C10.9814 6.87471 10.0002 5.8935 10.0002 4.6873ZM11.2501 4.6873C11.2501 5.20416 11.6707 5.62477 12.1876 5.62477C12.7044 5.62477 13.125 5.20416 13.125 4.6873V2.18741C13.125 1.67056 12.7044 1.24995 12.1876 1.24995C11.6707 1.24995 11.2501 1.67056 11.2501 2.18741V4.6873ZM4.37539 5.93725V3.43736C4.37539 2.23116 5.3566 1.24995 6.5628 1.24995C7.769 1.24995 8.7502 2.23116 8.7502 3.43736V5.93725C8.7502 7.14345 7.769 8.12466 6.5628 8.12466C5.3566 8.12466 4.37539 7.14345 4.37539 5.93725ZM5.62533 5.93725C5.62533 6.45411 6.04594 6.87471 6.5628 6.87471C7.07965 6.87471 7.50026 6.45411 7.50026 5.93725V3.43736C7.50026 2.9205 7.07965 2.4999 6.5628 2.4999C6.04594 2.4999 5.62533 2.9205 5.62533 3.43736V5.93725Z" fill="#0165FC" />
                            </svg>
                            <span class="text-5 text-sm">100 % chính hãng</span>
                        </div>
                        <div class="flex items-start gap-3 py-3.5">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.37447 0.00183262H2.49969C1.11861 0.00183262 0 1.12045 0 2.50153V4.3763C0 5.75738 1.11861 6.87599 2.49969 6.87599H4.37447C5.75555 6.87599 6.87416 5.75738 6.87416 4.3763V2.50153C6.87416 1.12045 5.75555 0.00183262 4.37447 0.00183262ZM12.4985 8.12584H10.6237C9.24262 8.12584 8.12401 9.24445 8.12401 10.6255V12.5003C8.12401 13.8814 9.24262 15 10.6237 15H12.4985C13.8796 15 14.9982 13.8814 14.9982 12.5003V10.6255C14.9982 9.24445 13.8796 8.12584 12.4985 8.12584ZM8.12401 3.12645C8.12401 2.46403 8.39897 1.84536 8.90516 1.38916L10.1988 0.170562C10.4487 -0.066909 10.8424 -0.0544105 11.0799 0.195559C11.3174 0.445528 11.3049 0.84548 11.0549 1.0767L9.75506 2.2953C9.68632 2.35779 9.63007 2.42654 9.58008 2.49528H11.8735C13.2546 2.49528 14.3732 3.61389 14.3732 4.99497V6.24482C14.3732 6.58853 14.092 6.86974 13.7483 6.86974C13.4046 6.86974 13.1234 6.58853 13.1234 6.24482V4.99497C13.1234 4.30756 12.561 3.74513 11.8735 3.74513H9.58008C9.63007 3.81387 9.68632 3.87636 9.74881 3.93885L11.0549 5.1637C11.3049 5.40117 11.3174 5.79487 11.0799 6.04484C10.9549 6.17608 10.7924 6.23857 10.6237 6.23857C10.4675 6.23857 10.3175 6.18233 10.1925 6.06984L8.89266 4.85124C8.39897 4.39505 8.11776 3.77637 8.11776 3.1202L8.12401 3.12645ZM6.87416 11.8754C6.87416 12.5378 6.59919 13.1502 6.09301 13.6127L4.79941 14.8313C4.68068 14.9438 4.52445 15 4.36822 15C4.19949 15 4.03701 14.9313 3.91202 14.8063C3.67455 14.5563 3.68705 14.1564 3.93702 13.9251L5.23686 12.7065C5.3056 12.644 5.36185 12.5753 5.41184 12.5066H3.11837C1.73729 12.5066 0.618674 11.3879 0.618674 10.0069V8.75701C0.618674 8.41331 0.89989 8.13209 1.2436 8.13209C1.58731 8.13209 1.86852 8.41331 1.86852 8.75701V10.0069C1.86852 10.6943 2.43095 11.2567 3.11837 11.2567H5.41184C5.36185 11.188 5.3056 11.1255 5.24311 11.063L3.93702 9.83813C3.68705 9.60066 3.67455 9.20696 3.91202 8.95699C4.14949 8.70702 4.54319 8.69452 4.79316 8.93199L6.09301 10.1506C6.5867 10.6068 6.86791 11.2255 6.86791 11.8816L6.87416 11.8754Z" fill="#0165FC" />
                            </svg>
                            <div>
                                <span class="text-5 text-sm block mb-1">15 ngày trả hàng</span>
                                <p class="text-xs text-gray-400 leading-relaxed">
                                    Được trả hàng với lý do "không vừa ý" (Sản phẩm chưa qua sử dụng và còn nguyên tem mác)
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 py-3.5 last:pb-0">
                            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_276_6678)">
                                    <path d="M10.1457 5.42565L8.12382 7.59815C7.77945 7.94378 7.34195 8.12503 6.8757 8.12503C6.40945 8.12503 5.97257 7.94378 5.6432 7.6144L4.7207 6.6919C4.47632 6.44753 4.47632 6.05253 4.7207 5.80815C4.96507 5.56378 5.36007 5.56378 5.60445 5.80815L6.52695 6.73065C6.7132 6.9169 7.0382 6.9169 7.22382 6.73065L9.2307 4.5744C9.46632 4.32128 9.86195 4.30815 10.1138 4.54253C10.3663 4.77753 10.3807 5.17315 10.1457 5.42565ZM14.9538 12.5819C14.8126 12.9213 14.4982 13.1319 14.1313 13.1319H13.1551V14.1082C13.1551 14.6663 12.6994 15 12.2582 15C12.0226 15 11.8069 14.9094 11.6351 14.7375L8.90632 12.0088C8.90632 12.0088 8.90445 12.005 8.90257 12.0032C8.7982 12.0869 8.6957 12.1725 8.57445 12.24C8.2482 12.4213 7.88195 12.5119 7.51632 12.5119C7.1507 12.5119 6.78445 12.4213 6.45757 12.24C6.33445 12.1719 6.22945 12.085 6.1232 11.9994C6.1207 12.0025 6.11945 12.0063 6.11695 12.0094L3.3882 14.7382C3.21695 14.91 3.00132 15.0007 2.76507 15.0007C2.32445 15.0007 1.86882 14.6669 1.86882 14.1088V13.1325H0.892571C0.525696 13.1325 0.210696 12.9225 0.0700709 12.5838C-0.0705541 12.2438 0.00382086 11.8725 0.263196 11.6132L2.47632 9.40065C2.44132 9.1369 2.44945 8.87378 2.5082 8.61565C2.54882 8.43753 2.4632 8.24565 2.2957 8.13753C1.98382 7.93628 1.73132 7.66315 1.54445 7.3269C1.36632 7.00503 1.27257 6.63628 1.27445 6.25878C1.27257 5.8869 1.3657 5.51753 1.54445 5.19565C1.7307 4.85878 1.98382 4.58565 2.2957 4.38503C2.4632 4.2769 2.54882 4.08503 2.5082 3.90753C2.42445 3.5369 2.43695 3.15753 2.54507 2.7794C2.75132 2.0619 3.32445 1.48878 4.04195 1.28253C4.41945 1.1744 4.79882 1.1619 5.16882 1.24565C5.3482 1.28503 5.53882 1.20003 5.64695 1.03253C5.84757 0.721279 6.1207 0.468779 6.45757 0.281904C7.11007 -0.0799707 7.92132 -0.0799707 8.57445 0.281904C8.91132 0.468779 9.18382 0.721279 9.38445 1.03315C9.49257 1.20065 9.68632 1.2869 9.86257 1.24565C10.2319 1.16128 10.6119 1.1744 10.9901 1.28253C11.7076 1.48878 12.2813 2.0619 12.4876 2.7794C12.5957 3.15815 12.6082 3.53815 12.5244 3.90815C12.4844 4.08565 12.5694 4.27753 12.7369 4.38565C13.0488 4.5869 13.3019 4.8594 13.4882 5.19628C13.6663 5.51815 13.7601 5.8869 13.7582 6.2644C13.7601 6.63628 13.6669 7.00565 13.4882 7.32753C13.3019 7.66378 13.0488 7.9369 12.7376 8.13815C12.5694 8.24628 12.4838 8.43815 12.5244 8.61628C12.5838 8.8769 12.5926 9.14253 12.5557 9.4094L14.7607 11.6144C15.0201 11.8738 15.0938 12.245 14.9538 12.5838V12.5819ZM5.0657 11.2925C4.72882 11.3525 4.38507 11.3369 4.04195 11.2394C3.6507 11.1275 3.30945 10.8988 3.04007 10.6038L1.76195 11.8819H2.49445C2.83945 11.8819 3.11945 12.1619 3.11945 12.5069V13.2388L5.06632 11.2919L5.0657 11.2925ZM10.1394 10.0569C10.3013 10.0938 10.4719 10.0869 10.6463 10.0375C10.9482 9.95128 11.1994 9.70003 11.2863 9.39815C11.3357 9.2244 11.3426 9.05378 11.3057 8.89128C11.1494 8.20315 11.4526 7.47815 12.0601 7.08628C12.1969 6.99753 12.3101 6.8744 12.3957 6.72003C12.4701 6.58565 12.5094 6.42753 12.5088 6.26315C12.5094 6.09378 12.4701 5.93565 12.3957 5.80065C12.3101 5.64565 12.1976 5.52253 12.0601 5.4344C11.4526 5.04253 11.1501 4.31753 11.3057 3.63003C11.3426 3.46753 11.3363 3.2969 11.2863 3.12253C11.2001 2.82128 10.9482 2.57003 10.6463 2.48315C10.4732 2.43315 10.3026 2.42753 10.1394 2.46378C9.45382 2.62128 8.72757 2.31753 8.33507 1.71003C8.24695 1.57315 8.12382 1.46003 7.96945 1.3744C7.69445 1.2219 7.33882 1.22253 7.06445 1.3744C6.90945 1.46065 6.78632 1.57315 6.6982 1.71003C6.30695 2.3169 5.58257 2.62128 4.8932 2.4644C4.73007 2.42753 4.5607 2.43378 4.38695 2.48378C4.08507 2.57065 3.8332 2.82128 3.74695 3.12315C3.69695 3.2969 3.6907 3.46753 3.72757 3.63065C3.88382 4.31753 3.5807 5.04315 2.9732 5.43503C2.83632 5.52315 2.72382 5.64628 2.6382 5.80128C2.5632 5.93628 2.52382 6.0944 2.52507 6.25815C2.52445 6.42753 2.56382 6.58565 2.6382 6.72065C2.72445 6.87565 2.83695 6.99878 2.97445 7.08753C3.58132 7.47878 3.88445 8.2044 3.7282 8.8919C3.69132 9.05378 3.6982 9.22503 3.7482 9.3994C3.83507 9.70065 4.0857 9.9519 4.38757 10.0382C4.5607 10.0882 4.73132 10.0944 4.8932 10.0575C5.01382 10.0307 5.1357 10.0169 5.25632 10.0169C5.82507 10.0169 6.3757 10.3107 6.69882 10.8113C6.78757 10.9482 6.9107 11.0607 7.06507 11.1469C7.33945 11.2994 7.69445 11.2994 7.97007 11.1469C8.12445 11.0613 8.24757 10.9482 8.3357 10.8113C8.7282 10.2044 9.45507 9.90065 10.1407 10.0569H10.1394ZM13.2626 11.8819L11.9888 10.6082C11.7201 10.9013 11.3801 11.1275 10.9901 11.2388C10.6432 11.3375 10.2963 11.3525 9.95695 11.2907L11.9051 13.2388V12.5069C11.9051 12.1619 12.1851 11.8819 12.5301 11.8819H13.2626Z" fill="#0165FC" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_276_6678">
                                        <rect width="15" height="15" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <span class="text-5 text-sm">Tem bảo hành 12 tháng</span>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-[10px]">
                    <h3 class="text-[20px] font-bold text-2 mb-4">
                        Sản phẩm liên quan
                    </h3>
                    <div class="flex flex-col gap-4">
                        @foreach($relatedProducts as $rp)
                        <a href="{{ route('products.detailClient', $rp->id ) }}" class="flex items-center gap-3.5 no-underline group">
                            <div class="w-25 h-25 rounded shrink-0 flex items-center justify-center bg-white group-hover:border-gray-300 transition-colors">
                                <img src="{{ $rp->thumbnail ? $rp->thumbnail_url : asset('storage/images/chitiet1.jpg') }}" alt="Related Product" class="max-h-full object-contain">
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-sm font-bold text-[#202F36] group-hover:text-7 transition-colors line-clamp-1 leading-snug">
                                    {{ $rp->sku }}
                                </h4>
                                <div class="flex text-[#FF7A00] text-xs gap-0.5 mt-1">
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star text-[#F29F05]"></i>
                                    <i class="fa-solid fa-star-half-stroke text-[#F29F05]"></i>
                                </div>
                                <span class="text-sm text-[#929B9E] font-semibold block mt-1.5 leading-none">
                                    {{ $rp->weight ? $rp->weight . 'kg' : '0.75kW' }}
                                </span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection