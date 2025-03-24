@extends('admin.layout.master')

@section('content_admin')
    <div>
        <div class="d-flex justify-content-between">
            <h1>Quản lý slider</h1>
            <div>
                <button id="create-slider" class="btn btn-primary">Tạo Slider</button>
            </div>
        </div>
        <hr>
        <div class="main-right-table">
            <table class="table table-bordered table-post-list" id = "table-manage">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">STT</th>
                        <th class="text-center" style="width: 30%;">Hình ảnh</th>
                        <th class="text-center" style="width: 23%;">Tiêu đề</th>
                        <th class="text-center" style="width: 25%;">Mô tả</th>
                        <th class="text-center" style="width: 8%;">Trạng thái</th>
                        <th class="text-center" style="width: 10%;">Hành động</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($sliders as $slider)
                        <tr>
                            <td>#SL{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ $slider->imageSlider }}" alt="HinhAnh">
                            </td>
                            <td>{{ $slider->title }}</td>
                            <td>{{ $slider->description }}</td>
                            <td class="{{ $slider->status ? 'text-success' : 'text-danger' }}">
                                {{ $slider->status ? 'Hiển thị' : 'Ẩn' }}
                            </td>
                            <td>
                                <a href="#" class="btn btn-warning edit-slider" data-id="{{ $slider->id }}"
                                    data-image="{{ $slider->imageSlider }}" data-title="{{ $slider->title }}"
                                    data-description="{{ $slider->description }}">
                                    Sửa
                                </a>
                                <a href="#" class="btn btn-danger delete-slider"
                                    data-id="{{ $slider->id }}">Xóa</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Pagination --}}
            <div class="fs-3">
                {{ $sliders->appends(request()->all())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@section('js_admin')
    <script>
        $(document).ready(function() {
            $("#create-slider, .edit-slider").click(function() {
                let isEdit = $(this).hasClass("edit-slider");
                let sliderId = isEdit ? $(this).data("id") : null;

                // Nếu là sửa thì lấy dữ liệu hiện tại của slider
                let existingData = isEdit ? {
                    image: $(this).data("image"),
                    title: $(this).data("title"),
                    description: $(this).data("description")
                } : {
                    image: "",
                    title: "",
                    description: ""
                };

                Swal.fire({
                    title: isEdit ? 'Chỉnh sửa slider' : 'Thêm mới slider',
                    width: "600px",
                    html: `
    <div class="input-file form-validator">
        <div class="input-img" id="upload-container">
            <i class="fa-solid fa-arrow-up-from-bracket"></i>
            <input type="file" class="upload-img" id="upload-img" style="display:block;">
        </div>
        <div id="display-img" style="margin-top:10px;">
            ${existingData.image ? `<img src="${existingData.image}" width="200" height="200"
                                                                        style="border-radius: 5px;">` : ""}
        </div>
        <button id="remove-img" style="display:${existingData.image ? 'block' : 'none'}; margin-top:10px;"
            class="btn btn-danger">Xóa ảnh</button>
        <span class="form-message text-danger" id="error-image"></span>
    </div>
    <div class="form-contact form-validator">
        <label class="contact-title">Tiêu đề</label>
        <input type="text" id="title" class="form-control" value="${existingData.title}">
        <span class="form-message text-danger" id="error-title"></span>
    </div>
    <div class="form-contact form-validator">
        <label class="contact-title">Mô tả</label>
        <textarea id="description" cols="30" rows="3" class="form-control">${existingData.description}</textarea>
        <span class="form-message text-danger" id="error-description"></span>
    </div>
    <div class="form-contact form-validator">
    <label class="contact-title">Trạng thái</label>
    <select id="status" class="form-select">
        <option value="1" ${existingData.status == 1 ? "selected" : ""}>Hoạt động</option>
        <option value="0" ${existingData.status == 0 ? "selected" : ""}>Không hoạt động</option>
    </select>
    <span class="form-message text-danger" id="error-status"></span>
    </div>
    `,
                    showCancelButton: true,
                    confirmButtonText: isEdit ? 'Cập nhật' : 'Lưu',
                    cancelButtonText: 'Hủy',
                    customClass: {
                        confirmButton: "custom-confirm-btn",
                        cancelButton: "custom-cancel-btn"
                    },
                    didOpen: () => {
                        $("#upload-img").change(function() {
                            const file = this.files[0];

                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    $("#display-img").html(
                                        `<img src="${e.target.result}" width="200" height="200" style="border-radius: 5px;">`
                                    );
                                    $("#upload-img").hide();
                                    $("#remove-img").show();
                                    $("#error-image").text(""); // Xóa lỗi nếu có
                                };
                                reader.readAsDataURL(file);
                            }
                        });

                        $("#remove-img").click(function() {
                            $("#upload-img").val("").show();
                            $("#display-img").html("");
                            $("#remove-img").hide();
                            $("#error-image").text(""); // Xóa lỗi nếu có
                        });
                    },
                    preConfirm: () => {
                        const image = $("#upload-img")[0].files[0];
                        const title = $("#title").val().trim();
                        const description = $("#description").val().trim();
                        const status = $("#status").val(); // Lấy trạng thái từ dropdown
                        let errors = {};

                        if (!title) {
                            errors.title = "Vui lòng nhập tiêu đề";
                        } else if (title.length > 255) {
                            errors.title = "Tiêu đề không được vượt quá 255 ký tự";
                        }

                        if (!description) {
                            errors.description = "Vui lòng nhập mô tả";
                        } else if (description.length > 255) {
                            errors.description = "Mô tả không được vượt quá 255 ký tự";
                        }

                        $("#error-title").text(errors.title || "");
                        $("#error-description").text(errors.description || "");

                        if (Object.keys(errors).length > 0) return false;

                        return {
                            image,
                            title,
                            description,
                            status
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        if (result.value.image) {
                            formData.append('image', result.value.image);
                        }
                        formData.append('title', result.value.title);
                        formData.append('description', result.value.description);
                        formData.append('status', result.value
                            .status); // Thêm trạng thái vào form data

                        const ajaxUrl = isEdit ? `{{ url('admin/slider/update') }}/${sliderId}` :
                            "{{ route('admin.slider.store') }}";

                        const ajaxType = isEdit ? "POST" :
                            "POST"; // Sửa lại method sau khi xử lý route

                        $.ajax({
                            url: ajaxUrl,
                            type: ajaxType,
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire('Thành công!', isEdit ?
                                    'Slider đã được cập nhật' :
                                    'Slider đã được thêm', 'success');
                            },
                            error: function(response) {
                                if (response.status === 422) { // Laravel validation lỗi
                                    const errors = response.responseJSON.errors;
                                    $("#error-image").text(errors.image ? errors.image[
                                        0] : "");
                                    $("#error-title").text(errors.title ? errors.title[
                                        0] : "");
                                    $("#error-description").text(errors.description ?
                                        errors.description[0] : "");
                                    $("#error-status").text(errors.status ? errors
                                        .status[0] : "");
                                } else {
                                    Swal.fire('Lỗi!', 'Không thể thực hiện thao tác',
                                        'error');
                                }
                            }
                        });
                    }
                });
            });
        });

        $(document).on("click", ".delete-slider", function(e) {
            e.preventDefault();
            let sliderId = $(this).data("id");
            Swal.fire({
                title: "Bạn có chắc muốn xóa slider này?",
                text: "Hành động này không thể hoàn tác!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Xóa",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('admin/slider/delete') }}/${sliderId}`,
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire("Đã xóa!", "Slider đã được xóa thành công.", "success")
                                .then(() => {
                                    location
                                        .reload(); // Reload lại trang sau khi xóa thành công
                                });
                        },
                        error: function() {
                            Swal.fire("Lỗi!", "Không thể xóa slider.", "error");
                        }
                    });
                }
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
