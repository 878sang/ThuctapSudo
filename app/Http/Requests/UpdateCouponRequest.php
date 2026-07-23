<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id') ?? $this->route('coupon');

        return [
            'code'                => ['required', 'string', 'max:50', Rule::unique('coupons', 'code')->ignore($id)],
            'name'                => 'required|string|max:255',
            'type'                => 'required|in:percent,fixed',
            'value'               => 'required|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'min_order_amount'    => 'nullable|numeric|min:0',
            'usage_limit'         => 'nullable|integer|min:1',
            'user_limit'          => 'nullable|integer|min:1',
            'start_date'          => 'nullable|date',
            'end_date'            => 'nullable|date|after_or_equal:start_date',
            'is_active'           => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required'      => 'Vui lòng nhập mã giảm giá.',
            'code.unique'        => 'Mã giảm giá này đã tồn tại.',
            'name.required'      => 'Vui lòng nhập tên chương trình.',
            'type.required'      => 'Vui lòng chọn loại giảm giá.',
            'value.required'     => 'Vui lòng nhập giá trị giảm.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ];
    }
}
