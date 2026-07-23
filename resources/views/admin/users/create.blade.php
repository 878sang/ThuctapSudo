@extends('admin.Layout.main')
@section('title', 'Thêm Người Dùng Mới')
@section('content')

<div class="max-w-4xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Người dùng', 'url' => route('admin.users.index')],
        ['label' => 'Thêm mới']
    ]" />

    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.users.index') }}" class="p-2 hover:bg-slate-100 rounded-xl transition-colors text-slate-500 hover:text-slate-700">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">Thêm Người Dùng Mới</h1>
            <p class="text-slate-500 text-sm mt-1">Đăng ký tài khoản người dùng hoặc nhân viên quản trị mới</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden backdrop-blur-sm">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
            @csrf

            <!-- Avatar Upload -->
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Ảnh đại diện</label>
                <div class="flex items-center gap-4">
                    <div id="avatar-preview" class="w-16 h-16 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 font-semibold text-xl shadow-inner shadow-slate-100">U</div>
                    <input type="file" name="avatar" id="avatar" accept="image/*" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors cursor-pointer">
                </div>
                @error('avatar')
                    <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Họ Tên -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Họ và Tên <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" placeholder="Nguyễn Văn A">
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tên Hiển Thị -->
                <div>
                    <label for="display_name" class="block text-sm font-semibold text-slate-700 mb-1.5">Tên hiển thị (Tùy chọn)</label>
                    <input type="text" name="display_name" id="display_name" value="{{ old('display_name') }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" placeholder="Anhvip123">
                    @error('display_name')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Địa chỉ Email <span class="text-rose-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" placeholder="example@mail.com">
                    @error('email')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Số Điện Thoại -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-slate-700 mb-1.5">Số điện thoại <span class="text-rose-500">*</span></label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" placeholder="0123456789">
                    @error('phone')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mật Khẩu -->
                <div x-data="{ show: false }">
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Mật khẩu <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" id="password" required class="w-full pl-4 pr-10 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" placeholder="••••••">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" class="h-5 w-5" style="display: none;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Xác Nhận Mật Khẩu -->
                <div x-data="{ show: false }">
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Xác nhận mật khẩu <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password_confirmation" id="password_confirmation" required class="w-full pl-4 pr-10 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" placeholder="••••••">
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                            <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" class="h-5 w-5" style="display: none;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Ngày Sinh -->
                <div>
                    <label for="dob" class="block text-sm font-semibold text-slate-700 mb-1.5">Ngày sinh <span class="text-rose-500">*</span></label>
                    <input type="date" name="dob" id="dob" value="{{ old('dob') }}" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                    @error('dob')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Giới tính -->
                <div>
                    <label for="gender" class="block text-sm font-semibold text-slate-700 mb-1.5">Giới tính <span class="text-rose-500">*</span></label>
                    <select name="gender" id="gender" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="">Chọn giới tính</option>
                        <option value="Nam" {{ old('gender') === 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ old('gender') === 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        <option value="Khác" {{ old('gender') === 'Khác' ? 'selected' : '' }}>Khác</option>
                    </select>
                    @error('gender')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vai Trò (Role) -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-slate-700 mb-1.5">Vai trò hệ thống <span class="text-rose-500">*</span></label>
                    <select name="role" id="role" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Khách hàng (Customer)</option>
                        <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Nhân viên (Staff)</option>
                        <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @error('role')
                        <p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-slate-600 hover:text-slate-800 text-sm font-semibold hover:bg-slate-50 rounded-xl transition-colors">
                    Hủy bỏ
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-750 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors bg-indigo-650 shadow-sm shadow-indigo-100">
                    Lưu thông tin
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
