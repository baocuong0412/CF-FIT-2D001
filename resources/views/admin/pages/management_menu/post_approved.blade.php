@extends('admin.layout.master')

@section('content_admin')
    <div>
        <h1>Quản lý tin đã đăng</h1>
        <hr>

        <div class="main-right-search">
            <form action="{{ route('admin.post-approved') }}" method="GET">
                <div class="form-group d-flex">
                    <label for="caterogry" class="mt-3 me-3">Tìm theo loại:</label>
                    <select name="caterogry" id="caterogry" class="form-select w-25 me-4 fs-4" style="height: 40px;">
                        <option value="">Tất cả</option>
                        @foreach ($categories as $key => $value)
                            <option value="{{ $value->id }}"
                                {{ request()->get('category') == $value->id ? 'selected' : '' }}>
                                {{ $value->name }}
                            </option>
                        @endforeach
                    </select>

                    <label for="status" class="mt-3 me-3">Tìm theo trạng thái:</label>
                    <select name="status" id="status" class="form-select w-25 me-4 fs-4" style="height: 40px;">
                        <option value="">Tất cả</option>
                        <option value="2" {{ request()->get('status') == 2 ? 'selected' : '' }}>Đã duyệt</option>
                        <option value="3" {{ request()->get('status') == 3 ? 'selected' : '' }}>Hết hạn</option>
                    </select>  
                    <button type="submit" class="btn btn-primary m-0 p-1">Tìm kiếm</button>
                </div>
            </form>
        </div>

        <div class="main-right-table">
            <table class="table table-bordered table-post-list" id = "table-manage">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 8%;">Mã tin</th>
                        <th class="text-center" style="width: 10%;">Ảnh đại diện</th>
                        <th class="text-center" style="width: 42%;">Tiêu đề</th>
                        <th class="text-center" style="width: 15%;">Thông tin</th>
                        <th class="text-center" style="width: 15%;">Giá/Thời gian</th>
                        <th class="text-center" style="width: 10%;">Trạng thái</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($rooms as $key => $value)
                        <tr>
                            <td>#MT{{ $value->id }}</td>
                            <td>
                                <div class="post_thumb">
                                    <img class="thumb-img" src="{{ $value->image_logo }}" alt=""
                                        style=" object-fit: contain; width: 100%; height: 100%;">
                                </div>
                            </td>
                            <td style="text-align: left; ">
                                <span class="category">{{ $value->category->name }}</span>
                                <span class="title">{{ $value->title }}</span>
                                <p class="address"><strong>Địa chỉ: </strong>
                                    {{ $value->street ?? 'Không xác định' }},
                                    {{ $value->ward->fullname ?? 'Không xác định' }},
                                    {{ $value->district->fullname ?? 'Không xác định' }},
                                    {{ $value->city->fullname ?? 'Không xác định' }}
                                </p>
                            </td>
                            <td>
                                <strong>{{ $value->user->name }}</strong>
                                <br>
                                <p>{{ $value->user->phone }}</p>

                            </td>
                            <td>
                                <div class="post_price">
                                    <span class="price"><strong>{{ number_format($value->price) }}</strong>/tháng</span>
                                </div>
                                <div class="post_date"><strong>Bắt đầu: </strong>{{ $value->time_start }}</div>
                                <div class="post_date"><strong>Kết thúc: </strong>{{ $value->time_end }}</div>
                            </td>
                            <td
                                class="{{ $value->status == 2 ? 'text-danger' : ($value->status == 3 ? 'text-secondary' : '') }}">
                                {{ $value->status == 2 ? 'Đã Duyệt' : ($value->status == 3 ? 'Hết Hạn' : '') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="fs-3">
        {{ $rooms->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
@endsection
