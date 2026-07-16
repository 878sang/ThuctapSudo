@extends('client.layout.main')

@section('content')
<div class="bg-blue_bg min-h-screen pb-12" x-data="{ step: {{ old('address_method') ? 2 : 1 }}, addressMethod: '{{ old('address_method', 'new') }}', paymentMethod: '{{ old('payment_method', 'bank') }}', vatRequired: {{ old('is_vat') == '1' ? 'true' : 'false' }}, selectedItems: [] }">
    <div class="bg-blue_bg border-b border-gray-100 py-3 mb-6">
        <div class="max-w-[1440px] mx-auto px-4">
            <x-breadcrumb :items="[['label' => 'Giỏ hàng']]" />
        </div>
    </div>
    <div class="max-w-[1440px] mx-auto px-4">
        @if(count($cartItems) > 0)
        <div class="flex flex-col lg:flex-row gap-6">
            <div class="w-full lg:w-[73%] flex flex-col gap-6">
                <div x-show="step === 1" class="flex flex-col gap-6">
                    <div class="bg-white rounded-[10px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] p-4 sm:p-5 flex items-center justify-between gap-4">
                        <h1 class="text-[22px] font-bold text-6 flex items-center gap-1">
                            Giỏ hàng <span class="text-[#F86614] font-bold">(<span id="cart-title-count">{{ count($cartItems) }}</span>)</span>
                        </h1>
                        <div class="relative w-48 sm:w-80">
                            <input type="text" placeholder="Nhập tên sản phẩm" class="w-full bg-[#F6F6F6] border-none rounded-[10px] px-4 py-2.5 text-xs sm:text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-400 pr-10">
                            <i class="fa-solid fa-magnifying-glass absolute right-3.5 top-3.5 text-gray-400 text-sm"></i>
                        </div>
                    </div>
                    <div class="bg-white rounded-[10px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm border-collapse">
                                <thead>
                                    <tr class="bg-white text-sm text-[#3D3E3F] font-bold">
                                        <th class="py-4 px-4 rounded-l w-[15%]">
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" @change="if ($el.checked) { selectedItems = [{{ implode(',', array_keys($cartItems)) }}] } else { selectedItems = [] }"
                                                    :checked="selectedItems.length === {{ count($cartItems) }} && {{ count($cartItems) }} > 0" class="rounded text-6 focus:ring-6 w-4.5 h-4.5 border-[#D9D9D9] cursor-pointer">
                                                <form id="bulk-delete-form" action="{{ route('cart.remove') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="product_ids" :value="selectedItems">
                                                </form>
                                                <button type="submit"
                                                    form="bulk-delete-form"
                                                    :disabled="selectedItems.length === 0"
                                                    :class="selectedItems.length === 0 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'"
                                                    class="bg-blue_bg hover:bg-[#DDECFF] text-3 text-[10px] font-bold px-2.5 py-1 rounded-[5px] shrink-0 transition-colors">
                                                    Xóa<span class="text-[#F86614]" x-show="selectedItems.length > 0">(<span x-text="selectedItems.length"></span>)</span>
                                                </button>
                                            </div>
                                        </th>
                                        <th class="py-4 px-4 font-bold text-[#3D3E3F] w-[35%]">Mã hàng</th>
                                        <th class="py-4 px-4 font-bold text-[#3D3E3F] w-[15%]">Đơn giá</th>
                                        <th class="py-4 px-4 text-center font-bold text-[#3D3E3F] w-[12%]">Số lượng</th>
                                        <th class="py-4 px-4 rounded-r text-center font-bold text-[#3D3E3F] w-[23%]">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($cartItems as $item)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="py-4 px-4 align-middle">
                                            <input type="checkbox"
                                                value="{{ $item['product']->id }}"
                                                x-model="selectedItems"
                                                class="rounded text-6 focus:ring-6 w-4.5 h-4.5 border-gray-300 cursor-pointer">
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-20 h-20 rounded-lg shrink-0 flex items-center justify-center">
                                                    <img src="{{ $item['product']->thumbnail_url }}" class="w-full h-full object-contain" alt="Product thumbnail">
                                                </div>
                                                <div class="flex flex-col gap-0.5 min-w-0">
                                                    <span class="text-sm text-2 leading-snug line-clamp-2">{{ $item['product']->name }}</span>
                                                    <x-star-rating :stars="$item['stars']" class="text-[9px]" />
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-sm text-2 whitespace-nowrap">{{ number_format($item['price'], 0, ',', '.') }} đ</td>
                                        <td class="py-4 px-4 text-center">
                                            <form action="{{ route('cart.update') }}" method="POST" @change="$el.requestSubmit()">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                                                <x-quantity-selector :qty="$item['quantity']" :autoUpdate="true" :max="$item['product']->stock" />
                                            </form>
                                        </td>
                                        <td class="py-4 px-4 text-center text-sm text-[#EB7507] font-bold whitespace-nowrap cart-subtotal">{{ number_format($item['subtotal'], 0, ',', '.') }} đ</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <form id="checkout-form" action="{{ route('checkout.placeOrder') }}" method="POST" class="flex flex-col gap-6">
                    @csrf
                    <input type="hidden" name="address_method" :value="addressMethod">
                    <input type="hidden" name="payment_method" :value="paymentMethod">
                    <input type="hidden" name="is_vat" :value="vatRequired ? 1 : 0">

                    <div x-show="step === 2" x-cloak class="flex flex-col gap-4">
                        <button type="button" @click="step = 1" class="text-xs text-6 hover:underline font-semibold flex items-center gap-1.5 cursor-pointer self-start">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i> Quay lại giỏ hàng
                        </button>
                        <div class="bg-white rounded-[10px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] p-6 flex flex-col gap-5">
                            <h2 class="text-[22px] font-bold text-2 mb-2">Thông tin giao hàng</h2>
                            @auth
                            <div class="space-y-3">
                                <x-radio-button model="addressMethod" value="account" label="Lấy địa chỉ theo tài khoản" />

                                <div x-show="addressMethod === 'account'" x-collapse class="bg-[#EDF3FF] rounded-[10px] p-5 flex items-center justify-between border-none ml-7.5">
                                    <div class="space-y-1.5 text-sm text-3 leading-relaxed">
                                        <p class="font-bold text-[#9090A7] uppercase">{{ auth()->user()->name }}</p>
                                        <p class="font-bold text-[#9090A7]">Số điện thoại: {{ auth()->user()->phone ?? 'Chưa cập nhật' }}</p>
                                        <p class="text-[#9090A7]">{{ auth()->user()->address ?? 'Chưa cập nhật' }}</p>
                                    </div>
                                    <button type="button" class="bg-6 hover:bg-blue-600 text-white w-10 h-10 rounded-[8px] flex items-center justify-center transition-colors shrink-0 cursor-pointer">
                                        <i class="fa-solid fa-chevron-down text-sm"></i>
                                    </button>
                                </div>
                            </div>
                            @endauth
                            <!-- Option 2: Thêm địa chỉ mới -->
                            <div class="space-y-3 pt-1">
                                <x-radio-button model="addressMethod" value="new" label="Thêm địa chỉ mới" />

                                <div x-show="addressMethod === 'new'" x-collapse class="ml-7.5 space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-sm text-3">Họ và tên <span class="text-[#FF7A00]">*</span></label>
                                            <input type="text" name="customer_name" data-error-field="customer_name" value="{{ old('customer_name') }}" placeholder="Chu Tuấn Anh" class="w-full border @error('customer_name') border-red-500 @else border-[#E5E7EB] @enderror rounded-[10px] mt-2.5 px-4 py-2.5 text-sm text-2 placeholder-[#A1A7AA] focus:outline-none focus:border-6 focus:ring-0 bg-white h-[46px]">
                                            <span class="text-xs text-red-500 mt-1 block error-message-span" data-error-for="customer_name">
                                                @error('customer_name'){{ $message }}@enderror
                                            </span>
                                        </div>
                                        <div>
                                            <label class="text-sm text-3">Số điện thoại <span class="text-[#FF7A00]">*</span></label>
                                            <input type="text" name="customer_phone" data-error-field="customer_phone" value="{{ old('customer_phone') }}" placeholder="(+84) 988 038 291" class="w-full border @error('customer_phone') border-red-500 @else border-[#E5E7EB] @enderror rounded-[10px] mt-2.5 px-4 py-2.5 text-sm text-2 placeholder-[#A1A7AA] focus:outline-none focus:border-6 focus:ring-0 bg-white h-[46px]">
                                            <span class="text-xs text-red-500 mt-1 block error-message-span" data-error-for="customer_phone">
                                                @error('customer_phone'){{ $message }}@enderror
                                            </span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="text-sm text-3 mb-2.5">Địa chỉ <span class="text-[#FF7A00]">*</span></label>
                                            <div class="relative">
                                                <input type="text" name="province" data-error-field="province" value="{{ old('province') }}" placeholder="Tỉnh/Thành phố" class="w-full border @error('province') border-red-500 @else border-[#E5E7EB] @enderror rounded-[10px] mt-2.5 px-4 py-2.5 text-sm text-2 placeholder-[#A1A7AA] focus:outline-none focus:border-6 focus:ring-0 bg-white h-[46px]">
                                                <span class="text-xs text-red-500 mt-1 block error-message-span" data-error-for="province">
                                                    @error('province'){{ $message }}@enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="text-sm text-3">&nbsp;</label>
                                            <div class="relative">
                                                <input type="text" name="district" data-error-field="district" value="{{ old('district') }}" placeholder="Quận/ huyện" class="w-full border @error('district') border-red-500 @else border-[#E5E7EB] @enderror rounded-[10px] mt-2.5 px-4 py-2.5 text-sm text-2 placeholder-[#A1A7AA] focus:outline-none focus:border-6 focus:ring-0 bg-white h-[46px]">
                                                <span class="text-xs text-red-500 mt-1 block error-message-span" data-error-for="district">
                                                    @error('district'){{ $message }}@enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="space-y-1.5">
                                            <label class="text-sm text-3">&nbsp;</label>
                                            <div class="relative">
                                                <input type="text" name="ward" data-error-field="ward" value="{{ old('ward') }}" placeholder="Phường/ xã" class="w-full border @error('ward') border-red-500 @else border-[#E5E7EB] @enderror rounded-[10px] mt-2.5 px-4 py-2.5 text-sm text-2 placeholder-[#A1A7AA] focus:outline-none focus:border-6 focus:ring-0 bg-white h-[46px]">
                                                <span class="text-xs text-red-500 mt-1 block error-message-span" data-error-for="ward">
                                                    @error('ward'){{ $message }}@enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-1.5">
                                        <div class="relative">
                                            <input type="text" name="street" data-error-field="street" value="{{ old('street') }}" placeholder="Địa chỉ chính xác (Số nhà, tên đường)" class="w-full border @error('street') border-red-500 @else border-[#E5E7EB] @enderror rounded-[10px] mt-2.5 px-4 py-2.5 text-sm text-2 placeholder-[#A1A7AA] focus:outline-none focus:border-6 focus:ring-0 bg-white h-[46px]">
                                            <span class="text-xs text-red-500 mt-1 block error-message-span" data-error-for="street">
                                                @error('street'){{ $message }}@enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <x-radio-button model="vatRequired" label="Yêu cầu xuất hóa đơn VAT" />

                            <div x-show="vatRequired" x-collapse class="ml-7.5 space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label class="text-sm text-3">Tên công ty <span class="text-[#FF7A00]">*</span></label>
                                        <div class="relative">
                                            <input type="text" name="company_name" data-error-field="company_name" value="{{ old('company_name') }}" class="w-full border @error('company_name') border-red-500 @else border-[#E5E7EB] @enderror rounded-[10px] px-4 py-2.5 text-sm text-2 font-bold focus:outline-none focus:border-6 pr-10 bg-white h-[46px]">
                                            <span class="text-xs text-red-500 mt-1 block error-message-span" data-error-for="company_name">
                                                @error('company_name'){{ $message }}@enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="text-sm text-3">Email nhận hóa đơn <span class="text-[#FF7A00]">*</span></label>
                                        <div class="relative">
                                            <input type="text" name="company_email" data-error-field="company_email" value="{{ old('company_email') }}" class="w-full border @error('company_email') border-red-500 @else border-[#E5E7EB] @enderror rounded-[10px] px-4 py-2.5 text-sm text-2 font-bold focus:outline-none focus:border-6 pr-10 bg-white h-[46px]">
                                            <span class="text-xs text-red-500 mt-1 block error-message-span" data-error-for="company_email">
                                                @error('company_email'){{ $message }}@enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label class="text-sm text-3">Mã số thuế <span class="text-[#FF7A00]">*</span></label>
                                        <div class="relative">
                                            <input type="text" name="tax_code" data-error-field="tax_code" value="{{ old('tax_code') }}" class="w-full border @error('tax_code') border-red-500 @else border-[#E5E7EB] @enderror rounded-[10px] px-4 py-2.5 text-sm text-2 font-bold focus:outline-none focus:border-6 pr-10 bg-white h-[46px]">
                                            <span class="text-xs text-red-500 mt-1 block error-message-span" data-error-for="tax_code">
                                                @error('tax_code'){{ $message }}@enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="text-sm text-3">Địa chỉ <span class="text-[#FF7A00]">*</span></label>
                                        <div class="relative">
                                            <input type="text" name="company_address" data-error-field="company_address" value="{{ old('company_address') }}" class="w-full border @error('company_address') border-red-500 @else border-[#E5E7EB] @enderror rounded-[10px] px-4 py-2.5 text-sm text-2 font-bold focus:outline-none focus:border-6 pr-10 bg-white h-[46px]">
                                            <span class="text-xs text-red-500 mt-1 block error-message-span" data-error-for="company_address">
                                                @error('company_address'){{ $message }}@enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="step === 3" x-cloak class="flex flex-col gap-4">
                        <!-- Back Button Link -->
                        <button type="button" @click="step = 2" class="text-xs text-6 hover:underline font-semibold flex items-center gap-1.5 cursor-pointer self-start">
                            <i class="fa-solid fa-arrow-left text-[10px]"></i> Quay lại bước trước
                        </button>

                        <div class="bg-white rounded-[10px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] p-6 flex flex-col gap-6">
                            <h2 class="text-[22px] font-bold text-gray-800">Thông tin thanh toán</h2>

                            <div class="space-y-4">
                                <h3 class="text-[22px] font-bold text-[#1F4388]">Thông tin liên hệ</h3>

                                <div class="space-y-3">
                                    <x-radio-button model="paymentMethod" value="bank" label="Chuyển khoản" />
                                    <div x-show="paymentMethod === 'bank'" x-collapse class="ml-7.5 space-y-2 text-sm text-3">
                                        <p class="font-bold mb-1">Vietcombank - Ngân hàng ngoại thương Việt Nam</p>
                                        <p>Chi nhánh Thành Công</p>
                                        <p>Chủ tài khoản: CHU TUAN ANH</p>
                                        <p class="flex items-center gap-1.5">
                                            Số tài khoản: 0451000310732
                                            <button type="button" class="text-6 hover:text-blue-700 cursor-pointer" title="Copy">
                                                <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_276_25352)">
                                                        <path d="M9.53 18H2.81C1.26 18 0 16.74 0 15.19V5.66C0 4.11 1.26 2.85 2.81 2.85H9.53C11.08 2.85 12.34 4.11 12.34 5.66V15.19C12.34 16.74 11.08 18 9.53 18ZM2.81 4.25C2.03 4.25 1.41 4.88 1.4 5.66V15.19C1.4 15.97 2.03 16.59 2.81 16.6H9.53C10.31 16.6 10.93 15.97 10.94 15.19V5.66C10.94 4.88 10.31 4.26 9.53 4.25H2.81ZM15.15 13.43V2.81C15.15 1.26 13.89 0 12.34 0H4.54C4.15 0 3.84 0.31 3.84 0.7C3.84 1.09 4.15 1.4 4.54 1.4H12.34C13.12 1.4 13.74 2.03 13.75 2.81V13.43C13.75 13.82 14.06 14.13 14.45 14.13C14.84 14.13 15.15 13.82 15.15 13.43Z" fill="#278AEC" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_276_25352">
                                                            <rect width="15.15" height="18" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </button>
                                        </p>

                                        <div class="bg-white border border-gray-200 rounded-[8px] p-3.5 space-y-1.5 mt-3">
                                            <p class="text-3"><strong class="text-3 font-bold">Nội dung chuyển khoản:</strong> “Tên khách hàng” + Số điện thoại</p>
                                            <p class="text-4 ">Ví dụ: “CHU TUAN ANH” + “0988038291”</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-2 pt-2">
                                    <x-radio-button model="paymentMethod" value="cod" label="Ship COD nhận hàng thanh toán tại nhà" />
                                    <p x-show="paymentMethod === 'cod'" x-collapse class="ml-7.5 text-sm text-4 font-semibold">Chúng tôi cung cấp dịch vụ Ship COD toàn quốc thuận tiện và đảm bảo</p>
                                </div>

                                <div class="space-y-2 pt-2">
                                    <x-radio-button model="paymentMethod" value="momo" label="Thanh toán qua Momo" />
                                    <p x-show="paymentMethod === 'momo'" x-collapse class="ml-7.5 text-sm text-4 font-semibold">Chúng tôi cung cấp dịch vụ Ship COD toàn quốc thuận tiện và đảm bảo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="w-full lg:w-[27%] flex flex-col gap-6">
                <div x-show="step < 3" x-cloak class="bg-white p-5 rounded-[10px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center gap-2.5 mb-4 text-2 font-bold">
                        <svg width="23" height="30" viewBox="0 0 23 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.25 0H16.0875C15.5281 0.00531477 14.9863 0.196267 14.5471 0.542874C14.108 0.889482 13.7964 1.37212 13.6613 1.915C13.5165 2.44355 13.2022 2.9099 12.7665 3.24232C12.3308 3.57473 11.798 3.75479 11.25 3.75479C10.702 3.75479 10.1692 3.57473 9.73351 3.24232C9.29784 2.9099 8.98347 2.44355 8.83875 1.915C8.70362 1.37212 8.39202 0.889482 7.95288 0.542874C7.51374 0.196267 6.97192 0.00531477 6.4125 0L6.25 0C4.59301 0.00198482 3.00445 0.661102 1.83277 1.83277C0.661102 3.00445 0.00198482 4.59301 0 6.25V26.25C0 27.2446 0.395088 28.1984 1.09835 28.9017C1.80161 29.6049 2.75544 30 3.75 30H6.4125C6.97192 29.9947 7.51374 29.8037 7.95288 29.4571C8.39202 29.1105 8.70362 28.6279 8.83875 28.085C8.98347 27.5565 9.29784 27.0901 9.73351 26.7577C10.1692 26.4253 10.702 26.2452 11.25 26.2452C11.798 26.2452 12.3308 26.4253 12.7665 26.7577C13.2022 27.0901 13.5165 27.5565 13.6613 28.085C13.7964 28.6279 14.108 29.1105 14.5471 29.4571C14.9863 29.8037 15.5281 29.9947 16.0875 30H18.75C19.7446 30 20.6984 29.6049 21.4017 28.9017C22.1049 28.1984 22.5 27.2446 22.5 26.25V6.25C22.498 4.59301 21.8389 3.00445 20.6672 1.83277C19.4956 0.661102 17.907 0.00198482 16.25 0ZM18.75 27.5L16.0713 27.4212C15.7777 26.3605 15.1423 25.4263 14.2636 24.7635C13.385 24.1006 12.3122 23.7462 11.2117 23.7552C10.1111 23.7642 9.04423 24.136 8.17653 24.8131C7.30882 25.4902 6.68876 26.4346 6.4125 27.5H3.75C3.41848 27.5 3.10054 27.3683 2.86612 27.1339C2.6317 26.8995 2.5 26.5815 2.5 26.25V21.25H5C5.33152 21.25 5.64946 21.1183 5.88388 20.8839C6.1183 20.6495 6.25 20.3315 6.25 20C6.25 19.6685 6.1183 19.3505 5.88388 19.1161C5.64946 18.8817 5.33152 18.75 5 18.75H2.5V6.25C2.5 5.25544 2.89509 4.30161 3.59835 3.59835C4.30161 2.89509 5.25544 2.5 6.25 2.5L6.42875 2.57875C6.72153 3.63303 7.35124 4.56256 8.22177 5.22544C9.0923 5.88832 10.1558 6.24815 11.25 6.25C12.3589 6.24057 13.4345 5.86913 14.3129 5.1922C15.1913 4.51528 15.8245 3.56993 16.1162 2.5H16.25C17.2446 2.5 18.1984 2.89509 18.9017 3.59835C19.6049 4.30161 20 5.25544 20 6.25V18.75H17.5C17.1685 18.75 16.8505 18.8817 16.6161 19.1161C16.3817 19.3505 16.25 19.6685 16.25 20C16.25 20.3315 16.3817 20.6495 16.6161 20.8839C16.8505 21.1183 17.1685 21.25 17.5 21.25H20V26.25C20 26.5815 19.8683 26.8995 19.6339 27.1339C19.3995 27.3683 19.0815 27.5 18.75 27.5Z" fill="#0165FC" />
                            <path d="M12.5 18.75H10C9.66848 18.75 9.35054 18.8817 9.11612 19.1161C8.8817 19.3505 8.75 19.6685 8.75 20C8.75 20.3315 8.8817 20.6495 9.11612 20.8839C9.35054 21.1183 9.66848 21.25 10 21.25H12.5C12.8315 21.25 13.1495 21.1183 13.3839 20.8839C13.6183 20.6495 13.75 20.3315 13.75 20C13.75 19.6685 13.6183 19.3505 13.3839 19.1161C13.1495 18.8817 12.8315 18.75 12.5 18.75Z" fill="#0165FC" />
                        </svg>
                        <span>Mã giảm giá</span>
                    </div>
                    <div class="flex items-center relative bg-6 rounded-[10px] h-[74px] p-3 overflow-hidden">
                        <div class="absolute left-0 ">
                            <svg width="93" height="74" viewBox="0 0 93 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0_276_24610" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="93" height="74">
                                    <path d="M83 0H10C4.47715 0 0 4.47715 0 10V64C0 69.5229 4.47715 74 10 74H83C88.5229 74 93 69.5229 93 64V10C93 4.47715 88.5229 0 83 0Z" fill="white" />
                                </mask>
                                <g mask="url(#mask0_276_24610)">
                                    <path d="M27.779 14.0799C25.8591 14.7399 23.759 14.5599 21.979 13.5899C14.729 10.2199 6.10905 13.1799 2.46905 20.3099C1.66905 22.1699 0.129047 23.5999 -1.79095 24.2599C-3.41095 24.8599 -5.19095 24.7899 -6.76095 24.0699C-11.481 22.3199 -16.731 24.7199 -18.481 29.4399C-19.221 31.4199 -19.241 33.5899 -18.551 35.5899L10.259 119.26C11.899 124.02 17.099 126.55 21.859 124.91C23.839 124.23 25.529 122.88 26.639 121.09C27.429 119.55 28.809 118.39 30.459 117.87C32.369 117.21 34.469 117.39 36.249 118.36C43.499 121.73 52.129 118.77 55.759 111.64C56.559 109.78 58.109 108.35 60.029 107.69C61.659 107.07 63.469 107.14 65.049 107.88C69.789 109.59 75.019 107.14 76.729 102.4C77.439 100.45 77.459 98.3199 76.789 96.3599L47.959 12.6799C46.319 7.91988 41.119 5.37988 36.359 7.02988C34.369 7.70988 32.679 9.05988 31.579 10.8499C30.799 12.3899 29.4291 13.5599 27.779 14.0799Z" fill="#90B6FA" />
                                    <path d="M46.0596 71.1698C46.7596 73.2098 45.6696 75.4398 43.6296 76.1398C42.6496 76.4798 41.5796 76.4098 40.6496 75.9598L14.1496 63.0399C12.2496 62.0199 11.5296 59.6498 12.5496 57.7499C13.5196 55.9499 15.6996 55.1999 17.5696 56.0199L44.0696 68.9399C44.9996 69.3899 45.7196 70.1999 46.0496 71.1799L46.0596 71.1698Z" fill="white" />
                                    <path d="M35.5791 57.9398C38.4565 57.9398 40.7891 55.6072 40.7891 52.7298C40.7891 49.8524 38.4565 47.5198 35.5791 47.5198C32.7017 47.5198 30.3691 49.8524 30.3691 52.7298C30.3691 55.6072 32.7017 57.9398 35.5791 57.9398Z" fill="white" />
                                </g>
                            </svg>

                        </div>
                        <div class="flex-1 bg-white rounded-[10px] p-1 flex items-center justify-between h-[54px] ml-3">
                            <input type="text" placeholder="Nhập mã khuyến mại" class="flex-1 pl-10 py-1.5 text-xs sm:text-sm text-4 placeholder-4 focus:outline-none focus:ring-0">
                            <button class="bg-6 hover:bg-blue-600 text-white p-2 rounded-[8px] text-xs sm:text-sm transition-colors cursor-pointer shrink-0">Áp dụng</button>
                        </div>
                    </div>
                    <a href="#" class="text-6 text-sm font-semibold hover:underline block mt-3.5">Xem thêm mã khuyến mại</a>
                </div>
                <div x-show="step < 3" x-cloak class="bg-white p-5 rounded-[10px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center gap-2.5 mb-4 text-2 font-bold">
                        <svg width="23" height="30" viewBox="0 0 23 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.25 0H16.0875C15.5281 0.00531477 14.9863 0.196267 14.5471 0.542874C14.108 0.889482 13.7964 1.37212 13.6613 1.915C13.5165 2.44355 13.2022 2.9099 12.7665 3.24232C12.3308 3.57473 11.798 3.75479 11.25 3.75479C10.702 3.75479 10.1692 3.57473 9.73351 3.24232C9.29784 2.9099 8.98347 2.44355 8.83875 1.915C8.70362 1.37212 8.39202 0.889482 7.95288 0.542874C7.51374 0.196267 6.97192 0.00531477 6.4125 0L6.25 0C4.59301 0.00198482 3.00445 0.661102 1.83277 1.83277C0.661102 3.00445 0.00198482 4.59301 0 6.25V26.25C0 27.2446 0.395088 28.1984 1.09835 28.9017C1.80161 29.6049 2.75544 30 3.75 30H6.4125C6.97192 29.9947 7.51374 29.8037 7.95288 29.4571C8.39202 29.1105 8.70362 28.6279 8.83875 28.085C8.98347 27.5565 9.29784 27.0901 9.73351 26.7577C10.1692 26.4253 10.702 26.2452 11.25 26.2452C11.798 26.2452 12.3308 26.4253 12.7665 26.7577C13.2022 27.0901 13.5165 27.5565 13.6613 28.085C13.7964 28.6279 14.108 29.1105 14.5471 29.4571C14.9863 29.8037 15.5281 29.9947 16.0875 30H18.75C19.7446 30 20.6984 29.6049 21.4017 28.9017C22.1049 28.1984 22.5 27.2446 22.5 26.25V6.25C22.498 4.59301 21.8389 3.00445 20.6672 1.83277C19.4956 0.661102 17.907 0.00198482 16.25 0ZM18.75 27.5L16.0713 27.4212C15.7777 26.3605 15.1423 25.4263 14.2636 24.7635C13.385 24.1006 12.3122 23.7462 11.2117 23.7552C10.1111 23.7642 9.04423 24.136 8.17653 24.8131C7.30882 25.4902 6.68876 26.4346 6.4125 27.5H3.75C3.41848 27.5 3.10054 27.3683 2.86612 27.1339C2.6317 26.8995 2.5 26.5815 2.5 26.25V21.25H5C5.33152 21.25 5.64946 21.1183 5.88388 20.8839C6.1183 20.6495 6.25 20.3315 6.25 20C6.25 19.6685 6.1183 19.3505 5.88388 19.1161C5.64946 18.8817 5.33152 18.75 5 18.75H2.5V6.25C2.5 5.25544 2.89509 4.30161 3.59835 3.59835C4.30161 2.89509 5.25544 2.5 6.25 2.5L6.42875 2.57875C6.72153 3.63303 7.35124 4.56256 8.22177 5.22544C9.0923 5.88832 10.1558 6.24815 11.25 6.25C12.3589 6.24057 13.4345 5.86913 14.3129 5.1922C15.1913 4.51528 15.8245 3.56993 16.1162 2.5H16.25C17.2446 2.5 18.1984 2.89509 18.9017 3.59835C19.6049 4.30161 20 5.25544 20 6.25V18.75H17.5C17.1685 18.75 16.8505 18.8817 16.6161 19.1161C16.3817 19.3505 16.25 19.6685 16.25 20C16.25 20.3315 16.3817 20.6495 16.6161 20.8839C16.8505 21.1183 17.1685 21.25 17.5 21.25H20V26.25C20 26.5815 19.8683 26.8995 19.6339 27.1339C19.3995 27.3683 19.0815 27.5 18.75 27.5Z" fill="#0165FC" />
                            <path d="M12.5 18.75H10C9.66848 18.75 9.35054 18.8817 9.11612 19.1161C8.8817 19.3505 8.75 19.6685 8.75 20C8.75 20.3315 8.8817 20.6495 9.11612 20.8839C9.35054 21.1183 9.66848 21.25 10 21.25H12.5C12.8315 21.25 13.1495 21.1183 13.3839 20.8839C13.6183 20.6495 13.75 20.3315 13.75 20C13.75 19.6685 13.6183 19.3505 13.3839 19.1161C13.1495 18.8817 12.8315 18.75 12.5 18.75Z" fill="#0165FC" />
                        </svg>
                        <span>Sử dụng điểm thưởng</span>
                    </div>
                    <div class="bg-6 p-3 rounded-[8px]">
                        <div class="flex-1 bg-white rounded-[10px] p-1 flex items-center justify-between h-[54px] ml-3">
                            <input type="text" placeholder="Nhập mã khuyến mại" class="flex-1 pl-3 py-1.5 text-xs sm:text-sm text-4 placeholder-4 focus:outline-none focus:ring-0">
                            <button class="bg-6 hover:bg-blue-600 text-white p-2 rounded-[8px] text-xs sm:text-sm transition-colors cursor-pointer shrink-0">Áp dụng</button>
                        </div>
                    </div>
                    <span class="text-sm text-6 font-semibold block mt-3.5 leading-none">Còn lại 0 điểm, 1 điểm = 1.000đ</span>
                </div>

                <!-- Order Summary Box -->
                <div class="bg-white p-5 rounded-[10px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center gap-2.5 mb-4 text-[#202F36] font-bold">
                        <i class="fa-regular fa-file-lines text-6 text-lg"></i>
                        <span>Tóm tắt đơn hàng</span>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-3 font-medium">Tổng</span>
                            <span class="text-3 font-medium cart-total-price">{{number_format($totalPrice, 0, ',', '.')}} đ</span>
                        </div>
                        <!-- <div class="flex justify-between">
                            <span class="text-3 font-medium">Thuế GTGT (VAT)</span>
                            <span class="text-3 font-medium">300.000đ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-3 font-medium">Áp dụng mã giảm giá</span>
                            <span class="text-3 font-medium">300.000đ</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-3 font-medium">Áp dụng điểm thưởng</span>
                            <span class="text-3 font-medium">300.000đ</span>
                        </div> -->
                        <!-- Phí vận chuyển, visible in step 2 and 3 -->
                        <div x-show="step >= 2" x-cloak class="flex justify-between">
                            <span class="text-3 font-medium">Phí vận chuyển</span>
                            <span class="text-3 font-medium">300.000đ</span>
                        </div>
                        <div class="border-t border-dashed border-[#C8C8C8] pt-4 mt-2 flex justify-between items-center">
                            <span class="text-sm font-bold text-[#1F4388]">Tổng tiền cần thanh toán</span>
                            <span class="text-[17px] font-extrabold text-[#EB7507] cart-total-payment">{{number_format($totalPrice, 0, ',', '.')}} đ</span>
                        </div>
                        <!-- Số tiền cần đặt cọc trước, visible in step 3 -->
                        <div x-show="step === 3" x-cloak class="flex justify-between items-center font-bold mt-2">
                            <span class="text-sm text-[#1F4388]">Số tiền cần đặt cọc trước</span>
                            <span class="text-[17px] text-[#EB7507] cart-total-deposit">{{number_format($totalPrice, 0, ',', '.')}} đ</span>
                        </div>
                    </div>

                    <button @click="if (step === 1) { step = 2 } else if (step === 2) { validateCheckoutStep2($data, '{{ route("checkout.validate") }}') } else { document.getElementById('checkout-form').submit() }" class="w-full bg-6 hover:bg-blue-600 text-white font-bold py-3.5 rounded-lg text-sm mt-5 transition-all shadow-md text-center cursor-pointer">
                        <span x-text="step === 3 ? 'Thanh toán cọc' : 'Tiếp theo'">Tiếp theo</span>
                    </button>
                </div>
                <div class="bg-[#DAE6FF]/60 rounded-xl p-4.5 space-y-4">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#76C138] text-base shrink-0 mt-0.5"></i>
                        <p class="text-sm text-[#5E6E78] leading-relaxed font-medium">
                            Ship COD toàn quốc nhận hàng thanh toán, tìm hiểu thêm <a href="#" class="text-6 hover:underline">tại đây</a>
                        </p>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-[#76C138] text-base shrink-0 mt-0.5"></i>
                        <p class="text-sm text-[#5E6E78] leading-relaxed font-medium">
                            Tư vấn miễn phí liên hệ <a href="tel:19006536" class="text-6 hover:underline">1900 6536</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-[10px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] p-12 text-center flex flex-col items-center justify-center gap-4">
            <div class="w-24 h-24 rounded-full bg-blue_bg flex items-center justify-center text-7 mb-2">
                <i class="fa-solid fa-cart-shopping text-3xl text-6"></i>
            </div>
            <h2 class="text-xl font-bold text-2">Giỏ hàng của bạn đang trống</h2>
            <p class="text-sm text-4 max-w-md">Hãy chọn những sản phẩm chất lượng của chúng tôi để thêm vào giỏ hàng nhé.</p>
            <a href="{{ route('products.showClient') }}" class="bg-6 hover:bg-blue-600 text-white font-bold px-6 py-3 rounded-lg text-sm transition-colors mt-2">
                Tiếp tục mua sắm
            </a>
        </div>
        @endif
    </div>
</div>
@endsection