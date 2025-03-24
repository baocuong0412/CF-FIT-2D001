<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\PaymentHistory;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaidRoomController extends Controller
{
    /** Quản lý bài đăng */
    public function postManage()
    {
        $rooms = Auth::check() ? Rooms::where('user_id', Auth::id())->whereIn('status', [1, 2, 3])->orderBy('created_at','desc')->get() : collect();
        $categories = Categories::all();
        return view('clients.pages.account_management.post-manage', compact('rooms', 'categories'));
    }
    
    // Huỷ bài đăng va bài đăng sẽ được chuyển trạng thái chưa thanh toán và số tiền sẽ được hoàn lại cho user
    public function cancelPost($id)
    {
        try {
            DB::beginTransaction();

            $room = Rooms::find($id);
            if (!$room) {
                return response()->json(['error' => 'Bài đăng không tồn tại!'], 404);
            }

            $paymentHistory = PaymentHistory::where('room_id', $id)->first();
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

            // Hủy bài đăng
            $room->status = 0;
            $room->save();

            // Cập nhật trạng thái của lịch sử thanh toán
            $paymentHistory->status = 0;
            $paymentHistory->save();
            DB::commit();

            return response()->json(['success' => 'Bài đăng đã được hủy thành công!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Đã có lỗi xảy ra. Bài đăng chưa được hủy!');
        }
    }

    // Xóa bài đăng và lịch sử thanh toán số tiền sẽ không được hoàn lại
    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $room = Rooms::find($id);
            if (!$room) {
                return response()->json(['error' => 'Bài đăng không tồn tại!'], 404);
            }

            $paymentHistory = PaymentHistory::where('room_id', $id)->first();
            if (!$paymentHistory) {
                return response()->json(['error' => 'Không tìm thấy lịch sử thanh toán!'], 404);
            }

            $room->delete();
            $paymentHistory->delete();

            DB::commit();

            return response()->json(['success' => 'Bài đăng đã được xóa']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Đã có lỗi xảy ra. Bài đăng chưa được xóa!']);
        }
    }
}
