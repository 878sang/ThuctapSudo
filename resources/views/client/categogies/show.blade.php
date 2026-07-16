@extends('client.layout.main')
@section('content')
<div class="pt-6 bg-blue_bg min-h-screen rounded-[5px] pb-12">
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
                        <a href="{{ route('products.showClient', ['category' => $category->id]) }}" class="no-underline">
                            {{ $category->name }}
                        </a>
                    </div>
                    <div class="text-2 text-sm">
                        @foreach ($category->activeChildren as $subCategory)
                        <div class="px-5 py-2.5">
                            <a href="{{ route('products.showClient', ['category' => $subCategory->id]) }}" class="no-underline">
                                {{ $subCategory->name }}
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