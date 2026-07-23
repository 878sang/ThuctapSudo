@extends('admin.Layout.main')
@section('title', 'Quản Lý Đơn Hàng')
@section('content')

<div class="max-w-7xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Đơn hàng']
    ]" />

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-tr from-indigo-500 to-violet-600 rounded-2xl text-white shadow-md shadow-indigo-200">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">Quản Lý Đơn Hàng</h1>
                <p class="text-slate-500 text-sm mt-1">Danh sách đơn hàng đặt từ hệ thống cửa hàng</p>
            </div>
        </div>
    </div>

    <!-- Bộ Lọc Đơn Hàng -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-6">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="search" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tìm kiếm</label>
                <input type="search" name="search" id="search" placeholder="Mã ĐH, tên khách hàng, SĐT..." value="{{ request()->search }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" />
            </div>
            <div>
                <label for="status" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Trạng thái</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                    <option value="all">Tất cả trạng thái</option>
                    <option value="pending" {{ request()->status == 'pending' ? 'selected' : '' }}>Tạo đơn hàng (Pending)</option>
                    <option value="processing" {{ request()->status == 'processing' ? 'selected' : '' }}>Đóng gói (Processing)</option>
                    <option value="shipped" {{ request()->status == 'shipped' ? 'selected' : '' }}>Vận chuyển (Shipped)</option>
                    <option value="delivered" {{ request()->status == 'delivered' ? 'selected' : '' }}>Giao hàng (Delivered)</option>
                    <option value="paid" {{ request()->status == 'paid' ? 'selected' : '' }}>Thanh toán (Paid)</option>
                    <option value="completed" {{ request()->status == 'completed' ? 'selected' : '' }}>Hoàn tất (Completed)</option>
                    <option value="cancelled" {{ request()->status == 'cancelled' ? 'selected' : '' }}>Đã hủy (Cancelled)</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <label for="start_date" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Từ ngày</label>
                    <input type="date" name="start_date" id="start_date" value="{{ request()->start_date }}" class="w-full px-3 py-1.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" />
                </div>
                <div>
                    <label for="end_date" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Đến ngày</label>
                    <input type="date" name="end_date" id="end_date" value="{{ request()->end_date }}" class="w-full px-3 py-1.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" />
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-750 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-colors bg-indigo-650 shadow-sm shadow-indigo-100">Tìm kiếm</button>
                <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-semibold transition-colors">Đặt lại</a>
            </div>
        </form>
    </div>

    <!-- Bảng Danh Sách Đơn Hàng -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden backdrop-blur-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/50">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-24 text-center">Mã ĐH</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Khách hàng</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Thông tin liên hệ</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Tổng tiền</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Thanh toán</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Trạng thái</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ngày đặt</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center w-24">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/40 transition-colors">
                        <td class="py-4 px-6 text-sm font-semibold text-slate-900 text-center">#{{ $order->id }}</td>
                        <td class="py-4 px-6">
                            <div class="font-semibold text-slate-900 text-sm">{{ $order->customer_name }}</div>
                            @if($order->user)
                            <div class="text-slate-400 text-xs mt-0.5">Tài khoản: {{ $order->user->name }}</div>
                            @else
                            <div class="text-slate-400 text-xs mt-0.5">Khách vãng lai</div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-slate-600 text-sm font-medium">{{ $order->customer_phone }}</div>
                            <div class="text-slate-400 text-xs mt-0.5 truncate max-w-xs" title="{{ $order->customer_address }}">{{ $order->customer_address }}</div>
                        </td>
                        <td class="py-4 px-6 text-right font-semibold text-indigo-600 text-sm">
                            {{ number_format($order->total_price) }}đ
                        </td>
                        <td class="py-4 px-6 text-center text-xs font-semibold text-slate-500 uppercase">
                            {{ $order->payment_method === 'cod' ? 'COD' : 'VNPAY/Chuyển khoản' }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($order->status === 'pending')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">Tạo đơn hàng</span>
                            @elseif($order->status === 'processing')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">Đóng gói</span>
                            @elseif($order->status === 'shipped')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">Vận chuyển</span>
                            @elseif($order->status === 'delivered')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100">Giao hàng</span>
                            @elseif($order->status === 'paid')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-100">Thanh toán</span>
                            @elseif($order->status === 'completed')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Hoàn tất</span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">Đã hủy</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-500 font-medium">
                            {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="p-2 text-slate-500 hover:text-indigo-600 rounded-lg hover:bg-slate-100 transition-colors inline-block" title="Xem chi tiết">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 px-6 text-center text-slate-400 text-sm">Không tìm thấy đơn hàng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>

@endsection
