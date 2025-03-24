<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueChartController extends Controller
{
    // Biểu đồ doanh thu theo từng ngày trong tháng
    public function revenueByDay(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        $data = DB::table('payment_history')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(pay_price) as total'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($data);
    }

    // Biểu đồ doanh thu theo loại thanh toán
    public function revenueByPaymentMethod(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);

        $data = DB::table('payment_history')
            ->select('payment_method', DB::raw('SUM(pay_price) as total'))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('payment_method')
            ->get();

        return response()->json($data);
    }

    // Biểu đồ doanh thu theo tháng
    public function revenueByMonth(Request $request)
    {
        $year = $request->query('year', now()->year);

        $data = DB::table('payment_history')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(pay_price) as total'))
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return response()->json($data);
    }
}
