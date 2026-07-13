@extends('Layout.main')
@section('title', 'Chi Tiết Thương Hiệu')
@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <x-breadcrumb :items="[
            ['label' => 'Thương hiệu', 'url' => route('brands.index')],
            ['label' => $brand->name]
        ]" />
        <a href="{{ route('brands.index') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors mb-5">
            &larr; Quay lại danh sách
        </a>
    </div>
    
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden p-6 md:p-8 mb-8">
        <div class="flex flex-col md:flex-row gap-6 justify-between">
            <div class="flex-1">
                <div class="mb-3">
                    @if($brand->status)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Hoạt động
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 ring-1 ring-gray-500/10">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                        Tạm ẩn
                    </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ $brand->name }}</h1>
                <div class="mb-4">
                    <span class="text-xs text-gray-400 font-medium">Đường dẫn tĩnh (Slug):</span>
                    <code class="text-xs font-mono bg-gray-100 text-gray-600 px-2 py-1 rounded ml-1">{{ $brand->slug }}</code>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <h2 class="text-sm font-semibold text-gray-700 mb-2">Mô tả thương hiệu</h2>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $brand->description ?? 'Chưa có mô tả chi tiết cho thương hiệu này.' }}
                    </p>
                </div>
            </div>
            
            <div class="flex md:flex-col gap-3 justify-end items-start mt-4 md:mt-0">
                <a href="{{ route('brands.edit', $brand->id) }}"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Chỉnh sửa
                </a>
                <form action="{{ route('brands.destroy', $brand->id) }}"
                    method="POST"
                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này? Hành động này sẽ không thể hoàn tác.')"
                    class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-white hover:bg-rose-50 border border-gray-300 hover:border-rose-300 text-gray-700 hover:text-rose-600 font-medium rounded-lg text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Xóa thương hiệu
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden p-6 md:p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center justify-between">
            <span>Sản phẩm thuộc thương hiệu</span>
            <span class="text-xs bg-gray-100 text-gray-600 font-semibold px-2.5 py-1 rounded-full">
                {{ $brand->products->count() }} sản phẩm
            </span>
        </h2>

        @if($brand->products->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/50">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16 text-center">ID</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-24">Ảnh</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tên sản phẩm</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Giá bán</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tồn kho</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($brand->products as $product)
                    <tr class="hover:bg-slate-50/70 transition-colors duration-150 group">
                        <td class="py-4 px-6 text-sm font-semibold text-slate-600 text-center">
                            {{ $product->id }}
                        </td>
                        <td class="py-4 px-6">
                            <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-xl object-cover ring-2 ring-slate-100 group-hover:scale-105 transition-transform duration-200">
                        </td>
                        <td class="py-4 px-6">
                            <a href="{{ route('products.show', [$product->slug, $product->id]) }}">
                                <span class="text-sm font-semibold text-slate-800 group-hover:text-indigo-600 transition-colors duration-150 block">
                                    {{ $product->name }}
                                </span>
                            </a>
                            <span class="text-[10px] font-mono text-slate-400">SKU: {{ $product->sku }}</span>
                        </td>
                        <td class="py-4 px-6">
                            @if($product->sale_price)
                            <div class="text-sm font-semibold text-slate-800">{{ number_format($product->sale_price, 0, ',', '.') }}đ</div>
                            <div class="text-xs text-slate-400 line-through">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                            @else
                            <div class="text-sm font-semibold text-slate-800">{{ number_format($product->price, 0, ',', '.') }}đ</div>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-600">
                            {{ $product->stock }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="py-12 text-center text-gray-505 text-sm text-gray-550">
            Chưa có sản phẩm nào liên kết với thương hiệu này.
        </div>
        @endif
    </div>
</div>
@endsection
