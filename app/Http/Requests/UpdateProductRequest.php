<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'detail' => 'required|string',
            'status' => 'required|in:active,draft,inactive',
            'cost_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|lte:price|min:0',
            'stock' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'featured' => 'nullable|in:0,1',
            'sku' => ['required', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($this->route('id'))],
            'brand_id' => 'required|exists:brands,id',
            'seo_title' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
            'seo_keyword' => 'nullable|string|max:255',
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
            'thumbnail.required' => 'Ảnh sản phẩm là bắt buộc',
            'thumbnail.max' => 'Ảnh sản phẩm không được vượt quá 2MB',
            'thumbnail.mimes' => 'Ảnh sản phẩm phải là định dạng jpeg,png,jpg,gif',
            'category_id.required' => 'Danh mục là bắt buộc',
            'category_id.exists' => 'Danh mục không tồn tại',
            'gallery.required' => 'Ảnh sản phẩm là bắt buộc',
            'gallery.max' => 'Ảnh sản phẩm không được vượt quá 2MB',
            'gallery.mimes' => 'Ảnh sản phẩm phải là định dạng jpeg,png,jpg,gif',
            'detail.required' => 'Chi tiết sản phẩm là bắt buộc',
            'status.required' => 'Trạng thái sản phẩm là bắt buộc',
            'cost_price.required' => 'Giá nhập là bắt buộc',
            'cost_price.numeric' => 'Giá nhập phải là số',
            'cost_price.min' => 'Giá nhập không được âm',
            'price.required' => 'Giá bán là bắt buộc',
            'price.numeric' => 'Giá bán phải là số',
            'price.min' => 'Giá bán không được âm',
            'sale_price.required' => 'Giá khuyến mãi là bắt buộc',
            'sale_price.numeric' => 'Giá khuyến mãi phải là số',
            'sale_price.min' => 'Giá khuyến mãi không được âm',
            'stock.required' => 'Số lượng là bắt buộc',
            'stock.integer' => 'Số lượng phải là số nguyên',
            'stock.min' => 'Số lượng tồn kho phải tối thiểu :min.',
            'minimum_stock.required' => 'Số lượng tối thiểu là bắt buộc',
            'minimum_stock.integer' => 'Số lượng tối thiểu phải là số nguyên',
            'minimum_stock.min' => 'Số lượng tối thiểu không được âm',
            'weight.required' => 'Trọng lượng là bắt buộc',
            'weight.numeric' => 'Trọng lượng phải là số',
            'weight.min' => 'Trọng lượng không được âm',
            'length.required' => 'Chiều dài là bắt buộc',
            'length.numeric' => 'Chiều dài phải là số',
            'length.min' => 'Chiều dài không được âm',
            'width.required' => 'Chiều rộng là bắt buộc',
            'width.numeric' => 'Chiều rộng phải là số',
            'width.min' => 'Chiều rộng không được âm',
            'height.required' => 'Chiều cao là bắt buộc',
            'height.numeric' => 'Chiều cao phải là số',
            'height.min' => 'Chiều cao không được âm',
            'featured.required' => 'Nổi bật là bắt buộc',
            'featured.in' => 'Nổi bật phải là 0 hoặc 1',
            'sale_price.lte' => 'Giá khuyến mãi phải nhỏ hơn giá bán',
            'sku.required' => 'Mã SKU là bắt buộc',
            'sku.unique' => 'Mã SKU đã tồn tại',
            'sku.string' => 'Mã SKU phải là chuỗi',
            'sku.max' => 'Mã SKU không được vượt quá 255 ký tự',
            'brand_id.required' => 'Thương hiệu là bắt buộc',
            'brand_id.exists' => 'Thương hiệu không hợp lệ',
            'seo_title.required' => 'Tiêu đề SEO là bắt buộc',
            'seo_title.string' => 'Tiêu đề SEO phải là chuỗi',
            'seo_title.max' => 'Tiêu đề SEO không được vượt quá 255 ký tự',
            'seo_description.required' => 'Mô tả SEO là bắt buộc',
            'seo_description.string' => 'Mô tả SEO phải là chuỗi',
            'seo_description.max' => 'Mô tả SEO không được vượt quá 255 ký tự',
            'seo_keyword.required' => 'Từ khóa SEO là bắt buộc',
            'seo_keyword.string' => 'Từ khóa SEO phải là chuỗi',
            'seo_keyword.max' => 'Từ khóa SEO không được vượt quá 255 ký tự',
        ];
    }
}
