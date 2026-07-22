@extends('client.layout.main')

@section('content')
<div class="bg-[#F4F8FA] min-h-screen py-6 rounded-[5px]">
    {{-- Breadcrumb --}}
    <div class="max-w-[1440px] mx-auto px-4 mb-4">
        <x-breadcrumb :items="[
            ['label' => 'Tổng quan tài khoản', 'url' => route('profile')],
            ['label' => 'Quản lý báo giá']
        ]" />
    </div>

    {{-- Main Container --}}
    <div class="max-w-[1440px] mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            @include('client.profile.sidebar', ['active' => 'quotes'])

            <main class="w-full lg:w-[73%] flex flex-col gap-6">

                <div class="bg-white rounded-[10px] shadow-sm p-6">
                    <h2 class="text-[22px] font-bold text-gray-800 mb-6">Quản lý đơn hàng</h2>

                    {{-- Filters Area --}}
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <div class="flex flex-wrap items-center gap-4">
                            {{-- Time Filter --}}
                            <div class="flex items-center gap-3 text-sm text-gray-600">
                                <span class="font-semibold text-gray-500">Chọn thời gian</span>
                                <div class="relative">
                                    <button type="button"
                                        class="bg-[#EBF3FF] text-[#0165FC] font-semibold py-2.5 px-4 rounded-lg text-sm flex items-center gap-3 focus:outline-none cursor-pointer transition-colors hover:bg-[#D4E6FF] select-none">
                                        <span>26 thg 10, 2023 - 27 thg 10, 2024</span>
                                        <svg class="w-4 h-4 text-[#0165FC] shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Status Filter --}}
                            <div class="relative">
                                <select class="appearance-none bg-[#EBF3FF] text-[#0165FC] font-semibold py-2.5 pl-4 pr-10 rounded-lg text-sm focus:outline-none cursor-pointer">
                                    <option value="all">Trạng thái</option>
                                    <option value="pending">Chưa phản hồi</option>
                                    <option value="quoted">Đã báo giá</option>
                                </select>
                                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-[#0165FC]">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Search Input --}}
                        <div class="relative w-full md:w-72">
                            <input type="text"
                                class="w-full bg-[#F5F5F5] text-gray-700 py-2.5 pl-4 pr-10 rounded-lg text-sm border-none focus:outline-none focus:ring-1 focus:ring-[#0165FC]"
                                placeholder="Nhập tên sản phẩm">
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Table Area --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border border-[#E9E9E9]">
                            <thead>
                                <tr class="bg-8 border-b border-[#E9E9E9]">
                                    <th class="text-center px-4 py-3 font-semibold text-[#0165FC] rounded-l-lg border-r border-[#E9E9E9]">Mã báo giá</th>
                                    <th class="text-center px-4 py-3 font-semibold text-[#0165FC] border-r border-[#E9E9E9]">Ngày gửi</th>
                                    <th class="text-center px-4 py-3 font-semibold text-[#0165FC] border-r border-[#E9E9E9]">Tình trạng</th>
                                    <th class="text-center px-4 py-3 font-semibold text-[#0165FC] border-r border-[#E9E9E9]">Ngày báo giá</th>
                                    <th class="text-center px-4 py-3 font-semibold text-[#0165FC] border-r border-[#E9E9E9]">Tổng tiền</th>
                                    <th class="text-center px-4 py-3 font-semibold text-[#0165FC] border-r border-[#E9E9E9]">Người báo giá</th>
                                    <th class="text-center px-4 py-3 font-semibold text-[#0165FC] rounded-r-lg">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#E9E9E9]">
                                {{-- Row 1: Chưa phản hồi --}}
                                <tr class="hover:bg-gray-50/50 transition-colors border-b border-[#E9E9E9]">
                                    <td class="px-4 py-4 text-center font-bold text-gray-900 border-r border-[#E9E9E9] whitespace-nowrap">#0123456</td>
                                    <td class="px-4 py-4 text-center font-normal text-gray-700 border-r border-[#E9E9E9] whitespace-nowrap">15/07/2024</td>
                                    <td class="px-4 py-4 text-center border-r border-[#E9E9E9] whitespace-nowrap">
                                        <span class="font-normal text-[#EB7507]">Chưa phản hồi</span>
                                    </td>
                                    <td class="px-4 py-4 text-center border-r border-[#E9E9E9] whitespace-nowrap"></td>
                                    <td class="px-4 py-4 text-center border-r border-[#E9E9E9] whitespace-nowrap"></td>
                                    <td class="px-4 py-4 text-center border-r border-[#E9E9E9] whitespace-nowrap"></td>
                                    <td class="px-4 py-4 text-center whitespace-nowrap"></td>
                                </tr>

                                {{-- Rows 2 to 8: Đã báo giá --}}
                                @for ($i = 0; $i < 7; $i++)
                                    <tr class="hover:bg-gray-50/50 transition-colors border-b border-[#E9E9E9] last:border-b-0">
                                    <td class="px-4 py-4 text-center font-bold text-gray-900 border-r border-[#E9E9E9] whitespace-nowrap">#0123456</td>
                                    <td class="px-4 py-4 text-center font-normal text-gray-700 border-r border-[#E9E9E9] whitespace-nowrap">15/07/2024</td>
                                    <td class="px-4 py-4 text-center border-r border-[#E9E9E9] whitespace-nowrap">
                                        <span class="font-normal text-[#0165FC]">Đã báo giá</span>
                                    </td>
                                    <td class="px-4 py-4 text-center font-normal text-gray-700 border-r border-[#E9E9E9] whitespace-nowrap">18/07/2024</td>
                                    <td class="px-4 py-4 text-center font-normal text-gray-800 border-r border-[#E9E9E9] whitespace-nowrap">135.000.000đ</td>
                                    <td class="px-4 py-4 text-center border-r border-[#E9E9E9] whitespace-nowrap">
                                        <div class="flex flex-col items-center justify-center leading-snug">
                                            <span class="text-gray-700 font-normal text-sm">Admin</span>
                                            <span class="text-[#0165FC] font-normal text-sm">0973924463</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-center whitespace-nowrap">
                                        <div class="flex flex-col gap-2 items-center justify-center">
                                            <a href="#" class="w-[130px] bg-[#E9E9E9] hover:bg-gray-300 text-gray-700 font-normal py-2 px-3 rounded-[8px] text-sm text-center transition-colors">
                                                Xem chi tiết
                                            </a>
                                            <a href="#" class="w-[130px] bg-[#3590CE] hover:bg-blue-600 text-white font-normal py-2 px-3 rounded-[8px] text-sm text-center transition-colors">
                                                Báo giá
                                            </a>
                                        </div>
                                    </td>
                                    </tr>
                                    @endfor
                            </tbody>
                        </table>
                    </div>

                    {{-- Bottom Pagination Area --}}
                    <div class="flex items-center justify-between mt-6 select-none">
                        <div class="flex items-center gap-2.5">
                            <button type="button"
                                class="w-[40px] h-[40px] bg-9 hover:bg-[#d6e5ff] text-[#006DF0] flex items-center justify-center rounded-[10px] transition-colors cursor-pointer border-none">
                                <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.5 7.5H1.5M1.5 7.5L7.5 1.5M1.5 7.5L7.5 13.5" stroke="#1F4388" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button type="button"
                                class="h-[40px] bg-[#006DF0] hover:bg-[#005ecf] text-white flex items-center gap-2.5 p-3 rounded-[5px] text-sm cursor-pointer transition-colors border-none select-none">
                                <span>Xem tiếp</span>
                                <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1.5 7.5H16.5M16.5 7.5L10.5 1.5M16.5 7.5L10.5 13.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex items-center gap-2 text-sm text-4">
                            <span>Trang</span>
                            <div class="w-[40px] h-[40px] border border-4 flex items-center justify-center rounded-[5px] bg-white">
                                <span class="font-bold text-gray-700">2</span>
                            </div>
                            <span>của <span class="font-bold">10</span></span>
                        </div>
                    </div>
                </div>

            </main>

        </div>
    </div>
</div>
@endsection