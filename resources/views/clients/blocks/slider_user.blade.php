<style>
    .nav-item-post:hover {
        background-color: yellow;
    }

    .item-post {
        transition: font-size 0.3s ease-in-out;
    }

    .item-post:hover {
        font-size: 1.2em;
    }
</style>

<div class="bg-body-secondary"
    style="width: 300px; height: 100vh; position: fixed; top:70; bottom: 0; left: 0; z-index: 900;">
    <div class="d-flex" style="margin-top: 60px">
        <img src="https://cdn.vectorstock.com/i/500p/52/38/avatar-icon-vector-11835238.jpg" alt="User"
            class="rounded-circle mt-3 mx-2" width="70" height="70">
        <div class="mt-3 ms-2">
            <span>Xin chào: <strong>{{ Auth::user()->name }}</strong></span><br>
            <span>SĐT: <strong>{{ Auth::user()->phone ?? 'Chưa có số' }}</strong></span><br>
            <span>Số dư: <strong>{{ number_format(Auth::user()->balance) }} VNĐ</strong></span>
        </div>
    </div>

    <div class="input-group mt-3 px-2">
        <span class="input-group-text" id="basic-addon1"><strong>Mã Code</strong></span>
        <input type="text" class="form-control bg-light" value="{{ Auth::user()->pay_code  }}" aria-label="Username"
            aria-describedby="basic-addon1" disabled>
    </div>

    <div class="text-center">
        <a href="{{ route('client.deposit-money') }}" class="mt-3 btn btn-success" style="width: 280px;">Nạp Tiền</a>
    </div>

    <hr>

    <ul class="list-unstyled text-center">
        <li class="p-3 text-start nav-item-post">
            <a href="{{ route('client.personal-page') }}" class="text-decoration-none text-secondary-emphasis d-block">
                <i class="fa-solid fa-palette pe-2"></i> Thông tin cá nhân
            </a>
        </li>

        <li class="p-3 text-start nav-item-post">
            <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                aria-controls="collapseExample" class="text-decoration-none text-secondary-emphasis d-block">
                <i class="fa-solid fa-folder-open pe-2"></i> Quản lý tin đăng
                <i class="fa-solid fa-arrows-up-down ps-3"></i>
            </a>
            <div class="collapse" id="collapseExample">
                <div class="card card-body bg-body-secondary">
                    <a href="{{ route('client.create-post') }}"
                        class="text-decoration-none p-2 d-block text-secondary-emphasis item-post">Thêm Tin</a>
                    <a href="{{ route('client.post-unpaid') }}"
                        class="text-decoration-none p-2 d-block text-secondary-emphasis item-post">Tin Chưa Thanh
                        Toán</a>
                    <a href="{{ route('client.post-manage') }}"
                        class="text-decoration-none p-2 d-block text-secondary-emphasis item-post">Tin Đã Thanh Toán</a>
                </div>
            </div>
        </li>

        <li class="p-3 text-start nav-item-post">
            <a href="{{ route('client.deposit-money') }}" class="text-decoration-none text-secondary-emphasis d-block">
                <i class="fa-solid fa-money-bill pe-2"></i> Nạp tiền vào tài khoản
            </a>
        </li>

        <li class="p-3 text-start nav-item-post">
            <a href="{{ route('client.deposit-money-history') }}"
                class="text-decoration-none text-secondary-emphasis d-block">
                <i class="fa-solid fa-money-bill-transfer pe-2"></i> Lịch sử nạp tiền
            </a>
        </li>

        <li class="p-3 text-start nav-item-post">
            <a href="{{ route('client.payment-history') }}"
                class="text-decoration-none text-secondary-emphasis d-block">
                <i class="fa-solid fa-money-check-dollar pe-2"></i> Lịch sử thanh toán
            </a>
        </li>

        <li class="p-3 text-start nav-item-post">
            <a href="{{ route('price-list') }}" class="text-decoration-none text-secondary-emphasis d-block">
                <i class="fa-solid fa-landmark-dome pe-2"></i> Bảng giá dịch vụ
            </a>
        </li>

        <li class="p-3 text-start nav-item-post">
            <a href="{{ route('contact') }}" class="text-decoration-none text-secondary-emphasis d-block">
                <i class="fa-solid fa-address-book pe-2"></i> Liên hệ
            </a>
        </li>

        <li class="p-3 text-start nav-item-post">
            <a href="{{ route('home') }}" class="text-decoration-none text-secondary-emphasis d-block">
                <i class="fa-solid fa-outdent pe-2"></i> Thoát
            </a>
        </li>
    </ul>
</div>
