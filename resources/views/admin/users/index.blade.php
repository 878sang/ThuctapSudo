@extends('admin.Layout.main')
@section('title', 'Quản Lý Người Dùng')
@section('content')

<div class="max-w-7xl mx-auto">
    <x-breadcrumb :items="[
        ['label' => 'Người dùng']
    ]" />

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-tr from-indigo-500 to-violet-600 rounded-2xl text-white shadow-md shadow-indigo-200">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">Quản Lý Người Dùng</h1>
                <p class="text-slate-500 text-sm mt-1">Quản lý và phân quyền người dùng trong hệ thống</p>
            </div>
        </div>
        <x-button href="{{ route('admin.users.create') }}">
            Thêm người dùng
        </x-button>
    </div>

    <div class="mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 items-center">
            <div class="w-full sm:w-48">
                <select name="role" id="role" onchange="this.form.submit()" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                    <option value="">Tất cả vai trò</option>
                    <option value="super_admin" {{ request()->role == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                    <option value="staff" {{ request()->role == 'staff' ? 'selected' : '' }}>Nhân viên (Staff)</option>
                    <option value="customer" {{ request()->role == 'customer' ? 'selected' : '' }}>Khách hàng (Customer)</option>
                </select>
            </div>
            <div class="w-full sm:w-72 flex gap-2">
                <input type="search" name="search" placeholder="Tìm kiếm tên người dùng..." value="{{ request()->search }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500" />
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-750 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-colors bg-indigo-650">Tìm</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden backdrop-blur-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-200/50">
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-16 text-center">ID</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-24 text-center">Avatar</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Họ và Tên</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Email / SĐT</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider">Ngày sinh / GT</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-32 text-center">Vai trò</th>
                        <th class="py-4 px-6 text-xs font-semibold text-slate-500 uppercase tracking-wider w-32 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/40 transition-colors">
                        <td class="py-4 px-6 text-sm font-medium text-slate-900 text-center">{{ $user->id }}</td>
                        <td class="py-4 px-6 text-center">
                            @if($user->avatar)
                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover inline-block border border-slate-100 shadow-sm">
                            @else
                            <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 font-bold flex items-center justify-center inline-block border border-slate-100 shadow-sm text-sm uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <div class="font-semibold text-slate-900 text-sm {{ $user->deleted_at ? 'text-slate-400 line-through' : '' }}">{{ $user->name }}</div>
                                @if($user->deleted_at)
                                <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-semibold bg-slate-100 text-slate-600 border border-slate-200">Vô hiệu hóa</span>
                                @endif
                            </div>
                            @if($user->display_name)
                            <div class="text-slate-400 text-xs mt-0.5">{{ $user->display_name }}</div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-slate-600 text-sm font-medium {{ $user->deleted_at ? 'text-slate-400' : '' }}">{{ $user->email }}</div>
                            <div class="text-slate-400 text-xs mt-0.5">{{ $user->phone }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-slate-600 text-sm {{ $user->deleted_at ? 'text-slate-400' : '' }}">{{ $user->dob ? $user->dob->format('d/m/Y') : 'Chưa cập nhật' }}</div>
                            <div class="text-slate-400 text-xs mt-0.5">{{ $user->gender ?? 'Chưa cập nhật' }}</div>
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($user->role === 'super_admin')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-100">Super Admin</span>
                            @elseif($user->role === 'staff')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">Nhân viên</span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">Khách hàng</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if ($user->deleted_at)
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn khôi phục Người dùng này?')" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 text-slate-500 hover:text-emerald-600 rounded-lg hover:bg-slate-100 transition-colors" title="Khôi phục">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h5V5m0 0l-4 4m4-4l4 4M21 14a8 8 0 11-2.34-5.66" />
                                        </svg>
                                    </button>
                                </form>
                                @if($user->id !== Auth::id())
                                <button type="button" class="p-2 text-slate-500 hover:text-rose-600 rounded-lg hover:bg-slate-100 transition-colors btn-delete" title="Xóa vĩnh viễn"
                                    data-id="{{ $user->id }}"
                                    data-url="{{ route('admin.users.destroy', $user->id) }}"
                                    data-type="user">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                            @else
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 text-slate-500 hover:text-indigo-600 rounded-lg hover:bg-slate-100 transition-colors" title="Chỉnh sửa">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </a>
                                @if($user->id !== Auth::id())
                                <button type="button" class="p-2 text-slate-500 hover:text-rose-600 rounded-lg hover:bg-slate-100 transition-colors btn-delete" title="Khóa tài khoản"
                                    data-id="{{ $user->id }}"
                                    data-url="{{ route('admin.users.destroy', $user->id) }}"
                                    data-type="user">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                            @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 px-6 text-center text-slate-400 text-sm">Không tìm thấy người dùng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>

@endsection