@extends('Layout.main')
@section('title', 'Danh Mục Sản Phẩm')
@section('content')
<div class="max-w-7xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Danh mục sản phẩm']
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
                <p class="text-slate-500 text-sm mt-1">Quản lý các danh mục phân loại sản phẩm trong hệ thống cửa hàng</p>
            </div>
        </div>

        <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white font-semibold rounded-xl text-sm shadow-lg shadow-indigo-150 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Thêm danh mục</span>
        </a>
    </div>
    <div>
        <form action="{{ route('categories.index') }}" method="GET">
            <select name="status" id="status" onchange="this.form.submit()">
                <option value="all" {{ !request()->has('status') ? 'selected' : '' }}>Tất cả</option>
                <option value="active" {{ request()->has('status')&&request()->status == 'active' ? 'selected' : '' }}>Sản phẩm</option>
                <option value="trash" {{ request()->has('status')&&request()->status == 'trash' ? 'selected' : '' }}>Thùng rác</option>
            </select>
        </form>
    </div>
    <div class="bg-white min-h-screen rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden backdrop-blur-sm">

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/50">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16 text-center">ID</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-24">Ảnh</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tên danh mục</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Đường dẫn (Slug)</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mô tả</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-32 text-center">Trạng thái</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-40">Ngày tạo</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-36 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $category)
                    <tr class="hover:bg-slate-50/70 transition-colors duration-150 group">
                        <td class="py-4 px-6 text-sm font-semibold text-slate-600 text-center">
                            {{ $category->id }}
                        </td>
                        <td class="py-4 px-6">
                            <img src="{{ asset('storage/images/' . $category->avatar) }}" alt="{{ $category->name }}" class="w-10 h-10 rounded-xl object-cover ring-2 ring-slate-100 group-hover:scale-105 transition-transform duration-200">
                        </td>
                        <td class="py-4 px-6">
                            <a href="{{route('categories.show', $category->id)}}"><span class="text-sm font-semibold text-slate-800 group-hover:text-indigo-600 transition-colors duration-150">
                                    {{ $category->name }}
                                </span></a>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex font-mono text-xs text-slate-500 bg-slate-100/80 px-2.5 py-1 rounded-lg border border-slate-200/50">
                                {{ $category->slug }}
                            </span>
                        </td>
                        <td class="py-4 px-6 max-w-xs sm:max-w-sm">
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed" title="{{ $category->description }}">
                                {{ $category->description ?? 'Chưa có mô tả' }}
                            </p>
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($category->deleted_at)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 ring-1 ring-red-600/20 shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                Đã xóa
                            </span>
                            @elseif($category->isActive())
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
                            {{ $category->created_at ? $category->created_at->format('d/m/Y H:i') : 'N/A' }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if ($category->deleted_at)
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('categories.restore', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục danh mục này?')" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all duration-150" title="Khôi phục">
                                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                </form>
                                <button type="button" 
                                    data-id="{{ $category->id }}"
                                    data-url="{{ route('categories.destroy', $category->id) }}"
                                    data-type="category-force"
                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all duration-150 btn-delete" 
                                    title="Xóa vĩnh viễn">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            @else
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('categories.edit', $category->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all duration-150" title="Chỉnh sửa">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <button type="button" 
                                    data-id="{{ $category->id }}"
                                    data-url="{{ route('categories.destroy', $category->id) }}"
                                    data-check-url="{{ route('categories.check', $category->id) }}"
                                    data-type="category"
                                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all duration-150 btn-delete" 
                                    title="Xóa">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
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
                                <h3 class="text-sm font-semibold text-slate-800">Không có danh mục nào</h3>
                                <p class="text-xs text-slate-500 mt-1 max-w-xs">Bắt đầu tạo danh mục đầu tiên của bạn để phân loại sản phẩm trong cửa hàng.</p>
                                <a href="{{ route('categories.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tạo danh mục mới
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-pagination :items="$categories" />
    </div>
    @endsection