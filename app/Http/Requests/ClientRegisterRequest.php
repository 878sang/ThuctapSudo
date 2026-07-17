<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRegisterRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone|regex:/^0[0-9]{9}$/',
            'password' => 'required|string|min:6|confirmed',
            'day' => 'required|integer|between:1,31',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'gender' => 'required|string|in:Nam,Nữ,Khác',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Họ và tên là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email này đã được sử dụng',
            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.unique' => 'Số điện thoại này đã được sử dụng',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'day.required' => 'Ngày sinh là bắt buộc',
            'month.required' => 'Tháng sinh là bắt buộc',
            'year.required' => 'Năm sinh là bắt buộc',
            'gender.required' => 'Giới tính là bắt buộc',
        ];
    }
}
