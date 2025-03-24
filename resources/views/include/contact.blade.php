@extends('welcome')

@section('content')
    <div class="container mb-4" style="margin-top: 108px;">
        <h2>Liên hệ với chúng tôi</h2>
        <p>Bạn đang có thắc mắc, bạn đang không biết làm sao để đăng bài, bạn muốn khiếu nại thì hãy liên hệ với chúng tôi
            để được giúp đỡ nhé!</p>
        <div class="row">
            <div style="width: 513px" class="col border border-2 rounded p-4 me-2">
                <form action="{{ route('post_contact') }}" method="POST">
                    @csrf
                    <h3 class="text-center">Điền thông tin vào biểu mẫu này!</h3>
                    <div>
                        <label for="name" class="py-2">Tên Người Dùng</label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->name ?? '' }}"
                            class="w-100">
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="py-2">Số điện thoại</label>
                        <input type="number" id="phone" name="phone" value="{{ Auth::user()->phone ?? '' }}"
                            class="w-100">
                        @error('phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="py-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ Auth::user()->email ?? '' }}"
                            class="w-100">
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="problem" class="py-2">Loại vấn đề cần giải quyết</label><br>
                        <select id="problem" name="problem" class="form-select">
                            <option value="">-- Vấn đề cần giải quyết --</option>
                            <option value="1">Giải đáp thắc mắc</option>
                            <option value="2">Hỗ trợ đăng bài</option>
                            <option value="3">Hỗ trợ thanh toán</option>
                            <option value="4">Giải quyết khiếu nại</option>
                        </select>
                        @error('problem')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="py-2">Nội dung</label><br>
                        <textarea id="message" name="message" rows="5" class="w-100"></textarea>
                        @error('message')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
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
                <p>Chúng tôi sẽ tiếp nhận thông tin, bộ phận chăm sóc khách hàng của chúng tôi sẽ liên hệ và hỗ trợ giúp
                    bạn.</p>
                <p>Mọi thông tin vui lòng liên hệ:</p>
                <p>Hotline: 0372901029</p>
                <p>Email: chungvobaocuong@gmail.com</p>
            </div>
        </div>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: "{{ session('error') }}",
                showConfirmButton: true
            });
        </script>
    @endif
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            let successMessage = @json(session('success', ''));
            let errorMessage = @json(session('error', ''));

            if (successMessage !== '') {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: successMessage,
                    showConfirmButton: false,
                    timer: 2000
                });
            }

            if (errorMessage !== '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: errorMessage,
                    showConfirmButton: true
                });
            }
        });
    </script>
@endsection
