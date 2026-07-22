@extends('client.layout.main')

@section('content')
<div class="bg-[#F4F8FA] min-h-screen py-6 rounded-[5px]">
    <!-- Breadcrumb -->
    <div class="max-w-[1440px] mx-auto px-4 mb-4">
        <x-breadcrumb :items="[
            ['label' => 'Tổng quan tài khoản', 'url' => route('profile')],
            ['label' => 'Mã giảm giá']
        ]" />
    </div>

    <!-- Main Container -->
    <div class="max-w-[1440px] mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            <!-- Left Sidebar -->
            @include('client.profile.sidebar', ['active' => 'vouchers'])

            <!-- Right Content -->
            <main class="w-full lg:w-[73%] flex flex-col gap-6">
                <!-- Main Card -->
                <div class="bg-white rounded-[10px] shadow-sm p-6">
                    <h2 class="text-[22px] font-bold text-[#202F36] mb-5">Mã giảm giá</h2>

                    <!-- Filter Tabs -->
                    <div class="flex items-center gap-3 mb-6 bg-white select-none">
                        <a href="{{ route('profile.vouchers', ['tab' => 'all']) }}"
                            class="px-4 py-2 rounded-lg font-bold text-sm transition-colors cursor-pointer select-none no-underline border-none {{ $activeTab === 'all' ? 'bg-[#0165FC] text-white' : 'bg-[#F5F5F5] text-gray-600 hover:bg-gray-100' }}">
                            Tất cả(155)
                        </a>
                        <a href="{{ route('profile.vouchers', ['tab' => 'unread']) }}"
                            class="px-4 py-2 rounded-lg font-bold text-sm transition-colors flex items-center gap-2 cursor-pointer select-none no-underline border-none {{ $activeTab === 'unread' ? 'bg-[#0165FC] text-white' : 'bg-[#F5F5F5] text-gray-600 hover:bg-gray-100' }}">
                            <span>Chưa đọc</span>
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-[#FF9500] text-white text-xs font-bold">1</span>
                        </a>
                    </div>

                    <!-- Vouchers List Box -->
                    <div class="vouchers-list-container blue-scrollbar max-h-[480px] overflow-y-auto pr-4 border-t border-[#F0F2F5]">
                        @forelse ($vouchers as $item)
                            <div class="flex items-center justify-between gap-4 py-4.5 border-b border-[#F0F2F5] last:border-b-0">
                                <div class="flex items-center gap-4 min-w-0">
                                    <!-- Unread Dot Spacer -->
                                    <div class="w-3.5 flex justify-center shrink-0">
                                        @if ($item->is_unread)
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#0165FC] shadow-sm animate-pulse"></span>
                                        @endif
                                    </div>

                                    <!-- Ticket Icon Container -->
                                    <div class="w-12 h-12 rounded-full bg-[#FFF0EB] border border-[#FFE4DC] flex items-center justify-center shrink-0">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21 8.5V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V8.5C4.10457 8.5 5 9.39543 5 10.5C5 11.6046 4.10457 12.5 3 12.5V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V15.5C19.8954 15.5 19 14.6046 19 13.5C19 12.3954 19.8954 11.5 21 11.5V8.5Z" stroke="#FF5E3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12 9V15" stroke="#FF5E3A" stroke-dasharray="2 2" stroke-linecap="round" stroke-width="1.5"/>
                                        </svg>
                                    </div>

                                    <!-- Transaction Text Info -->
                                    <div class="flex flex-col min-w-0">
                                        <p class="text-sm font-semibold text-[#5D6F7A] leading-relaxed truncate">
                                            Bạn nhận được mã giảm giá 15% từ Hoplong Tech mã giảm giá 
                                            <span class="font-bold text-[#0165FC] font-sans">&ldquo;{{ $item->code }}&rdquo;</span>
                                        </p>
                                        <div class="flex items-center gap-1.5 text-xs text-gray-400 mt-0.5">
                                            <span>{{ $item->time }}</span>
                                            <span>•</span>
                                            <span>từ:</span>
                                            <a href="#" class="text-[#0165FC] hover:underline font-bold">{{ $item->from }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                                <svg class="w-12 h-12 opacity-40 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-sm">Không có thông báo chưa đọc nào</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Section -->
                    <x-pagination-client :items="$vouchers" />

                </div>
            </main>
        </div>
    </div>
</div>
@endsection
