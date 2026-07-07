<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
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
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'status' => ['required', 'boolean'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên thương hiệu.',
            'description.required' => 'Vui lòng nhập mô tả thương hiệu.',
            'logo.image' => 'Logo phải là định dạng ảnh.',
            'logo.mimes' => 'Logo chỉ chấp nhận các định dạng jpeg, png, jpg, gif.',
            'logo.max' => 'Kích thước logo không được vượt quá 2MB.',
            'status.required' => 'Vui lòng chọn trạng thái thương hiệu.',
        ];
    }
}
