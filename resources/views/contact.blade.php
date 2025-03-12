@extends('welcome')

@section('content')
    <div class="container mb-4" style="margin-top: 108px;">
        <h2>Liên hệ với chúng tôi</h2>
        <p>Bạn đang có thắc mắc, bạn đang không biết làm sao để đăng bài, bạn muốn khiếu nại thì hãy liên hệ với chúng tôi
            để được giúp đỡ nhé!</p>
        <div class="row">
            <div style="width: 513px" class="col border border-2 rounded p-4 me-2">
                <form action="#" method="POST">
                    @csrf
                    <h3 class="text-center">Điền thông tin vào biểu mẫu này!</h3>
                    <div>
                        <label for="name" class="py-2">Tên Người Dùng</label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name ?? '' }}" required class="w-100">
                    </div>

                    <div>
                        <label for="phone" class="py-2">Số điện thoại</label>
                        <input type="text" id="phone" name="phone" value="{{Auth::user()->phone ?? '' }}" required class="w-100">
                    </div>

                    <div>
                        <label for="email" class="py-2">Email</label>
                        <input type="email" id="email" name="email" value="{{Auth::user()->email ?? '' }}" required class="w-100">
                    </div>

                    <div>
                        <label for="issue" class="py-2">Loại vấn đề cần giải quyết</label><br>
                        <select id="issue" name="issue" class="form-select">
                            <option value="">-- Vấn đề cần giải quyết --</option>
                            <option value="thac_mac">Giải đáp thắc mắc</option>
                            <option value="ho_tro_dang_bai">Hỗ trợ đăng bài</option>
                            <option value="ho_tro_thanh_toan">Hỗ trợ thanh toán</option>
                            <option value="giai_quyet_khieu_nai">Giải quyết khiếu nại</option>
                        </select>
                    </div>

                    <div>
                        <label for="content" class="py-2">Nội dung</label><br>
                        <textarea id="content" name="content" rows="5" required class="w-100"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2 w-100">Gửi thông tin</button>
                </form>
            </div>

            <div class="col rounded-4 p-4 me-2" style="width: 513px; background-color: #48dbfb">
                <h3 class="text-center">Lưu ý</h3>
                <p>Chúng tôi tin rằng bạn có rất nhiều lựa chọn và nhiều kênh thông tin để tìm kiếm, cảm ơn bạn đã tin tưởng
                    chúng tôi.</p>
                <p>Nếu bạn đang cần giúp đỡ:</p>
                <ul>
                    <li>Giải đáp thắc mắc</li>
                    <li>Hỗ trợ đăng bài</li>
                    <li>Hỗ trợ thanh toán</li>
                    <li>Giải quyết khiếu nại</li>
                </ul>
                <p>Hãy điền đầy đủ những thông tin cần thiết vào form bên và gửi cho chúng tôi.</p>
                <p>Chúng tôi sẽ tiếp nhận thông tin, bộ phận chăm sóc khách hàng của chúng tôi sẽ liên hệ và hỗ trợ giúp bạn.</p>
                <p>Mọi thông tin vui lòng liên hệ:</p>
                <p>Hotline: 0372901029</p>
                <p>Email: chungvobaocuong@gmail.com</p>
            </div>
        </div>
    </div>
@endsection
