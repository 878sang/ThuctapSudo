<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'detail' => 'required|string',
            'status' => 'required|in:0,1',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc',
            'description.required' => 'Mô tả sản phẩm là bắt buộc',
            'avatar.required' => 'Ảnh sản phẩm là bắt buộc',
            'avatar.max' => 'Ảnh sản phẩm không được vượt quá 2MB',
            'avatar.mimes' => 'Ảnh sản phẩm phải là định dạng jpeg,png,jpg,gif',
            'category_id.required' => 'Danh mục là bắt buộc',
            'category_id.exists' => 'Danh mục không tồn tại',
            'images.required' => 'Ảnh sản phẩm là bắt buộc',
            'images.max' => 'Ảnh sản phẩm không được vượt quá 2MB',
            'images.mimes' => 'Ảnh sản phẩm phải là định dạng jpeg,png,jpg,gif',
            'detail.required' => 'Chi tiết sản phẩm là bắt buộc',
            'status.required' => 'Trạng thái sản phẩm là bắt buộc',
        ];
    }
}
