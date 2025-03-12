<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Can Ho Cho Thue</title>
</head>
{{-- Bootstrap CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
{{-- FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
{{-- Asset CSS --}}
<link rel="stylesheet" href="{{ asset('css/slider.css') }}">
<link rel="stylesheet" href="{{ asset('css/logo.css') }}">

<body>

    @include('include.header')
    @if (!request()->is('contact') && !request()->is('price-list'))
        <div style="margin-top: 110px">
            @include('include.slider')
        </div>
    @endif

    @if (!request()->is('category'))
        <div class="container mt-3">
            <h1>Slider title</h1>
            <p>Slider description</p>

            <div class="d-flex">
                <div style="width: 68%;" class="me-2">
                    {{-- Danh sách tin đăng --}}
                    <div class="border border-1 rounded-2">
                        <h3 class="p-3 text-center">Danh sách tin đăng</h3>
                        @foreach ($rooms as $room)
                            <a href="#" class="text-decoration-none">
                                <div class="border border-5 border-bottom-0 border-start-0 border-end-0"
                                    style="background-color: #7efff5;">

                                    <div class="d-flex justify-content-between p-3">
                                        <!-- Hình ảnh -->
                                        <div>
                                            <img src="{{ $room->image_logo ?? 'https://via.placeholder.com/300' }}"
                                                alt="hinhAnh" class="rounded-3 img-fluid" style="width: 300px; height: 220px;">
                                        </div>
    
                                        <div></div>
                                        <!-- Thông tin -->
                                        <div style="width: 500px;">
                                            {{-- <div class="d-flex justify-content-between"> --}}
                                                <p class="bg-warning rounded-pill p-1 mb-2 text-center" style="width: 150px;">
                                                    {{ $room->newType->name_type ?? 'Không xác định' }}
                                                </p>
                                            {{-- </div> --}}
    
                                            <strong class="text-danger">{{ $room->title ?? 'Không có tiêu đề' }}</strong>
    
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
                                                        alt="Avatar" class="rounded-circle me-2" style="width: 40px;">
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
                        @endforeach
                    </div>
                </div>

                {{-- Danh sách cho thuê --}}
                <div style="width: 30%;">

                    <div class="border border-1 rounded-2">
                        <h3 class="p-3 text-center">Danh mục cho thuê</h3>

                        <ul class="border border-5 border-bottom-0 border-start-0 border-end-0 list-unstyled">

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
        </div>
    @else
        @yield('content')
    @endif


    @include('include.footer')

</body>
{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

{{-- jQuery  --}}
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $(window).scrollTop(0);
    });
</script>

</html>
