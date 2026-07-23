@extends('client.layout.main')

@section('content')
<div class="bg-[#F4F8FA] min-h-screen py-6 rounded-[5px]">
    {{-- Breadcrumb --}}
    <div class="max-w-[1440px] mx-auto px-4 mb-4">
        <x-breadcrumb :items="[
            ['label' => 'Tổng quan tài khoản', 'url' => route('profile')],
            ['label' => 'Quản lý đơn hàng']
        ]" />
    </div>

    {{-- Main Container --}}
    <div class="max-w-[1440px] mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            @include('client.profile.sidebar', ['active' => 'orders'])

            <main class="w-full lg:w-[73%] flex flex-col gap-6">

                <div class="bg-white rounded-[10px] shadow-sm p-6">
                    <h2 class="text-[22px] font-bold text-gray-800 mb-6">Quản lý đơn hàng</h2>

                    {{-- Backend Filter Form --}}
                    <form method="GET" action="{{ route('profile.orders') }}" id="filter-form" class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <div class="flex flex-wrap items-center gap-4">
                            {{-- Date Range Picker --}}
                            <div class="flex items-center gap-3 text-sm text-gray-600" x-data="{ openDatePicker: false }" @click.away="openDatePicker = false">
                                <span class="font-semibold text-gray-500">Chọn thời gian</span>
                                <div class="relative">
                                    <button type="button" @click="openDatePicker = !openDatePicker"
                                        class="bg-[#EBF3FF] text-[#0165FC] font-bold py-2.5 px-4 rounded-lg text-sm flex items-center gap-3 focus:outline-none cursor-pointer transition-colors hover:bg-[#D4E6FF] select-none">
                                        <span>
                                            @if(request('start_date') && request('end_date'))
                                                Từ {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }} đến {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
                                            @elseif(request('start_date'))
                                                Từ {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }}
                                            @elseif(request('end_date'))
                                                Đến {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}
                                            @else
                                                Chọn thời gian
                                            @endif
                                        </span>
                                        <svg class="w-4 h-4 text-[#0165FC] shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="openDatePicker" x-transition.opacity
                                        class="absolute left-0 mt-2 bg-white border border-gray-100 rounded-xl shadow-xl p-4 z-50 flex flex-col gap-3 min-w-[280px]">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-xs text-gray-400 font-bold uppercase text-left">Từ ngày</span>
                                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                                class="w-full bg-[#F5F5F5] border border-transparent focus:border-[#0165FC] rounded-lg p-2 text-sm text-gray-800 font-semibold focus:outline-none">
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <span class="text-xs text-gray-400 font-bold uppercase text-left">Đến ngày</span>
                                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                                class="w-full bg-[#F5F5F5] border border-transparent focus:border-[#0165FC] rounded-lg p-2 text-sm text-gray-800 font-semibold focus:outline-none">
                                        </div>
                                        <div class="flex justify-end gap-2 mt-1">
                                            <a href="{{ route('profile.orders') }}"
                                                class="px-3 py-1.5 text-xs text-red-500 hover:bg-red-50 font-bold rounded-lg transition-colors cursor-pointer text-center">
                                                Xóa lọc
                                            </a>
                                            <button type="submit"
                                                class="px-3 py-1.5 text-xs bg-[#0165FC] text-white font-bold rounded-lg hover:bg-blue-700 transition-colors cursor-pointer">
                                                Lọc
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Status Filter --}}
                            <div class="relative">
                                <select name="status" onchange="this.form.submit()"
                                    class="appearance-none bg-[#EBF3FF] text-[#0165FC] font-semibold py-2.5 pl-4 pr-10 rounded-lg text-sm focus:outline-none cursor-pointer">
                                    <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>Trạng thái</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Đang chờ xử lý</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đã tiếp nhận</option>
                                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đang vận chuyển</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã hoàn thành</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-[#0165FC]">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Search Input --}}
                        <div class="relative w-full md:w-72">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="w-full bg-[#F5F5F5] text-gray-700 py-2.5 pl-4 pr-10 rounded-lg text-sm border-none focus:outline-none focus:ring-1 focus:ring-[#0165FC]"
                                placeholder="Nhập tên sản phẩm hoặc mã đơn...">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#0165FC]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    {{-- Table Area --}}
                    <table class="w-full text-sm border border-[#E9E9E9]">
                        <thead>
                            <tr class="bg-8 border-b border-[#E9E9E9]">
                                <th class="text-center px-4 py-3 font-semibold text-[#0165FC] rounded-l-lg border-r border-[#E9E9E9]">Mã đơn hàng</th>
                                <th class="text-center px-4 py-3 font-semibold text-[#0165FC] border-r border-[#E9E9E9]">Giá trị đơn hàng</th>
                                <th class="text-center px-4 py-3 font-semibold text-[#0165FC] border-r border-[#E9E9E9]">Ngày tạo đơn</th>
                                <th class="text-center px-4 py-3 font-semibold text-[#0165FC] border-r border-[#E9E9E9]">Trạng thái</th>
                                <th class="text-center px-4 py-3 font-semibold text-[#0165FC] rounded-r-lg">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E9E9E9]">
                            @forelse($orders as $order)
                                @php
                                    $thumbnail = $order->items->first()?->product?->thumbnail_url;
                                    $orderCode = 'HL' . str_pad($order->id, 8, '0', STR_PAD_LEFT);
                                    $itemsCount = $order->items->count();
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors border-b border-[#E9E9E9] last:border-b-0">
                                    {{-- Column 1: Code and Thumbnail --}}
                                    <td class="px-4 py-4 border-r border-[#E9E9E9]">
                                        <div class="flex items-center gap-3">
                                            {{-- Thumbnail --}}
                                            <div class="w-22 h-22 rounded-lg overflow-hidden bg-gray-100 shrink-0 border border-gray-200">
                                                @if($thumbnail)
                                                    <img src="{{ $thumbnail }}"
                                                        onerror="this.src='https://placehold.co/48x48/EBF3FF/0165FC?text=SP'"
                                                        alt="SP" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            {{-- Info --}}
                                            <div class="flex flex-col gap-0.5">
                                                <span class="font-bold text-base text-2">{{ $orderCode }}</span>
                                                <span class="text-sm text-7">{{ $itemsCount }} sản phẩm</span>
                                                <a href="{{ route('profile.orders.show', $order->id) }}" class="text-sm rounded-[5px] text-[#0165FC] underline underline-offset-2 hover:text-blue-700 p-2.5 bg-[#DDECFF]">Xem chi tiết</a>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Column 2: Total Price --}}
                                    <td class="px-4 py-4 text-2 text-sm text-center whitespace-nowrap border-r border-[#E9E9E9]">
                                        {{ number_format($order->total_price, 0, ',', '.') }} đ
                                    </td>

                                    {{-- Column 3: Created At --}}
                                    <td class="px-4 py-4 text-2 text-sm text-center whitespace-nowrap border-r border-[#E9E9E9]">
                                        {{ $order->created_at?->format('d/m/Y') }}
                                    </td>

                                    {{-- Column 4: Status --}}
                                    <td class="px-4 py-4 text-center border-r border-[#E9E9E9]">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'text-[#FF3B30]',
                                                'processing' => 'text-[#0165FC]',
                                                'shipped' => 'text-[#00B074]',
                                                'delivered' => 'text-[#8E8E8E]',
                                                'cancelled' => 'text-[#8E8E8E]',
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Đang chờ xử lý',
                                                'processing' => 'Đã tiếp nhận',
                                                'shipped' => 'Đang vận chuyển',
                                                'delivered' => 'Đã hoàn thành',
                                                'cancelled' => 'Đã hủy',
                                            ];
                                        @endphp
                                        <span class="inline-block px-3 py-1 text-sm {{ $statusClasses[$order->status] ?? 'text-gray-800' }}">
                                            {{ $statusLabels[$order->status] ?? $order->status }}
                                        </span>
                                    </td>

                                    {{-- Column 5: Action Button --}}
                                    <td class="px-4 py-4 text-center">
                                        @if($order->status === 'pending')
                                            <form action="{{ route('profile.orders.cancel', $order->id) }}" method="POST" class="m-0"
                                                onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này không?')">
                                                @csrf
                                                <button type="submit"
                                                    class="px-4 py-2 bg-[#D9534F] hover:bg-red-600 text-white text-sm rounded-lg transition-colors cursor-pointer whitespace-nowrap">
                                                    Hủy đơn hàng
                                                </button>
                                            </form>
                                        @elseif($order->status === 'processing')
                                            <button type="button" disabled
                                                class="w-full bg-[#D9534F] text-white py-2.5 px-4 rounded-lg text-sm cursor-not-allowed whitespace-nowrap">
                                                Hủy đơn hàng
                                            </button>
                                        @elseif($order->status === 'shipped')
                                            <a href="#"
                                                class="inline-block w-full bg-[#00D294] hover:bg-emerald-600 text-white font-bold py-2.5 px-4 rounded-lg text-sm text-center transition-colors cursor-pointer whitespace-nowrap">
                                                Tracking order
                                            </a>
                                        @elseif($order->status === 'delivered')
                                            <a href="#"
                                                class="inline-block w-full bg-[#0165FC] hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg text-sm text-center transition-colors cursor-pointer whitespace-nowrap">
                                                Đặt lại đơn hàng
                                            </a>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                                            </svg>
                                            <p class="text-base font-semibold text-gray-500">Không tìm thấy đơn hàng nào</p>
                                            <p class="text-sm text-gray-400 mt-1">Vui lòng thử lại với các bộ lọc khác.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Area --}}
                @if($orders->hasPages())
                <div class="flex items-center justify-between mt-4 rounded-[10px] select-none">
                    <div class="flex items-center gap-2.5">
                        @if($orders->onFirstPage())
                            <span class="w-[40px] h-[40px] bg-gray-100 text-gray-400 flex items-center justify-center rounded-[10px] opacity-50 cursor-not-allowed">
                                <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.5 7.5H1.5M1.5 7.5L7.5 1.5M1.5 7.5L7.5 13.5" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}"
                                class="w-[40px] h-[40px] bg-9 hover:bg-[#d6e5ff] text-[#006DF0] flex items-center justify-center rounded-[10px] transition-colors cursor-pointer">
                                <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.5 7.5H1.5M1.5 7.5L7.5 1.5M1.5 7.5L7.5 13.5" stroke="#1F4388" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        @endif

                        @if($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}"
                                class="h-[40px] bg-[#006DF0] hover:bg-[#005ecf] text-white flex items-center gap-2.5 p-3 rounded-[5px] text-sm cursor-pointer transition-colors select-none">
                                <span>Xem tiếp</span>
                                <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.5 7.5H16.5M16.5 7.5L10.5 1.5M16.5 7.5L10.5 13.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        @else
                            <span class="h-[40px] bg-gray-200 text-gray-400 flex items-center gap-2.5 p-3 rounded-[5px] text-sm opacity-50 cursor-not-allowed select-none">
                                <span>Xem tiếp</span>
                                <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.5 7.5H16.5M16.5 7.5L10.5 1.5M16.5 7.5L10.5 13.5" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 text-sm text-4">
                        <span>Trang</span>
                        <div class="w-[40px] h-[40px] border border-4 flex items-center justify-center rounded-[5px] bg-white">
                            <span class="font-bold text-gray-700">{{ $orders->currentPage() }}</span>
                        </div>
                        <span>của <span class="font-bold">{{ $orders->lastPage() }}</span></span>
                    </div>
                </div>
                @endif
            </main>

        </div>
    </div>
</div>
@endsection