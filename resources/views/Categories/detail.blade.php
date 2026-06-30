<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi Tiết Danh Mục - {{ $category->name }}</title>

    <!-- Tailwind CSS Vite Helper -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <nav class="flex text-sm text-gray-500 space-x-2">
                <a href="{{ route('categories.index') }}" class="hover:text-indigo-600 transition-colors">Danh mục</a>
                <span>/</span>
                <span class="text-gray-800 font-medium truncate max-w-[200px]">{{ $category->name }}</span>
            </nav>
            <a href="{{ route('categories.index') }}" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
                &larr; Quay lại danh sách
            </a>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden p-6 md:p-8 mb-8">
            <div class="flex gap-8">
                <div class="w-48 rounded-2xl bg-gray-50 border border-gray-200 p-4">
                    @if($category->avatar)
                    <img src="{{ asset('storage/images/' . $category->avatar) }}"
                        alt="{{ $category->name }}"
                        class="w-full h-full object-contain rounded-xl">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        Không có ảnh đại diện
                    </div>
                    @endif
                </div>
                <div class="flex flex-col justify-between">
                    <div>
                        <div class="mb-3">
                            @if($category->status == 1)
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

                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ $category->name }}</h1>
                        <div class="mb-4">
                            <span class="text-xs text-gray-450 font-medium">Đường dẫn tĩnh (Slug):</span>
                            <code class="text-xs font-mono bg-gray-100 text-gray-600 px-2 py-1 rounded ml-1">{{ $category->slug }}</code>
                        </div>

                        <div class="border-t border-gray-100 pt-4">
                            <h2 class="text-sm font-semibold text-gray-700 mb-2">Mô tả danh mục</h2>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $category->description ?? 'Chưa có mô tả chi tiết cho danh mục này.' }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-6 mt-6 flex gap-3">
                        <a href="{{ route('categories.edit', $category->id) }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-650 hover:bg-indigo-700 text-white font-medium rounded-lg text-sm transition-colors shadow-sm bg-indigo-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Chỉnh sửa danh mục
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}"
                            method="POST"
                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Hành động này sẽ không thể hoàn tác.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-white hover:bg-rose-50 border border-gray-300 hover:border-rose-300 text-gray-700 hover:text-rose-600 font-medium rounded-lg text-sm transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Xóa danh mục
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden p-6 md:p-8">
            <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center justify-between">
                <span>Sản phẩm thuộc danh mục</span>
                <span class="text-xs bg-gray-100 text-gray-650 font-semibold px-2.5 py-1 rounded-full text-gray-600">
                    {{ $category->products->count() }} sản phẩm
                </span>
            </h2>

            @if($category->products->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-200/50">
                            <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16 text-center">ID</th>
                            <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-24">Ảnh</th>
                            <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tên sản phẩm</th>
                            <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Đường dẫn (Slug)</th>
                            <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Mô tả</th>
                            <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-32 text-center">Trạng thái</th>
                            <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-36 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($category->products as $product)
                        <tr class="hover:bg-slate-50/70 transition-colors duration-150 group">
                            <td class="py-4 px-6 text-sm font-semibold text-slate-600 text-center">
                                {{ $product->id }}
                            </td>
                            <td class="py-4 px-6">
                                @if($product->avatar)
                                <img src="{{ asset('storage/images/' . $product->avatar) }}"
                                    alt="{{ $product->name }}"
                                    class="w-12 h-12 rounded-xl object-cover ring-2 ring-slate-100 group-hover:scale-105 transition-transform duration-200">
                                @else
                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 text-[10px] text-center border">
                                    No image
                                </div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm font-semibold text-slate-800 group-hover:text-indigo-600 transition-colors duration-150">
                                    {{ $product->name }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex font-mono text-xs text-slate-500 bg-slate-100/80 px-2.5 py-1 rounded-lg border border-slate-200/50">
                                    {{ $product->slug }}
                                </span>
                            </td>
                            <td class="py-4 px-6 max-w-xs">
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed" title="{{ $product->description }}">
                                    {{ $product->description ?? 'Chưa có mô tả' }}
                                </p>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($product->status == 1)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/20 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Hoạt động
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 ring-1 ring-slate-500/10">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    Tạm ẩn
                                </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('products.show', [$product->slug,$product->id]) }}" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-semibold text-indigo-650 hover:text-white bg-indigo-50 hover:bg-indigo-600 border border-indigo-100 rounded-lg transition-all">
                                    Xem chi tiết &rarr;
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-10 border border-dashed border-gray-200 rounded-xl">
                <p class="text-sm text-gray-500">Chưa có sản phẩm nào thuộc danh mục này.</p>
                <a href="{{ route('products.create') }}" class="mt-3 inline-flex items-center gap-1.5 text-xs text-indigo-600 font-semibold hover:underline">
                    Thêm sản phẩm mới &rarr;
                </a>
            </div>
            @endif
        </div>

    </div>
</body>

</html>