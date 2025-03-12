<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostStoreRequest extends FormRequest
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
            'category_id' => 'required|integer|exists:categories,id',
            'title' => 'required|string|max:100', // Giới hạn tối đa 100 ký tự
            'description' => 'required|string',
            'price' => 'required|integer|min:1000', // Giá tối thiểu 1000 VND
            'area' => 'required|integer|min:1', // Diện tích tối thiểu 1 m²
            'city_id' => 'required|integer|exists:cities,id',
            'district_id' => 'required|integer|exists:districts,id',
            'ward_id' => 'required|integer|exists:wards,id',
            'street' => 'required|string|max:255',
            'new_type_id' => 'required|integer|exists:new_type,id',
            'time_start' => 'required|date|after_or_equal:today', // Ngày bắt đầu phải từ hôm nay trở đi
            'time_end' => 'required|date|after:time_start', // Ngày kết thúc phải sau ngày bắt đầu
            'image_logo' => 'min:1|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {

        return [
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.integer' => 'Danh mục phải là số nguyên.',
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.string' => 'Tiêu đề phải là chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 100 ký tự.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'description.string' => 'Mô tả phải là chuỗi.',
            'price.required' => 'Vui lòng nhập giá thuê.',
            'price.integer' => 'Giá thuê phải là số nguyên.',
            'price.min' => 'Giá thuê phải lớn hơn hoặc bằng 1000 VND.',
            'area.required' => 'Vui lòng nhập diện tích.',
            'area.integer' => 'Diện tích phải là số nguyên.',
            'area.min' => 'Diện tích phải lớn hơn 0 m².',
            'city_id.required' => 'Vui lòng chọn tỉnh/thành phố.',
            'city_id.integer' => 'Tỉnh/thành phố phải là số nguyên.',
            'district_id.required' => 'Vui lòng chọn quận/huyện.',
            'district_id.integer' => 'Quận/huyện phải là số nguyên.',
            'ward_id.required' => 'Vui lòng chọn phường/xã.',
            'ward_id.integer' => 'Phường/xã phải là số nguyên.',
            'street.required' => 'Vui lòng nhập tên đường.',
            'street.string' => 'Tên đường phải là chuỗi.',
            'street.max' => 'Tên đường không được vượt quá 255 ký tự.',
            'new_type_id.required' => 'Vui lòng chọn loại tin.',
            'new_type_id.integer' => 'Loại tin phải là số nguyên.',
            'time_start.required' => 'Vui lòng chọn ngày bắt đầu.',
            'time_start.date' => 'Ngày bắt đầu phải là ngày.',
            'time_end.required' => 'Vui lòng chọn ngày kết thúc.',
            'time_end.date' => 'Ngày kết thúc phải là ngày.',
            'time_start.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay.',
            'time_end.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
            'image.min' => 'Phải có ít nhất 1 tắm hình',
            'image_logo.image' => 'Tệp phải là hình ảnh.',
            'image_logo.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'image_logo.max' => 'Hình ảnh không được vượt quá 2MB.',
            'images.array' => 'Tệp tải lên phải là mảng.',
            'images.*.image' => 'Mỗi tệp tải lên phải là hình ảnh.',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'images.*.max' => 'Mỗi hình ảnh không được vượt quá 2MB.',
        ];
    }
}
