@extends('Layout.main')
@section('title', 'Sửa Danh Mục Sản Phẩm')
@section('content')
<div class="max-w-xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Danh mục', 'url' => route('categories.index')],
        ['label' => 'Chỉnh sửa']
    ]" />
</div>
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Sửa Danh Mục Mới</h1>
        <a href="{{ route('categories.index') }}" class="text-sm text-indigo-600 hover:underline">
            &larr; Quay lại
        </a>
    </div>
    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4" novalidate>
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên danh mục <span class="text-red-500">*</span></label>
            <input type="text"
                name="name"
                id="name"
                value="{{ old('name', $category->name) }}"
                placeholder="Nhập tên danh mục..."
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
            <x-form-error name="name" />
        </div>
        <div>
            <label>Ảnh hiện tại</label>
            <img src="{{ $category->avatar_url }}" class="w-24 h-24 " alt="">
        </div>
        <div>
            <label for=" avatar" class="block text-sm font-medium text-gray-700 mb-1">Ảnh đại diện <span class="text-red-500">*</span></label>
            <input type="file"
                name="avatar"
                id="avatar"
                accept="image/*"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('avatar') border-red-500 @enderror">
            <x-form-error name="avatar" />
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả <span class="text-red-500">*</span></label>
            <textarea name="description"
                id="description"
                rows="3"
                placeholder="Mô tả ngắn về danh mục..."
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
            <x-form-error name="description" />
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái <span class="text-red-500">*</span></label>
            <select name="status"
                id="status"
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>Tạm ẩn</option>
            </select>
            <x-form-error name="status" />
        </div>

        <div class="flex justify-end space-x-2 pt-2">
            <a href="{{ route('categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Hủy
            </a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cập nhật
            </button>
        </div>
    </form>

</div>
@endsection