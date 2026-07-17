@extends('client.layout.main')

@section('content')
<div class="bg-blue_bg py-16 min-h-[60vh] flex items-center justify-center">
    <div class="max-w-[620px] w-full bg-white rounded-2xl p-10 sm:p-12 text-center flex flex-col items-center mx-4">

        <!-- Icon Checkmark Tròn Xanh Dương -->
        <span class="w-16 h-16 rounded-full flex items-center justify-center bg-[#0165FC] shadow-sm">
            <svg width="77" height="77" viewBox="0 0 77 77" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="38.5039" cy="38.5039" r="38.5039" fill="#0165FC" />
                <path d="M24.082 37.0921L34.6381 47.6491L52.9287 29.3584" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </span>

        <!-- Nội dung thông báo -->
        <div class="space-y-3">
            <h2 class="text-[28px] font-bold text-2 leading-tight mt-6 mb-2.5">Đăng ký thành công !</h2>
            <p class="text-sm text-3 leading-relaxed max-w-[400px] mx-auto mb-5">
                Hãy kiểm tra Email của bạn để xác minh tài khoản
            </p>
        </div>
        <!-- Ghi chú lưu ý -->
        <p class="text-xs text-4 italic">
            Lưu ý: mail có thể nằm trong thư mục SPAM hoặc JUNK
        </p>
        <!-- Hỗ trợ liên hệ -->
        <div class="text-sm text-[#5D6F7A] font-medium pt-2 border-t border-gray-100 w-full">
            Bạn cần hỗ trợ?
            <a href="tel:19006536" class="text-[#0165FC] font-bold hover:underline">Gọi điện thoại</a> hoặc
            <a href="https://zalo.me" target="_blank" rel="noopener noreferrer" class="text-[#0165FC] font-bold hover:underline">Chat ZALO OA</a>
        </div>

    </div>
</div>
@endsection