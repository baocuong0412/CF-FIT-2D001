<?php

namespace App\Http\Controllers\Include;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Categories;
use App\Models\Cities;
use App\Models\Comments;
use App\Models\Contact;
use App\Models\District;
use App\Models\RoomImages;
use App\Models\Rooms;
use App\Models\Slider;
use App\Models\User;
use App\Models\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {

        $itemPerPage = env('ITEM_PER_PAGE', 10);

        // Lấy danh sách phòng bình thường
        $rooms = Rooms::with(['category', 'newType', 'city', 'district', 'ward', 'user'])
            ->sorted()
            ->where('status', 2)
            ->paginate($itemPerPage);

        // Lấy danh sách phòng nổi bật
        $roomsOutstanding = Rooms::with(['category', 'newType', 'city', 'district', 'ward', 'user'])
            ->outstanding()
            ->where('status', 2)
            ->paginate($itemPerPage);



        // Xử lý thời gian trước khi gửi sang Blade
        foreach ($rooms as $room) {
            $room->time_elapsed = Carbon::parse($room->created_at)->diffForHumans();
        }

        // Xử lý thời gian trước khi gửi sang Blade
        foreach ($roomsOutstanding as $room) {
            $room->time_elapsed = Carbon::parse($room->created_at)->diffForHumans();
        }

        // Lấy danh sách sliders
        $sliders = Slider::where('status', 1)->get();

        return view(
            'clients.pages.category.home_pages',
            [
                'categories' => Categories::all(),
                'cities' => Cities::all(),
                'districts' => District::all()->groupBy('city_id'),
                'wards' => Ward::all()->groupBy('district_id'),
                'rooms' => $rooms,
                'roomsOutstanding' => $roomsOutstanding,
                'sliders' => $sliders,
            ]
        );
    }

    public function category($slug)
    {
        $itemPerPage = env('ITEM_PER_PAGE', 10);
        // Tìm danh mục theo slug
        $categories = Categories::all();

        if (!$categories) {
            abort(404, 'Danh mục không tồn tại');
        }

        $rooms = Rooms::whereHas('category', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })
            ->with(['category', 'newType', 'city', 'district', 'ward', 'user'])
            ->where('status', 2)
            ->orderBy('new_type_id', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($itemPerPage);

        // Xử lý thời gian trước khi gửi sang Blade
        foreach ($rooms as $room) {
            $room->time_elapsed = Carbon::parse($room->created_at)->diffForHumans();
        }

        $sliders = Slider::where('status', 1)->get();

        return view('clients.pages.category.main', [
            'categories' => $categories,
            'cities' => Cities::all(),
            'districts' => District::all()->groupBy('city_id'),
            'wards' => Ward::all()->groupBy('district_id'),
            'rooms' => $rooms,
            'sliders' => $sliders,
        ]);
    }

    public function detail($id)
    {
        $categories = Categories::all();
        $sliders = Slider::where('status', 1)->get();
        $comments = Comments::where('room_id', $id)->with('user', 'reply.user')->orderBy('created_at', 'desc')->get();
        // Lấy thông tin phòng
        $room = Rooms::with(['category', 'newType', 'city', 'district', 'ward', 'user'])
            ->where('id', $id)
            ->first();

        // Kiểm tra nếu phòng không tồn tại
        if (!$room) {
            abort(404, 'Không tìm thấy phòng');
        }

        $room->time_elapsed = Carbon::parse($room->created_at)->diffForHumans();

        // Lấy hình ảnh của phòng
        $roomImage = RoomImages::where('room_id', $id)->get();

        // Lấy các phòng liên quan (cùng phường và thành phố, nhưng không phải phòng hiện tại)
        $relatedRooms = Rooms::where('status', 2)
            ->where('city_id', $room->city_id)
            // ->where('ward_id', $room->ward_id)
            ->where('id', '!=', $id) // Loại trừ bài viết hiện tại
            ->orderBy('created_at', 'desc')
            ->limit(5) // Lấy tối đa 5 bài viết liên quan
            ->get();

        // Lấy thông tin user đã đăng bài này
        $user = $room->user;

        return view('clients.pages.category.detail', [
            'categories' => $categories,
            'sliders' => $sliders,
            'cities' => Cities::all(),
            'districts' => District::all()->groupBy('city_id'),
            'wards' => Ward::all()->groupBy('district_id'),
            'relatedRooms' => $relatedRooms,
            'room' => $room,
            'roomImage' => $roomImage,
            'user' => $user, // Truyền user sang view
            'comments' => $comments
        ]);
    }

    public function search(Request $request)
    {
        // Bắt đầu truy vấn từ model Rooms (Không gọi get() ở đây)
        $query = Rooms::where('status', 2);

        // Lọc theo danh mục (category)
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Lọc theo thành phố (city_id)
        if ($request->has('city_id') && !empty($request->city_id)) {
            $query->where('city_id', $request->city_id);
        }

        // Lọc theo quận (district_id)
        if ($request->has('district_id') && !empty($request->district_id)) {
            $query->where('district_id', $request->district_id);
        }

        // Lọc theo phường (ward_id)
        if ($request->has('ward_id') && !empty($request->ward_id)) {
            $query->where('ward_id', $request->ward_id);
        }

        // Lọc theo khoảng giá
        if ($request->has('price') && !empty($request->price)) {
            $priceRange = explode('-', $request->price);
            $minPrice = (int) $priceRange[0];
            $maxPrice = (int) $priceRange[1];

            if ($maxPrice == 999) {
                $query->where('price', '>=', $minPrice * 1000000);
            } elseif ($minPrice == 0) {
                $query->where('price', '<=', $maxPrice * 1000000);
            } else {
                $query->whereBetween('price', [$minPrice * 1000000, $maxPrice * 1000000]);
            }
        }

        // Debug query nếu cần
        // dd($query->toSql(), $query->getBindings());

        // Lấy danh sách phòng sau khi lọc
        $rooms = $query->get(); // Gọi get() sau khi đã lọc xong

        // Lấy danh sách sliders
        $sliders = Slider::where('status', 1)->get();

        // Trả về view cùng với dữ liệu đã lọc
        return view('clients.pages.category.search', [
            'categories' => Categories::all(),
            'cities' => Cities::all(),
            'districts' => District::all()->groupBy('city_id'),
            'wards' => Ward::all()->groupBy('district_id'),
            'sliders' => $sliders,
            'rooms' => $rooms
        ]);
    }

    /** Bảng giá dịch vụ */
    public function priceList()
    {

        return view('include.price-list', [
            'categories' => Categories::all(),
            'cities' => Cities::all(),
            'districts' => District::all()->groupBy('city_id'),
            'wards' => Ward::all()->groupBy('district_id'),
        ]);
    }

    /** Liên hệ */
    public function contact()
    {
        return view('include.contact', [
            'categories' => Categories::all(),
            'cities' => Cities::all(),
            'districts' => District::all()->groupBy('city_id'),
            'wards' => Ward::all()->groupBy('district_id'),
            'user' => User::all(),
        ]);
    }

    public function postContact(ContactRequest $request)
    {
        try {
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->phone = $request->phone;
            $contact->email = $request->email;
            $contact->problem = $request->problem;
            $contact->message = $request->message;
            $contact->save();

            return redirect()->back()->with('success', 'Thông tin đã được gửi thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại!');
        }
    }

    public function news()
    {
        // Lấy danh sách sliders
        $sliders = Slider::where('status', 1)->get();

        return view('include.new', [
            'categories' => Categories::all(),
            'cities' => Cities::all(),
            'districts' => District::all()->groupBy('city_id'),
            'wards' => Ward::all()->groupBy('district_id'),
            'sliders' => $sliders,
        ]);
    }
}
