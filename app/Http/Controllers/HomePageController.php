<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Cities;
use App\Models\District;
use App\Models\Rooms;
use App\Models\User;
use App\Models\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $rooms = Rooms::with(['category', 'newType', 'city', 'district', 'ward', 'user'])->get();

        // Xử lý thời gian trước khi gửi sang Blade
        foreach ($rooms as $room) {
            $room->time_elapsed = Carbon::parse($room->time_start)->diffForHumans();
        }

        return view(
            'welcome',
            [
                'categories' => Categories::all(),
                'cities' => Cities::all(),
                'districts' => District::all()->groupBy('city_id'),
                'wards' => Ward::all()->groupBy('district_id'),
                'rooms' => $rooms
            ]
        );
    }

    public function category($slug)
    {
        // dd($slug);
        // Tìm danh mục theo slug
        $categories = Categories::all();

        if (!$categories) {
            abort(404, 'Danh mục không tồn tại');
        }

        $rooms = Rooms::whereHas('category', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })
            ->with(['category', 'newType', 'city', 'district', 'ward', 'user']) // ✅ Sửa tên quan hệ đúng với model
            ->get();

        // Xử lý thời gian trước khi gửi sang Blade
        foreach ($rooms as $room) {
            $room->time_elapsed = Carbon::parse($room->time_start)->diffForHumans();
        }

        return view('clients.pages.category.main', [
            'categories' => $categories,
            'cities' => Cities::all(),
            'districts' => District::all()->groupBy('city_id'),
            'wards' => Ward::all()->groupBy('district_id'),
            'rooms' => $rooms,
        ]);
    }

    /** Bảng giá dịch vụ */
    public function priceList()
    {

        return view('price-list', [
            'categories' => Categories::all(),
            'cities' => Cities::all(),
            'districts' => District::all()->groupBy('city_id'),
            'wards' => Ward::all()->groupBy('district_id'),
        ]);
    }

    /** Liên hệ */
    public function contact()
    {
        return view('contact', [
            'categories' => Categories::all(),
            'cities' => Cities::all(),
            'districts' => District::all()->groupBy('city_id'),
            'wards' => Ward::all()->groupBy('district_id'),
            'user' => User::all(),
        ]);
    }
}
