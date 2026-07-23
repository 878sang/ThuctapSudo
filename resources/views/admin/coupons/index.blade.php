@extends('admin.Layout.main')
@section('title', 'Quản Lý Mã Giảm Giá')
@section('content')

<div class="max-w-7xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Mã giảm giá']
    ]" />

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-tr from-blue-500 to-indigo-600 rounded-2xl text-white shadow-md shadow-blue-200">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10M7 15h10M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">Quản Lý Mã Giảm Giá</h1>
                <p class="text-slate-500 text-sm mt-1">Danh sách khuyến mại và mã voucher trong hệ thống</p>
            </div>
        </div>
        <x-button href="{{ route('admin.coupons.create') }}">
            + Thêm mã giảm giá
        </x-button>
    </div>

    <div class="mb-6">
        <form action="{{ route('admin.coupons.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
            <div class="w-full sm:w-48">
                <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="all" {{ request()->status == 'all' || !request()->has('status') ? 'selected' : '' }}>Tất cả trạng thái</option>
                    <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>Kích hoạt (Bật)</option>
                    <option value="inactive" {{ request()->status == 'inactive' ? 'selected' : '' }}>Tạm dừng (Tắt)</option>
                </select>
            </div>
            <div class="w-full sm:w-72 flex gap-2">
                <input type="search" name="search" placeholder="Tìm kiếm theo mã hoặc tên..." value="{{ request()->search }}" class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" />
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-colors">Tìm</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden backdrop-blur-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/50">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16 text-center">ID</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mã (Code)</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tên chương trình</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Mức giảm</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Đơn tối thiểu</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Đã dùng / Giới hạn</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Trạng thái</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($coupons as $coupon)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-4 px-6 text-sm font-medium text-slate-400 text-center">{{ $coupon->id }}</td>
                        <td class="py-4 px-6 font-bold text-blue-600 font-mono text-base">{{ $coupon->code }}</td>
                        <td class="py-4 px-6 font-medium text-slate-800 text-sm">{{ $coupon->name }}</td>
                        <td class="py-4 px-6 text-sm font-semibold text-emerald-600 text-center">
                            @if($coupon->type === 'percent')
                                {{ $coupon->value }}%
                                @if($coupon->max_discount_amount)
                                    <span class="block text-xs font-normal text-slate-500">(Tối đa {{ number_format($coupon->max_discount_amount, 0, ',', '.') }}đ)</span>
                                @endif
                            @else
                                {{ number_format($coupon->value, 0, ',', '.') }}đ
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-600 text-center">
                            {{ number_format($coupon->min_order_amount, 0, ',', '.') }}đ
                        </td>
                        <td class="py-4 px-6 text-sm text-center">
                            <span class="font-bold text-slate-700">{{ $coupon->used_count }}</span> / 
                            <span class="text-slate-500">{{ $coupon->usage_limit ? $coupon->usage_limit : '∞' }}</span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($coupon->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    Đang bật
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                    Đã tắt
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Sửa">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa mã này?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors cursor-pointer" title="Xóa">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-slate-500">Chưa có mã giảm giá nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($coupons->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $coupons->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
