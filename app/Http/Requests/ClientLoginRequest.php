<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientLoginRequest extends FormRequest
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
            'login' => 'required|string',
            'password' => 'required|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'login.required' => 'Email hoặc Số điện thoại là bắt buộc',
            'password.required' => 'Mật khẩu là bắt buộc',
        ];
    }
}
