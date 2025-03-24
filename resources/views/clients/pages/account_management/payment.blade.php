@extends('clients.layout.master')

@section('content_client')
    <div class="mx-3 mt-3" style="width: 1570px">
        <h1 class="pt-2">Thanh toán tin</h1>
        <hr>
        <div class="alert alert-warning p-3">
            <h5 class="text-danger">Lưu ý</h5>
            <ul class="text-danger">
                <li>Chọn hình thức thanh toán và tiến hành thanh toán.</li>
                <li>Với phương thức chuyển khoản qua nhân hàng nhớ ghi đúng nội dung chuyển khoản hiện thị.</li>
                <li>Nếu có thắc mắc hoặc cần giúp đỡ hãy liên hệ với chúng tôi ngay</li>

            </ul>
        </div>
        <div class="text-center border border-1 rounded-3 shadow-lg p-3 mb-5 bg-body-tertiary rounded w-50 mx-auto">
            <h3>Cho thuê phòng trọ khép kín tự quản</h3>
            <p>Thời gian đăng bài:<strong> 5 ngày </strong>{{ sprintf('(%s đến %s)', $room->time_start, $room->time_end) }}
            </p>
            <p>Loại tin đăng: <strong>{{ $room->newType->name_type }}</strong></p>
            <p>Tổng tiền thanh toán: <strong>{{ number_format($total) }} đồng</strong></p>
            <p>Mã thanh toán: </p>
            <input type="text" name="pay_code" value="{{ $pay_code }}"
                class="form-control w-75 mx-auto text-center text-danger fs-4" disabled>

            <h3 class="mt-2">Lựa chọn hình thức thanh toán</h3>
            <form action="{{ route('client.post-payment', ['id' => $room->id]) }}" method="post">
                @csrf
                <div class="text-start ms-5 d-flex flex-column">
                    <!-- Di chuyển ô nhập mã thanh toán lên trên -->
                    <div class="text-center mb-3">
                        <p class="pt-2">Nội dung chuyển khoản:</p>
                        <input type="text" name="pay_code" value="{{ $pay_code }}"
                            class="form-control w-50 mx-auto text-center text-danger" readonly>

                        <p class="mt-2">Số tiền cần chuyển khoản: <strong>{{ number_format($total) }} đồng</strong></p>
                    </div>
                    <!-- Phần chọn phương thức thanh toán -->
                    <div class="form-check py-2">
                        <input class="form-check-input" type="radio" name="pay" value="account" id="flexRadioDefault1"
                            checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                            Trừ tiền trong tài khoản Timphonghanh (Số dư hiện tại:
                            <strong>{{ number_format($room->user->balance) }}</strong> đồng)
                        </label>
                    </div>
                    <div class="form-check py-2">
                        <input class="form-check-input" type="radio" name="pay" value="VNPAY" id="flexRadioDefault2">
                        <label class="form-check-label" for="flexRadioDefault2">
                            Thanh toán qua ví điện tử VNPay
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Thanh toán</button>
            </form>

        </div>
    </div>
@endsection
