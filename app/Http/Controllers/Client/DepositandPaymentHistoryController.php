<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\DepositMoney;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositandPaymentHistoryController extends Controller
{
    /** Lịch sử nạp tiền */
    public function depositMoneyHistory()
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);
        $categories = Categories::all();
        $depositMoney = DepositMoney::where('user_id', Auth::id())->orderBy('created_at','desc')->paginate($itemPerPage);
        return view('clients.pages.account_management.deposit-money-history', [
            'categories' => $categories,
            'depositMoney' => $depositMoney,
        ]);
    }

    /** Lịch sử thanh toán */
    public function paymentHistory(Request $request)
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);

        // Lấy giá trị của payment_method từ request
        $query = PaymentHistory::where('user_id', Auth::id());

        if ($request->has('payment_method') && $request->payment_method !== '') {
            $query->where('payment_method', $request->payment_method);
        }

        $paymentHistory = $query->orderBy('created_at','desc')->paginate($itemPerPage);

        return view('clients.pages.account_management.payment-history', [
            'categories' => Categories::all(),
            'paymentHistory' => $paymentHistory,
        ]);
    }
}
