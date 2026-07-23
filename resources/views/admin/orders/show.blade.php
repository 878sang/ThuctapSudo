@extends('admin.Layout.main')
@section('title', 'Chi Tiết Đơn Hàng #' . $order->id)
@section('content')

<div class="max-w-5xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Đơn hàng', 'url' => route('admin.orders.index')],
        ['label' => 'Chi tiết #' . $order->id]
    ]" />
    <div class="max-w-[1440px] mx-auto px-4">

        {{-- Status Stepper --}}
        @php
        $stepIndex = $order->step_index ?? 1;
        $steps = \App\Models\Order::getStepsList();
        @endphp

        <div class="bg-white rounded-[10px] p-6 mb-6">
            <div class="relative flex items-center justify-between max-w-5xl mx-auto px-2 sm:px-6">
                @foreach($steps as $idx => $stepLabel)
                @php
                $isActive = $stepIndex >= $idx && $stepIndex > 0;
                $isCompletedLine = $stepIndex > $idx && $stepIndex > 0;
                @endphp
                <div class="flex flex-col items-center relative z-10 flex-1">
                    <!-- Circle Icon -->
                    <div class="w-9 h-9 sm:w-10 sm:h-10 transition-all shrink-0">
                        <svg class="w-full h-full" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="24.9961" cy="24.9961" r="24.9961" fill="{{ $isActive ? '#0165FC' : '#E1E1E1' }}" />
                            <path d="M15.6348 24.0797L22.4876 30.9331L34.3615 19.0591" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <!-- Label -->
                    <span class="mt-2.5 text-[11px] sm:text-xs font-semibold text-center {{ $isActive ? 'text-2' : 'text-[#959595]' }}">
                        {{ $stepLabel }}
                    </span>

                    <!-- Connecting Line (for all except last) -->
                    @if($idx < count($steps))
                        <div class="absolute top-4 sm:top-5 left-[50%] w-full h-[2px] -z-10 {{ $isCompletedLine ? 'bg-[#0165FC]' : 'bg-[#E5E7EB]' }}">
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.orders.index') }}" class="p-2 hover:bg-slate-100 rounded-xl transition-colors text-slate-500 hover:text-slate-700">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">Chi Tiết Đơn Hàng #{{ $order->id }}</h1>
                @if($order->status === 'pending')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">Tạo đơn hàng</span>
                @elseif($order->status === 'processing')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-100">Đóng gói</span>
                @elseif($order->status === 'shipped')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">Vận chuyển</span>
                @elseif($order->status === 'delivered')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100">Giao hàng</span>
                @elseif($order->status === 'paid')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-pink-50 text-pink-700 border border-pink-100">Thanh toán</span>
                @elseif($order->status === 'completed')
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Hoàn tất</span>
                @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">Đã hủy</span>
                @endif
            </div>
            <p class="text-slate-500 text-sm mt-1">Đặt lúc: {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Thông tin sản phẩm & thanh toán -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Danh sách sản phẩm -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden p-6">
                <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Sản phẩm đã mua
                </h2>
                <div class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                    <div class="py-4 flex items-center gap-4 first:pt-0 last:pb-0">
                        <div class="w-16 h-16 rounded-xl border border-slate-200 bg-slate-50 flex-shrink-0 overflow-hidden flex items-center justify-center">
                            @if($item->product && $item->product->thumbnail_url)
                            <img src="{{ $item->product->thumbnail_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            @else
                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-slate-800 text-sm truncate" title="{{ $item->product ? $item->product->name : 'Sản phẩm đã xóa' }}">
                                {{ $item->product ? $item->product->name : 'Sản phẩm đã xóa' }}
                            </h3>
                            <p class="text-slate-500 text-xs mt-1">Số lượng: <span class="font-semibold text-slate-700">{{ $item->quantity }}</span></p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <div class="font-semibold text-slate-900 text-sm">{{ number_format($item->price) }}đ</div>
                            <div class="text-slate-400 text-xs mt-0.5">Tổng: {{ number_format($item->price * $item->quantity) }}đ</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Hóa đơn VAT (Nếu có) -->
            @if($order->is_vat)
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
                <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Thông tin xuất hóa đơn VAT
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="block text-slate-400 text-xs uppercase tracking-wider mb-1">Tên công ty</span>
                        <span class="font-semibold text-slate-800">{{ $order->company_name }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-xs uppercase tracking-wider mb-1">Mã số thuế</span>
                        <span class="font-semibold text-slate-800">{{ $order->tax_code }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-xs uppercase tracking-wider mb-1">Email nhận hóa đơn</span>
                        <span class="font-semibold text-slate-800">{{ $order->company_email }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-xs uppercase tracking-wider mb-1">Địa chỉ công ty</span>
                        <span class="font-semibold text-slate-800">{{ $order->company_address }}</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Thanh toán -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-3">
                <h2 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Chi tiết thanh toán</h2>
                <div class="flex justify-between text-sm text-slate-600">
                    <span>Tạm tính</span>
                    <span class="font-semibold text-slate-800">{{ number_format($order->total_price + $order->discount_amount) }}đ</span>
                </div>
                @if($order->discount_amount > 0)
                <div class="flex justify-between text-sm text-rose-600">
                    <span>Giảm giá (Coupon: {{ $order->coupon_code }})</span>
                    <span class="font-semibold">-{{ number_format($order->discount_amount) }}đ</span>
                </div>
                @endif
                <div class="flex justify-between text-sm text-slate-600">
                    <span>Phí vận chuyển</span>
                    <span class="font-semibold text-slate-800">Miễn phí</span>
                </div>
                <hr class="border-slate-100 my-2">
                <div class="flex justify-between text-base font-bold text-slate-900">
                    <span>Tổng cộng</span>
                    <span class="text-lg text-indigo-600">{{ number_format($order->total_price) }}đ</span>
                </div>
                <div class="flex justify-between text-xs text-slate-400 mt-2">
                    <span>Phương thức thanh toán</span>
                    <span class="font-semibold uppercase">{{ $order->payment_method === 'cod' ? 'COD (Thanh toán khi nhận hàng)' : 'Chuyển khoản / VNPAY' }}</span>
                </div>
            </div>
        </div>

        <!-- Khách hàng & Cập nhật trạng thái -->
        <div class="space-y-6">
            <!-- Thông tin khách hàng -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
                <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Thông tin giao hàng
                </h2>
                <div class="space-y-4 text-sm">
                    <div>
                        <span class="block text-slate-400 text-xs uppercase tracking-wider mb-1">Người nhận</span>
                        <span class="font-semibold text-slate-800">{{ $order->customer_name }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-xs uppercase tracking-wider mb-1">Số điện thoại</span>
                        <span class="font-semibold text-slate-800">{{ $order->customer_phone }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-xs uppercase tracking-wider mb-1">Địa chỉ nhận hàng</span>
                        <span class="font-semibold text-slate-800 leading-relaxed">{{ $order->customer_address }}</span>
                    </div>
                </div>
            </div>

            <!-- Cập nhật trạng thái đơn hàng -->
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
                <h2 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-3">Xử lý đơn hàng</h2>
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="status" class="block text-slate-400 text-xs uppercase tracking-wider mb-2">Trạng thái đơn hàng</label>
                        <select name="status" id="status" class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>1. Tạo đơn hàng</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>2. Đóng gói</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>3. Vận chuyển</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>4. Giao hàng</option>
                            <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>5. Thanh toán</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>6. Hoàn tất</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Đã hủy đơn hàng</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-750 text-white py-2.5 rounded-xl text-sm font-semibold transition-colors bg-indigo-650 shadow-sm shadow-indigo-100">
                        Cập nhật trạng thái
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection