<div id="sidebar">
    <div class="sidebar-title">
        <h1>Menu Quản Trị</h1>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-item">
            <a href="{{ route('admin.index') }}">
                <i class="fa-solid fa-palette me-3"></i>
                Bảng điều khiển
            </a>
        </li>
        <li class="menu-item">
            <a href="#" data-bs-toggle="collapse" data-bs-target="#quanLyTinDang" aria-expanded="false"
                aria-controls="quanLyTinDang">
                <i class="fa-solid fa-folder-plus me-3"></i>
                Quản lý tin đăng
                <i class="fa-solid fa-arrows-up-down ps-3"></i>
            </a>
            <ul class="sidebar-menu-mini collapse" id="quanLyTinDang">
                <li class="menu-item-mini"><a href="{{ route('admin.post-unpaid') }}">Chưa thanh toán</a></li>
                <li class="menu-item-mini"><a href="{{ route('admin.post-pending') }}">Chờ duyệt</a></li>
                <li class="menu-item-mini"><a href="{{ route('admin.post-approved') }}">Đã duyệt</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" data-bs-toggle="collapse" data-bs-target="#quanLyHeThong" aria-expanded="false"
                aria-controls="quanLyHeThong">
                <i class="fa-solid fa-list-check me-3"></i>
                Quản lý hệ thống
                <i class="fa-solid fa-arrows-up-down ps-3"></i>
            </a>
            <ul class="sidebar-menu-mini collapse" id="quanLyHeThong">
                <li class="menu-item-mini"><a href="{{ route('admin.slider') }}">Quản lý slider</a></li>
                <li class="menu-item-mini"><a href="{{ route('admin.category') }}">Quản lý danh mục</a></li>
                <li class="menu-item-mini"><a href="{{ route('admin.new-type') }}">Quản lý loại tin</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" data-bs-toggle="collapse" data-bs-target="#quanLyNguoiDung" aria-expanded="false"
                aria-controls="quanLyNguoiDung">
                <i class="fa-solid fa-people-roof me-3"></i>
                Quản lý người dùng
                <i class="fa-solid fa-arrows-up-down ps-3"></i>
            </a>
            <ul class="sidebar-menu-mini collapse" id="quanLyNguoiDung">
                <li class="menu-item-mini"><a href="{{ route('admin.user-manager') }}">Quản lý user</a></li>
                <li class="menu-item-mini"><a href="{{ route('admin.admin-manager') }}">Quản lý admin</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" data-bs-toggle="collapse" data-bs-target="#quanLyTinTuc" aria-expanded="false"
                aria-controls="quanLyTinTuc">
                <i class="fa-solid fa-rss me-3"></i>
                Quản lý tin tức
                <i class="fa-solid fa-arrows-up-down ps-3"></i>
            </a>
            <ul class="sidebar-menu-mini collapse" id="quanLyTinTuc">
                <li class="menu-item-mini"><a href="{{ route('admin.make-news') }}">Thêm tin mới</a></li>
                <li class="menu-item-mini"><a href="{{ route('admin.posted-news') }}">Tin đã đăng</a></li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" data-bs-toggle="collapse" data-bs-target="#quanLyThanhToan" aria-expanded="false"
                aria-controls="quanLyThanhToan">
                <i class="fa-solid fa-money-bills me-3"></i>
                Quản lý thanh toán
                <i class="fa-solid fa-arrows-up-down ps-3"></i>
            </a>
            <ul class="sidebar-menu-mini collapse" id="quanLyThanhToan">
                <li class="menu-item-mini"><a href="{{ route('admin.payment-history-manager') }}">Lịch sử thanh toán</a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a href="#" data-bs-toggle="collapse" data-bs-target="#quanLyPhanHoi" aria-expanded="false"
                aria-controls="quanLyPhanHoi">
                <i class="fa-solid fa-envelope-open-text me-3"></i>
                Quản lý phản hồi
                <i class="fa-solid fa-arrows-up-down ps-3"></i>
            </a>
            <ul class="sidebar-menu-mini collapse" id="quanLyPhanHoi">
                <li class="menu-item-mini"><a href="{{ route('admin.unresolved_feedback') }}">Chưa giải quyết</a></li>
                <li class="menu-item-mini"><a href="{{ route('admin.response_resolved') }}">Đã giải quyết</a></li>
            </ul>
        </li>

        <li class="menu-item">
            <form action="{{ route('admin.logout') }}" method="post" class="text-center">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fa-solid fa-arrow-right-from-bracket me-3"></i>
                    Đăng xuất
                </button>
            </form>
        </li>
    </ul>
</div>
