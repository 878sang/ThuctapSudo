<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'address_method' => 'required|string|in:account,new',
            'customer_name' => 'required_if:address_method,new|nullable|string|max:255',
            'customer_phone' => ['required_if:address_method,new', 'nullable', 'string'],
            'province' => 'required_if:address_method,new|nullable|string|max:100',
            'district' => 'required_if:address_method,new|nullable|string|max:100',
            'ward' => 'required_if:address_method,new|nullable|string|max:100',
            'street' => 'required_if:address_method,new|nullable|string|max:255',

            'payment_method' => 'required|string|in:cod,bank,momo',

            // Các trường VAT: Chỉ bắt buộc khi is_vat bằng 1 (được tích chọn)
            'is_vat' => 'nullable|in:0,1',
            'company_name' => 'required_if:is_vat,1|nullable|string|max:255',
            'company_email' => 'required_if:is_vat,1|nullable|email|max:255',
            'tax_code' => 'required_if:is_vat,1|nullable|string|max:50',
            'company_address' => 'required_if:is_vat,1|nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'address_method.required' => 'Phương thức lấy địa chỉ là bắt buộc',
            'customer_name.required_if' => 'Tên khách hàng là bắt buộc',
            'customer_phone.required_if' => 'Số điện thoại là bắt buộc',
            'customer_phone.regex' => 'Số điện thoại phải bắt đầu bằng 0 và có 10 số',
            'province.required_if' => 'Tỉnh/Thành phố là bắt buộc',
            'district.required_if' => 'Quận/Huyện là bắt buộc',
            'ward.required_if' => 'Phường/Xã là bắt buộc',
            'street.required_if' => 'Địa chỉ cụ thể (số nhà, tên đường) là bắt buộc',
            'payment_method.required' => 'Phương thức thanh toán là bắt buộc',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ',
            'company_name.required_if' => 'Tên công ty là bắt buộc khi yêu cầu xuất hóa đơn VAT',
            'company_email.required_if' => 'Email công ty là bắt buộc khi yêu cầu xuất hóa đơn VAT',
            'company_email.email' => 'Email không đúng định dạng',
            'tax_code.required_if' => 'Mã số thuế là bắt buộc khi yêu cầu xuất hóa đơn VAT',
            'company_address.required_if' => 'Địa chỉ công ty là bắt buộc khi yêu cầu xuất hóa đơn VAT',
        ];
    }
}
