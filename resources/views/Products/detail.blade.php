@extends('Layout.main')
@section('title', 'Chi tiết sản phẩm')
@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <x-breadcrumb :items="[
            ['label' => 'Sản phẩm', 'url' => route('products.index')],
            ['label' => $product->name]
        ]" />
        <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors mb-5">
            &larr; Quay lại danh sách
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden p-6 md:p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
            <div>
                <div class="swiper mainSwiper mb-4 border border-gray-200 rounded-2xl bg-gray-50 p-4">
                    <div class="swiper-wrapper">
                        @if($product->avatar)
                        <div class="swiper-slide flex items-center justify-center h-[300px] md:h-[380px]">
                            <img src="{{ $product->avatar_url }}"
                                class="max-w-full max-h-full object-contain rounded-xl"
                                alt="{{ $product->name }}">
                        </div>
                        @endif
                        @if(!empty($product->images) && is_array($product->images))
                        @foreach($product->images as $img)
                        <div class="swiper-slide flex items-center justify-center h-[300px] md:h-[380px]">
                            <img src="{{ $img }}"
                                class="max-w-full max-h-full object-contain rounded-xl"
                                alt="Ảnh phụ sản phẩm">
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
                @if(!empty($product->images) && is_array($product->images) && count($product->images) > 0)
                <div class="swiper thumbSwiper">
                    <div class="swiper-wrapper">
                        @if($product->avatar)
                        <div class="swiper-slide cursor-pointer border-2 border-transparent rounded-xl overflow-hidden bg-gray-50 p-1">
                            <img src="{{ $product->avatar_url }}" class="w-full h-16 object-contain rounded-lg"
                                alt="">
                        </div>
                        @endif
                        @foreach($product->images as $img)
                        <div class="swiper-slide cursor-pointer border-2 border-transparent rounded-xl overflow-hidden bg-gray-50 p-1">
                            <img src="{{ $img }}"
                                class="w-full h-16 object-contain rounded-lg"
                                alt="">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            <div class="flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 ring-1 ring-indigo-600/10">
                            {{ $product->category->name ?? 'Không rõ danh mục' }}
                        </span>
                        @if($product->status == 1)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Hoạt động
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 ring-1 ring-gray-500/10">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                            Tạm ẩn
                        </span>
                        @endif
                    </div>

                    <!-- Tên sản phẩm -->
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                    <!-- Đường dẫn tĩnh (Slug) -->
                    <div class="mb-4">
                        <span class="text-xs text-gray-400 font-medium">Đường dẫn (Slug):</span>
                        <code class="text-xs font-mono bg-gray-100 text-gray-600 px-2 py-1 rounded ml-1">{{ $product->slug }}</code>
                    </div>

                    <!-- Mô tả ngắn -->
                    <div class="border-t border-gray-100 pt-4 mb-6">
                        <h2 class="text-sm font-semibold text-gray-700 mb-2">Mô tả ngắn</h2>
                        <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">
                            {{ $product->description ?? 'Chưa có mô tả ngắn cho sản phẩm này.' }}
                        </p>
                    </div>
                </div>

                <!-- Nút thao tác -->
                <div class="border-t border-gray-100 pt-6 flex flex-wrap gap-3">
                    <a href="{{ route('products.edit', $product->id) }}"
                        class="flex-1 min-w-[120px] inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Chỉnh sửa
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}"
                        method="POST"
                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')"
                        class="flex-1 min-w-[120px]">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-white hover:bg-rose-50 border border-gray-300 hover:border-rose-300 text-gray-700 hover:text-rose-600 font-medium rounded-lg text-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Xóa sản phẩm
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Chi tiết sản phẩm -->
        <div class="border-t border-gray-200 mt-10 pt-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Chi tiết sản phẩm</h2>
            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                @if($product->detail)
                {!! $product->detail !!}
                @else
                <span class="text-gray-400 italic">Chưa có thông tin chi tiết.</span>
                @endif
            </div>
        </div>

    </div>
</div>
@push('scripts')
<script>
    const thumbSwiper = new Swiper('.thumbSwiper', {
        spaceBetween: 10,
        slidesPerView: 4,
        watchSlidesProgress: true,
    });

    const mainSwiper = new Swiper('.mainSwiper', {
        spaceBetween: 10,
        thumbs: {
            swiper: thumbSwiper,
        },
    });
</script>
@endpush
@endsection