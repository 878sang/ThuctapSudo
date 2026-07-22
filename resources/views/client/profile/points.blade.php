@extends('client.layout.main')

@section('content')
<div class="bg-[#F4F8FA] min-h-screen py-6 rounded-[5px]">
    <!-- Breadcrumb -->
    <div class="max-w-[1440px] mx-auto px-4 mb-4">
        <x-breadcrumb :items="[
            ['label' => 'Tổng quan tài khoản', 'url' => route('profile')],
            ['label' => 'Điểm thưởng']
        ]" />
    </div>

    <!-- Main Container -->
    <div class="max-w-[1440px] mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            <!-- Left Sidebar -->
            @include('client.profile.sidebar', ['active' => 'points'])

            <!-- Right Content -->
            <main class="w-full lg:w-[73%] flex flex-col gap-6">
                <!-- Main Card -->
                <div class="bg-white rounded-[10px] shadow-sm p-6">
                    <h2 class="text-[22px] font-bold text-[#202F36] mb-5">Điểm thưởng</h2>

                    <!-- Point Summary Area -->
                    <div class="flex items-center gap-4 mb-6 select-none bg-white">
                        <!-- Premium SVG Gold Coin -->
                        <div class="shrink-0 drop-shadow-md">
                            <svg width="50" height="50" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="24" cy="24" r="22" fill="url(#coinGrad)" stroke="#E5A900" stroke-width="1.5" />
                                <circle cx="24" cy="24" r="17" fill="none" stroke="#F5D061" stroke-width="1" stroke-dasharray="2 2" />
                                <text x="24" y="31" font-family="'Outfit', 'Inter', sans-serif" font-weight="900" font-size="22" fill="#D49000" text-anchor="middle" filter="url(#inset-shadow)">$</text>
                                <text x="24" y="30" font-family="'Outfit', 'Inter', sans-serif" font-weight="900" font-size="22" fill="url(#textGrad)" text-anchor="middle">$</text>
                                <defs>
                                    <linearGradient id="coinGrad" x1="0" y1="0" x2="48" y2="48" gradientUnits="userSpaceOnUse">
                                        <stop offset="0%" stop-color="#FFEFA6" />
                                        <stop offset="30%" stop-color="#FFD043" />
                                        <stop offset="70%" stop-color="#FFB600" />
                                        <stop offset="100%" stop-color="#D49000" />
                                    </linearGradient>
                                    <linearGradient id="textGrad" x1="0" y1="12" x2="0" y2="36" gradientUnits="userSpaceOnUse">
                                        <stop offset="0%" stop-color="#FFF3C4" />
                                        <stop offset="100%" stop-color="#F5B000" />
                                    </linearGradient>
                                    <filter id="inset-shadow" x="-10%" y="-10%" width="120%" height="120%">
                                        <feOffset dx="0.5" dy="1"/>
                                        <feGaussianBlur stdDeviation="0.5" result="offset-blur"/>
                                        <feComposite operator="out" in="SourceGraphic" in2="offset-blur" result="inverse"/>
                                        <feFlood flood-color="black" flood-opacity="0.6" result="color"/>
                                        <feComposite operator="in" in="color" in2="inverse" result="shadow"/>
                                        <feComposite operator="over" in="shadow" in2="SourceGraphic"/>
                                    </filter>
                                </defs>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-semibold text-gray-500">Bạn đang có</span>
                            <span class="text-lg font-bold text-[#0165FC]">{{ number_format($user->points ?? 1560) }} điểm thưởng</span>
                        </div>
                    </div>

                    <!-- Transactions List Box -->
                    <div class="points-list-container blue-scrollbar max-h-[480px] overflow-y-auto pr-4 border-t border-[#F0F2F5]">
                        @foreach ($points as $item)
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
                                            Bạn nhận 100 điểm thưởng cho đơn hàng 
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

                                <!-- Transaction Point Value Badge -->
                                <div class="shrink-0 pl-2">
                                    <span class="inline-block bg-[#FF9500] hover:bg-[#E08300] text-white font-bold py-2.5 px-6 rounded-lg text-sm transition-colors cursor-pointer select-none whitespace-nowrap shadow-sm text-center min-w-[105px]">
                                        +{{ $item->points }} điểm
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination Section -->
                    <x-pagination-client :items="$points" />

                </div>
            </main>
        </div>
    </div>
</div>
@endsection
