@extends('clients.layout.master')

@section('content_client')
    <div class="mx-3 mt-3" style="width: 1570px">
        <h1 class="pt-2">Lịch sử thanh toán</h1>
        <hr>
        <div class=" mt-3 text-center">
            <h3 class="text-start">Bảng danh sách thanh toán</h3>

            <form action="{{ route('client.payment-history') }}" method="GET">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="d-flex">
                            <label for="payment_method" class="w-50 mt-2">Hình thức:</label>
                            <select name="payment_method" id="payment_method" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="account"
                                    {{ request()->get('payment_method') == 'account' ? 'selected' : '' }}>
                                    Trừ tiền tài khoản</option>
                                <option value="VNPAY" {{ request()->get('payment_method') == 'VNPAY' ? 'selected' : '' }}>
                                    Chuyển khoản ngân hàng</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </div>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên bài viểt</th>
                        <th>Mã thanh toán</th>
                        <th>Số tiền</th>
                        <th>Hình thức</th>
                        <th>Ngày thực hiện</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentHistory as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if ($item->room_id == null)
                                    <p class="text-danger">Bài viết đã bị hủy</p>
                                @else
                                    {{ $item->room->title }}
                                @endif
                            </td>
                            <td>{{ $item->pay_code }}</td>
                            <td>{{ number_format($item->pay_price) }} đồng</td>
                            <td>
                                @switch($item->payment_method)
                                    @case('account')
                                        <p>Trừ tiền tài khoản</p>
                                    @break

                                    @case('VNPAY')
                                        <p>Chuyển khoản ngân hàng</p>
                                    @break
                                @endswitch
                            </td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                @if ($item->status == 1)
                                    <p class="text-success">Đang hoạt động</p>
                                @else
                                    <p class="text-warning">Đã hủy</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="fs-4">
            {{ $paymentHistory->appends(request()->all())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
