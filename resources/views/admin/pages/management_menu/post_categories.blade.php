@extends('admin.layout.master')

@section('content_admin')
    <div class="row">
        <div class="d-flex justify-content-between">
            <h1>Quản lý chuyên mục</h1>
            <button class="btn btn-primary" id="add_category">Thêm mới</button>
        </div>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">STT</th>
                    <th class="text-center" style="width: 12%;">Tên chuyên mục</th>
                    <th class="text-center" style="width: 12%;">Phân loại</th>
                    <th class="text-center" style="width: 12%;">Menu hiển thị</th>
                    <th class="text-center" style="width: 20%;">Tiêu đề</th>
                    <th class="text-center" style="width: 22%;">Mô tả</th>
                    <th class="text-center" style="width: 8%;">Trạng thái</th>
                    <th class="text-center" style="width: 10%;">Hoạt động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr id="category-{{ $category->id }}">
                        <td class="text-center">#CTGR{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->classify }}</td>
                        <td>{{ $category->type }}</td>
                        <td>{{ $category->title }}</td>
                        <td>{{ $category->description }}</td>
                        <td class="text-center">
                            @if ($category->status == 1)
                                <span class="text-success">Hiển thị</span>
                            @else
                                <span class="text-danger">Ẩn</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button class="btn btn-warning editCategory" data-id="{{ $category->id }}"
                                data-name="{{ $category->name }}" data-classify="{{ $category->classify }}"
                                data-type="{{ $category->type }}" data-title="{{ $category->title }}"
                                data-description="{{ $category->description }}"
                                data-status="{{ $category->status }}">Sửa</button>
                            <button class="btn btn-danger deleteCategory" data-id="{{ $category->id }}">Xóa</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="fs-3">
        {{ $categories->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
@endsection

@section('js_admin')
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                // Thêm chuyên mục
                $('#add_category').click(function() {
                    Swal.fire({
                        title: "Thêm chuyên mục",
                        width: '600px',
                        html: `
            <div>
                <input type="text" id="name" class="swal2-input w-75 fs-3" placeholder="Tên chuyên mục">
                <input type="text" id="classify" class="swal2-input w-75 fs-3" placeholder="Phân loại">
                <input type="text" id="type" class="swal2-input w-75 fs-3" placeholder="Menu hiển thị">
                <input type="text" id="title" class="swal2-input w-75 fs-3" placeholder="Tiêu đề">
                <textarea id="description" class="swal2-textarea w-75 fs-3" placeholder="Mô tả"></textarea>
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
                            let name = $("#name").val().trim();
                            let classify = $("#classify").val().trim();
                            let type = $("#type").val().trim();
                            let title = $("#title").val().trim();
                            let description = $("#description").val().trim();
                            let status = $("#status").val();

                            if (!name) {
                                Swal.showValidationMessage(
                                    "Tên chuyên mục không được để trống");
                                return false;
                            }
                            if (!classify) {
                                Swal.showValidationMessage(
                                    "Phân loại không được để trống");
                                return false;
                            }
                            if (!type) {
                                Swal.showValidationMessage(
                                    "Menu hiển thị không được để trống");
                                return false;
                            }

                            return {
                                name: name,
                                classify: classify,
                                type: type,
                                title: title,
                                description: description,
                                status: status,
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "/admin/category/store",
                                method: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                        .attr('content')
                                },
                                data: result
                                .value, // 🛠 Sử dụng dữ liệu từ preConfirm
                                success: function(response) {
                                    Swal.fire("Thành công!", response.message ||
                                            "Chuyên mục đã được thêm!",
                                            "success")
                                        .then(() => location.reload());
                                },
                                error: function(xhr) {
                                    Swal.fire("Lỗi!", xhr.responseJSON
                                        ?.message ||
                                        "Không thể thêm chuyên mục!",
                                        "error");
                                }
                            });
                        }
                    });
                });
            });

            // Sua category
            $('.editCategory').click(function() {
                let id = $(this).data("id");
                Swal.fire({
                    title: "Chỉnh sửa chuyên mục",
                    width: '600px',
                    html: `
                    <div>
                        <input type="text" id="name" class="swal2-input w-75 fs-3" value="${$(this).data("name")}">
                        <input type="text" id="classify" class="swal2-input w-75 fs-3" value="${$(this).data("classify")}">
                        <input type="text" id="type" class="swal2-input w-75 fs-3" value="${$(this).data("type")}">
                        <input type="text" id="title" class="swal2-input w-75 fs-3" value="${$(this).data("title")}">
                        <textarea id="description" class="swal2-textarea w-75 fs-3">${$(this).data("description")}</textarea>
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
                            name: $("#name").val(),
                            classify: $("#classify").val(),
                            type: $("#type").val(),
                            title: $("#title").val(),
                            description: $("#description").val(),
                            status: $("#status").val(),
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/category/update/${id}`,
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: "POST", // ✅ Nếu route yêu cầu POST, thêm dòng này
                                name: $("#name").val(),
                                classify: $("#classify").val(),
                                type: $("#type").val(),
                                title: $("#title").val(),
                                description: $("#description").val(),
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

            $('.deleteCategory').click(function() {
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
                            url: `/admin/category/delete/${id}`,
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
