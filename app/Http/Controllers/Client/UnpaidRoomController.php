<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadImageController;
use App\Http\Requests\Client\CreatePostUpdateRequest;
use App\Models\Categories;
use App\Models\Cities;
use App\Models\District;
use App\Models\NewType;
use App\Models\RoomImages;
use App\Models\Rooms;
use App\Models\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class UnpaidRoomController extends Controller
{
    /** Danh sách bài đăng chưa thanh toán */
    public function postUnpaid()
    {
        $rooms = Auth::check() ? Rooms::where('user_id', Auth::id())->where('status', 0)->orderBy('created_at', 'desc')->get() : collect();
        $categories = Categories::all();
        return view('clients.pages.account_management.post-unpaid', compact('rooms', 'categories'));
    }

    // Hien thi trang sua bai dang
    public function edit(Request $request)
    {
        $room = Rooms::find($request->id);
        $roomImages = RoomImages::where('room_id', $request->id)->get();
        // dd($roomImages);  
        return view('clients.pages.account_management.create-post-update', [
            'data' => $room,
            'roomImages' => $roomImages,
            'categories' => Categories::all(),
            'cities' => Cities::all(),
            'districts' => District::all()->groupBy('city_id'),
            'wards' => Ward::all()->groupBy('district_id'),
            'newType' => NewType::all(),
        ]);
    }

    // Cap nhat hoac Gia Han bai dang vao DB
    public function createPostUpdate(CreatePostUpdateRequest $request)
    {

        try {
            DB::beginTransaction();

            $room = Rooms::findOrFail($request->id);

            $uploadController = new UploadImageController();

            // Kiểm tra nếu người dùng không tải lên ảnh mới, giữ nguyên ảnh cũ
            if ($request->hasFile('image_logo')) {
                $imageLogo = $uploadController->uploadImageToCloudinary($request->file('image_logo'), 'rooms');
            } else {
                $imageLogo = $room->image_logo; // Giữ lại ảnh cũ
            }

            // Nếu có ảnh chi tiết mới, thêm vào danh sách, nếu không giữ ảnh cũ
            if ($request->hasFile('images')) {
                $imageUrls = $uploadController->uploadImagesToCloudinary($request->file('images'), 'room_image');

                // Xóa ảnh chi tiết cũ trước khi thêm ảnh mới
                RoomImages::where('room_id', $room->id)->delete();

                foreach ($imageUrls as $imageUrl) {
                    RoomImages::create([
                        'room_id' => $room->id,
                        'images'   => $imageUrl
                    ]);
                }
            }

            // Chuyển đổi time_start & time_end sang định dạng đầy đủ giờ, phút, giây
            $timeStart = Carbon::parse($request->time_start)->format('Y-m-d H:i:s');
            $timeEnd = Carbon::parse($request->time_end)->format('Y-m-d H:i:s');

            // Cập nhật thông tin bài đăng
            $room->update([
                'title'        => $request->title,
                'slug'         => Str::slug($request->title),
                'price'        => $request->price,
                'area'         => $request->area,
                'description'  => $request->description,
                'time_start'   => $timeStart,
                'time_end'     => $timeEnd,
                'street'       => $request->street,
                'category_id'  => $request->category_id,
                'new_type_id'  => $request->new_type_id,
                'city_id'      => $request->city_id,
                'district_id'  => $request->district_id,
                'ward_id'      => $request->ward_id,
                'image_logo'   => $imageLogo, // Giữ lại hoặc cập nhật ảnh đại diện
                'status'       => 0, // Cập nhật trạng thái bài đăng về chưa thanh toán
            ]);

            DB::commit();

            return redirect()->route('client.post-unpaid')->with('success', 'Bài đăng đã được cập nhật thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã có lỗi xảy ra. Bài cập nhật không thành công.' . $e->getMessage());
        }
    }

    // Xóa bài viết
    public function deletePost($id)
    {
        $room = Rooms::find($id);

        if (!$room) {
            return response()->json(['error' => 'Bài đăng không tồn tại!'], 404);
        }

        $room->delete();

        return response()->json(['success' => 'Bài đăng đã được xóa thành công!']);
    }

    // Thanh toan bai dang
    public function Payment($id)
    {
        $categories = Categories::all();
        $room = Rooms::find($id);
        $total = $room->newType->price * 5;
        $pay_code = sprintf('TPN-KH%s-MP%s/%s', Auth::user()->id, $room->id, $room->newType->slug);
        // dd($total);
        return view('clients.pages.account_management.payment', [
            'categories' => $categories,
            'room' => $room,
            'total' => $total,
            'pay_code' => $pay_code
        ]);
    }
}
