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
                <li>Vui lòng kiểm số tiền bạn muốn nạp vào tài khoản</li>
                <li>Vui lòng nạp tối thiểu <strong>50.000 VNĐ</strong></li>
                <li>Bạn vui lòng hoàn tất các bước để tiến hành thanh toán thành công.</li>

            </ul>
        </div>
        <h3 class="mt-2">Nhập số tiền bạn muốn nạp vào tài khoản</h3>
        <form action="{{ route('client.post.deposit-money-vnpay') }}" method="post">
            @csrf
            <div class="w-25 d-flex">
                <input type="number" name="pay_price" class="input-group px-4 rounded-start-pill"
                    placeholder="Nhập số tiền nạp" style="height: 38px;">
                <span class="rounded-end-circle p-1 pe-2 bg-secondary" style="height: 38px;"><strong
                        class="text-light">Đồng</strong></span>
            </div>
            <input type="hidden" name="pay_code" value="{{ auth()->user()->pay_code }}">
            @error('pay_price')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-success mt-3" style="height: 38px; width: 25%;">Nạp Tiền</button>
        </form>
    </div>
@endsection
