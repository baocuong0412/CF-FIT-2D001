<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Cities;
use App\Models\District;
use App\Models\NewType;
use App\Models\Rooms;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountManagementController extends Controller
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

    /** Quản lý bài đăng */
    public function postManage()
    {
        $rooms = Auth::check() ? Rooms::where('user_id', Auth::id())->whereIn('status', [1, 2, 3])->get() : collect();
        return view('clients.pages.account_management.post-manage', compact('rooms'));
    }

    /** Nạp tiền vào tài khoản */
    public function depositMoney()
    {
        return view('clients.pages.account_management.deposit-money', [
            'rooms' => Rooms::all(),
        ]);
    }

    /** Lịch sử nạp tiền */
    public function depositMoneyHistory()
    {
        return view('clients.pages.account_management.deposit-money-history');
    }

    /** Trang cá nhân */
    public function personalPage()
    {
        return view('clients.pages.account_management.personal-page');
    }

    /** Danh sách bài đăng chưa thanh toán */
    public function postUnpaid()
    {
        $rooms = Auth::check() ? Rooms::where('user_id', Auth::id())->where('status', 0)->get() : collect();
        return view('clients.pages.account_management.post-unpaid', compact('rooms'));
    }

    /** Xử lý thanh toán bằng số dư tài khoản */
    public function payByBalance($id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Bạn cần đăng nhập'], 401);
        }

        $room = Rooms::with('newType')->find($id);

        if (!$room) {
            return response()->json(['error' => 'Phòng không tồn tại'], 404);
        }

        return response()->json([
            'room_code' => $room->id,
            'start_date' => $room->time_start,
            'end_date' => $room->time_end,
            'balance' => Auth::user()->balance,
            'priceNewType' => $room->newType->price,
        ]);
    }

    /** Xác nhận thanh toán */
    public function payByBalanceConfirm($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'error' => 'Bạn cần đăng nhập'], 401);
        }

        $room = Rooms::with('newType')->find($id);

        if (!$room) {
            return response()->json(['success' => false, 'error' => 'Phòng không tồn tại'], 404);
        }

        $user = Auth::user();
        $priceNewType = $room->newType->price;

        if ($user->balance < $priceNewType) {
            return response()->json(['success' => false, 'error' => 'Số dư không đủ'], 400);
        }

        // Trừ tiền & cập nhật trạng thái
        $user->decrement('balance', $priceNewType);
        $room->update(['status' => 1]);

        return response()->json(['success' => true, 'message' => 'Thanh toán thành công'], 200);
    }

    /** Lịch sử thanh toán */
    public function paymentHistory()
    {
        return view('clients.pages.account_management.payment-history');
    }

    

    
}
