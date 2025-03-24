@extends('admin.layout.master')

@section('content_admin')
    <div>
        <h1>Phản hồi chưa giải quyết</h1>
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
                        <th style="width: 10%;">Hành động</th>
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
                                @if (!$value->status)
                                    <p class="text-warning">Chưa giải quyết</p>
                                @endif
                            </td>
                            <td>
                                <a href="javascript:void(0);" class="fs-1 update-status" data-id="{{ $value->id }}">
                                    <i class="fa-solid fa-check"></i>
                                </a>
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

@section('js_admin')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).on("click", ".update-status", function(e) {
            e.preventDefault();

            let id = $(this).data("id");

            Swal.fire({
                title: "Bạn có chắc chắn?",
                text: "Bạn có muốn cập nhật trạng thái không?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Có, cập nhật!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/admin/update-status/" + id, // Sửa đường dẫn
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: 1
                        },
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}" // Thêm header
                        },
                        success: function(response) {
                            Swal.fire("Thành công!", "Trạng thái đã được cập nhật.", "success")
                                .then(() => location.reload());
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText); // In lỗi chi tiết để debug
                            Swal.fire("Lỗi!", "Có lỗi xảy ra, vui lòng thử lại.", "error");
                        }
                    });
                }
            });
        });
    </script>
@endsection
