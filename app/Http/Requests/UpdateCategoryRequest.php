<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $this->route('id'),
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'parent_id.exists' => 'Danh mục cha không tồn tại',
            'parent_id.not_in' => 'Danh mục cha không được là chính nó',
            'name.required' => 'Tên danh mục là bắt buộc',
            'description.required' => 'Mô tả danh mục là bắt buộc',
            'avatar.max' => 'Ảnh danh mục không được vượt quá 2MB',
            'avatar.mimes' => 'Ảnh danh mục phải là định dạng jpeg,png,jpg,gif',
            'status.required' => 'Trạng thái danh mục là bắt buộc',
        ];
    }
}
