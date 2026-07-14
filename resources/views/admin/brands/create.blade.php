@extends('admin.Layout.main')
@section('title', 'Thêm Thương Hiệu Mới')
@section('content')
<div class="max-w-xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Thương hiệu', 'url' => route('admin.brands.index')],
        ['label' => 'Thêm mới']
    ]" />
</div>
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Thêm Thương Hiệu Mới</h1>
        <a href="{{ route('admin.brands.index') }}" class="text-sm text-indigo-600 hover:underline">
            &larr; Quay lại
        </a>
    </div>
    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" novalidate>
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên thương hiệu <span class="text-red-500">*</span></label>
            <input type="text"
                name="name"
                id="name"
                value="{{ old('name') }}"
                required
                placeholder="Nhập tên thương hiệu..."
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
            <x-form-error name="name" />
        </div>
        <div>
            <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Ảnh đại diện <span class="text-red-500">*</span></label>
            <input type="file"
                name="logo"
                id="logo"
                required
                accept="image/*"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('logo') border-red-500 @enderror">
            <x-form-error name="logo" />
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
            <textarea name="description"
                id="description"
                rows="4"
                placeholder="Nhập mô tả ngắn về thương hiệu..."
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            <x-form-error name="description" />
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
            <x-form-error name="status" />
        </div>
        <div class="flex justify-end space-x-2 pt-2">
            <a href="{{ route('admin.brands.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Hủy
            </a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Thêm mới
            </button>
        </div>
    </form>
</div>
@endsection

