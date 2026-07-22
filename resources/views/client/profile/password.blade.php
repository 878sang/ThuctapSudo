@extends('client.layout.main')

@section('content')
<div class="bg-[#F4F8FA] min-h-screen py-6 rounded-[5px]">
    <div class="max-w-[1440px] mx-auto px-4 mb-4">
        <x-breadcrumb :items="[
            ['label' => 'Tổng quan tài khoản', 'url' => route('profile')],
            ['label' => 'Đổi mật khẩu']
        ]" />
    </div>

    <div class="max-w-[1440px] mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6 items-start">
            @include('client.profile.sidebar', ['active' => 'password'])

            <main class="w-full lg:w-[73%] bg-white rounded-[10px] shadow-sm p-6">
                <h2 class="text-[22px] font-bold text-gray-800 pb-4 border-b border-gray-100 mb-6">Đổi mật khẩu</h2>
                <div class="flex flex-col lg:flex-row gap-8 items-stretch">
                    <div class="w-full lg:w-[40%] flex flex-col justify-between" x-data="{ showOld: false, showNew: false, showConfirm: false }">
                        <form action="{{ route('profile.password.update') }}" method="POST" class="space-y-5">
                            @csrf

                            {{-- Old Password --}}
                            <div class="flex flex-col gap-2.5">
                                <label class="text-sm text-gray-600">Mật khẩu cũ <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input :type="showOld ? 'text' : 'password'" name="old_password" required
                                        class="w-full border border-gray-200 focus:border-[#0165FC] rounded-[18px] py-4 pl-5 pr-12 text-[15px] font-semibold text-gray-700 focus:outline-none bg-white transition-colors @error('old_password', 'update_password') border-red-500 @enderror"
                                        placeholder="Abcd@123456789">
                                    <button type="button" @click="showOld = !showOld" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer p-1">
                                        <template x-if="showOld">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </template>
                                        <template x-if="!showOld">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                            </svg>
                                        </template>
                                    </button>
                                </div>
                                @error('old_password', 'update_password')
                                <span class="text-xs text-red-500 font-semibold ml-1">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- New Password --}}
                            <div class="flex flex-col gap-2.5">
                                <label class="text-sm text-gray-600">Mật khẩu mới <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input :type="showNew ? 'text' : 'password'" name="password" required
                                        class="w-full border border-gray-200 focus:border-[#0165FC] rounded-[18px] py-4 pl-5 pr-12 text-[15px] font-semibold text-gray-700 focus:outline-none bg-white transition-colors @error('password', 'update_password') border-red-500 @enderror"
                                        placeholder="*****************">
                                    <button type="button" @click="showNew = !showNew" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer p-1">
                                        <template x-if="showNew">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </template>
                                        <template x-if="!showNew">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                            </svg>
                                        </template>
                                    </button>
                                </div>
                                @error('password', 'update_password')
                                <span class="text-xs text-red-500 font-semibold ml-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex flex-col gap-2.5">
                                <label class="text-sm text-gray-600">Xác nhận lại mật khẩu mới <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                                        class="w-full border border-gray-200 focus:border-[#0165FC] rounded-[18px] py-4 pl-5 pr-12 text-[15px] font-semibold text-gray-700 focus:outline-none bg-white transition-colors"
                                        placeholder="*****************">
                                    <button type="button" @click="showConfirm = !showConfirm" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none cursor-pointer p-1">
                                        <template x-if="showConfirm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </template>
                                        <template x-if="!showConfirm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5.5 h-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                            </svg>
                                        </template>
                                    </button>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex items-center gap-4 pt-4">
                                <button type="submit"
                                    class="bg-[#0165FC] hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-[16px] text-base transition-colors cursor-pointer select-none border-none">
                                    Lưu thay đổi
                                </button>
                                <a href="{{ route('profile.password')}}"
                                    class="bg-[#EFEFEF] hover:bg-gray-200 text-[#595959] font-bold py-3.5 px-8 rounded-[16px] text-base transition-colors text-center cursor-pointer select-none decoration-none">
                                    Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="w-full lg:w-[60%] flex items-center justify-center">
                        <img src="{{ asset('storage/images/doimatkhau.jpg') }}" class="w-full h-full object-cover rounded-[20px] shadow-sm max-h-[480px]">
                    </div>
                </div>

            </main>
        </div>
    </div>
</div>
@endsection