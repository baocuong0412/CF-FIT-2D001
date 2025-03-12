<header class="fixed-top bg-white shadow-sm">
    <div class="d-flex justify-content-around align-items-center p-2 px-md-4">
        <!-- Logo -->
        <a href="/" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="logo" style="width: 100px">
        </a>

        <!-- User Info or Auth Links -->
        <div class="d-flex align-items-center">
            @auth
                <!-- User Info -->
                <div class="d-flex align-items-center">
                    <img src="https://cdn.vectorstock.com/i/500p/52/38/avatar-icon-vector-11835238.jpg" alt="User"
                        class="rounded-circle" style="width: 50px; height: 50px;">
                    <div class="ms-2">
                        <span>Xin chào, <strong>{{ Auth::user()->name }}</strong></span><br>
                        <span>Số dư: <strong>{{ number_format(Auth::user()->balance) }} VNĐ</strong></span>
                    </div>

                    <!-- Dropdown Menu -->
                    <div class="dropdown ms-3">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-list-check"></i> Quản lý tài khoản
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('client.post-manage') }}"><i
                                        class="fa-solid fa-bars-progress me-2"></i> Quản lý tin đăng</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.deposit-money') }}"><i
                                        class="fa-solid fa-file-invoice-dollar me-2"></i> Nạp tiền</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.deposit-money-history') }}"><i
                                        class="fa-solid fa-clock-rotate-left me-2"></i> Lịch sử nạp tiền</a></li>
                            <li><a class="dropdown-item" href="{{ route('client.personal-page') }}"><i
                                        class="fa-solid fa-user me-2"></i> Thông tin cá nhân</a></li>
                            <li>
                                <a href="{{ route('logout') }}" class="dropdown-item"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa-solid fa-right-from-bracket me-2"></i> Đăng xuất
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary me-2">Đăng nhập</a>
                <a href="{{ route('register') }}" class="btn btn-warning">Đăng ký</a>
            @endauth

            <!-- Đăng tin button -->
            <a href="{{ route('client.create-post') }}" class="btn btn-danger ms-2">
                Đăng tin <i class="fa-solid fa-plus ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-primary">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link text-white px-3">Trang chủ</a>
            </li>
            @foreach ($categories as $key => $category)
                <li class="nav-item">
                    <a href="{{ route('category', ['slug' => $category->slug]) }}" class="nav-link text-white px-3">
                        {{ ucfirst($category->type) }}
                    </a>
                </li>
            @endforeach
            <li class="nav-item">
                <a href="#" class="nav-link text-white px-3">Tin Tức</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('price-list') }}" class="nav-link text-white px-3">Bảng giá</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('contact') }}" class="nav-link text-white px-3">Liên hệ</a>
            </li>
        </ul>
    </nav>

</header>
