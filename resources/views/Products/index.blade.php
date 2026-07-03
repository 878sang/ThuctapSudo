@extends('Layout.main')
@section('title', 'Danh Mục Sản Phẩm')
@section('content')

<div class="max-w-7xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Sản phẩm']
    ]" />
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-tr from-indigo-500 to-violet-600 rounded-2xl text-white shadow-md shadow-indigo-200">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">Danh Mục Sản Phẩm</h1>
                <p class="text-slate-500 text-sm mt-1">Quản lý các Sản Phẩm phân loại sản phẩm trong hệ thống cửa hàng</p>
            </div>
        </div>
        <x-button href="{{ route('products.create') }}">
            Thêm sản phẩm
        </x-button>
    </div>
    <div>
        <form action="{{ route('products.index') }}" method="GET">
            <select name="action" id="action" onchange="this.form.submit()">
                <option value="active" {{ request()->has('action')&&request()->action == 'active' ? 'selected' : '' }}>Sản phẩm</option>
                <option value="trash" {{ request()->has('action')&&request()->action == 'trash' ? 'selected' : '' }}>Thùng rác</option>
            </select>
            <select name="category" id="category" onchange="this.form.submit()">
                <option value="all" {{ !request()->has('category') ? 'selected' : '' }}>Tất cả danh mục</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request()->has('category')&&request()->category == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <select name="status" id="status" onchange="this.form.submit()">
                <option value="all" {{ !request()->has('status') ? 'selected' : '' }}>Trạng thái</option>
                <option value="1" {{ request()->has('status')&&request()->status == '1' ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ request()->has('status')&&request()->status == '0' ? 'selected' : '' }}>Ngưng hoạt động</option>
            </select>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="" {{ !request()->has('sort') ? 'selected' : '' }}>Sắp xếp</option>
                <option value="asc" {{ request()->has('sort')&&request()->sort == 'asc' ? 'selected' : '' }}>Tăng dần</option>
                <option value="desc" {{ request()->has('sort')&&request()->sort == 'desc' ? 'selected' : '' }}>Giảm dần</option>
            </select>
            <input type="search" name="search" placeholder="Tìm kiếm sản phẩm" value="{{ request()->search }}" />
            <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded-xl">Tìm kiếm</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden backdrop-blur-sm">

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/50">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16 text-center">ID</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-24">Ảnh</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tên Sản phẩm</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tên Dah mục</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Đường dẫn (Slug)</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mô tả</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-32 text-center">Trạng thái</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-40">Ngày tạo</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-36 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50/70 transition-colors duration-150 group">
                        <td class="py-4 px-6 text-sm font-semibold text-slate-600 text-center">
                            {{ $product->id }}
                        </td>
                        <td class="py-4 px-6">
                            <img src="{{ $product->avatar_url }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-xl object-cover ring-2 ring-slate-100 group-hover:scale-105 transition-transform duration-200">
                        </td>
                        <td class="py-4 px-6">
                            <a href="{{ route('products.show',[$product->slug,$product->id ]) }}"><span class="text-sm font-semibold text-slate-800 group-hover:text-indigo-600 transition-colors duration-150">
                                    {{ $product->name}}
                                </span></a>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex font-mono text-xs text-slate-500 bg-slate-100/80 px-2.5 py-1 rounded-lg border border-slate-200/50">
                                {{ $product->category->name ??'Không có danh mục'}}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex font-mono text-xs text-slate-500 bg-slate-100/80 px-2.5 py-1 rounded-lg border border-slate-200/50">
                                {{ $product->slug }}
                            </span>
                        </td>
                        <td class="py-4 px-6 max-w-xs sm:max-w-sm">
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed" title="{{ $product->description }}">
                                {{ $product->description ?? 'Chưa có mô tả' }}
                            </p>
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($product->deleted_at)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 ring-1 ring-red-600/20 shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                Đã xóa
                             </span>
                            @elseif($product->isActive())
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20 shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Hoạt động
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 ring-1 ring-slate-500/10">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                Tạm ẩn
                            </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-400 font-medium">
                            {{ $product->created_at ? $product->created_at->format('d/m/Y H:i') : 'N/A' }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if ($product->deleted_at)
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('products.restore', $product->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục Sản phẩm này?')" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all duration-150" title="Khôi phục">
                                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h5V5m0 0l-4 4m4-4l4 4M21 14a8 8 0 11-2.34-5.66" />
                                        </svg>
                                    </button>
                                </form>
                                <button type="button" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all duration-150 btn-delete" title="Xóa"
                                    data-id="{{ $product->id }}"
                                    data-url="{{ route('products.destroy', $product->id) }}"
                                    data-type="product">
                                    Xóa
                                </button>
                            </div>
                            @else
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all duration-150" title="Chỉnh sửa">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <button type="button" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all duration-150 btn-delete" title="Xóa"
                                    data-id="{{ $product->id }}"
                                    data-url="{{ route('products.destroy', $product->id) }}"
                                    data-type="product">
                                    Xóa
                                </button>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-12 px-6 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-slate-800">Không có sản phẩm nào</h3>
                                <p class="text-xs text-slate-500 mt-1 max-w-xs">Bắt đầu tạo sản phẩm đầu tiên của bạn để phân loại sản phẩm trong cửa hàng.</p>
                                <x-button href="{{ route('products.create') }}">
                                    Thêm sản phẩm
                                </x-button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
        <x-pagination :items="$products" />
    </div>
    @endsection