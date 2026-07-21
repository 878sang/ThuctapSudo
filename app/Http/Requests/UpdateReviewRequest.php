<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'title' => ['nullable', 'string', 'max:255'],
            'comment' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'rating.min' => 'Số sao đánh giá phải từ 1 đến 5.',
            'rating.max' => 'Số sao đánh giá phải từ 1 đến 5.',
            'comment.required' => 'Vui lòng nhập nội dung đánh giá.',
            'comment.max' => 'Nội dung đánh giá không được vượt quá 1000 ký tự.',
        ];
    }
}
