@extends('client.layout.main')

@section('content')
<div class="bg-[#F4F8FA] min-h-screen py-6 rounded-[5px]">
    {{-- Breadcrumb --}}
    <div class="max-w-[1440px] mx-auto px-4 mb-4">
        <x-breadcrumb :items="[
            ['label' => 'Tổng quan tài khoản']
        ]" />
    </div>

    {{-- Main Container --}}
    <div class="max-w-[1440px] mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            {{-- Left Sidebar --}}
            @include('client.profile.sidebar', ['active' => 'overview'])

            {{-- Right Content --}}
            <main class="w-full lg:w-[73%] flex flex-col gap-6">

                {{-- Stat Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white rounded-[10px] shadow-sm p-5 flex items-center gap-4">
                        <img src="{{ asset('storage/images/Group 34228.png') }}" alt="">
                        <div class="flex flex-col min-w-0">
                            <span class="text-sm text-2 font-bold leading-snug">Tổng giá trị hàng đã mua</span>
                            <span class="text-2xl font-bold text-6 truncate">
                                {{ number_format($totalRevenue, 0, ',', '.') }}đ
                            </span>
                            <span class="text-sm text-4 mt-0.5">
                                Tháng này:
                                <span class="text-[#EB7507]">
                                    {{ number_format($monthRevenue, 0, ',', '.') }}đ
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="bg-white rounded-[10px] shadow-sm p-5 flex items-center gap-4">
                        <img src="{{ asset('storage/images/2 28.png') }}" alt="">
                        <div class="flex flex-col min-w-0">
                            <span class="text-sm text-2 font-bold leading-snug">Đơn hàng thành công</span>
                            <span class="text-2xl font-bold text-6 truncate">
                                {{ $totalDelivered }}
                                <span class="text-sm font-normal text-gray-400">đơn hàng</span>
                            </span>
                            <span class="text-sm text-4 mt-0.5">
                                Tháng này:
                                <span class="text-[#EB7507]">
                                    {{ $monthDelivered }} đơn hàng
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="bg-white rounded-[10px] shadow-sm p-5 flex items-center gap-4">
                        <img src="{{ asset('storage/images/3 11991995.png') }}" alt="">
                        <div class="flex flex-col min-w-0">
                            <span class="text-sm text-2 font-bold leading-snug">Tổng báo giá đã gửi</span>
                            <span class="text-2xl font-bold text-6 truncate">
                                {{ $totalOrders }}
                                <span class="text-sm font-normal text-gray-400">đơn hàng</span>
                            </span>
                            <span class="text-sm text-4 mt-0.5">
                                Tháng này:
                                <span class="text-[#EB7507]">
                                    {{ $monthOrders }} đơn hàng
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-[10px] shadow-sm p-6"
                    x-data="{
                        allOrders: {{ json_encode($ordersData) }},
                        activeTab: 'pending', // 'pending' hoặc 'all'
                        currentPage: 1,
                        perPage: 10,
                        
                        get filteredOrders() {
                            if (this.activeTab === 'pending') {
                                return this.allOrders.filter(o => o.status === 'pending');
                            }
                            return this.allOrders.filter(o => o.status==='delivered');
                        },
                        
                        get paginatedOrders() {
                            let start = (this.currentPage - 1) * this.perPage;
                            let end = start + this.perPage;
                            return this.filteredOrders.slice(start, end);
                        },
                        
                        get totalPages() {
                            return Math.ceil(this.filteredOrders.length / this.perPage) || 1;
                        },
                        
                        changeTab(tab) {
                            this.activeTab = tab;
                            this.currentPage = 1;
                        },
                        
                        nextPage() {
                            if (this.currentPage < this.totalPages) {
                                this.currentPage++;
                            }
                        },
                        
                        prevPage() {
                            if (this.currentPage > 1) {
                                this.currentPage--;
                            }
                        },
                        
                        formatPrice(value) {
                            return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
                        },

                        getStatusBadgeClass(status) {
                            const map = {
                                'pending': 'text-[#F30000]',
                                'processing': 'text-[#2D7BE0]',
                                'shipping': 'text-[#3AC5FF]',
                                'delivered': 'text-[#22965D]',
                                'cancelled': 'text-red-500'
                            };
                            return map[status] || 'text-gray-600 bg-gray-100';
                        },

                        getStatusLabel(status) {
                            const map = {
                                'pending': 'Đang chờ xử lý',
                                'processing': 'Đang xử lý',
                                'shipping': 'Đang giao hàng',
                                'delivered': 'Đã giao hàng',
                                'cancelled': 'Đã hủy'
                            };
                            return map[status] || status;
                        }
                     }">
                    <h2 class="text-[20px] font-bold text-gray-800 mb-4">Tổng quan giao dịch của bạn</h2>

                    {{-- Tabs --}}
                    <div class="flex gap-2 mb-5">
                        <button type="button" @click="changeTab('pending')"
                            class="px-4 py-2 rounded-lg text-sm transition-colors cursor-pointer"
                            :class="activeTab === 'pending' ? 'bg-[#3C82EA] text-white' : 'bg-[#F5F5F5] text-gray-600 hover:bg-gray-200'">
                            Đơn hàng đang chờ xử lý
                        </button>
                        <button type="button" @click="changeTab('all')"
                            class="px-4 py-2 rounded-lg text-sm transition-colors cursor-pointer"
                            :class="activeTab === 'all' ? 'bg-[#3C82EA] text-white' : 'bg-[#F5F5F5] text-gray-600 hover:bg-[#DDECFF]'">
                            Sản phẩm đã mua
                        </button>
                    </div>

                    <div x-show="filteredOrders.length > 0" class="overflow-x-auto">
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
                                <template x-for="order in paginatedOrders" :key="order.id">
                                    <tr class="hover:bg-gray-50 transition-colors border-b border-[#E9E9E9] last:border-b-0">
                                        <td class="px-4 py-4 border-r border-[#E9E9E9]">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 shrink-0 border border-gray-200">
                                                    <template x-if="order.thumbnail">
                                                        <img :src="order.thumbnail"
                                                            onerror="this.src='https://placehold.co/48x48/EBF3FF/0165FC?text=SP'"
                                                            alt="SP" class="w-full h-full object-cover">
                                                    </template>
                                                    <template x-if="!order.thumbnail">
                                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                                                            </svg>
                                                        </div>
                                                    </template>
                                                </div>
                                                <div class="flex flex-col gap-0.5">
                                                    <span class="font-bold text-base text-2" x-text="order.code"></span>
                                                    <span class="text-sm text-7" x-text="order.items_count + ' sản phẩm'"></span>
                                                    <a href="#" class="text-sm rounded-[5px] text-[#0165FC] underline underline-offset-2 hover:text-blue-700 p-2.5 bg-[#DDECFF]">Xem chi tiết</a>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-4 py-4 text-2 text-sm text-center whitespace-nowrap border-r border-[#E9E9E9]" x-text="formatPrice(order.total_price)">
                                        </td>
                                        <td class="px-4 py-4 text-2 text-sm text-center whitespace-nowrap border-r border-[#E9E9E9]" x-text="order.created_at">
                                        </td>

                                        <td class="px-4 py-4 text-center border-r border-[#E9E9E9]">
                                            <span class="inline-block px-3 py-1 text-sm"
                                                :class="getStatusBadgeClass(order.status)"
                                                x-text="getStatusLabel(order.status)">
                                            </span>
                                        </td>

                                        <td class="px-4 py-4">
                                            <template x-if="order.status === 'pending'">
                                                <form :action="order.cancel_url" method="POST"
                                                    onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này không?')">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-[#D9534F] hover:bg-red-600 text-white text-xs rounded-lg transition-colors cursor-pointer whitespace-nowrap">
                                                        Hủy đơn hàng
                                                    </button>
                                                </form>
                                            </template>
                                            <template x-if="order.status !== 'pending'">
                                                <span class="text-xs text-gray-300 select-none">—</span>
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div x-show="filteredOrders.length > 0 && totalPages > 1" class="flex items-center justify-between mt-6 pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            {{-- Prev --}}
                            <button type="button" @click="prevPage()" :disabled="currentPage === 1"
                                class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-[#EBF3FF] hover:border-[#0165FC] hover:text-[#0165FC] transition-colors disabled:opacity-50 disabled:pointer-events-none cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>

                            {{-- Next --}}
                            <button type="button" @click="nextPage()" :disabled="currentPage === totalPages"
                                class="flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#0165FC] text-white text-sm font-semibold hover:bg-blue-700 transition-colors disabled:bg-gray-200 disabled:text-gray-400 disabled:cursor-not-allowed cursor-pointer">
                                Xem tiếp
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                        <span class="text-sm text-gray-400">
                            Trang <span class="font-semibold text-gray-700" x-text="currentPage"></span>
                            của <span class="font-semibold text-gray-700" x-text="totalPages"></span>
                        </span>
                    </div>

                    {{-- Empty state --}}
                    <div x-show="filteredOrders.length === 0" class="flex flex-col items-center justify-center py-16 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mb-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                        </svg>
                        <p class="text-base font-medium text-gray-500">Chưa có đơn hàng nào</p>
                        <p class="text-sm mt-1 text-gray-400">Hãy bắt đầu mua sắm ngay hôm nay!</p>
                        <a href="{{ route('products.showClient') }}"
                            class="mt-4 px-5 py-2.5 bg-[#0165FC] text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                            Khám phá sản phẩm
                        </a>
                    </div>
                </div>

            </main>
        </div>
    </div>
</div>
@endsection