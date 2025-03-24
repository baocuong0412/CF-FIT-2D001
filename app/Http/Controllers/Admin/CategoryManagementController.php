<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoriesStoreRequest;
use App\Http\Requests\Admin\CategoriesUpdateRequest;
use App\Models\Categories;
use Illuminate\Support\Str;

class CategoryManagementController extends Controller
{
    // Hiển thị Category
    public function category()
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);
        $categories = Categories::paginate($itemPerPage);
        return view('admin.pages.management_menu.post_categories', [
            'categories' => $categories
        ]);
    }

    // Thêm Category mới
    public function categoryStore(CategoriesStoreRequest $request)
    {
        try {
            // Tạo chuyên mục mới
            Categories::create([
                'name' => $request->name,
                'classify' => $request->classify,
                'slug' => Str::slug($request->name),
                'type' => $request->type,
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            return redirect()->route('admin.category')->with('success', 'Thêm chuyên mục thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.category')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Cập nhật Category
    public function categoryUpdate(CategoriesUpdateRequest $request, $id)
    {
        $category = Categories::find($id);
        if (!$category) {
            return redirect()->route('admin.category')->with('error', 'Category không tồn tại!');
        }

        try {
            // Cap nhat thong tin moi
            $category->name = $request->name;
            $category->classify = $request->classify;
            $category->slug = Str::slug($request->name);
            $category->type = $request->type;
            $category->title = $request->title;
            $category->description = $request->description;
            $category->status = $request->status;
            $category->save();

            return redirect()->route('admin.category')->with('success', 'Cập nhật chuyên mục thành công!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.category')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Xóa Category
    public function categoryDelete($id)
    {
        try {
            $category = Categories::findOrFail($id);
            $category->delete();

            return redirect()->route('admin.category')->with('success', 'Xóa chuyên mục thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.category')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
