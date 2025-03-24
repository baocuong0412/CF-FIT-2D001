@extends('clients.layout.master')

@section('content_client')
    <div class="mx-3 mt-3" style="width: 1570px">
        <h1 class="pt-2">Lịch sử nạp tiền</h1>
        <hr>
        <div class=" mt-3 text-center">
            <h3 class="text-start">Bảng danh sách nạp tiền</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Mã giao dịch</th>
                        <th>Hình thức</th>
                        <th>Số tiền</th>
                        <th>Ngày thực hiện</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($depositMoney as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->pay_code }}</td>
                            <td>{{ $item->payment_method }}</td>
                            <td>{{ number_format($item->pay_price) }} VNĐ</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="fs-4">
            {{ $depositMoney->appends(request()->all())->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
