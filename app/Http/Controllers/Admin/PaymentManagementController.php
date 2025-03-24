<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewType;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;

class PaymentManagementController extends Controller
{
    public function paymentHistoryManager(Request $request)
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);
        $newTypes = NewType::all();

        // Lấy dữ liệu từ request
        $nameUser = $request->input('nameUser');
        $nameType = $request->input('name_type');
        $paymentMethod = $request->input('payment_method');
        $status = $request->input('status');

        // Khởi tạo truy vấn
        $query = PaymentHistory::with(['room', 'newType', 'user']);

        // Áp dụng điều kiện tìm kiếm nếu có nhập dữ liệu
        if ($nameUser !== null) {
            $query->whereHas('user', function ($q) use ($nameUser) {
                $q->where('name', 'like', "%$nameUser%");
            });
        }

        if (!empty($nameType)) {
            $query->where('new_type_id', $nameType);
        }

        if (!empty($paymentMethod)) {
            $query->where('payment_method', $paymentMethod);
        }

        if ($status !== null && $status !== '') {
            $query->where('status', $status);
        }

        // Sắp xếp theo ngày tạo (mới nhất trước)
        $paymentHistories = $query->orderBy('created_at', 'desc')->paginate($itemPerPage);

        return view('admin.pages.management_menu.payment-history-manager', compact('paymentHistories', 'newTypes'));
    }
}
