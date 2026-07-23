@extends('client.layout.main')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 my-16">
    <div class="max-w-xl mx-auto p-8 bg-white border border-gray-100 rounded-2xl shadow-sm text-center">
        <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-circle-check text-4xl"></i>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Đặt hàng thành công!</h1>
        <p class="text-gray-500 mb-6">Cảm ơn bạn đã mua hàng tại hệ thống của chúng tôi.</p>
        
        <div class="bg-gray-50 rounded-xl p-4.5 mb-8 text-left text-sm space-y-2">
            <p><span class="text-gray-400">Mã đơn hàng:</span> <strong class="text-gray-800">#{{ $order->id }}</strong></p>
            <p><span class="text-gray-400">Người nhận:</span> <strong class="text-gray-800">{{ $order->customer_name }}</strong></p>
            <p><span class="text-gray-400">Số điện thoại:</span> <strong class="text-gray-800">{{ $order->customer_phone }}</strong></p>
            <p><span class="text-gray-400">Địa chỉ giao hàng:</span> <strong class="text-gray-800">{{ $order->customer_address }}</strong></p>
            @if($order->coupon_code)
            <p><span class="text-gray-400">Mã giảm giá áp dụng:</span> <strong class="text-blue-600">{{ $order->coupon_code }}</strong> <span class="text-red-500 font-semibold">(-{{ number_format($order->discount_amount, 0, ',', '.') }} đ)</span></p>
            @endif
            <p><span class="text-gray-400">Tổng thanh toán:</span> <strong class="text-[#EB7507]">{{ number_format($order->total_price, 0, ',', '.') }} đ</strong></p>
            <p><span class="text-gray-400">Phương thức thanh toán:</span> 
                <strong class="text-gray-800">
                    @if($order->payment_method === 'cod')
                        Thanh toán khi nhận hàng (COD)
                    @elseif($order->payment_method === 'bank')
                        Chuyển khoản ngân hàng
                    @elseif($order->payment_method === 'momo')
                        Thanh toán qua ví điện tử MoMo
                    @else
                        {{ $order->payment_method }}
                    @endif
                </strong>
            </p>
        </div>
        
        <a href="{{ route('products.showClient') }}" class="inline-block bg-6 text-white px-6 py-3 rounded-lg text-sm font-semibold hover:bg-blue-600 transition-colors cursor-pointer">
            Tiếp tục mua sắm
        </a>
    </div>
</div>
@endsection
