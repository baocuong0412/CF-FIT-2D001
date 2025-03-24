@extends('admin.layout.master')

@section('content_admin')
    <div>
        <h1>Quản lý thanh toán</h1>
        
        <form action="{{ route('admin.payment-history-manager') }}" method="get">
            <div class="row g-2">
                <div class="col-6">
                    <label for="nameUser" class="p-3">Tên KH:</label>
                    <input type="text" name="nameUser" class="form-control" value="{{ request('nameUser') }}">
                </div>

                <div class="col-6">
                    <label for="name_type" class="p-3">Loại tin:</label>
                    <select name="name_type" id="name_type" class="form-select fs-4">
                        <option value="">---Chọn loại tin---</option>
                        @foreach ($newTypes as $item)
                            <option value="{{ $item->id }}" {{ request('name_type') == $item->id ? 'selected' : '' }}>
                                {{ $item->name_type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6">
                    <label for="payment_method" class="p-3">Hình thức:</label>
                    <select name="payment_method" id="payment_method" class="form-select fs-4">
                        <option value="">---Chọn hình thức---</option>
                        <option value="account" {{ request('payment_method') == 'account' ? 'selected' : '' }}>Tài khoản
                            người dùng</option>
                        <option value="VNPAY" {{ request('payment_method') == 'VNPAY' ? 'selected' : '' }}>VNPay</option>
                    </select>
                </div>

                <div class="col-6">
                    <label for="status" class="p-3">Trạng thái:</label>
                    <select name="status" id="status" class="form-select fs-4">
                        <option value="">---Chọn trạng thái---</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Đã hủy</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Đã thành công</option>
                    </select>
                </div>
            </div>
            <div class="text-center mt-2">
                <button type="submit" class="btn btn-secondary w-25">Tìm kiếm</button>
                <a href="{{ route('admin.payment-history-manager') }}" class="btn btn-danger w-25">Xóa bộ lọc</a>
            </div>
        </form>

        <div class="main-right-table mt-2">
            <table class="table table-bordered table-post-list" id = "table-manage">
                <thead>
                    <tr>
                        <th style="width: 3%;">STT</th>
                        <th style="width: 15%;">Tên bài đăng</th>
                        <th style="width: 10%;">Loại tin</th>
                        <th style="width: 22%;">Mã giao dịch</th>
                        <th style="width: 10%;">Hình thức</th>
                        <th style="width: 10%;">Khách hàng</th>
                        <th style="width: 12%;">Số tiền</th>
                        <th style="width: 10%;">Ngày thực hiện</th>
                        <th style="width: 8%;">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentHistories as $value)
                        <tr>
                            <td>#{{ $loop->iteration }}</td>
                            <td>{{ $value->room->title }}</td>
                            <td>{{ $value->newType->name_type }}</td>
                            <td>{{ $value->pay_code }}</td>
                            <td>{{ $value->payment_method }}</td>
                            <td>{{ $value->user->name }}</td>
                            <td><strong>{{ number_format($value->pay_price) }} </strong>VNĐ</td>
                            <td>{{ $value->created_at }}</td>
                            <td>
                                @if ($value->status)
                                    <p class="text-success">Đã thành công</p>
                                @else
                                    <p class="text-warning">Đã hủy</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Pagination --}}
    <div class="fs-3">
        {{ $paymentHistories->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
@endsection
