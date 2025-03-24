<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesStoreRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền thực hiện yêu cầu này không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Quy tắc xác thực cho request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'classify' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'integer', 'in:0,1'],
        ];
    }

    /**
     * Thông báo lỗi tùy chỉnh.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục không được để trống',
            'name.string' => 'Tên danh mục phải là chuỗi',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
            
            'classify.required' => 'Phân loại không được để trống',
            'classify.string' => 'Phân loại phải là chuỗi',
            'classify.max' => 'Phân loại không được vượt quá 255 ký tự',
            
            'type.required' => 'Loại không được để trống',
            'type.string' => 'Loại phải là chuỗi',
            'type.max' => 'Loại không được vượt quá 255 ký tự',

            'title.required' => 'Tiêu đề không được để trống',
            'title.string' => 'Tiêu đề phải là chuỗi',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            
            'description.string' => 'Mô tả phải là chuỗi',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự',

            'status.required' => 'Trạng thái không được để trống',
            'status.integer' => 'Trạng thái phải là số nguyên',
            'status.in' => 'Trạng thái chỉ có thể là 0 (Ẩn) hoặc 1 (Hiển thị)',
        ];
    }
}
