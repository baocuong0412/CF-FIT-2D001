<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadImageController;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserInformationController extends Controller
{
    /** Trang cá nhân */
    public function personalPage()
    {
        return view('clients.pages.account_management.personal-page', [
            'categories' => Categories::all(),
        ]);
    }

    /** Cập nhật thông tin cá nhân */
    public function updatePersonalPage(Request $request)
    {
        try {
            $user = Auth::user();
            $uploadAvatar = new UploadImageController();

            if (!$user) {
                return redirect()->back()->with('error', 'Người dùng chưa đăng nhập!');
            }

            // Upload avatar nếu có file
            if ($request->hasFile('avatar')) {
                $avatarUrl = $uploadAvatar->uploadImageToCloudinary($request->file('avatar'), 'users');
            }

            // Chuẩn bị dữ liệu để cập nhật
            $updateData = [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'zalo' => $request->zalo,
                'facebook' => $request->facebook,
                'email' => $request->email,
            ];

            // Nếu có avatar mới, thêm vào dữ liệu cập nhật
            if (!empty($avatarUrl)) {
                $updateData['avatar'] = $avatarUrl;
            }

            // Nếu có password mới, mã hóa và thêm vào dữ liệu cập nhật
            if (!empty($request->password)) {
                $updateData['password'] = Hash::make($request->password);
            }

            // Cập nhật thông tin người dùng
            $user->update($updateData);

            return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }
}
