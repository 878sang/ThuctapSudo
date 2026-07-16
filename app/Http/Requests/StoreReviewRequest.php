<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
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
            'comment' => ['required', 'string', 'max:1000'],
            'title' => ['nullable', 'string', 'max:255'],
            'user_name' => ['required', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'parent_id' => ['nullable', 'exists:reviews,id'],
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
            'comment.required' => 'Vui lòng nhập nội dung đánh giá.',
            'comment.max' => 'Nội dung đánh giá không được vượt quá 1000 ký tự.',
            'user_name.required' => 'Vui lòng nhập tên của bạn.',
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'rating.min' => 'Số sao đánh giá phải từ 1 đến 5.',
            'rating.max' => 'Số sao đánh giá phải từ 1 đến 5.',
            'parent_id.exists' => 'Bình luận phản hồi không hợp lệ.',
        ];
    }
}
