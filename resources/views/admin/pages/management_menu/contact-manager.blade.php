@extends('admin.layout.master')

@section('content_admin')
    <div>
        <h1>Phản hồi đã giải quyết</h1>
        <hr>
        <div class="main-right-table">
            <table class="table table-bordered table-post-list" id = "table-manage">
                <thead>
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 10%;">Họ tên</th>
                        <th style="width: 10%;">SĐT</th>
                        <th style="width: 10%;">Email</th>
                        <th style="width: 10%;">Vấn đề</th>
                        <th style="width: 30%;">Nội dung</th>
                        <th style="width: 7%;">Thời gian</th>
                        <th style="width: 8%;">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contact as $value)
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->phone }}</td>
                            <td>{{ $value->email }}</td>
                            @php
                                switch ($value->problem) {
                                    case 1:
                                        $problemText = 'Giải đáp thắc mắc';
                                        break;
                                    case 2:
                                        $problemText = 'Hỗ trợ đăng bài';
                                        break;
                                    case 3:
                                        $problemText = 'Hỗ trợ thanh toán';
                                        break;
                                    case 4:
                                        $problemText = 'Giải quyết khiếu nại';
                                        break;
                                    default:
                                        $problemText = 'Không xác định';
                                }
                            @endphp

                            <td>{{ $problemText }}</td>
                            <td>{{ $value->message }}</td>
                            <td>{{ $value->created_at }}</td>
                            <td>
                                @if ($value->status)
                                    <p class="text-success">Đã giải quyết</p>
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
        {{ $contact->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
@endsection
