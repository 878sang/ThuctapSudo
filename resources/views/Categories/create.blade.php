<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thêm Danh Mục</title>

    <!-- Tailwind CSS Vite helper -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 min-h-screen py-10 px-4">
    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">Thêm Danh Mục Mới</h1>
            <a href="{{ route('categories.index') }}" class="text-sm text-indigo-600 hover:underline">
                &larr; Quay lại
            </a>
        </div>
        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên danh mục <span class="text-red-500">*</span></label>
                <input type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    required
                    placeholder="Nhập tên danh mục..."
                    class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                @error('name')
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
                    placeholder="Mô tả ngắn về danh mục..."
                    class="w-full px-3 py-2 border rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Trạng thái -->
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

            <!-- Nút hành động -->
            <div class="flex justify-end space-x-2 pt-2">
                <a href="{{ route('categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Hủy
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Thêm mới
                </button>
            </div>
        </form>

    </div>
</body>

</html>