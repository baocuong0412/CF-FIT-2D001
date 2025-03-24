@extends('welcome')

@section('content')
    <div class="container mt-3">
        <div>
            <h1>Cho thông tin phòng trọ, nhà ở, căn hộ, homestay số 1 Việt Nam</h1>
            <p>Kênh thông tin Phòng Trọ số 1 Việt Nam - Website đăng tin cho thuê phòng trọ, nhà nguyên căn, căn hộ, ở ghép
                nhanh, hiệu quả với 100.000+ tin đăng và 2.500.000 lượt xem mỗi tháng.
            </p>
        </div>
        <br>
        <div class="row g-0 text-center">
            {{-- Bài viết nổi bật --}}
            <div class="col-sm-6 col-md-8 pe-2">
                <div class="me-2">
                    @if ($roomsOutstanding->count() > 0)
                        <h3 class="p-3 text-center border border-1 shadow-lg bg-body-tertiary">Bài viết nổi bật</h3>
                        @foreach ($roomsOutstanding as $room)
                            @if ($room->new_type_id == 5)
                                <a href="{{ route('detail', ['id' => $room->id]) }}" class="text-decoration-none">
                                    <div class="border border-1 rounded-4 shadow-lg bg-body-tertiary rounded mb-3">
                                        <div class="p-3">
                                            <!-- Hình ảnh -->
                                            <div>
                                                <img src="{{ $room->image_logo ?? 'https://via.placeholder.com/300' }}"
                                                    alt="hinhAnh" class="rounded-3 img-fluid w-100" style="height: 300px;">
                                            </div>
                                            <!-- Thông tin -->
                                            <div class="text-start ps-3">
                                                <div id="stars">
                                                    @for ($i = 0; $i < ($room->new_type_id ?? 0); $i++)
                                                        <i class="fa-solid fa-star text-warning"></i>
                                                    @endfor
                                                </div>
                                                <strong
                                                    class="text-danger fs-5">{{ $room->title ?? 'Không có tiêu đề' }}</strong>

                                                <!-- Giá, diện tích, thời gian -->
                                                <div>
                                                    <h5 class="me-4">
                                                        <i class="fa-solid fa-money-bill-wave me-2"></i>
                                                        {{ number_format($room->price) ?? 'Liên hệ' }}/tháng
                                                    </h5>
                                                    <h5 class="me-4">
                                                        <i class="fa-solid fa-chart-area me-2"></i>
                                                        {{ $room->area ?? 'N/A' }}m&sup2;
                                                    </h5>
                                                </div>

                                                <!-- Địa chỉ -->
                                                <p class="text-secondary-emphasis">
                                                    <i class="fa-solid fa-location-dot"></i>
                                                    {{ $room->street ?? 'Không xác định' }},
                                                    {{ $room->ward->fullname ?? 'Không xác định' }},
                                                    {{ $room->district->fullname ?? 'Không xác định' }},
                                                    {{ $room->city->fullname ?? 'Không xác định' }}
                                                </p>

                                                <!-- Người đăng -->
                                                <div class="d-flex justify-content-between">
                                                    <p>
                                                        <img src="{{ $room->user->avatar ?? 'https://cdn.vectorstock.com/i/500p/52/38/avatar-icon-vector-11835238.jpg' }}"
                                                            alt="Avatar" class="rounded-circle me-2"
                                                            style="width: 40px; height: 40px;">
                                                        <span class="text-secondary-emphasis">
                                                            {{ $room->user->name ?? 'Người dùng ẩn danh' }}
                                                        </span>
                                                    </p>
                                                    <p></p>
                                                    <div>
                                                        @if (isset($room->user) && ($room->user->zalo || $room->user->facebook))
                                                            <a href="https://zalo.me/{{ $room->user->zalo }}"
                                                                class="btn btn-outline-success me-1">Nhắn Zalo</a>
                                                            <a href="https://{{ $room->user->facebook }}"
                                                                class="btn btn-primary">Facebook</a>
                                                        @else
                                                            <span class="text-muted">Không có thông tin liên hệ</span>
                                                        @endif

                                                    </div>
                                                </div>
                                                <p class="text-sm-end mb-0"><i
                                                        class="fa-regular fa-clock me-2"></i>{{ $room->time_elapsed ?? 'Mới đăng' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                        {{-- Pagination --}}
                        <div class="fs-5 mt-3">
                            {{ $roomsOutstanding->links('pagination::bootstrap-4') }}
                        </div>
                    @endif
                </div>
            </div>
            {{-- Danh sách cho thuê --}}
            <div class="col-6 col-md-4">
                <div>
                    {{-- Danh muc cho thue  --}}
                    <div class="border border-1 rounded-2">
                        <h3 class="p-3 text-center">Danh mục cho thuê</h3>
                        <ul class=" list-unstyled">
                            @foreach ($categories as $key => $category)
                                <li class="border border-5 border-bottom-0 border-start-0 border-end-0 p-2">
                                    <i class="fa-solid fa-tag text-success me-2"></i>
                                    <a href="{{ route('category', ['slug' => $category->slug]) }}"
                                        class="text-decoration-none text-secondary-emphasis hover-danger">
                                        {{ ucfirst($category->name) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Bai do admin viết --}}
                    <div class="border border-1 rounded-2 mt-5">
                        <h3 class="p-3 text-center">Bài viết mới</h3>
                        <ul class=" list-unstyled">
                            @foreach ($categories as $key => $category)
                                <li class="border border-5 border-bottom-0 border-start-0 border-end-0 p-2">
                                    <i class="fa-solid fa-tag text-success me-2"></i>
                                    <a href="{{ route('category', ['slug' => $category->slug]) }}"
                                        class="text-decoration-none text-secondary-emphasis hover-danger">
                                        {{ ucfirst($category->name) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>

            {{-- Danh sách tin đăng --}}
            <div class="col-sm-6 col-md-8 pe-2">
                <div class="me-2">
                    <h3 class="p-3 text-center border border-1 shadow-lg bg-body-tertiary">Danh sách tin đăng</h3>
                    @foreach ($rooms as $room)
                        @if ($room->new_type_id !== 5)
                            <a href="{{ route('detail', ['id' => $room->id]) }}" class="text-decoration-none">
                                <div class="border border-1 rounded-4 shadow-lg bg-body-tertiary rounded mb-3">
                                    <div class="p-3 d-flex flex-row">
                                        <!-- Hình ảnh -->
                                        <div style="width: 300px; height: 220px;">
                                            <img src="{{ $room->image_logo ?? 'https://via.placeholder.com/300' }}"
                                                alt="hinhAnh" class="rounded-3 img-fluid"
                                                style="width: 300px; height: 220px;">
                                        </div>

                                        <!-- Thông tin -->
                                        <div class="ps-3 w-100">
                                            <div id="stars">
                                                @for ($i = 0; $i < ($room->new_type_id ?? 0); $i++)
                                                    <i class="fa-solid fa-star text-warning"></i>
                                                @endfor
                                            </div>
                                            <strong
                                                class="text-danger fs-5">{{ $room->title ?? 'Không có tiêu đề' }}</strong>

                                            <!-- Giá, diện tích, thời gian -->
                                            <div class="d-flex flex-wrap mt-2">
                                                <h5 class="me-4">
                                                    <i class="fa-solid fa-money-bill-wave me-2"></i>
                                                    {{ number_format($room->price) ?? 'Liên hệ' }}/tháng
                                                </h5>
                                                <h5 class="me-4">
                                                    <i class="fa-solid fa-chart-area me-2"></i>
                                                    {{ $room->area ?? 'N/A' }}m&sup2;
                                                </h5>
                                            </div>

                                            <!-- Địa chỉ -->
                                            <p class="text-secondary-emphasis">
                                                <i class="fa-solid fa-location-dot"></i>
                                                {{ $room->street ?? 'Không xác định' }},
                                                {{ $room->ward->fullname ?? 'Không xác định' }},
                                                {{ $room->district->fullname ?? 'Không xác định' }},
                                                {{ $room->city->fullname ?? 'Không xác định' }}
                                            </p>

                                            <!-- Người đăng -->
                                            <div class="d-flex justify-content-between">
                                                <p>
                                                    <img src="{{ $room->user->avatar ?? 'https://cdn.vectorstock.com/i/500p/52/38/avatar-icon-vector-11835238.jpg' }}"
                                                        alt="Avatar" class="rounded-circle me-2"
                                                        style="width: 40px; height: 40px;">
                                                    <span class="text-secondary-emphasis">
                                                        {{ $room->user->name ?? 'Người dùng ẩn danh' }}
                                                    </span>
                                                </p>
                                                <p></p>
                                                <div>
                                                    @if (isset($room->user) && ($room->user->zalo || $room->user->facebook))
                                                        <a href="zalo.me/{{ $room->user->zalo }}"
                                                            class="btn btn-outline-success me-1">Nhắn Zalo</a>
                                                        <a href="{{ $room->user->facebook }}"
                                                            class="btn btn-primary">Facebook</a>
                                                    @else
                                                        <span class="text-muted">Không có thông tin liên hệ</span>
                                                    @endif

                                                </div>
                                            </div>
                                            <p class="text-sm-end mb-0"><i
                                                    class="fa-regular fa-clock me-2"></i>{{ $room->time_elapsed ?? 'Mới đăng' }}
                                            </p>

                                        </div>

                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                    {{-- Pagination --}}
                    <div class="fs-5 mt-3">
                        {{ $rooms->appends(request()->all())->links('pagination::bootstrap-4') }}
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function(e) {
            e.preventDefault();
        });
    </script>
@endsection
<style>
    #stars {
        font-size: 24px;
        color: gold;
    }

    .hover-danger {
        color: #6c757d;
        /* Màu mặc định (text-secondary-emphasis) */
        text-decoration: none;
        transition: color 0.3s ease;
        /* Hiệu ứng chuyển đổi mượt mà */
    }

    .hover-danger:hover {
        color: red !important;
        /* Màu chữ khi hover */
    }
</style>
