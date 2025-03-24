<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderStoreRequest;
use App\Http\Requests\Admin\SliderUpdateRequest;
use App\Models\Slider;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class SliderManagementController extends Controller
{
    // Hiển thị danh sách slider
    public function slider()
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);

        $slider = Slider::paginate($itemPerPage);
        return view('admin.pages.management_menu.post_slider', [
            'sliders' => $slider
        ]);
    }

    // Thêm slider mới
    public function sliderStore(SliderStoreRequest $request)
    {
        try {
            // Kiểm tra xem có ảnh được tải lên không
            if ($request->hasFile('image')) {
                // Upload ảnh lên Cloudinary
                $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            } else {
                return redirect()->route('admin.slider')->with('error', 'Ảnh không hợp lệ!');
            }

            // Lưu dữ liệu vào database
            Slider::create([
                'imageSlider' => $uploadedFileUrl, // Lưu link ảnh từ Cloudinary
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status // Thêm trạng thái cho slider
            ]);

            return redirect()->route('admin.slider')->with('success', 'Lưu slider thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.slider')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Cập nhật slider
    public function sliderUpdate(SliderUpdateRequest $request, $id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return redirect()->route('admin.slider')->with('error', 'Slider không tồn tại!');
        }

        try {
            // Chỉ cập nhật ảnh mới nếu có ảnh được upload
            if ($request->hasFile('image')) {
                $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
                $slider->imageSlider = $uploadedFileUrl;
            }

            // Cập nhật thông tin khác
            $slider->title = $request->title;
            $slider->description = $request->description;
            $slider->status = $request->status; // Thêm trạng thái cho slider
            $slider->save();

            return redirect()->route('admin.slider')->with('success', 'Cập nhật slider thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.slider')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Xóa slider
    public function sliderDelete($id)
    {
        try {

            $slider = Slider::find($id);
            $slider->delete();

            return redirect()->route('admin.slider')->with('success', 'Xóa slider thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.slider')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
