<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\DepositMoneyRequest;
use App\Models\Categories;
use App\Models\DepositMoney;
use App\Models\PaymentHistory;
use App\Models\Rooms;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DepositAndPaymentController extends Controller
{
    /**Hiển thị Nạp tiền vào tài khoản */
    public function depositMoney()
    {
        $categories = Categories::all();
        return view('clients.pages.account_management.deposit-money', [
            'categories' => $categories,
        ]);
    }

    /**Hiển thị Nạp tiền VNPAY */
    public function depositMoneyVnpay()
    {
        $categories = Categories::all();
        return view('clients.pages.account_management.deposit-money-vnpay', [
            'categories' => $categories,
        ]);
    }

    // Xử lý Nạp tiền VNPAY
    public function postDepositMoneyVnpay(DepositMoneyRequest $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
        $payCode = Auth::user()->pay_code;
        $payCodeUser = sprintf("%s-%s", $payCode, random_int(100000, 999999));

        $vnp_TxnRef = $payCodeUser; //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $request->pay_price; // Số tiền thanh toán
        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = 'VNPAY'; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => env('VNP_TMNCODE'),
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => env('VNP_RETURNURL'),
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire,
            "vnp_BankCode" => $vnp_BankCode
        );

        // dd($inputData);

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = env('VNP_URL') . "?" . $query;
        $vnpSecureHash =   hash_hmac('sha512', $hashdata, env('VNP_HASHSECRET')); //  
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        return Redirect::to($vnp_Url);
    }

    // Xu ly thanh toan
    public function postPayment(Request $request, $id)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        try {
            DB::beginTransaction();

            $room = Rooms::find($id);

            if (!$room) {
                return redirect()->back()->with('error', 'Phòng không tồn tại.');
            }

            if ($room->status == 1) {
                return redirect()->back()->with('error', 'Phòng đã được đặt.');
            }

            $total = $room->newType->price * 5; // Kiểm tra nếu 5 là số ngày cố định hoặc cần lấy từ request

            // Thanh toán qua số dư tài khoản 
            if ($request->pay === 'account') {
                $user = Auth::user();

                if ($user->balance < $total) {
                    return redirect()->back()->with('error', 'Số dư tài khoản không đủ.');
                }
                // Trừ tiền từ tài khoản người dùng
                $user->balance -= $total;
                $user->save();

                // Cập nhật trạng thái phòng (phòng đã được thanh toán)
                $room->status = 1;
                $room->save();

                // Tạo lịch sử thanh toán qua số dư tài khoản người dùng
                PaymentHistory::create([
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'new_type_id' => $room->new_type_id,
                    'pay_price' => $total,
                    'payment_method' => 'account',
                    'pay_code' => sprintf("%s/%s", $request->pay_code, random_int(100000, 999999)),
                ]);
            }

            DB::commit();

            if ($request->pay === 'VNPAY') {

                $startTime = date("YmdHis");
                $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));
                $payCode = sprintf("%s/%s", $request->pay_code, random_int(100000, 999999));

                $vnp_TxnRef = $payCode; //Mã giao dịch thanh toán tham chiếu của merchant
                $vnp_Amount = $total; // Số tiền thanh toán
                $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
                $vnp_BankCode = $request->pay; //Mã phương thức thanh toán
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => env('VNP_TMNCODE'),
                    "vnp_Amount" => $vnp_Amount * 100,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
                    "vnp_OrderType" => "other",
                    "vnp_ReturnUrl" => env('VNP_RETURNURL'),
                    "vnp_TxnRef" => $vnp_TxnRef,
                    "vnp_ExpireDate" => $expire,
                    "vnp_BankCode" => $vnp_BankCode
                );

                // dd($inputData);

                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }

                $vnp_Url = env('VNP_URL') . "?" . $query;
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, env('VNP_HASHSECRET')); //  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

                // dd($vnp_Url);
                return Redirect::to($vnp_Url);
            }

            return redirect()->route('client.post-manage')->with('success', 'Thanh toán thành công');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Thanh toán thất bại.' . $e->getMessage());
        }
    }

    // Xử lý callback từ VNPAY
    public function vnpayCallback(Request $request)
    {
        // Lấy thông tin từ VNPAY
        $responseCode = $request->vnp_ResponseCode;
        $pay_code = $request->vnp_TxnRef; // Mã giao dịch
        $amount = $request->vnp_Amount / 100; // VNPAY gửi số tiền nhân 100


        $errorMessage = match ($request->vnp_ResponseCode) {
            '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên quan tới lừa đảo, giao dịch bất thường).',
            '09' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng chưa đăng ký dịch vụ InternetBanking tại ngân hàng.',
            '10' => 'Giao dịch không thành công do: Khách hàng xác thực thông tin thẻ/tài khoản không đúng quá 3 lần',
            '12' => 'Giao dịch không thành công do: Thẻ/Tài khoản của khách hàng bị khóa.',
            '51' => 'Giao dịch không thành công do: Tài khoản của quý khách không đủ số dư để thực hiện giao dịch.',
            '65' => 'Giao dịch không thành công do: Tài khoản của Quý khách đã vượt quá hạn mức giao dịch trong ngày.',
            default => 'Thanh cong'
        };

        // Kiểm tra mã phản hồi từ VNPAY
        if ($responseCode !== '00') {
            return response()->json([
                'message' => 'Giao dịch không thành công!',
                'error' => $errorMessage,
            ], 400);
        }

        try {
        // Kiểm tra nếu là giao dịch nạp tiền
        if (is_string($pay_code) && Str::contains($pay_code, 'PAY-CODE-')) {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'Người dùng chưa đăng nhập!'], 401);
            }

            // Kiểm tra nếu giao dịch đã tồn tại để tránh xử lý trùng
            if (DepositMoney::where('pay_code', $pay_code)->exists()) {
                return response()->json(['message' => 'Giao dịch này đã được xử lý trước đó.']);
            }

            // Tạo bản ghi nạp tiền
            DepositMoney::create([
                'pay_code' => $pay_code,
                'pay_price' => $amount,
                'payment_method' => 'VNPAY',
                'status' => 1,
                'user_id' => $user->id,
            ]);

            // Cập nhật số dư tài khoản người dùng
            $user->increment('balance', $amount);
            return redirect()->route('client.deposit-money')->with('success', 'Nạp Tiền thành công');
        };
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Nạp tiền thất bại']);
        }

        try {
            DB::beginTransaction();

            if (preg_match('/^TPN-KH\d+-/', $pay_code)) {
                // Giao dịch thanh toán dịch vụ
                $user = Auth::user();

                if (!$user) {
                    return response()->json(['error' => 'Người dùng chưa đăng nhập!'], 401);
                }

                // Tách ID phòng từ pay_code
                preg_match('/MP(\d+)/', $pay_code, $matches);
                $roomId = $matches[1] ?? null;

                if (!$roomId) {
                    return response()->json(['error' => 'Không tìm thấy ID phòng trong mã giao dịch!'], 400);
                }

                // Kiểm tra phòng tồn tại hay không
                $room = Rooms::find($roomId);
                if (!$room) {
                    return response()->json(['error' => 'Phòng không tồn tại!'], 400);
                }

                // Kiểm tra nếu phòng đã được thanh toán trước đó
                if (PaymentHistory::where('pay_code', $pay_code)->exists()) {
                    return response()->json(['message' => 'Giao dịch đã được xử lý trước đó.']);
                }

                // Cập nhật trạng thái phòng (phòng đã được thanh toán)
                $room->status = 1;
                $room->save();

                // Tạo lịch sử thanh toán
                PaymentHistory::create([
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'new_type_id' => $room->newType->id ?? null,
                    'pay_price' => $amount,
                    'payment_method' => 'VNPAY',
                    'pay_code' => $pay_code,
                ]);
            }
            DB::commit();

            return redirect()->route('client.post-manage')->with('success', 'Thanh toán thành công');
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => 'Thanh toán thất bại']);
        }
    }
}
