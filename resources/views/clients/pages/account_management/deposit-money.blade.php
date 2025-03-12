{{-- ------------------------------------------------------- --}}
{{-- Nap tien vao tai khoan --}}
{{-- ------------------------------------------------------- --}}

@extends('clients.layout.master')

@section('content_client')
    <div class="ms-3" style="width: 1570px">
        <h1 class="pt-2">Nạp tiền vào tài khoản</h1>
        <hr>
        <div class="alert alert-warning p-3">
            <h5>Lưu ý khi nạp tiền</h5>
            <ul>
                <li>Vui lòng kiểm tra lại thông tin thanh toán trước khi xác nhận thanh toán.</li>
                <li>Điền đầy đủ thông tin thanh toán vào form thanh toán VNPAY.</li>
                <li>Bạn vui lòng hoàn tất các bước để tiến hành thanh toán thành công.</li>

            </ul>
        </div>
        {{-- <div>
            <h3>Thanh Toán Bằng Số Dư</h3>
            <label for="balance">Số tiền cần thanh toán</label>
            <div class="d-flex">
                <input type="number" name="balance" id="balance" class="form-control me-2" value="{{ $room->newType->price ?? 0 }}" disabled style="width: 300px;; height: 50px">
                <button class="btn btn-primary">Thanh toán</button>
            </div>
        </div> --}}
        <h3 class="mt-2">Lựa chọn hình thức nạp tiền</h3>
        <div class="d-flex">                
            <div class="me-3 rounded-4 p-2 border border-3 text-center item">
                <a href="#" class="text-decoration-none">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTp1v7T287-ikP1m7dEUbs2n1SbbLEqkMd1ZA&s"
                        alt="VNPay" style="width: 200px; height: 200px;">
                    <hr>
                    Qua VNPAY
                </a>
            </div>
        </div>
    </div>
@endsection
