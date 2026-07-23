@extends('client.layout.main')

@section('content')
<div class="bg-[#F4F8FA] min-h-screen py-6">
    {{-- Breadcrumb --}}
    <div class="max-w-[1440px] mx-auto px-4 mb-4">
        <x-breadcrumb :items="[
            ['label' => 'Chi tiết đơn hàng ']
        ]" />
    </div>

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

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- Left Column (8/12) --}}
        <div class="lg:col-span-8 flex flex-col gap-6">

            {{-- Box 1: THÔNG TIN ĐƠN HÀNG --}}
            <div class="bg-white rounded-[10px] p-6">
                <div class="bg-[#DDEBFF] text-[#0165FC] font-bold text-base uppercase py-4 px-5 rounded-[5px] mb-6">
                    THÔNG TIN ĐƠN HÀNG
                </div>
                <div class="text-sm px-2">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-3.5 gap-x-8">
                        {{-- Col 1 --}}
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <span class="text-[#959595] w-32 shrink-0">Mã đơn hàng:</span>
                                <span class="text-2">{{ $order->code ?? '210722DS3WOFFS' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-[#959595] w-32 shrink-0">Ngày tạo đơn:</span>
                                <span class="text-2">{{ isset($order->created_at) ? \Carbon\Carbon::parse($order->created_at)->format('H:i d/m/Y') : '10:26 22/07/2021' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-[#959595] w-32 shrink-0">Trạng thái:</span>
                                <span class="text-2">{{ $order->status_label ?? 'Đang xử lý' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-[#959595] w-32 shrink-0">Dự kiến giao hàng:</span>
                                <span class="text-2">{{ $order->estimated_delivery ?? '05/08/2021' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-[#959595] w-32 shrink-0">Yêu cầu COCQ:</span>
                                <span class="text-2">{{ isset($order->is_cocq) ? ($order->is_cocq ? 'Có' : 'Không') : 'Không' }}</span>
                            </div>
                        </div>

                        {{-- Col 2 --}}
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <span class="text-[#959595] w-28 shrink-0">Người đặt:</span>
                                <span class="text-2">{{ $order->customer_name ?? $order->user->name ?? 'Hiền Thanh' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-[#959595] w-28 shrink-0">Email:</span>
                                <span class="text-2 truncate">{{ $order->company_email ?? $order->user->email ?? 'thanhhien8789@gmail.com' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-[#959595] w-28 shrink-0">Số điện thoại:</span>
                                <span class="text-2">{{ $order->customer_phone ?? '0888911577' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-[#959595] w-28 shrink-0">Sale hỗ trợ:</span>
                                <span class="text-2">{{ $order->support_sale ?? 'Leader (84963235363)' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Box 2: THÔNG TIN GIAO NHẬN --}}
            <div class="bg-white rounded-[10px] p-6">
                <div class="bg-[#DDEBFF] text-[#0165FC] font-bold text-base uppercase py-4 px-5 rounded-[5px] mb-6">
                    THÔNG TIN GIAO NHẬN
                </div>
                <div class="text-sm space-y-3 px-2">
                    <div class="flex flex-col sm:flex-row sm:items-start gap-2 sm:gap-3">
                        <span class="text-[#959595] w-32 shrink-0">Địa chỉ:</span>
                        <span class="text-2">{{ $order->customer_address ?? '946 Bạch Đằng, Thanh Lương, Hai Bà Trưng, Hà Nội' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                        <span class="text-[#959595] w-32 shrink-0">Tên người nhận:</span>
                        <span class="text-2">{{ $order->receiver_name ?? $order->customer_name ?? 'Nguyễn Thanh Hiền' }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                        <span class="text-[#959595] w-32 shrink-0">Số điện thoại:</span>
                        <span class="text-2">{{ $order->receiver_phone ?? $order->customer_phone ?? '0888911577' }}</span>
                    </div>
                </div>
            </div>

            {{-- Box 3: DANH SÁCH SẢN PHẨM --}}
            <div class="bg-white rounded-[10px] p-6">
                <div class="bg-[#DDEBFF] text-[#0165FC] font-bold text-base uppercase py-4 px-5 rounded-[5px] mb-6">
                    DANH SÁCH SẢN PHẨM
                </div>
                <div class="overflow-x-auto px-2">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead>
                            <tr class="border-t border-b border-[#EEEEEE] text-2 font-bold">
                                <th class="py-3 px-2 w-10 text-center"></th>
                                <th class="py-3 px-3">Mã hàng</th>
                                <th class="py-3 px-3 text-center w-28">Đơn giá</th>
                                <th class="py-3 px-3 text-center w-20">Số lượng</th>
                                <th class="py-3 px-3 text-right w-32">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F0F0F0]">
                            @forelse($order->items as $index => $item)
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-4 px-2 text-center text-[#959595] font-medium">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="py-4 px-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $item->product->thumbnail_url ?? ($item->thumbnail ?? 'https://ui-avatars.com/api/?name=SP&background=DDECFF&color=006DF0') }}" class="w-12 h-12 object-cover rounded border border-gray-200 shrink-0" alt="{{ $item->product->name ?? ($item->product_name ?? 'Cầu dao tự động') }}">
                                        <div class="flex flex-col gap-1">
                                            <span class="font-medium text-2 line-clamp-2">{{ $item->product->name ?? ($item->product_name ?? 'Cầu dao tự động dạng cài SIEMENS NS080N3M2') }}</span>
                                            {{-- Rating stars --}}
                                            <div class="flex items-center text-amber-400 text-xs">
                                                ★★★★<span class="text-gray-300">★</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center whitespace-nowrap text-2">
                                    {{ number_format($item->price ?? ($item->unit_price ?? 150000), 0, ',', '.') }} đ
                                </td>
                                <td class="py-4 px-3 text-center font-bold text-2 whitespace-nowrap">
                                    {{ $item->quantity ?? 1 }}
                                </td>
                                <td class="py-4 px-3 text-right font-bold text-[#FF5722] whitespace-nowrap">
                                    {{ number_format($item->total ?? (($item->price ?? 150000) * ($item->quantity ?? 1)), 0, ',', '.') }} đ
                                </td>
                            </tr>
                            @empty
                            {{-- Mock Demonstration Items if no items in DB to match image design --}}
                            @for($i = 1; $i <= 6; $i++)
                                <tr class="hover:bg-gray-50/50">
                                <td class="py-4 px-2 text-center text-[#959595] font-medium">1</td>
                                <td class="py-4 px-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded border border-gray-200 bg-gray-100 flex items-center justify-center text-gray-400 shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <span class="font-medium text-2 line-clamp-2">Cầu dao tự động dạng cài SIEMENS NS080N3M2</span>
                                            <div class="flex items-center text-amber-400 text-xs">
                                                ★★★★<span class="text-gray-300">★</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-3 text-center whitespace-nowrap text-2">150.000 đ</td>
                                <td class="py-4 px-3 text-center font-bold text-2 whitespace-nowrap">1</td>
                                <td class="py-4 px-3 text-right font-bold text-[#FF5722] whitespace-nowrap">150.000 đ</td>
                                </tr>
                                @endfor
                                @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        {{-- Right Column (4/12) --}}
        <div class="lg:col-span-4 flex flex-col gap-6">

            {{-- Box 4: THÔNG TIN XUẤT HÓA ĐƠN --}}
            <div class="bg-white rounded-[10px] p-6">
                <div class="bg-[#DDEBFF] text-[#0165FC] font-bold text-base uppercase py-4 px-5 rounded-[5px] mb-6">
                    THÔNG TIN XUẤT HÓA ĐƠN
                </div>
                <div class="text-sm space-y-3 px-2">
                    @if($order->is_vat ?? true)
                    <div class="flex justify-between gap-2">
                        <span class="text-[#959595] shrink-0">Tên công ty:</span>
                        <span class="text-2 text-right">{{ $order->company_name ?? 'HOPLONGTECH' }}</span>
                    </div>
                    <div class="flex justify-between gap-2">
                        <span class="text-[#959595] shrink-0">Mã số thuế:</span>
                        <span class="text-2">{{ $order->tax_code ?? '0888911577' }}</span>
                    </div>
                    <div class="flex justify-between gap-2">
                        <span class="text-[#959595] shrink-0">Địa chỉ:</span>
                        <span class="text-2 text-right">{{ $order->company_address ?? '87 Lĩnh Nam, Mai Động, Hoàng Mai, Hà Nội' }}</span>
                    </div>
                    <div class="flex justify-between gap-2">
                        <span class="text-[#959595] shrink-0">Email nhận hóa đơn:</span>
                        <span class="text-2 text-right truncate">{{ $order->company_email ?? 'info@hoplongtech.com.vn' }}</span>
                    </div>
                    <div class="flex justify-between gap-2">
                        <span class="text-[#959595] shrink-0">Yêu cầu COCQ:</span>
                        <span class="text-2">{{ isset($order->is_cocq) ? ($order->is_cocq ? 'Có' : 'Không') : 'Có' }}</span>
                    </div>
                    @else
                    <div class="text-2">Không xuất hóa đơn</div>
                    @endif
                </div>
            </div>

            {{-- Box 5: HÌNH THỨC THANH TOÁN --}}
            <div class="bg-white rounded-[10px] p-6">
                <div class="bg-[#DDEBFF] text-[#0165FC] font-bold text-base uppercase py-4 px-5 rounded-[5px] mb-6">
                    HÌNH THỨC THANH TOÁN
                </div>
                <div class="text-sm text-2 px-2">
                    {{ $order->payment_method ?? 'Tiền mặt (thanh toán ngay khi nhận được hàng)' }}
                </div>
            </div>

            {{-- Box 6: THÔNG TIN CẦN THANH TOÁN --}}
            <div class="bg-white rounded-[10px] p-6">
                <div class="bg-[#DDEBFF] text-[#0165FC] font-bold text-base uppercase py-4 px-5 rounded-[5px] mb-6">
                    THÔNG TIN CẦN THANH TOÁN
                </div>
                <div class="text-sm space-y-3 px-2">
                    <div class="flex justify-between items-center">
                        <span class="text-[#959595]">Tổng tiền hàng</span>
                        <span class="font-medium text-2">{{ number_format(($order->total_price + $order->discount_amount), 0, ',', '.') }}đ</span>
                    </div>
                    @if($order->coupon_code)
                    <div class="flex justify-between items-center">
                        <span class="text-[#959595]">Giảm giá (Mã: <strong class="text-blue-600">{{ $order->coupon_code }}</strong>)</span>
                        <span class="font-medium text-red-500">-{{ number_format($order->discount_amount ?? 0, 0, ',', '.') }}đ</span>
                    </div>
                    @endif
                    <div class="border-b border-dashed border-gray-300 my-4"></div>

                    <div class="flex justify-between items-center pt-1">
                        <span class="font-bold text-2">Tổng tiền cần thanh toán</span>
                        <span class="font-bold text-[#FF5722] text-sm sm:text-base">{{ number_format($order->total_price, 0, ',', '.') }}đ</span>
                    </div>

                    <div class="pt-3">
                        @if(($order->status ?? 'pending') === 'pending')
                        <form action="{{ $order->cancel_url ?? route('profile.orders.cancel', $order->id ?? 1) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                            @csrf
                            <button type="submit" class="w-full bg-[#EFEFEF] hover:bg-gray-300 text-2 font-bold py-3 px-4 rounded-[4px] text-sm transition-colors text-center cursor-pointer">
                                Hủy đơn hàng
                            </button>
                        </form>
                        @else
                        <button type="button" disabled class="w-full bg-[#EFEFEF] text-gray-400 font-bold py-3 px-4 rounded-[4px] text-sm text-center cursor-not-allowed">
                            Hủy đơn hàng
                        </button>
                        @endif
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>
</div>
@endsection