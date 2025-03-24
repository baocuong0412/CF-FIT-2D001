<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class UserAndAdminManagementController extends Controller
{
    // Hiển thị User
    public function userManager(Request $request)
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);

        // Lấy danh sách người dùng (nếu có tên thì tìm theo tên, nếu không thì lấy tất cả)
        $query = User::query();

        if (!empty(trim($request->name))) {
            $name = trim($request->name);
            $query->where('name', 'LIKE', "%{$name}%"); // ✅ Tìm kiếm mềm
        }

        $users = $query->paginate($itemPerPage);
        return view('admin.pages.management_menu.user-manager', [
            'users' => $users
        ]);
    }

    // Mở khóa User
    public function userManagerUnlock($id)
    {
        try {
            $users = User::findOrFail($id);
            $users->status = 1;
            $users->save();

            return redirect()->route('admin.user-manager')->with('success', 'Mở khóa người dùng thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.user-manager')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Khóa User
    public function userManagerLock($id)
    {
        try {
            $users = User::findOrFail($id);
            $users->status = 0;
            $users->save();

            return redirect()->route('admin.user-manager')->with('success', 'Khóa người dùng thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.user-manager')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Xóa User
    public function userManagerDelete($id)
    {
        try {
            $users = User::findOrFail($id);
            $users->delete();

            return redirect()->route('admin.user-manager')->with('success', 'Xóa người dùng thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.user-manager')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    // Hiển thị Admin
    public function adminManager(Request $request)
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);

        // Lấy danh sách người dùng (nếu có tên thì tìm theo tên, nếu không thì lấy tất cả)
        $query = Admin::query();

        if (!empty(trim($request->name))) {
            $name = trim($request->name);
            $query->where('name', 'LIKE', "%{$name}%"); // ✅ Tìm kiếm mềm
        }

        $admin = $query->paginate($itemPerPage);
        return view('admin.pages.management_menu.admin-manager', [
            'admins' => $admin
        ]);
    }
}
