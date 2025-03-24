<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadImageController;
use App\Http\Requests\Admin\NewStoreRequest;
use App\Http\Requests\Admin\NewUpdateRequest;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class NewsManagementController extends Controller
{
    public function news()
    {
        return view('admin.pages.management_menu.make-news');
    }

    public function store(NewStoreRequest $request)
    {
        try {
            // Kiểm tra admin đã đăng nhập hay chưa
            if (!auth('admin')->check()) {
                return redirect()->route('admin.make-news')->with('error', 'Bạn cần đăng nhập để thực hiện thao tác này.');
            }

            // Upload ảnh logo lên Cloudinary
            $uploadController = new UploadImageController();
            $imageNew = $uploadController->uploadImageToCloudinary($request->file('image_new'), 'new');

            // Tạo bài viết mới
            News::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'image_new' => $imageNew,
                'description' => $request->description,
                'status' => $request->status, // Mặc định trạng thái là 0 nếu không có
                'admin_id' => auth('admin')->id()
            ]);

            return redirect()->route('admin.posted-news')->with('success', 'Bài viết đã được tạo thành công.');
        } catch (\Throwable $th) {
            return redirect()->route('admin.posted-news')->with('error', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    public function detail()
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);
        $news = News::paginate($itemPerPage);
        return view('admin.pages.management_menu.posted-news', compact('news'));
    }

    public function show($id)
    {
        // Tìm bài viết theo ID
        $new = News::findOrFail($id);

        // Trả về view và truyền dữ liệu bài viết
        return view('admin.pages.management_menu.edit-make-news', compact('new'));
    }

    public function edit(NewUpdateRequest $request, $id)
    {
        try {
            $new = News::findOrFail($id);
            $uploadController = new UploadImageController();

            // Kiểm tra nếu người dùng không tải lên ảnh mới, giữ nguyên ảnh cũ
            if ($request->hasFile('image_new')) {
                $imageNew = $uploadController->uploadImageToCloudinary($request->file('image_new'), 'new');
            } else {
                $imageNew = $new->image_new; // Giữ lại ảnh cũ
            }

            // Cập nhật dữ liệu đúng cách
            $new->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image_new' => $imageNew,
                'status' => $request->input('status'),
            ]);

            return redirect()->route('admin.posted-news', ['id' => $new->id])->with('success', 'Cập nhật bài viết thành công!');
        } catch (\Throwable $th) {
            return redirect()->route('admin.posted-news')->with('error', 'Đã xảy ra lỗi, vui lòng thử lại.');
        }
    }

    public function destroy(Request $request)
    {
        try {
            $news = News::findOrFail($request->id);
            $news->delete();
            return response()->json(['success' => 'Bài viết đã được xóa thành công!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể xóa bài viết!'], 500);
        }
    }
}
