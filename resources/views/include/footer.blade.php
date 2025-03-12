<div class="container">
    <div class="border border-primary border-5 rounded mt-3 p-4 text-center">
        <h1>TẠI SAO LẠI CHỌN TÌM PHÒNG NHANH?</h1>
        <p>Chúng tôi biết bạn có rất nhiều lựa chọn, nhưng Tìm phòng nhanh tự hào là trang web đứng top google về các từ
            khóa: cho thuê phòng trọ, nhà trọ, thuê nhà nguyên căn, cho thuê căn hộ, tìm người ở ghép, cho thuê mặt
            bằng... Vì vậy tin của bạn đăng trên website sẽ tiếp cận được với nhiều khách hàng hơn, do đó giao dịch
            nhanh hơn, tiết kiệm chi phí hơn.</p>

        <div class="stats d-flex justify-content-around">
            <div class="stat-item">
                <h3 class="number text-danger">200.250+</h3>
                <span class="label">Thành viên</span>
            </div>
            <div class="stat-item">
                <h3 class="number text-danger">100.000++</h3>
                <span class="label">Bài đăng</span>
            </div>
            <div class="stat-item">
                <h3 class="number text-danger">250.000+</h3>
                <span class="label">Lượt truy cập/tháng</span>
            </div>
            <div class="stat-item">
                <h3 class="number text-danger">2.000.000+</h3>
                <span class="label">Lượt xem/tháng</span>
            </div>
        </div>

        <h2 class="pt-3">BẠN ĐANG CÓ PHÒNG TRỌ / CĂN HỘ CHO THUÊ?</h2>
        <p>Không phải lo tìm người cho thuê, phòng trống kéo dài.</p>
        <a href="{{ route('client.create-post') }}" class="btn btn-primary">Đăng tin ngay</a>
    </div>

    <div class="border border-danger border-5 rounded mt-3 p-4 text-center">
        <img src="{{ asset('images/support-bg.jpg') }}" alt="support-bg">
        <h2>Bạn đang gặp vấn đề gì?</h2>
        <p>Bạn đang gặp vấn đề về việc tìm nhà cần được hỗ trợ?</p>
        <p>Bạn đang khó khăn trong việc đăng bài cần hỗ trợ?</p>
        <p>Bạn đang gặp khó khăn trong thanh toán cần giúp đỡ?</p>
        <a href="{{ route('contact') }}" class="btn btn-primary">Gửi liên hệ</a>
    </div>
</div>

<div class="text-center mt-2" style="background-color: #bdc3c7">
    <div class="row text-start container mx-auto pt-2">
        <div class="col-md-3">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="logo" style="width: 220px">
            </a>
            <p class="mt-2">Tìm phòng nhanh tự hào có lượng dữ liệu bài đăng lớn nhất trong lĩnh vực cho thuê phòng trọ và được
                nhiều người lựa chọn là website uy tín để lựa chọn phòng trọ, thuê nhà, căn hộ, homestay,..
            </p>
        </div>

        <div class="col-md-3">
            <h4>Danh mục cho thuê</h4>
            <ul class="list-unstyled">
                @foreach ($categories as $key => $category)
                    <li>
                        <a href="{{ route('category', ['slug' => $category->slug]) }}" class="text-decoration-none" style="color: black">
                            <p>{{ ucfirst($category->name) }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
            </nav>
            </ul>
        </div>
        <div class="col-md-3">
            <h4>Hỗ trợ khách hàng</h4>
            <ul>
                <li>Câu hỏi thường gặp</li>
                <li>Hướng dẫn đăng tin</li>
                <li>Bảng giá dịch vụ</li>
                <li>Quy định đăng tin</li>
                <li>Giải quyết khiếu nại</li>
            </ul>
        </div>
        <div class="col-md-3">
            <h4>Liên hệ với chúng tôi</h4>
            <p>
                <a href="https://www.facebook.com/baocuong.chungvo/" class="text-decoration-none">
                    <img src="{{ asset('images/Facebook.jpg') }}" alt="fb" class="rounded-circle mx-3" style="width: 50px">
                </a>
                <a href="https://zalo.me/0372901029" class="text-decoration-none">
                    <img src="{{ asset('images/zalo.jpg') }}" alt="zalo" class="rounded-circle mx-3" style="width: 50px">
                </a>
            </p>
            
        </div>
    </div>
</div>
<div class="text-center bg-warning">
    <p>Copyright © Đồ án tốt nghiệp ngành CNTT</p>
</div>
