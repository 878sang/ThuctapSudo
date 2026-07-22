@extends('client.layout.main')

@section('content')
<div class="bg-[#F4F8FA] min-h-screen py-6 rounded-[5px]">
    <!-- Breadcrumb -->
    <div class="max-w-[1440px] mx-auto px-4 mb-4">
        <x-breadcrumb :items="[
            ['label' => 'Tổng quan tài khoản', 'url' => route('profile')],
            ['label' => 'Địa chỉ nhận hàng']
        ]" />
    </div>

    <!-- Main Container -->
    <div class="max-w-[1440px] mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            <!-- Left Sidebar -->
            @include('client.profile.sidebar', ['active' => 'addresses'])

            <!-- Right Content -->
            <main class="w-full lg:w-[73%] flex flex-col gap-6">
                <!-- Address List Card -->
                <div class="bg-white rounded-[10px] shadow-sm p-6" x-data="{ openAddModal: false, openEditModal: false, editAddress: {} }" x-init="
        @if($errors->getBag('add_address')->any()) openAddModal = true; @endif
        @if($errors->getBag('edit_address')->any()) openEditModal = true; @endif
    ">
                    <div class="flex flex-col sm:flex-row sm:items-center border-b border-[#C9C5C5]  justify-between gap-4 pb-3 mb-6">
                        <div>
                            <h2 class="text-[22px] font-bold text-2">Địa chỉ nhận hàng</h2>
                        </div>
                        <button @click="openAddModal = true" class="flex items-center gap-2 px-4 py-2.5 rounded-lg border border-dashed border-[#0165FC] text-6 font-bold text-sm bg-transparent hover:bg-[#EBF3FF] transition-colors cursor-pointer">
                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.5 1V18" stroke="#0165FC" stroke-width="2" stroke-linecap="round" />
                                <path d="M1 9.5L18 9.5" stroke="#0165FC" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            Thêm địa chỉ nhận hàng mới
                        </button>

                    </div>

                    @if($addresses->count() > 0)
                    <div class="flex flex-col divide-y divide-dashed divide-gray-200">
                        @foreach($addresses as $address)
                        <div class="flex items-start justify-between gap-4 py-5 first:pt-0">
                            <div class="flex flex-col gap-1.5 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-bold text-5 text-base">{{ $address->name }}</span>
                                    @if($address->is_default)
                                    <span class="inline-flex items-center gap-1 bg-blue_button text-6 text-sm px-3 py-1.5 rounded">
                                        Mặc định
                                    </span>
                                    @endif
                                </div>

                                <!-- Phone -->
                                <p class="text-sm text-[#747474]">Số điện thoại: {{ $address->phone }}</p>

                                <!-- Address -->
                                <p class="text-sm text-[#747474]">
                                    {{ $address->address_detail }}, {{ $address->ward }}, {{ $address->district }}, {{ $address->city_province }}
                                </p>
                            </div>

                            <!-- Right: Action Buttons -->
                            <div class="flex gap-2 shrink-0 self-end">
                                @if(!$address->is_default)
                                <form action="{{ route('profile.addresses.default', $address->id) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit"
                                        class="px-5 py-4 text-sm font-bold rounded bg-6 text-white cursor-pointer transition-colors">
                                        Đặt làm mặc định
                                    </button>
                                </form>
                                @endif

                                <button @click="editAddress = {{ json_encode($address) }}; openEditModal = true"
                                    class="px-5 py-4 text-sm font-bold rounded text-white bg-6 cursor-pointer transition-colors">
                                    Chỉnh sửa
                                </button>

                                <form action="{{ route('profile.addresses.destroy', $address->id) }}" method="POST" class="m-0"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-7 py-4 text-sm font-bold rounded text-[#696969] border border-[#CFCFCF] bg-white cursor-pointer transition-colors">
                                        Xóa
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="flex flex-col items-center justify-center py-16 px-4">
                        <div class="w-16 h-16 bg-[#F4F8FA] rounded-full flex items-center justify-center mb-4 text-[#006DF0]">
                            <svg class="w-8 h-8 text-[#006DF0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1.5">Chưa có địa chỉ giao hàng</h3>
                        <p class="text-xs text-[#9090A7] text-center max-w-sm mb-6 leading-relaxed">
                            Hãy thêm địa chỉ giao hàng đầu tiên của bạn để thanh toán các đơn hàng sau nhanh chóng hơn.
                        </p>
                        <button @click="openAddModal = true" class="bg-[#006DF0] hover:bg-blue-600 text-white font-bold text-sm px-4 py-2.5 rounded-lg flex items-center gap-2 shadow-sm border-none cursor-pointer transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Thêm địa chỉ mới
                        </button>
                    </div>
                    @endif

                    <!-- Add Address Modal -->
                    <div x-show="openAddModal" class="fixed inset-0 z-[1000] flex items-center justify-center p-4 bg-black/50 overflow-y-auto" x-cloak>
                        <div @click.away="openAddModal = false" class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden my-8" x-transition>
                            <!-- Modal Header -->
                            <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-gray-50/50">
                                <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#006DF0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Thêm địa chỉ nhận hàng mới
                                </h3>
                                <button @click="openAddModal = false" class="text-gray-400 hover:text-gray-600 bg-transparent border-none cursor-pointer text-lg p-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Modal Body -->
                            <form action="{{ route('profile.addresses.store') }}" method="POST" class="p-5 flex flex-col gap-4 m-0">
                                @csrf

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-xs font-bold text-gray-700">Họ và tên người nhận <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Ví dụ: Nguyễn Văn A" class="border @if($errors->getBag('add_address')->has('name')) border-red-500 @else border-gray-200 @endif rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006DF0]">
                                        <span class="text-xs text-red-500 mt-0.5">
                                            @if($errors->getBag('add_address')->has('name')){{ $errors->getBag('add_address')->first('name') }}@endif
                                        </span>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-xs font-bold text-gray-700">Số điện thoại <span class="text-red-500">*</span></label>
                                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Ví dụ: 0912345678" class="border @if($errors->getBag('add_address')->has('phone')) border-red-500 @else border-gray-200 @endif rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006DF0]">
                                        <span class="text-xs text-red-500 mt-0.5">
                                            @if($errors->getBag('add_address')->has('phone')){{ $errors->getBag('add_address')->first('phone') }}@endif
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-xs font-bold text-gray-700">Tỉnh / Thành phố <span class="text-red-500">*</span></label>
                                        <input type="text" name="city_province" value="{{ old('city_province') }}" placeholder="Ví dụ: Hà Nội" class="border @if($errors->getBag('add_address')->has('city_province')) border-red-500 @else border-gray-200 @endif rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006DF0]">
                                        <span class="text-xs text-red-500 mt-0.5">
                                            @if($errors->getBag('add_address')->has('city_province')){{ $errors->getBag('add_address')->first('city_province') }}@endif
                                        </span>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-xs font-bold text-gray-700">Quận / Huyện <span class="text-red-500">*</span></label>
                                        <input type="text" name="district" value="{{ old('district') }}" placeholder="Ví dụ: Cầu Giấy" class="border @if($errors->getBag('add_address')->has('district')) border-red-500 @else border-gray-200 @endif rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006DF0]">
                                        <span class="text-xs text-red-500 mt-0.5">
                                            @if($errors->getBag('add_address')->has('district')){{ $errors->getBag('add_address')->first('district') }}@endif
                                        </span>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-xs font-bold text-gray-700">Phường / Xã <span class="text-red-500">*</span></label>
                                        <input type="text" name="ward" value="{{ old('ward') }}" placeholder="Ví dụ: Dịch Vọng Hậu" class="border @if($errors->getBag('add_address')->has('ward')) border-red-500 @else border-gray-200 @endif rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006DF0]">
                                        <span class="text-xs text-red-500 mt-0.5">
                                            @if($errors->getBag('add_address')->has('ward')){{ $errors->getBag('add_address')->first('ward') }}@endif
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-xs font-bold text-gray-700">Địa chỉ chi tiết <span class="text-red-500">*</span></label>
                                    <input type="text" name="address_detail" value="{{ old('address_detail') }}" placeholder="Ví dụ: Số 12, ngõ 34, đường Trần Thái Tông" class="border @if($errors->getBag('add_address')->has('address_detail')) border-red-500 @else border-gray-200 @endif rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006DF0]">
                                    <span class="text-xs text-red-500 mt-0.5">
                                        @if($errors->getBag('add_address')->has('address_detail')){{ $errors->getBag('add_address')->first('address_detail') }}@endif
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 mt-2">
                                    <input type="checkbox" name="is_default" id="is_default_add" value="1" class="w-4 h-4 rounded text-[#006DF0] focus:ring-[#006DF0] border-gray-200 cursor-pointer">
                                    <label for="is_default_add" class="text-xs text-gray-600 font-medium cursor-pointer">Đặt làm địa chỉ nhận hàng mặc định</label>
                                </div>

                                <!-- Modal Footer -->
                                <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-gray-100">
                                    <button type="button" @click="openAddModal = false" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm px-4 py-2.5 rounded-lg border-none cursor-pointer transition-colors">
                                        Hủy bỏ
                                    </button>
                                    <button type="submit" class="bg-[#006DF0] hover:bg-blue-600 text-white font-bold text-sm px-5 py-2.5 rounded-lg border-none cursor-pointer transition-colors shadow-sm animate-none">
                                        Lưu địa chỉ
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Edit Address Modal -->
                    <div x-show="openEditModal" class="fixed inset-0 z-[1000] flex items-center justify-center p-4 bg-black/50 overflow-y-auto" x-cloak>
                        <div @click.away="openEditModal = false" class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden my-8" x-transition>
                            <!-- Modal Header -->
                            <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-gray-50/50">
                                <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                                    <svg class="w-5 h-5 text-[#006DF0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Chỉnh sửa địa chỉ nhận hàng
                                </h3>
                                <button @click="openEditModal = false" class="text-gray-400 hover:text-gray-600 bg-transparent border-none cursor-pointer text-lg p-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <!-- Modal Body -->
                            <form :action="`/profile/addresses/${editAddress.id}`" method="POST" class="p-5 flex flex-col gap-4 m-0">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-xs font-bold text-gray-700">Họ và tên người nhận <span class="text-red-500">*</span></label>
                                        <input type="text" name="name" required :value="editAddress.name" placeholder="Ví dụ: Nguyễn Văn A" class="border @if($errors->getBag('edit_address')->has('name')) border-red-500 @else border-gray-200 @endif rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006DF0]">
                                        <span class="text-xs text-red-500 mt-0.5">
                                            @if($errors->getBag('edit_address')->has('name')){{ $errors->getBag('edit_address')->first('name') }}@endif
                                        </span>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-xs font-bold text-gray-700">Số điện thoại <span class="text-red-500">*</span></label>
                                        <input type="tel" name="phone" required :value="editAddress.phone" placeholder="Ví dụ: 0912345678" class="border @if($errors->getBag('edit_address')->has('phone')) border-red-500 @else border-gray-200 @endif rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006DF0]">
                                        <span class="text-xs text-red-500 mt-0.5">
                                            @if($errors->getBag('edit_address')->has('phone')){{ $errors->getBag('edit_address')->first('phone') }}@endif
                                        </span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-xs font-bold text-gray-700">Tỉnh / Thành phố <span class="text-red-500">*</span></label>
                                        <input type="text" name="city_province" required :value="editAddress.city_province" placeholder="Ví dụ: Hà Nội" class="border @if($errors->getBag('edit_address')->has('city_province')) border-red-500 @else border-gray-200 @endif rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006DF0]">
                                        <span class="text-xs text-red-500 mt-0.5">
                                            @if($errors->getBag('edit_address')->has('city_province')){{ $errors->getBag('edit_address')->first('city_province') }}@endif
                                        </span>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-xs font-bold text-gray-700">Quận / Huyện <span class="text-red-500">*</span></label>
                                        <input type="text" name="district" required :value="editAddress.district" placeholder="Ví dụ: Cầu Giấy" class="border @if($errors->getBag('edit_address')->has('district')) border-red-500 @else border-gray-200 @endif rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006DF0]">
                                        <span class="text-xs text-red-500 mt-0.5">
                                            @if($errors->getBag('edit_address')->has('district')){{ $errors->getBag('edit_address')->first('district') }}@endif
                                        </span>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-xs font-bold text-gray-700">Phường / Xã <span class="text-red-500">*</span></label>
                                        <input type="text" name="ward" required :value="editAddress.ward" placeholder="Ví dụ: Dịch Vọng Hậu" class="border @if($errors->getBag('edit_address')->has('ward')) border-red-500 @else border-gray-200 @endif rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006DF0]">
                                        <span class="text-xs text-red-500 mt-0.5">
                                            @if($errors->getBag('edit_address')->has('ward')){{ $errors->getBag('edit_address')->first('ward') }}@endif
                                        </span>
                                    </div>
                                </div>

                                <div class="flex flex-col gap-1.5">
                                    <label class="text-xs font-bold text-gray-700">Địa chỉ chi tiết <span class="text-red-500">*</span></label>
                                    <input type="text" name="address_detail" required :value="editAddress.address_detail" placeholder="Ví dụ: Số 12, ngõ 34, đường Trần Thái Tông" class="border @if($errors->getBag('edit_address')->has('address_detail')) border-red-500 @else border-gray-200 @endif rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-[#006DF0]">
                                    <span class="text-xs text-red-500 mt-0.5">
                                        @if($errors->getBag('edit_address')->has('address_detail')){{ $errors->getBag('edit_address')->first('address_detail') }}@endif
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 mt-2" x-show="!editAddress.is_default">
                                    <input type="checkbox" name="is_default" id="is_default_edit" value="1" :checked="editAddress.is_default" class="w-4 h-4 rounded text-[#006DF0] focus:ring-[#006DF0] border-gray-200 cursor-pointer">
                                    <label for="is_default_edit" class="text-xs text-gray-600 font-medium cursor-pointer">Đặt làm địa chỉ nhận hàng mặc định</label>
                                </div>

                                <!-- Modal Footer -->
                                <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-gray-100">
                                    <button type="button" @click="openEditModal = false" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm px-4 py-2.5 rounded-lg border-none cursor-pointer transition-colors">
                                        Hủy bỏ
                                    </button>
                                    <button type="submit" class="bg-[#006DF0] hover:bg-blue-600 text-white font-bold text-sm px-5 py-2.5 rounded-lg border-none cursor-pointer transition-colors shadow-sm animate-none">
                                        Lưu thay đổi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</div>
@endsection