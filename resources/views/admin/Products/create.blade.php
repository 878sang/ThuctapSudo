@extends('admin.Layout.main')
@section('title', 'Thêm sản phẩm mới')
@section('content')
<div class="max-w-xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Sản phẩm', 'url' => route('admin.products.index')],
        ['label' => 'Thêm mới']
    ]" />
</div>
<div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">

    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">Thêm Sản Phẩm Mới</h1>
        <a href="{{ route('admin.products.index') }}" class="text-sm text-indigo-600 hover:underline">
            &larr; Quay lại
        </a>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" novalidate>
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
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
            <x-form-error name="category_id" />
        </div>
        <div>
            <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Ảnh đại diện <span class="text-red-500">*</span></label>
            <input type="file"
                name="thumbnail"
                id="thumbnail"
                required
                accept="image/*"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('thumbnail') border-red-500 @enderror">
            <x-form-error name="thumbnail" />
        </div>
        <div>
            <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU <span class="text-red-500">*</span></label>
            <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required placeholder="Nhập SKU..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('sku') border-red-500 @enderror">
            <x-form-error name="sku" />
        </div>
        <div>
            <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">Thương hiệu <span class="text-red-500">*</span></label>
            <select name="brand_id" id="brand_id" required class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('brand_id') border-red-500 @enderror">
                <option value="">-- Chọn thương hiệu --</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
            <x-form-error name="brand_id" />
        </div>
        <div>
            <label for="cost_price" class="block text-sm font-medium text-gray-700 mb-1">Giá vốn <span class="text-red-500">*</span></label>
            <input type="number" name="cost_price" id="cost_price" value="{{ old('cost_price') }}" required placeholder="Nhập giá vốn..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('cost_price') border-red-500 @enderror">
            <x-form-error name="cost_price" />
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Giá bán <span class="text-red-500">*</span></label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" required placeholder="Nhập giá bán..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @enderror">
            <x-form-error name="price" />
        </div>
        <div>
            <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-1">Giá sale</label>
            <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" placeholder="Nhập giá sale..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('sale_price') border-red-500 @enderror">
            <x-form-error name="sale_price" />
        </div>
        <div>
            <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Số lượng tồn kho <span class="text-red-500">*</span></label>
            <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required placeholder="Nhập số lượng tồn kho..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('stock') border-red-500 @enderror">
            <x-form-error name="stock" />
        </div>
        <div>
            <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-1">Số lượng tồn kho tối thiểu <span class="text-red-500">*</span></label>
            <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock') }}" required placeholder="Nhập số lượng tồn kho tối thiểu..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('minimum_stock') border-red-500 @enderror">
            <x-form-error name="minimum_stock" />
        </div>
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả <span class="text-red-500">*</span></label>
            <textarea name="description"
                id="description"
                rows="3"
                required
                placeholder="Mô tả ngắn về sản phẩm..."
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            <x-form-error name="description" />
        </div>
        <div>
            <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Trọng lượng (kg) <span class="text-red-500">*</span></label>
            <input type="number" name="weight" id="weight" value="{{ old('weight') }}" required placeholder="Nhập trọng lượng..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('weight') border-red-500 @enderror">
            <x-form-error name="weight" />
        </div>
        <div>
            <label for="length" class="block text-sm font-medium text-gray-700 mb-1">Chiều dài (cm) <span class="text-red-500">*</span></label>
            <input type="number" name="length" id="length" value="{{ old('length') }}" required placeholder="Nhập chiều dài..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('length') border-red-500 @enderror">
            <x-form-error name="length" />
        </div>
        <div>
            <label for="width" class="block text-sm font-medium text-gray-700 mb-1">Chiều rộng (cm) <span class="text-red-500">*</span></label>
            <input type="number" name="width" id="width" value="{{ old('width') }}" required placeholder="Nhập chiều rộng..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('width') border-red-500 @enderror">
            <x-form-error name="width" />
        </div>
        <div>
            <label for="height" class="block text-sm font-medium text-gray-700 mb-1">Chiều cao (cm) <span class="text-red-500">*</span></label>
            <input type="number" name="height" id="height" value="{{ old('height') }}" required placeholder="Nhập chiều cao..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('height') border-red-500 @enderror">
            <x-form-error name="height" />
        </div>
        <div>
            <label for="featured" class="block text-sm font-medium text-gray-700 mb-1">Sản phẩm nổi bật</label>
            <input type="checkbox" name="featured" id="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('featured') border-red-500 @enderror">
            <x-form-error name="featured" />
        </div>
        <div>
            <label for="seo_title" class="block text-sm font-medium text-gray-700 mb-1">SEO Title</label>
            <input type="text" name="seo_title" id="seo_title" value="{{ old('seo_title') }}" placeholder="Nhập SEO Title..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('seo_title') border-red-500 @enderror">
            <x-form-error name="seo_title" />
        </div>
        <div>
            <label for="seo_description" class="block text-sm font-medium text-gray-700 mb-1">SEO Description</label>
            <input type="text" name="seo_description" id="seo_description" value="{{ old('seo_description') }}" placeholder="Nhập SEO Description..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('seo_description') border-red-500 @enderror">
            <x-form-error name="seo_description" />
        </div>
        <div>
            <label for="seo_keyword" class="block text-sm font-medium text-gray-700 mb-1">SEO Keyword</label>
            <input type="text" name="seo_keyword" id="seo_keyword" value="{{ old('seo_keyword') }}" placeholder="Nhập SEO Keyword..." class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('seo_keyword') border-red-500 @enderror">
            <x-form-error name="seo_keyword" />
        </div>
        <div>
            <label for="gallery" class="block text-sm font-medium text-gray-700 mb-1">Ảnh sản phẩm <span class="text-red-500">*</span></label>
            <input type="file"
                name="gallery[]"
                id="gallery"
                required
                multiple
                accept="image/*"
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('gallery') border-red-500 @enderror">
            <x-form-error name="gallery" />
            <x-form-error name="gallery.*" />
        </div>
        <div>
            <label for="detail" class="block text-sm font-medium text-gray-700 mb-1">Chi tiết sản phẩm</label>
            <input id="detail" type="hidden" name="detail" value="{{ old('detail') }}">
            <trix-editor input="detail" class="border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 bg-white" style="min-height: 350px;"></trix-editor>
            <x-form-error name="detail" />
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Trạng thái <span class="text-red-500">*</span></label>
            <select name="status"
                id="status"
                required
                class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Tạm ẩn</option>
            </select>
            <x-form-error name="status" />
        </div>
        <div class="flex justify-end space-x-2 pt-2">
            <x-button href="{{ route('admin.products.index') }}" class="bg-white text-gray-800">
                Hủy
            </x-button>
            <x-button href="{{ route('admin.products.create') }}" type="submit">
                Thêm sản phẩm
            </x-button>
        </div>
    </form>

</div>
@endsection

