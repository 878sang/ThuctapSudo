<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $userId = Auth::id();

        return [
            'type' => 'required|string|in:personal,business',
            'display_name' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'dob_day' => 'required|integer|between:1,31',
            'dob_month' => 'required|integer|between:1,12',
            'dob_year' => 'required|integer|between:1920,' . now()->year,
            'gender' => 'required|string|in:Nam,Nữ,Khác',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'phone' => 'required|string|max:20|unique:users,phone,' . $userId,
            'avatar' => 'nullable|image|max:2048',
        ];
    }

    /**
     * Get the custom validation messages.
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Loại tài khoản không được để trống.',
            'type.in' => 'Loại tài khoản không hợp lệ.',
            'name.required' => 'Họ và tên không được để trống.',
            'dob_day.required' => 'Ngày sinh không được để trống.',
            'dob_month.required' => 'Tháng sinh không được để trống.',
            'dob_year.required' => 'Năm sinh không được để trống.',
            'gender.required' => 'Giới tính không được để trống.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',
            'avatar.image' => 'Ảnh đại diện phải là định dạng hình ảnh.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
        ];
    }
}
