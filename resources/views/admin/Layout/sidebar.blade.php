<aside id="sidebar" class=" min-h-screen  flex w-72 flex-col bg-slate-950 text-slate-200 border-r border-slate-800/80">
    <div class="flex-1 overflow-y-auto px-4 py-6 custom-scrollbar space-y-7">
        @if(auth()->user()->role == 'super_admin')
        <div>
            <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Danh Mục Sản Phẩm</p>
            <div class="mt-3 space-y-1">
                <a href="{{ route('admin.categories.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.categories.index') || request()->routeIs('admin.categories.show') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span>Danh Sách Danh Mục</span>
                </a>
                <a href="{{ route('admin.categories.create') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.categories.create') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Thêm Danh Mục</span>
                </a>
            </div>
        </div>
        @endif
        <div>
            <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Sản Phẩm</p>
            <div class="mt-3 space-y-1">
                <a href="{{ route('admin.products.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.products.index') || request()->routeIs('admin.products.show') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span>Danh Sách Sản Phẩm</span>
                </a>
                <a href="{{ route('admin.products.create') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.products.create') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <span>Thêm Sản Phẩm</span>
                </a>
            </div>
        <div>
            <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Khuyến Mãi</p>
            <div class="mt-3 space-y-1">
                <a href="{{ route('admin.coupons.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.coupons.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 11h10M7 15h10M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                    </svg>
                    <span>Mã Giảm Giá</span>
                </a>
            </div>
        </div>
        <div class="mt-6">
            <form action="{{ route('admin.auth.logout') }}" method="POST">
                @csrf
                <button type="submit" class="group flex w-full items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 text-slate-400 hover:bg-slate-900 hover:text-slate-100">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Đăng Xuất</span>
                </button>
            </form>
        </div>
    </div>
</aside>

