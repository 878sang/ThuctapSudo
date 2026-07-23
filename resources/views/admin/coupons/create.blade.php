@extends('admin.Layout.main')
@section('title', 'Thêm Mã Giảm Giá Mới')
@section('content')

<div class="max-w-4xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Mã giảm giá', 'url' => route('admin.coupons.index')],
        ['label' => 'Thêm mới']
    ]" />

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Thêm Mã Giảm Giá Mới</h1>
        <p class="text-slate-500 text-sm mt-1">Tạo mã voucher hoặc chương trình khuyến mại cho khách hàng</p>
    </div>

    <form action="{{ route('admin.coupons.store') }}" method="POST" class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Mã Giảm Giá (Code) <span class="text-rose-500">*</span></label>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="Ví dụ: SUMMER2026" class="w-full px-4 py-2.5 border rounded-xl font-mono uppercase focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('code') border-rose-500 @enderror" required>
                @error('code') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tên Chương Trình <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Ví dụ: Giảm giá chào hè 2026" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('name') border-rose-500 @enderror" required>
                @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Loại Giảm Giá <span class="text-rose-500">*</span></label>
                <select name="type" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Giảm số tiền cố định (đ)</option>
                    <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Giảm theo phần trăm (%)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Giá Trị Giảm <span class="text-rose-500">*</span></label>
                <input type="number" step="0.01" name="value" value="{{ old('value') }}" placeholder="Nhập số tiền hoặc %" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('value') border-rose-500 @enderror" required>
                @error('value') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Số Tiền Giảm Tối Đa (khi giảm %)</label>
                <input type="number" step="0.01" name="max_discount_amount" value="{{ old('max_discount_amount') }}" placeholder="Ví dụ: 100000 (để trống nếu không giới hạn)" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Đơn Hàng Tối Thiểu (đ)</label>
                <input type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', 0) }}" placeholder="Ví dụ: 200000" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tổng Số Lượt Giới Hạn (Toàn hệ thống)</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" placeholder="Để trống nếu không giới hạn" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Lượt Dùng Tối Đa / Mỗi Tài Khoản</label>
                <input type="number" name="user_limit" value="{{ old('user_limit', 1) }}" placeholder="Mặc định = 1" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ngày Bắt Đầu</label>
                <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ngày Hết Hạn</label>
                <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
            <label for="is_active" class="text-sm font-semibold text-slate-700 cursor-pointer">Kích hoạt mã giảm giá ngay</label>
        </div>

        <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
            <a href="{{ route('admin.coupons.index') }}" class="px-5 py-2.5 border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold rounded-xl text-sm transition-colors">
                Hủy bỏ
            </a>
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl text-sm transition-colors shadow-sm cursor-pointer">
                Lưu mã giảm giá
            </button>
        </div>
    </form>
</div>

@endsection
