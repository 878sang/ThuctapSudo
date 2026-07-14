<form id="filter-form" action="{{ route('products.showClient') }}" method="get" class="w-full lg:w-1/4">
    <div class="bg-white p-5 flex-shrink-0 bg-white rounded-xl">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-[#D9D9D9]">
            <div class="flex items-center gap-3 text-2 font-bold text-lg text-2">
                <svg width="19" height="18" viewBox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_746_37356)">
                        <path d="M11.0072 18C10.8266 18 10.646 17.95 10.4992 17.85L7.11212 15.6C6.8976 15.46 6.77341 15.24 6.77341 15V10.78L0.834741 4.86C-0.384605 3.66 -0.249122 1.81 1.117 0.74C1.71538 0.26 2.49441 0 3.29601 0H15.3201C17.1491 0 18.6169 1.31 18.6169 2.93C18.6169 3.64 18.3233 4.33 17.7814 4.87L11.8427 10.79V17.26C11.8427 17.67 11.4589 18.01 10.996 18.01L11.0072 18ZM8.46694 14.62L10.1605 15.74V10.49C10.1605 10.31 10.2395 10.13 10.375 9.99L16.5282 3.86C17.1153 3.27 17.0475 2.37 16.3814 1.85C16.0879 1.62 15.7153 1.5 15.3201 1.49H3.29601C2.40408 1.49 1.6928 2.13 1.6928 2.92C1.6928 3.27 1.83957 3.6 2.09925 3.86L8.25243 9.99C8.38791 10.13 8.46694 10.31 8.46694 10.49V14.61V14.62Z" fill="#202F36" />
                    </g>
                    <defs>
                        <clipPath id="clip0_746_37356">
                            <rect width="18.6176" height="18" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
                <span>Bộ lọc</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-7 cursor-pointer hover:underline">Xóa tất cả</span>
            </div>
        </div>
        <div class="space-y-4">
            <div x-data="{ open: false, selectedId: '{{ $selectedCategory->id ?? '' }}', selectedName: '{{ $selectedCategory->name ?? '' }}' }" x-init="let form = $el.closest('form'); $watch('selectedId', () => form.submit())" @click.outside="open = false" class="relative">
                <label class="block text-sm font-bold text-2 mb-2.5">Danh mục sản phẩm</label>
                <div @click="open = !open"
                    :class="selectedId ? 'border-[#D9D9D9] bg-white' : 'border-[#D9D9D9] bg-white hover:border-gray-300'"
                    class="w-full min-h-[44px] border rounded-[5px] text-sm cursor-pointer flex items-center gap-2 flex-wrap">
                    <template x-if="selectedId">
                        <div>
                            <span class="flex items-center gap-5 bg-[#DDECFF] text-gray-700 font-medium rounded-[5px] m-1 px-4 py-2.5 text-sm flex-1">
                                <span x-text="selectedName"></span>
                                <button type="button" @click.stop="selectedId = null; selectedName = null" class="w-[22px] h-[22px] rounded-full bg-[#006DF0] flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-xmark text-white" style="font-size:10px"></i>
                                </button>
                            </span>
                        </div>
                    </template>
                    <template x-if="!selectedId">
                        <span class="text-gray-400 mx-2.5 my-4">Chọn danh mục sản phẩm</span>
                    </template>
                    <span class="ml-auto flex-shrink-0">
                    </span>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="filter-dropdown-list absolute left-0 right-0 mt-1 bg-white border border-gray-100 rounded-lg shadow-xl z-50 max-h-72 overflow-y-auto py-2" style="display:none">
                    @foreach ($categories as $item)
                    <div @click="selectedId = '{{ $item->id }}'; selectedName = '{{ $item->name }}'; open = false"
                        :class="selectedId === '{{ $item->id }}' ? 'bg-blue-50/60' : ''"
                        class="px-6 py-[10px] text-sm font-semibold text-7 uppercase cursor-pointer hover:bg-blue-50/60 transition-colors">{{ $item->name }}</div>
                    @endforeach
                </div>
                <input type="hidden" name="category" :value="selectedId">
            </div>
        </div>
        <div class="space-y-4">
            <div x-data="{ open: false, selectedId: '{{ $selectedBrand->id ?? '' }}', selectedName: '{{ $selectedBrand->name ?? '' }}' }" x-init="let form = $el.closest('form'); $watch('selectedId', () => form.submit())" @click.outside="open = false" class="relative">
                <label class="block text-sm font-bold text-2 mb-2.5">Thương hiệu</label>
                <div @click="open = !open"
                    :class="selectedId ? 'border-[#D9D9D9] bg-white' : 'border-[#D9D9D9] bg-white hover:border-gray-300'"
                    class="w-full min-h-[44px] border rounded-[5px] text-sm cursor-pointer flex items-center gap-2 flex-wrap">
                    <template x-if="selectedId">
                        <div>
                            <span class="flex items-center gap-5 bg-[#DDECFF] text-gray-700 font-medium rounded-[5px] m-1 px-4 py-2.5 text-sm flex-1">
                                <span x-text="selectedName"></span>
                                <button type="button" @click.stop="selectedId = null; selectedName = null" class="w-[22px] h-[22px] rounded-full bg-[#006DF0] flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-xmark text-white" style="font-size:10px"></i>
                                </button>
                            </span>
                        </div>
                    </template>
                    <template x-if="!selectedId">
                        <span class="text-gray-400 mx-2.5 my-4">Chọn thương hiệu sản phẩm</span>
                    </template>
                    <span class="ml-auto flex-shrink-0">
                    </span>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="filter-dropdown-list absolute left-0 right-0 mt-1 bg-white border border-gray-100 rounded-lg shadow-xl z-50 max-h-72 overflow-y-auto py-2" style="display:none">
                    @foreach ($brands as $item)
                    <div @click="selectedId = '{{ $item->id }}'; selectedName = '{{ $item->name }}'; open = false"
                        :class="selectedId === '{{ $item->id }}' ? 'bg-blue-50/60' : ''"
                        class="px-6 py-[10px] text-sm font-semibold text-7 uppercase cursor-pointer hover:bg-blue-50/60 transition-colors">{{ $item->name }}</div>
                    @endforeach
                </div>
                <input type="hidden" name="brand" :value="selectedId">
            </div>
        </div>
        <input type="hidden" id="sort-input" name="sort" value="{{ request('sort') }}">
    </div>
</form>