<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->id ?? Auth::id();

        return [
            'name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'phone' => 'required|string|max:20|unique:users,phone,' . $userId . '|regex:/^0[0-9]{9}$/',
            'gender' => 'required|string|in:Nam,Nữ,Khác',
            'avatar' => 'nullable|image|max:2048',
            'dob' => 'nullable|date',
            'dob_day' => 'nullable|integer|between:1,31',
            'dob_month' => 'nullable|integer|between:1,12',
            'dob_year' => 'nullable|integer|between:1920,' . now()->year,
            'role' => 'nullable|string|in:super_admin,staff,customer',
            'password' => 'nullable|string|min:6|confirmed',
        ];
    }

    /**
     * Get the custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Họ và tên không được để trống.',
            'gender.required' => 'Giới tính không được để trống.',
            'gender.in' => 'Giới tính không hợp lệ.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.unique' => 'Số điện thoại này đã được sử dụng.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'avatar.image' => 'Ảnh đại diện phải là định dạng hình ảnh.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2MB.',
            'password.min' => 'Mật khẩu phải từ 6 ký tự trở lên.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'role.in' => 'Vai trò không hợp lệ.',
            'role.required' => 'Vai trò không được để trống.',
            'dob.date' => 'Ngày sinh không hợp lệ.',
            'dob_day.between' => 'Ngày sinh không hợp lệ.',
            'dob_month.between' => 'Tháng sinh không hợp lệ.',
            'dob_year.between' => 'Năm sinh không hợp lệ.',
            'display_name.max' => 'Tên hiển thị không được vượt quá 255 ký tự.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',

        ];
    }
}
