@extends('admin.layout.master')

@section('content_admin')
    <div class="row">
        <h1>Quản lý người dùng</h1>
        <hr>
        <form action="{{ route('admin.user-manager') }}" method="get">
            <div class="d-flex mb-3">
                <label for="name" class="mt-3 me-3 fs-3">Tên người dùng: </label>
                <input type="text" name="name" class="form-control w-25 me-3" style="height: 40px">
                <button type="submit" class="btn btn-primary m-0 px-2">Tìm kiếm</button>
            </div>
        </form>
        <div class="mt-3">
            <table class="table table-bordered table-post-list">
                <thead>
                    <tr>
                        <th class="text-center">STT</th>
                        <th class="text-center">Tên người dùng</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Số điện thoại</th>
                        <th class="text-center">Địa chỉ</th>
                        <th class="text-center">Số dư tk</th>
                        <th class="text-center">Ngày tạo</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>#{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->address ?? 'Người Dùng Chưa Thêm' }}</td>
                            <td><strong>{{ number_format($user->balance) }}</strong> VNĐ</td>
                            <td>{{ $user->created_at }}</td>
                            <td class="{{ $user->status ? 'text-success' : 'text-danger' }}">
                                {{ $user->status ? 'Hoạt động' : 'Không hoạt động' }}
                            </td>
                            <td>
                                <a href="" class="btn btn-success me-3 unlock-user" data-id="{{ $user->id }}">Mở</a>
                                <a href="" class="btn btn-warning me-3 lock-user" data-id="{{ $user->id }}">Khóa</a>
                                <a href="" class="btn btn-danger delete-user" data-id="{{ $user->id }}">Xóa</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="fs-3">
        {{ $users->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
@endsection

@section('js_admin')
    <script>
        $(document).ready(function() {
            $('.delete-user').click(function(e) {
                e.preventDefault();
                let id = $(this).data("id");
                Swal.fire({
                    title: "Bạn có chắc không?",
                    text: "Dữ liệu sẽ bị xóa vĩnh viễn!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Xóa",
                    cancelButtonText: "Hủy",
                    customClass: {
                        confirmButton: "custom-confirm-btn",
                        cancelButton: "custom-cancel-btn"
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/user-manager/delete/${id}`,
                            type: "POST", // Nếu route yêu cầu POST
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            success: function(response) {
                                Swal.fire("Đã xóa!", response.message, "success")
                                    .then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire("Lỗi!", xhr.responseJSON?.message ||
                                    "Không thể xóa người dùng!", "error");
                            },
                        });
                    }
                });
            });

            $('.lock-user').click(function(e) {
                e.preventDefault();
                let id = $(this).data("id");
                Swal.fire({
                    title: "Bạn có chắc không?",
                    text: "Người dùng sẽ bị khóa hoặc mở khóa!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Khóa",
                    cancelButtonText: "Hủy",
                    customClass: {
                        confirmButton: "custom-confirm-btn",
                        cancelButton: "custom-cancel-btn"
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/user-manager/lock/${id}`,
                            type: "POST", // Nếu route yêu cầu POST
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            success: function(response) {
                                Swal.fire("Thành công!", response.message, "success")
                                    .then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire("Lỗi!", xhr.responseJSON?.message ||
                                    "Không thể khóa người dùng!", "error");
                            },
                        });
                    }
                });
            });

            $('.unlock-user').click(function(e) {
                e.preventDefault();
                let id = $(this).data("id");
                Swal.fire({
                    title: "Bạn có chắc không?",
                    text: "Người dùng sẽ bị khóa hoặc mở khóa!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Mở khóa",
                    cancelButtonText: "Hủy",
                    customClass: {
                        confirmButton: "custom-confirm-btn",
                        cancelButton: "custom-cancel-btn"
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/user-manager/unlock/${id}`,
                            type: "POST", // Nếu route yêu cầu POST
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            success: function(response) {
                                Swal.fire("Thành công!", response.message, "success")
                                    .then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire("Lỗi!", xhr.responseJSON?.message ||
                                    "Không thể mở khóa người dùng!", "error");
                            },
                        });
                    }
                });
            });
        });
    </script>
    <style>
        .custom-confirm-btn {
            font-size: 18px !important;
            padding: 12px 25px !important;
            border-radius: 8px !important;
            background-color: #3085d6 !important;
        }

        .custom-cancel-btn {
            font-size: 18px !important;
            padding: 12px 25px !important;
            border-radius: 8px !important;
            background-color: #d33 !important;
        }
    </style>
@endsection
