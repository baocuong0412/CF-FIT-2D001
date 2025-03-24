@extends('admin.layout.master')

@section('content_admin')
    <div>
        <h1>Quản lý tin đã đăng chờ duyệt</h1>
        <hr>

        <div class="main-right-search">
            <form action="{{ route('admin.post-pending') }}" method="GET">
                <div class="form-group d-flex">
                    <label for="caterogry" class="mt-3 me-3">Tìm theo loại:</label>
                    <select name="caterogry" id="caterogry" class="form-select w-25 me-4 fs-4" style="height: 40px;">
                        <option value="">Tất cả</option>
                        @foreach ($categories as $key => $value)
                            <option value="{{ $value->id }}"
                                {{ request()->get('category') == $value->id ? 'selected' : '' }}>
                                {{ $value->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary m-0 p-1">Tìm kiếm</button>
                </div>
            </form>
        </div>

        <div class="main-right-table">
            <table class="table table-bordered table-post-list" id = "table-manage">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 8%;">Mã tin</th>
                        <th class="text-center" style="width: 10%;">Ảnh đại diện</th>
                        <th class="text-center" style="width: 42%;">Tiêu đề</th>
                        <th class="text-center" style="width: 15%;">Thông tin</th>
                        <th class="text-center" style="width: 15%;">Giá/Thời gian</th>
                        <th class="text-center" style="width: 10%;">Trạng thái</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($rooms as $key => $value)
                        <tr>
                            <td>#MT{{ $value->id }}</td>
                            <td>
                                <div class="post_thumb">
                                    <img class="thumb-img" src="{{ $value->image_logo }}" alt=""
                                        style=" object-fit: contain; width: 100%; height: 100%;">
                                </div>
                            </td>
                            <td style="text-align: left; ">
                                <span class="category">{{ $value->category->name }}</span>
                                <span class="title">{{ $value->title }}</span>
                                <p class="address"><strong>Địa chỉ: </strong>
                                    {{ $value->street ?? 'Không xác định' }},
                                    {{ $value->ward->fullname ?? 'Không xác định' }},
                                    {{ $value->district->fullname ?? 'Không xác định' }},
                                    {{ $value->city->fullname ?? 'Không xác định' }}
                                </p>
                                <div class="btn-tool">
                                    <a href="#" class="btn-hide browse" style = "color: rgb(28, 231, 21);"
                                        data-id="{{ $value->id }}">
                                        <i class="fa-solid fa-check"></i>
                                        Duyệt
                                    </a>
                                    <a href="#" class="btn-hide cancel" style = "color: red;"
                                        data-id="{{ $value->id }}">
                                        <i class="fa-solid fa-trash-arrow-up"></i>
                                        Hủy
                                    </a>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $value->user->name }}</strong>
                                <br>
                                <p>{{ $value->user->phone }}</p>

                            </td>
                            <td>
                                <div class="post_price">
                                    <span class="price"><strong>{{ number_format($value->price) }}</strong>/tháng</span>
                                </div>
                                <div class="post_date"><strong>Bắt đầu: </strong>{{ $value->time_start }}</div>
                                <div class="post_date"><strong>Kết thúc: </strong>{{ $value->time_end }}</div>
                            </td>
                            <td class="{{ $value->status == 1 ? 'text-danger' : '' }}">
                                {{ $value->status == 1 ? 'Chờ Duyệt' : '' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="fs-3">
        {{ $rooms->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
@endsection

@section('js_admin')
    <script>
        $(document).ready(function() {
            // Duyet Tin
            $('.browse').click(function() {
                var id = $(this).data('id');
                var url = "{{ route('admin.browse') }}" + "/" + id; // Đảm bảo URL chính xác

                Swal.fire({
                    title: "Xác nhận",
                    text: "Bạn có chắc muốn duyệt tin này?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Duyệt",
                    cancelButtonText: "Hủy",
                    customClass: {
                        title: "swal-custom-title",
                        htmlContainer: "swal-custom-text",
                        confirmButton: "custom-confirm-btn",
                        cancelButton: "custom-cancel-btn"
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: xhr.responseJSON?.message ||
                                        'Đã xảy ra lỗi!',
                                    showConfirmButton: true
                                });
                            }
                        });
                    }
                });
            });

            // Huy Tin
            $('.cancel').click(function() {
                var id = $(this).data('id');
                var url = "{{ route('admin.cancel') }}" + "/" + id; // Đảm bảo URL chính xác

                Swal.fire({
                    title: "Xác nhận",
                    text: "Bạn có chắc muốn hủy tin này?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Xác nhận",
                    cancelButtonText: "Hủy",
                    customClass: {
                        title: "swal-custom-title",
                        htmlContainer: "swal-custom-text",
                        confirmButton: "custom-confirm-btn",
                        cancelButton: "custom-cancel-btn"
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Thành công!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi!',
                                    text: xhr.responseJSON?.message ||
                                        'Đã xảy ra lỗi!',
                                    showConfirmButton: true
                                });
                            }
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

        .swal-custom-title {
            font-size: 24px !important;
            font-weight: bold !important;
        }

        .swal-custom-text {
            font-size: 18px !important;
        }
    </style>
@endsection
