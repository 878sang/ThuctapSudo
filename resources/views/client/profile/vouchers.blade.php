@extends('client.layout.main')

@section('content')
<div class="bg-[#F4F8FA] min-h-screen py-6 rounded-[5px]">

    <div class="max-w-[1440px] mx-auto px-4 mb-4">
        <x-breadcrumb :items="[
            ['label' => 'Tổng quan tài khoản', 'url' => route('profile')],
            ['label' => 'Mã giảm giá']
        ]" />
    </div>


    <div class="max-w-[1440px] mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            @include('client.profile.sidebar', ['active' => 'vouchers'])

            <main class="w-full lg:w-[73%] flex flex-col gap-6">
                <div class="bg-white rounded-[10px] shadow-sm p-6">
                    <h2 class="text-[22px] font-bold text-[#202F36] mb-5">Mã giảm giá</h2>


                    <div class="vouchers-list-container blue-scrollbar max-h-[480px] overflow-y-auto pr-4 border-t border-[#F0F2F5]">
                        @forelse ($validCoupons as $coupon)
                        <div class="flex items-center justify-between gap-4 py-4.5 border-b border-[#F0F2F5] last:border-b-0">
                            <div class="flex items-center gap-4 min-w-0">

                                <div class="w-12 h-12 rounded-full bg-[#FFF0EB] border border-[#FFE4DC] flex items-center justify-center shrink-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21 8.5V7C21 5.89543 20.1046 5 19 5H5C3.89543 5 3 5.89543 3 7V8.5C4.10457 8.5 5 9.39543 5 10.5C5 11.6046 4.10457 12.5 3 12.5V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V15.5C19.8954 15.5 19 14.6046 19 13.5C19 12.3954 19.8954 11.5 21 11.5V8.5Z" stroke="#FF5E3A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 9V15" stroke="#FF5E3A" stroke-dasharray="2 2" stroke-linecap="round" stroke-width="1.5" />
                                    </svg>
                                </div>


                                <div class="flex flex-col min-w-0">
                                    <p class="text-sm font-semibold text-[#202F36] leading-relaxed truncate">
                                        {{ $coupon->name }}
                                        <span class="font-bold text-[#0165FC] font-sans">&ldquo;{{ $coupon->code }}&rdquo;</span>
                                    </p>
                                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 mt-1">
                                        <span class="font-medium text-[#FF9500]">
                                            Giảm: {{ $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value, 0, ',', '.') . ' đ' }}
                                        </span>
                                        @if($coupon->min_order_amount > 0)
                                        <span>•</span>
                                        <span>Đơn tối thiểu: {{ number_format($coupon->min_order_amount, 0, ',', '.') }} đ</span>
                                        @endif
                                        @if($coupon->end_date)
                                        <span>•</span>
                                        <span>HSD: {{ $coupon->end_date->format('d/m/Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                            <svg class="w-12 h-12 opacity-40 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <p class="text-sm">Hiện chưa có mã giảm giá nào phù hợp với tài khoản của bạn</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination Section -->
                    <x-pagination-client :items="$validCoupons" />

                </div>
            </main>
        </div>
    </div>
</div>
@endsection