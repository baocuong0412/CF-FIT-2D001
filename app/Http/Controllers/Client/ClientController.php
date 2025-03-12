<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreatePostStoreRequest;
use App\Http\Requests\Client\CreatePostUpdateRequest;
use App\Models\Categories;
use App\Models\Cities;
use App\Models\District;
use App\Models\NewType;
use App\Models\RoomImages;
use App\Models\Rooms;
use App\Models\Ward;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function createPostStore(CreatePostStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            // Upload ảnh logo
            $imageLogo = $this->uploadImageToCloudinary($request->file('image_logo'), 'rooms');

            // Upload nhiều ảnh phòng
            $imageUrls = $this->uploadImagesToCloudinary($request->file('images'), 'room_image');

            // Tạo mới Room
            $rooms = Rooms::create([
                'title'        => $request->title,
                'slug'         => Str::slug($request->title),
                'price'        => $request->price,
                'area'         => $request->area,
                'description'  => $request->description,
                'time_start'   => $request->time_start,
                'time_end'     => $request->time_end,
                'street'       => $request->street,
                'user_id'      => Auth::id(),
                'category_id'  => $request->category_id,
                'new_type_id'  => $request->new_type_id,
                'city_id'      => $request->city_id,
                'district_id'  => $request->district_id,
                'ward_id'      => $request->ward_id,
                'image_logo'   => $imageLogo,
            ]);

            // Lưu ảnh phòng nếu có
            if (!empty($imageUrls)) {
                foreach ($imageUrls as $imageUrl) {
                    RoomImages::create([
                        'room_id' => $rooms->id,
                        'image'   => $imageUrl
                    ]);
                }
            }


            DB::commit();
            return redirect()->route('client.post-unpaid')->with('success', 'Bài đăng đã được tạo thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Upload một ảnh duy nhất lên Cloudinary
     */
    private function uploadImageToCloudinary($file, $folder)
    {
        if ($file) {
            $uploadedImage = Cloudinary::upload($file->getRealPath(), ['folder' => $folder]);
            return $uploadedImage ? $uploadedImage->getSecurePath() : null;
        }
        return null;
    }

    public function createPostUpdate(CreatePostUpdateRequest $request)
    {  
       
        try {
            DB::beginTransaction();

            $room = Rooms::findOrFail($request->id);

            // Kiểm tra nếu người dùng không tải lên ảnh mới, giữ nguyên ảnh cũ
            if ($request->hasFile('image_logo')) {
                $imageLogo = $this->uploadImageToCloudinary($request->file('image_logo'), 'rooms');
            } else {
                $imageLogo = $room->image_logo; // Giữ lại ảnh cũ
            }

            // Nếu có ảnh chi tiết mới, thêm vào danh sách, nếu không giữ ảnh cũ
            if ($request->hasFile('images')) {
                $imageUrls = $this->uploadImagesToCloudinary($request->file('images'), 'room_image');

                // Xóa ảnh chi tiết cũ trước khi thêm ảnh mới
                RoomImages::where('room_id', $room->id)->delete();

                foreach ($imageUrls as $imageUrl) {
                    RoomImages::create([
                        'room_id' => $room->id,
                        'image'   => $imageUrl
                    ]);
                }
            }

            // Cập nhật thông tin bài đăng
            $room->update([
                'title'        => $request->title,
                'slug'         => Str::slug($request->title),
                'price'        => $request->price,
                'area'         => $request->area,
                'description'  => $request->description,
                'time_start'   => $request->time_start,
                'time_end'     => $request->time_end,
                'street'       => $request->street,
                'category_id'  => $request->category_id,
                'new_type_id'  => $request->new_type_id,
                'city_id'      => $request->city_id,
                'district_id'  => $request->district_id,
                'ward_id'      => $request->ward_id,
                'image_logo'   => $imageLogo, // Giữ lại hoặc cập nhật ảnh đại diện
            ]);

            DB::commit();
            if ($room->status == 0) {
                return redirect()->route('client.post-unpaid')->with('success', 'Bài đăng đã được cập nhật thành công!');
            } else {
                return redirect()->route('client.post-manage')->with('success', 'Bài đăng đã được cập nhật thành công!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function deletePost($id) {
        $room = Rooms::find($id);
        
        if (!$room) {
            return response()->json(['error' => 'Bài đăng không tồn tại!'], 404);
        }
    
        $room->delete();
    
        return response()->json(['success' => 'Bài đăng đã được xóa thành công!']);
    }
    

    /**
     * Upload nhiều ảnh lên Cloudinary
     */
    private function uploadImagesToCloudinary($files, $folder)
    {
        $imageUrls = [];
        if ($files) {
            foreach ($files as $file) {
                $imageUrls[] = $this->uploadImageToCloudinary($file, $folder);
            }
        }
        return $imageUrls;
    }

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
}
