<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\PaymentHistory;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleManagementController extends Controller
{
    // Hiển thị danh sách bài viết chưa thanh toán
    public function postUnpaid(Request $request)
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);
        $categoryId = $request->caterogry ?? ""; // Đúng với tên field trong form

        // Lọc theo category_id nếu có
        $query = Rooms::where('status', 0);
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        $rooms = $query->paginate($itemPerPage);
        $categories = Categories::all();

        return view('admin.pages.management_menu.post_unpaid', compact('rooms', 'categories'));
    }

    // Hiển thị danh sách bài viết đã thanh toán
    public function postPending(Request $request)
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);
        $categoryId = $request->caterogry ?? ""; // Đúng với tên field trong form

        // Lọc theo category_id nếu có
        $query = Rooms::where('status', 1);
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        $rooms = $query->paginate($itemPerPage);
        $categories = Categories::all();

        return view('admin.pages.management_menu.post_pending', compact('rooms', 'categories'));
    }

    // Duyệt bài viết
    public function browse($id)
    {
        try {
            $room = Rooms::find($id);
            if (!$room) {
                return redirect()->route('admin.post-unpaid')->with('error', 'Phòng không tồn tại!');
            }

            $room->status = 2; // Duyệt phòng
            $room->save();

            return redirect()->route('admin.post-unpaid')->with('success', 'Duyệt phòng thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Đã có lỗi xảy ra. Bài đăng chưa được duyệt!');
        }
    }

    // Hủy bài viết sẽ hoàn tiền lại cho user
    public function cancel($id)
    {
        try {
            DB::beginTransaction();

            $room = Rooms::find($id);
            if (!$room) {
                return redirect()->route('admin.post-pending')->with('error', 'Phòng không tồn tại!');
            }

            $room->status = 0;
            $room->save();

            $paymentHistory = PaymentHistory::where('room_id', 17)->orderBy('created_at', 'desc')->first();
            if (!$paymentHistory) {
                return response()->json(['error' => 'Không tìm thấy lịch sử thanh toán!'], 404);
            }

            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'Người dùng chưa đăng nhập!'], 401);
            }
            // Hoàn tiền lại cho user
            $user->balance += $paymentHistory->pay_price;
            $user->save(); // Lưu lại số dư mới của user

            // Cập nhật trạng thái của lịch sử thanh toán
            $paymentHistory->status = 0;
            $paymentHistory->save();
            DB::commit();

            return redirect()->route('admin.post-pending')->with('success', 'Hủy phòng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã có lỗi xảy ra. Bài đăng chưa được hủy!');
        }
    }
    
    // Hiển thị danh sách bài viết đã duyệt hoặc hết hạn
    public function postApproved(Request $request)
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);
        $categoryId = $request->caterogry ?? ""; // Fix lỗi chính tả nếu cần: $request->category
        $status = $request->status ?? ""; // Nhận giá trị trạng thái từ form

        // Truy vấn danh sách phòng đã duyệt hoặc hết hạn
        $query = Rooms::query();

        if (!empty($status)) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', [2, 3]);
        }

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        $rooms = $query->paginate($itemPerPage);
        $categories = Categories::all();

        return view('admin.pages.management_menu.post_approved', compact('rooms', 'categories'));
    }
}
