@extends('admin.Layout.main')
@section('title', 'Chi Tiết Người Dùng: ' . $user->name)
@section('content')

<div class="max-w-7xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Người dùng', 'url' => route('admin.users.index')],
        ['label' => 'Chi tiết: ' . $user->name]
    ]" />

    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.users.index') }}" class="p-2 hover:bg-slate-100 rounded-xl transition-colors text-slate-500 hover:text-slate-700">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">Hồ Sơ Người Dùng</h1>
            <p class="text-slate-500 text-sm mt-1">Thông tin chi tiết và lịch sử hoạt động của tài khoản</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Cột trái: Thông tin cá nhân -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 text-center">
                <!-- Avatar -->
                <div class="mb-4 flex justify-center">
                    @if($user->avatar)
                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover border-2 border-slate-100 shadow-md">
                    @else
                    <div class="w-24 h-24 rounded-full bg-indigo-50 text-indigo-600 font-bold flex items-center justify-center border border-indigo-100 shadow-sm text-3xl uppercase">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    @endif
                </div>

                <h2 class="text-lg font-bold text-slate-900">{{ $user->name }}</h2>
                @if($user->display_name)
                <p class="text-slate-400 text-xs mt-0.5">{{ $user->display_name }}</p>
                @endif

                <div class="mt-4 flex flex-wrap gap-2 justify-center">
                    <!-- Badge vai trò -->
                    @if($user->isSuperAdmin())
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">Super Admin</span>
                    @elseif($user->isStaff())
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">Nhân viên</span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Khách hàng</span>
                    @endif

                    <!-- Badge trạng thái -->
                    @if($user->deleted_at)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">Vô hiệu hóa</span>
                    @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-100">Đang hoạt động</span>
                    @endif
                </div>

                <div class="border-t border-slate-100 my-6"></div>

                <div class="space-y-4 text-left text-sm">
                    <div>
                        <span class="block text-slate-400 text-xs uppercase tracking-wider mb-1">Email đăng nhập</span>
                        <span class="font-semibold text-slate-800 break-all">{{ $user->email }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-xs uppercase tracking-wider mb-1">Số điện thoại</span>
                        <span class="font-semibold text-slate-800">{{ $user->phone ?? 'Chưa cập nhật' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-xs uppercase tracking-wider mb-1">Ngày sinh</span>
                        <span class="font-semibold text-slate-800">{{ $user->dob ? $user->dob->format('d/m/Y') : 'Chưa cập nhật' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-xs uppercase tracking-wider mb-1">Giới tính</span>
                        <span class="font-semibold text-slate-800 capitalize">{{ $user->gender ?? 'Chưa cập nhật' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-xs uppercase tracking-wider mb-1">Ngày tham gia</span>
                        <span class="font-semibold text-slate-800">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'Chưa cập nhật' }}</span>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="flex-1 text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-600 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                        Sửa hồ sơ
                    </a>
                </div>
            </div>
        </div>

        <!-- Cột phải: Lịch sử mua hàng -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden p-6">
                <h2 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Đơn hàng đã đặt ({{ $user->orders->count() }})
                </h2>

                <div class="overflow-x-auto -mx-6">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-200/50">
                                <th class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Mã đơn hàng</th>
                                <th class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ngày mua</th>
                                <th class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Tổng tiền</th>
                                <th class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Trạng thái</th>
                                <th class="py-3 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($user->orders as $order)
                            <tr class="hover:bg-slate-50/30 transition-colors text-sm">
                                <td class="py-4 px-6 text-center font-bold text-indigo-600">
                                    #{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="py-4 px-6 text-slate-600">
                                    {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </td>
                                <td class="py-4 px-6 text-right font-semibold text-slate-900">
                                    {{ number_format($order->total_price) }}đ
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if($order->status === 'pending')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">Chờ xử lý</span>
                                    @elseif($order->status === 'processing')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">Đóng gói</span>
                                    @elseif($order->status === 'shipped')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">Vận chuyển</span>
                                    @elseif($order->status === 'delivered')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">Giao hàng</span>
                                    @elseif($order->status === 'paid')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-pink-50 text-pink-700 border border-pink-100">Thanh toán</span>
                                    @elseif($order->status === 'completed')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Hoàn tất</span>
                                    @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-100">Đã hủy</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-xs text-indigo-600 hover:text-indigo-900 font-semibold flex items-center justify-center gap-1">
                                        Chi tiết <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 px-6 text-center text-slate-400 text-sm italic">Khách hàng chưa đặt mua đơn hàng nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
