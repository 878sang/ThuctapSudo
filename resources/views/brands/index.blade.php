@extends('Layout.main')
@section('title', 'Quản Lý Thương Hiệu')
@section('content')

<div class="max-w-7xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Thương hiệu']
    ]" />

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-tr from-indigo-500 to-violet-600 rounded-2xl text-white shadow-md shadow-indigo-200">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">Quản Lý Thương Hiệu</h1>
                <p class="text-slate-500 text-sm mt-1">Quản lý các thương hiệu sản phẩm trong hệ thống</p>
            </div>
        </div>
        <x-button href="{{ route('brands.create') }}">
            Thêm thương hiệu
        </x-button>
    </div>

    <div class="mb-6">
        <form action="{{ route('brands.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
            <div class="w-full sm:w-48">
                <select name="status" id="status" onchange="this.form.submit()" class="w-full px-3 py-2 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                    <option value="all" {{ !request()->has('status') || request()->status == 'all' ? 'selected' : '' }}>Tất cả trạng thái</option>
                    <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="inactive" {{ request()->status == 'inactive' ? 'selected' : '' }}>Tạm ẩn</option>
                </select>
            </div>
            <div class="w-full sm:w-72 flex gap-2">
                <input type="search" name="search" placeholder="Tìm kiếm thương hiệu..." value="{{ request()->search }}" class="w-full px-4 py-2 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" />
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-750 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-colors bg-indigo-650">Tìm</button>
            </div>
            <label for="trash" class="inline-flex items-center gap-2.5 cursor-pointer select-none text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                <div class="relative">
                    <input type="checkbox" name="trash" id="trash" onchange="this.form.submit()" class="sr-only peer" {{ request()->trash ? 'checked' : '' }}>
                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-500/20 rounded-full peer peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:after:translate-x-full"></div>
                </div>
                <span>Thùng rác</span>
            </label>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden backdrop-blur-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/50">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16 text-center">ID</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-24 text-center">Logo</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tên thương hiệu</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Đường dẫn (Slug)</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mô tả</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-32 text-center">Trạng thái</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-40">Ngày tạo</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-36 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($brands as $brand)
                    <tr class="hover:bg-slate-50/70 transition-colors duration-150 group">
                        <td class="py-4 px-6 text-sm font-semibold text-slate-600 text-center">
                            {{ $brand->id }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" class="h-10 w-auto object-contain mx-auto rounded-md">
                        </td>
                        <td class="py-4 px-6">
                            <a href="{{ route('brands.show', [$brand->slug, $brand->id]) }}">
                                <span class="text-sm font-semibold text-slate-800 group-hover:text-indigo-600 transition-colors duration-150 block">
                                    {{ $brand->name }}
                                </span>
                            </a>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex font-mono text-xs text-slate-500 bg-slate-100/80 px-2.5 py-1 rounded-lg border border-slate-200/50">
                                {{ $brand->slug }}
                            </span>
                        </td>
                        <td class="py-4 px-6 max-w-xs sm:max-w-sm">
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed" title="{{ $brand->description }}">
                                {{ $brand->description ?? 'Chưa có mô tả' }}
                            </p>
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($brand->status)
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
                            {{ $brand->created_at ? $brand->created_at->format('d/m/Y H:i') : 'N/A' }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if ($brand->deleted_at)
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('brands.restore', $brand->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục Thương hiệu này?')" class="inline">
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
                                    data-id="{{ $brand->id }}"
                                    data-url="{{ route('brands.destroy', $brand->id) }}"
                                    data-type="brand">
                                    Xóa
                                </button>
                            </div>
                            @else
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('brands.edit', $brand->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all duration-150" title="Chỉnh sửa">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                <button type="button" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all duration-150 btn-delete" title="Xóa"
                                    data-id="{{ $brand->id }}"
                                    data-url="{{ route('brands.destroy', $brand->id) }}"
                                    data-type="brand">
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
                                <h3 class="text-sm font-semibold text-slate-800">Không có thương hiệu nào</h3>
                                <p class="text-xs text-slate-500 mt-1 max-w-xs">Bắt đầu tạo thương hiệu đầu tiên của bạn trong hệ thống.</p>
                                <a href="{{ route('brands.create') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded-xl hover:bg-indigo-700 transition-colors">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tạo thương hiệu mới
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-pagination :items="$brands" />
    </div>
</div>

<x-delete-modal />

@endsection