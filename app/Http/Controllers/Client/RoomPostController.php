<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadImageController;
use App\Http\Requests\Client\CreatePostStoreRequest;
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

class RoomPostController extends Controller
{
    /** Hiển thị trang tạo bài đăng */
    public function create()
    {
        return view('clients.pages.account_management.create-post', [
            'categories' => Categories::all(),
            'cities' => Cities::all(),
            'districts' => District::all()->groupBy('city_id'),
            'wards' => Ward::all()->groupBy('district_id'),
            'newType' => NewType::all(),
        ]);
    }

    // Luu bai dang vao DB
    public function createPostStore(CreatePostStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $uploadController = new UploadImageController();
            // Upload ảnh logo
            $imageLogo = $uploadController->uploadImageToCloudinary($request->file('image_logo'), 'rooms');
            // Upload nhiều ảnh phòng
            $imageUrls = $uploadController->uploadImagesToCloudinary($request->file('images'), 'room_image');

            // Chuyển đổi time_start & time_end sang định dạng đầy đủ giờ, phút, giây
            $timeStart = Carbon::parse($request->time_start)->format('Y-m-d H:i:s');
            $timeEnd = Carbon::parse($request->time_end)->format('Y-m-d H:i:s');

            // Tạo mới Room
            $rooms = Rooms::create([
                'title'        => $request->title,
                'slug'         => Str::slug($request->title),
                'price'        => $request->price,
                'area'         => $request->area,
                'description'  => $request->description,
                'image_logo'   => $imageLogo,
                'time_start'   => $timeStart,
                'time_end'     => $timeEnd,
                'street'       => $request->street,
                'user_id'      => Auth::id(),
                'category_id'  => $request->category_id,
                'new_type_id'  => $request->new_type_id,
                'city_id'      => $request->city_id,
                'district_id'  => $request->district_id,
                'ward_id'      => $request->ward_id,
            ]);

            // Lưu ảnh phòng nếu có
            if (!empty($imageUrls)) {
                foreach ($imageUrls as $imageUrl) {
                    RoomImages::create([
                        'images'   => $imageUrl,
                        'room_id' => $rooms->id
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('client.post-unpaid')->with('success', 'Bài đăng đã được tạo thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra. Bài đăng chưa được tạo!');
        }
    }
}
