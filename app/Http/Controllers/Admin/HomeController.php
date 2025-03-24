<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginStoreRequest;
use App\Http\Requests\Admin\AdminRegisterStoreRequest;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\Rooms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        $unpaidRoom = Rooms::where('status', 0)->count();
        $pendingRoom = Rooms::where('status', 1)->count();
        $approvedRoom = Rooms::where('status', 2)->count();
        $newFeedback = Contact::where('status', 0)->count(); // Example for feedback count
        
        return view('admin.pages.dashboard', [
            'unpaidRoom' => $unpaidRoom,
            'pendingRoom' => $pendingRoom,
            'approvedRoom' => $approvedRoom,
            'newFeedback' => $newFeedback,
        ]);
    }

    public function registerStore(AdminRegisterStoreRequest $request)
    {
        try {
            // Lấy dữ liệu từ request
            Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // Trả về JSON cho Fetch API
            return response()->json([
                'success' => true,
                'message' => 'Đăng ký thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function showLoginForm()
    {
        return view('admin.pages.login');
    }

    public function store(LoginStoreRequest $request)
    {
        // Tìm admin theo username
        $admin = Admin::where('name', $request->name)->first();
        // dd($admin);
        // Kiểm tra nếu admin không tồn tại hoặc mật khẩu không đúng
        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Tên đăng nhập hoặc mật khẩu không đúng');
        }

        // Đăng nhập admin  
        Auth::guard('admin')->login($admin);

        // Chuyển hướng đến trang dashboard
        return redirect()->route('admin.index');
    }

    public function logout()
    {
        // Đăng xuất người dùng (nếu có dùng Auth)
        auth()->logout();

        // Chuyển hướng về trang đăng nhập
        return redirect()->route('admin.login.form');
    }
}
