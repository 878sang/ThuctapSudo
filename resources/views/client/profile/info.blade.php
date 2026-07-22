@extends('client.layout.main')

@section('content')
<div class="bg-[#F4F8FA] min-h-screen py-6 rounded-[5px]">
    {{-- Breadcrumb --}}
    <div class="max-w-[1440px] mx-auto px-4 mb-4">
        <x-breadcrumb :items="[
            ['label' => 'Tổng quan tài khoản', 'url' => route('profile')],
            ['label' => 'Thông tin tài khoản']
        ]" />
    </div>

    {{-- Main Container --}}
    <div class="max-w-[1440px] mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            {{-- Left Sidebar --}}
            @include('client.profile.sidebar', ['active' => 'info'])

            {{-- Right Content --}}
            <main class="w-full lg:w-[73%] flex flex-col gap-6">
                <div class="bg-white rounded-[10px] shadow-sm p-6" x-data="{
                    type: '{{ old('type', $user->type ?? 'personal') }}',
                    displayName: '{{ old('display_name', $user->display_name ?? '') }}',
                    fullName: '{{ old('name', $user->name ?? '') }}',
                    email: '{{ old('email', $user->email ?? '') }}',
                    phone: '{{ old('phone', $user->phone ?? '') }}',
                    gender: '{{ old('gender', $user->gender ?? 'Nam') }}',
                    avatarPreview: '{{ $user->avatar_url }}',
                    
                    previewAvatar(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.avatarPreview = URL.createObjectURL(file);
                        }
                    }
                }">
                    <h2 class="text-[22px] font-bold text-gray-800 mb-6">Thông tin tài khoản</h2>

                    <form action="{{ route('profile.info.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Account Type Selection --}}
                        <div class="flex items-center gap-6 mb-6">
                            <input type="hidden" name="type" :value="type">

                            <x-radio-button model="type" value="personal" label="Tài khoản cá nhân" />
                            <x-radio-button model="type" value="business" label="Tài khoản doanh nghiệp" />
                        </div>

                        {{-- Avatar Upload Section --}}
                        <div class="relative w-28 h-28 mb-8">
                            <div class="w-full h-full rounded-full overflow-hidden border border-gray-200 shadow-sm bg-gray-100">
                                <img :src="avatarPreview" class="w-full h-full object-cover" alt="Avatar">
                            </div>
                            <label for="avatar-input" class="absolute bottom-1 right-1 bg-white w-8 h-8 rounded-full shadow-md border border-gray-100 flex items-center justify-center cursor-pointer hover:bg-gray-50 transition-colors">
                                <svg class="w-4 h-4 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" @change="previewAvatar($event)">
                            </label>
                        </div>

                        {{-- Form Layout Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                            {{-- Left Column --}}
                            <div class="flex flex-col gap-6">
                                {{-- Tên hiển thị --}}
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-sm font-semibold text-gray-500">Tên hiển thị</label>
                                    <div class="relative">
                                        <input type="text" name="display_name" x-model="displayName"
                                            class="w-full border border-gray-200 rounded-[10px] py-3.5 px-4 pr-10 text-base font-semibold text-[#003870] focus:outline-none focus:border-[#0165FC] bg-white shadow-sm"
                                            placeholder="Nhập tên hiển thị">
                                        <button type="button" x-show="displayName.length > 0" @click="displayName = ''"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 bg-transparent p-1 cursor-pointer">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Tên đầy đủ --}}
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-sm font-semibold text-gray-500">Tên đầy đủ <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="text" name="name" x-model="fullName"
                                            class="w-full border border-gray-200 rounded-[10px] py-3.5 px-4 pr-10 text-base font-semibold text-[#003870] focus:outline-none focus:border-[#0165FC] bg-white shadow-sm"
                                            placeholder="Nhập họ và tên đầy đủ">
                                        <button type="button" x-show="fullName.length > 0" @click="fullName = ''"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 bg-transparent p-1 cursor-pointer">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Sinh nhật --}}
                                @php
                                $day = null;
                                $month = null;
                                $year = null;
                                if (!empty($user->dob)) {
                                $dobTime = strtotime($user->dob);
                                if ($dobTime) {
                                $day = (int)date('d', $dobTime);
                                $month = (int)date('m', $dobTime);
                                $year = (int)date('Y', $dobTime);
                                }
                                }
                                @endphp
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-sm font-semibold text-gray-500">Sinh nhật <span class="text-red-500">*</span></label>
                                    <div class="flex gap-3">
                                        {{-- Day --}}
                                        <div class="relative shrink-0">
                                            <select name="dob_day" class="appearance-none text-center w-16 border border-gray-200 rounded-[10px] py-3.5 px-2 text-base font-semibold text-[#003870] focus:outline-none focus:border-[#0165FC] bg-white shadow-sm cursor-pointer">
                                                @for($d = 1; $d <= 31; $d++)
                                                    <option value="{{ $d }}" {{ (old('dob_day', $day) == $d || ($day === null && $d === 1)) ? 'selected' : '' }}>
                                                    {{ sprintf('%02d', $d) }}
                                                    </option>
                                                    @endfor
                                            </select>
                                        </div>
                                        {{-- Month --}}
                                        <div class="relative shrink-0">
                                            <select name="dob_month" class="appearance-none text-center w-16 border border-gray-200 rounded-[10px] py-3.5 px-2 text-base font-semibold text-[#003870] focus:outline-none focus:border-[#0165FC] bg-white shadow-sm cursor-pointer">
                                                @for($m = 1; $m <= 12; $m++)
                                                    <option value="{{ $m }}" {{ (old('dob_month', $month) == $m || ($month === null && $m === 1)) ? 'selected' : '' }}>
                                                    {{ sprintf('%02d', $m) }}
                                                    </option>
                                                    @endfor
                                            </select>
                                        </div>
                                        {{-- Year --}}
                                        <div class="relative shrink-0">
                                            <select name="dob_year" class="appearance-none text-center w-24 border border-gray-200 rounded-[10px] py-3.5 px-2 text-base font-semibold text-[#003870] focus:outline-none focus:border-[#0165FC] bg-white shadow-sm cursor-pointer">
                                                @for($y = now()->year; $y >= 1920; $y--)
                                                <option value="{{ $y }}" {{ (old('dob_year', $year) == $y || ($year === null && $y === 1990)) ? 'selected' : '' }}>
                                                    {{ $y }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Giới tính --}}
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-sm font-semibold text-gray-500">Giới tính <span class="text-red-500">*</span></label>
                                    <div class="flex gap-4">
                                        <!-- Nam -->
                                        <label class="flex items-center gap-3.5 py-3.5 px-5 rounded-[10px] bg-white cursor-pointer select-none">
                                            <input type="radio" name="gender" value="Nam" x-model="gender" class="hidden">
                                            <div class="w-6 h-6 rounded flex items-center justify-center border transition-all"
                                                :class="gender === 'Nam' ? 'bg-[#4CD964] border-[#4CD964] text-white' : 'border-gray-300 bg-white'">
                                                <svg x-show="gender === 'Nam'" class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span class="text-base font-semibold text-gray-800">Nam</span>
                                        </label>
                                        <!-- Nữ -->
                                        <label class="flex items-center gap-3.5 py-3.5 px-5 rounded-[10px] bg-white cursor-pointer select-none">
                                            <input type="radio" name="gender" value="Nữ" x-model="gender" class="hidden">
                                            <div class="w-6 h-6 rounded flex items-center justify-center border transition-all"
                                                :class="gender === 'Nữ' ? 'bg-[#4CD964] border-[#4CD964] text-white' : 'border-gray-300 bg-white'">
                                                <svg x-show="gender === 'Nữ'" class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span class="text-base font-semibold text-gray-800">Nữ</span>
                                        </label>
                                        <!-- Khác -->
                                        <label class="flex items-center gap-3.5 py-3.5 px-5 rounded-[10px] bg-white cursor-pointer select-none">
                                            <input type="radio" name="gender" value="Khác" x-model="gender" class="hidden">
                                            <div class="w-6 h-6 rounded flex items-center justify-center border transition-all"
                                                :class="gender === 'Khác' ? 'bg-[#4CD964] border-[#4CD964] text-white' : 'border-gray-300 bg-white'">
                                                <svg x-show="gender === 'Khác'" class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <span class="text-base font-semibold text-gray-800">Khác</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- Right Column --}}
                            <div class="flex flex-col gap-6">
                                {{-- Email --}}
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-sm font-semibold text-gray-500">Email <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="email" name="email" x-model="email"
                                            class="w-full border border-gray-200 rounded-[10px] py-3.5 px-4 pr-10 text-base font-semibold text-[#003870] focus:outline-none focus:border-[#0165FC] bg-white shadow-sm"
                                            placeholder="example@hoaphat.com.vn">
                                        <button type="button" x-show="email.length > 0" @click="email = ''"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 bg-transparent p-1 cursor-pointer">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Số điện thoại --}}
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-sm font-semibold text-gray-500">Số điện thoại <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="text" name="phone" x-model="phone"
                                            class="w-full border border-gray-200 rounded-[10px] py-3.5 px-4 pr-10 text-base font-semibold text-[#003870] focus:outline-none focus:border-[#0165FC] bg-white shadow-sm"
                                            placeholder="(+84) 988-038-291">
                                        <button type="button" x-show="phone.length > 0" @click="phone = ''"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 bg-transparent p-1 cursor-pointer">
                                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Buttons: Save & Cancel --}}
                                <div class="flex gap-4 mt-4">
                                    <button type="submit" class="flex-1 bg-[#0165FC] hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-lg transition-colors cursor-pointer text-center text-sm">
                                        Lưu thay đổi
                                    </button>
                                    <a href="{{ route('profile.info') }}" class="flex-1 bg-[#F0F2F5] hover:bg-gray-200 text-[#4E4E4E] font-bold py-4 px-6 rounded-lg transition-colors text-center text-sm cursor-pointer">
                                        Hủy
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </main>

        </div>
    </div>
</div>
@endsection