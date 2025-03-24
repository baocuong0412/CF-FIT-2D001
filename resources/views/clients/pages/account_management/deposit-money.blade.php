{{-- ------------------------------------------------------- --}}
{{-- Nap tien vao tai khoan --}}
{{-- ------------------------------------------------------- --}}

@extends('clients.layout.master')

@section('content_client')
    <div class="ms-3" style="width: 1570px">
        <h1 class="pt-2">Nạp tiền vào tài khoản</h1>
        <hr>
        <div class="alert alert-warning p-3">
            <h5 class="text-danger">Lưu ý khi nạp tiền</h5>
            <ul class="text-danger">
                <li>Vui lòng kiểm tra lại thông tin thanh toán trước khi xác nhận thanh toán.</li>
                <li>Điền đầy đủ thông tin thanh toán vào form thanh toán VNPAY.</li>
                <li>Bạn vui lòng hoàn tất các bước để tiến hành thanh toán thành công.</li>

            </ul>
        </div>
        <h3 class="mt-2">Lựa chọn hình thức nạp tiền</h3>
        <div class="d-flex">
            <div class="me-3 rounded-4 p-2 border border-3 text-center item">
                <a href="{{ route('client.deposit-money-vnpay') }}" class="text-decoration-none">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTp1v7T287-ikP1m7dEUbs2n1SbbLEqkMd1ZA&s"
                        alt="VNPay" style="width: 200px; height: 200px;">
                    <hr>
                    Qua VNPAY
                </a>
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

@section('js_client')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
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
