<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewTypeStoreRequest;
use App\Http\Requests\Admin\NewTypeUpdateRequest;
use App\Models\NewType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsTypeManagementController extends Controller
{
    // Hiển thị News Type
    public function newType()
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);
        $newType = NewType::paginate($itemPerPage);
        return view('admin.pages.management_menu.post_new-type', [
            'newType' => $newType
        ]);
    }

    // Thêm New Type
    public function newTypeStore(NewTypeStoreRequest $request)
    {
        try {
            // Tạo chuyên mục mới
            Newtype::create([
                'name_type' => $request->name_type,
                'slug' => Str::slug($request->name_type),
                'price' => $request->price,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.new-type')->with('success', 'Thêm loại tin thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.new-type')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Cập nhật New Type
    public function newTypeUpdate(NewTypeUpdateRequest $request, $id)
    {
        $newType = NewType::find($id);
        if (!$newType) {
            return redirect()->route('admin.new-type')->with('error', 'Loại tin không tồn tại!');
        }

        try {
            // Cap nhat thong tin moi
            $newType->name_type = $request->name_type;
            $newType->slug  = Str::slug($request->name_type);
            $newType->price = $request->price;
            $newType->status = $request->status;
            $newType->save();

            return redirect()->route('admin.new-type')->with('success', 'Cập nhật loại tin thành công!');
        } catch (\Throwable $e) {
            return redirect()->route('admin.new-type')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Xóa New Type
    public function newTypeDelete($id)
    {
        try {
            $newType = NewType::findOrFail($id);
            $newType->delete();

            return redirect()->route('admin.new-type')->with('success', 'Xóa loại tin thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.new-type')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
