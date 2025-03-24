@extends('admin.layout.master')

@section('content_admin')
    <div class="row">
        <div class="d-flex justify-content-between">
            <h1>Quản lý loại tin</h1>
            <button class="btn btn-primary" id="add_newType">Thêm mới</button>
        </div>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">STT</th>
                    <th class="text-center" style="width: 12%;">Loại tin</th>
                    <th class="text-center" style="width: 12%;">Giá tin</th>
                    <th class="text-center" style="width: 12%;">Trạng thái</th>
                    <th class="text-center" style="width: 10%;">Hoạt động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($newType as $item)
                    <tr id="category-{{ $item->id }}">
                        <td class="text-center">#{{ $loop->iteration }}</td>
                        <td>{{ $item->name_type }}</td>
                        <td><strong>{{ number_format($item->price) }}</strong> VNĐ</td>
                        <td>
                            @if ($item->status == 1)
                                <span class="text-success">Hiển thị</span>
                            @else
                                <span class="text-danger">Ẩn</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-warning editNewType" data-id="{{ $item->id }}"
                                data-name_type="{{ $item->name_type }}" data-price="{{ $item->price }}"
                                data-status="{{ $item->status }}">Sửa</button>
                            <button class="btn btn-danger deleteNewType" data-id="{{ $item->id }}">Xóa</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="fs-3">
        {{ $newType->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
@endsection

@section('js_admin')
    <script>
        $(document).ready(function() {
            // Them new_type
            $('#add_newType').click(function() {
                Swal.fire({
                    title: "Thêm loại tin",
                    width: '600px',
                    html: `
                    <div>
                        <input type="text" id="name_type" class="swal2-input w-75 fs-3" placeholder="Loại tin">
                        <input type="number" id="price" class="swal2-input w-75 fs-3" placeholder="Giá tin">
                        <div>
                            <label for="status" class="mt-3 me-3 fs-3">Trạng thái:</label>
                            <select id="status" class="swal2-select fs-3">
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>
                    </div>
                    `,
                    confirmButtonText: "Thêm",
                    showCancelButton: true,
                    cancelButtonText: 'Hủy',
                    customClass: {
                        confirmButton: "custom-confirm-btn",
                        cancelButton: "custom-cancel-btn"
                    },
                    preConfirm: () => {
                        let name_type = $("#name_type").val().trim();
                        let price = $("#price").val().trim();
                        let status = $("#status").val();

                        if (!name_type) {
                            Swal.showValidationMessage("Tên loại tin không được để trống");
                            return false;
                        }
                        if (!price || price < 0) {
                            Swal.showValidationMessage("Giá phải là số và không được âm");
                            return false;
                        }

                        return {
                            name_type: name_type,
                            price: price,
                            status: status,
                        };
                    }
                }).then((result) => { // ✅ Đúng vị trí
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/admin/new-type/store",
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            data: {
                                name_type: $("#name_type").val(),
                                price: $("#price").val(),
                                status: $("#status").val(),
                            },
                            success: function(response) {
                                Swal.fire("Thành công!", "Chuyên mục đã được thêm!",
                                        "success")
                                    .then(() => location.reload());
                            },
                            error: function() {
                                Swal.fire("Lỗi!", "Không thể thêm chuyên mục!",
                                    "error");
                            },
                        });
                    }
                });
            });

            // Sua new_type
            $('.editNewType').click(function() {
                let id = $(this).data("id");
                Swal.fire({
                    title: "Chỉnh sửa chuyên mục",
                    width: '600px',
                    html: `
                    <div>
                        <input type="text" id="name_type" class="swal2-input w-75 fs-3" value="${$(this).data("name_type")}">
                        <input type="number" id="price" class="swal2-input w-75 fs-3" value="${$(this).data("price")}">
                        <div>
                            <label for="status" class="mt-3 me-3 fs-3">Trạng thái:</label>
                            <select id="status" class="swal2-select fs-3">
                                <option value="1" ${$(this).data("status") == 1 ? "selected" : ""}>Hiển thị</option>
                                <option value="0" ${$(this).data("status") == 0 ? "selected" : ""}>Ẩn</option>
                            </select>
                        </div>
                    </div>
                    `,
                    confirmButtonText: "Lưu",
                    showCancelButton: true,
                    cancelButtonText: 'Hủy',
                    customClass: {
                        confirmButton: "custom-confirm-btn",
                        cancelButton: "custom-cancel-btn"
                    },
                    preConfirm: () => {
                        return {
                            name_type: $("#name_type").val(),
                            price: $("#price").val(),
                            status: $("#status").val(),
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/new-type/update/${id}`,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                name_type: $("#name_type").val(),
                                price: $("#price").val(),
                                status: $("#status").val(),
                            },
                            success: function(response) {
                                Swal.fire("Thành công!", "Chuyên mục đã được cập nhật!",
                                        "success")
                                    .then(() => location.reload());
                            },
                            error: function() {
                                Swal.fire("Lỗi!", "Không thể cập nhật chuyên mục!",
                                    "error");
                            },
                        });
                    }
                });
            })

            // Xóa new_type
            $('.deleteNewType').click(function() {
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
                            url: `/admin/new-type/delete/${id}`,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                Swal.fire("Đã xóa!", response.message, "success")
                                    .then(() => location.reload());
                            },
                            error: function(xhr) {
                                Swal.fire("Lỗi!", xhr.responseJSON?.message ||
                                    "Không thể xóa chuyên mục!", "error");
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
