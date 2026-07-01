@extends('Layout.main')
@section('title', 'Thêm sản phẩm mới')
@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">

    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Thêm Sản Phẩm Mới</h1>
        <a href="{{ route('products.index') }}" class="text-sm text-indigo-600 hover:underline">
            &larr; Quay lại
        </a>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên sản phẩm <span class="text-red-500">*</span></label>
            <input type="text"
                name="name"
                id="name"
                value="{{ old('name') }}"
                required
                placeholder="Nhập tên sản phẩm..."
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
            @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục <span class="text-red-500">*</span></label>
            <select name="category_id"
                id="category_id"
                required
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('category_id') border-red-500 @enderror">
                <option value="">-- Chọn danh mục --</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            @error('category_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Ảnh đại diện <span class="text-red-500">*</span></label>
            <input type="file"
                name="avatar"
                id="avatar"
                required
                accept="image/*"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('avatar') border-red-500 @enderror">
            @error('avatar')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả <span class="text-red-500">*</span></label>
            <textarea name="description"
                id="description"
                rows="3"
                required
                placeholder="Mô tả ngắn về sản phẩm..."
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Ảnh sản phẩm <span class="text-red-500">*</span></label>
            <input type="file"
                name="images[]"
                id="images"
                required
                multiple
                accept="image/*"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('images') border-red-500 @enderror">
            @error('images.*')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @error('images')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="detail" class="block text-sm font-medium text-gray-700 mb-1">Chi tiết sản phẩm</label>
            <input id="detail" type="hidden" name="detail" value="{{ old('detail') }}">
            <trix-editor input="detail" class="border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 bg-white" style="min-height: 350px;"></trix-editor>
            @error('detail')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái <span class="text-red-500">*</span></label>
            <select name="status"
                id="status"
                required
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tạm ẩn</option>
            </select>
            @error('status')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex justify-end space-x-2 pt-2">
            <x-button href="{{ route('products.index') }}" class="bg-white text-gray-800">
                Hủy
            </x-button>
            <x-button href="{{ route('products.create') }}" type="submit">
                Thêm sản phẩm
            </x-button>
        </div>
    </form>

</div>
@endsection