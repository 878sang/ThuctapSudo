@extends('Layout.main')
@section('title', 'Sửa sản phẩm')
@section('content')
<div class="max-w-xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Sản phẩm', 'url' => route('products.index')],
        ['label' => 'Chỉnh sửa']
    ]" />
</div>
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">

    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Sửa Sản Phẩm</h1>
        <a href="{{ route('products.index') }}" class="text-sm text-indigo-600 hover:underline">
            &larr; Quay lại
        </a>
    </div>

    <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4" novalidate>
        @csrf
        @method('PUT')
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên sản phẩm <span class="text-red-500">*</span></label>
            <input type="text"
                name="name"
                id="name"
                value="{{ old('name', $product->name) }}"
                required
                placeholder="Nhập tên sản phẩm..."
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
            <x-form-error name="name" />
        </div>
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục <span class="text-red-500">*</span></label>
            <select name="category_id"
                id="category_id"
                required
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('category_id') border-red-500 @enderror">
                <option value="">-- Chọn danh mục --</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            <x-form-error name="category_id" />
        </div>
        <div>
            <div>
                <label>Ảnh hiện tại</label>
                <img src="{{ $product->avatar_url }}" class="w-24 h-24" alt="">
            </div>
        </div>
        <div>
            <label for="avatar" class="block text-sm font-medium text-gray-700 mb-1">Ảnh đại diện <span class="text-red-500">*</span></label>
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
                placeholder="Mô tả ngắn về sản phẩm..."
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
            <x-form-error name="description" />
        </div>
        <div>
            <label>Ảnh hiện tại</label>
            @if(!empty($product->image_urls))
            @foreach ($product->image_urls as $url)
            <img src="{{ $url }}" class="w-24 h-24" alt="">
            @endforeach
            @endif
        </div>

        <div>
            <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Ảnh sản phẩm <span class="text-red-500">*</span></label>
            <input type="file"
                name="images[]"
                id="images"
                multiple
                accept="image/*"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('images') border-red-500 @enderror">
            <x-form-error name="images" />
            <x-form-error name="images.*" />
        </div>
        <div>
            <label for="detail" class="block text-sm font-medium text-gray-700 mb-1">Chi tiết sản phẩm</label>
            <input id="detail" type="hidden" name="detail" value="{{ old('detail') }}">
            <trix-editor input="detail" class="border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 bg-white" style="min-height: 350px;">{!! old('detail', $product->detail) !!}</trix-editor>
            <x-form-error name="detail" />
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái <span class="text-red-500">*</span></label>
            <select name="status"
                id="status"
                required
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>Tạm ẩn</option>
            </select>
            <x-form-error name="status" />
        </div>
        <div class="flex justify-end space-x-2 pt-2">
            <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Hủy
            </a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Lưu
            </button>
        </div>
    </form>

</div>
@endsection