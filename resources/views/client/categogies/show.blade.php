@extends('client.layout.main')
@section('content')
<div class="pt-6 bg-8 min-h-screen rounded-[5px] pb-12">
    <div class="max-w-[1440px] mx-auto">
        <x-breadcrumb :items="[
            ['label' => 'Toàn bộ danh mục sản phẩm'],
        ]" />
    </div>
    <div class="max-w-[1440px] mx-auto bg-white p-5">
        <div class="grid-masonry">
            <div class="grid-sizer w-full sm:w-1/2 md:w-1/3 lg:w-1/4"></div>
            @foreach ($categories as $category)
            <div class="grid-item w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2.5 mb-5">
                <div class="rounded-xl flex flex-col">
                    <div class="bg-8 rounded-[5px] mb-2.5 text-7 text-base font-bold py-4 px-5">
                        <a href="#" class="no-underline">
                            {{ $category['name'] }}
                        </a>
                    </div>
                    <div class="flex flex-col">
                        @foreach ($category['children'] as $child)
                        <div class="text-sm py-2.5 px-5 hover:text-7 transition-all duration-150">
                            <a href="#" class="no-underline text-gray-600 hover:text-7 flex items-center">
                                <span>{{ $child }}</span>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection