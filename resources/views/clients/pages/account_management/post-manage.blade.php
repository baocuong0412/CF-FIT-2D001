{{-- --------------------------------------------------------- --}}
{{-- Quan ly tin da dang --}}
{{-- ------------------------------------------------------------ --}}
@extends('clients.layout.master')
@section('content_client')
    <div class="mx-3 mt-3" style="width: 1570px">
        <div class="row">
            <div class="col-md-12">
                <h1 class="pt-2">Quản lý tin đã đăng</h1>
                <hr>
                <div>
                    <form action="#" method="get">
                        <div class="d-flex justify-content-start">
                            {{-- Tim theo trang thai --}}
                            <h6 class="mt-2 me-3">Trạng thái:</h6>
                            <div class="me-4">
                                <select name="status" class="form-select">
                                    @foreach ($rooms as $key => $item)
                                        <option value="{{ $key }}">
                                            @if ($item->status == 1)
                                                Chưa duyệt
                                            @elseif ($item->status == 2)
                                                Đã duyệt
                                            @elseif ($item->status == 3)
                                                Hết hạn
                                            @else
                                                Không xác định
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Tim theo gia cao nhat hoac thap nhat --}}
                            <h6 class="mt-2 me-3">Giá:</h6>
                            <div class="me-4">
                                <select name="price" class="form-select">
                                    <option value="">Chọn giá</option>
                                    <option value="asc">Giá thấp đến cao</option>
                                    <option value="desc">Giá cao đến thấp</option>
                                </select>
                            </div>
                            {{-- Nut tim kiem --}}
                            <div class="me-4">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Hien thi danh sach tin da dang --}}
                <div class=" mt-3">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>Mã tin</th>
                                <th>Ảnh đại diện</th>
                                <th>Tiêu đề</th>
                                <th>Giá</th>
                                <th>Thời gian</th>
                                <th>Trạng thái</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $item)
                                <tr>
                                    <td>#MTR{{ $loop->iteration }}</td>

                                    <td>
                                        <img src="{{ $item->image_logo }}" alt=""
                                            style="width: 100px; height: 100px;">
                                    </td>
                                    <td class="row">
                                        <div>
                                            {{ $item->title }}
                                        </div>
                                        <div>

                                            @if ($item->status == 1)
                                                <a href="#" class="text-danger cancel-btn me-2"
                                                    data-id="{{ $item->id }}">
                                                    <i class="fa-solid fa-ban"></i>
                                                    Hủy
                                                </a>
                                            @elseif ($item->status == 2)
                                                <a href="#" class="text-warning me-2 delete-btn" data-id="{{ $item->id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                    Xóa
                                                </a>
                                            @elseif ($item->status == 3)
                                                <a href="{{ route('client.create.edit', ['id' => $item->id]) }}"
                                                    class="text-warning me-2">
                                                    <i class="fa-solid fa-file-export"></i>
                                                    Gia Hạn
                                                </a>
                                            @endif


                                        </div>
                                    </td>
                                    <td>
                                        {{ number_format($item->price) }}/tháng
                                    </td>
                                    <td>
                                        <strong>Loại tin: </strong> {{ $item->newType->name_type }} <br>
                                        <strong>Bắt Đầu: </strong> {{ $item->time_start }} <br>
                                        <strong>Kết thúc: </strong>{{ $item->time_end }}
                                    </td>
                                    <td
                                        class=
                                        "
                                            @if ($item->status == 1) text-warning 
                                            @elseif ($item->status == 2) text-success 
                                            @elseif ($item->status == 3) text-danger 
                                            @else text-secondary @endif
                                        ">

                                        @if ($item->status == 1)
                                            Chưa duyệt
                                        @elseif ($item->status == 2)
                                            Đã duyệt
                                        @elseif ($item->status == 3)
                                            Hết hạn
                                        @else
                                            Không xác định
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: "{{ session('error') }}",
                showConfirmButton: true
            });
        </script>
    @endif
@endsection

@section('js_client')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            let successMessage = @json(session('success', ''));
            let errorMessage = @json(session('error', ''));

            if (successMessage !== '') {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: successMessage,
                    showConfirmButton: false,
                    timer: 2000
                });
            }

            if (errorMessage !== '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: errorMessage,
                    showConfirmButton: true
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $(".delete-btn").on("click", function(e) {
                e.preventDefault();
                let id = $(this).data("id");

                Swal.fire({
                    title: "Bạn chắc chắn muốn xóa bài này?",
                    text: "Số tiền bạn thanh toán sẽ không được hoàn lại!!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Xác Nhận",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/client/delete/${id}`,
                            type: "POST", // Sử dụng đúng method DELETE
                            data: {
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire("Đã hủy!",
                                    "Bài đăng đã được hủy thành công.",
                                    "success");
                                setTimeout(() => location.reload(), 1000);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire("Lỗi!",
                                    `Có lỗi xảy ra: ${xhr.responseText}`,
                                    "error");
                            }

                        });
                    }
                });
            });


            $(".cancel-btn").on("click", function(e) {
                e.preventDefault();
                let id = $(this).data("id");

                Swal.fire({
                    title: "Bạn chắc chắn muốn hủy bài này?",
                    text: "Số tiền bạn thanh toán sẽ được hoàn lại!! Số tiền sẻ được hoàn lại vào số dư tài khoản của bạn.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Xác Nhận",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/client/cancel-post/${id}`,
                            type: "POST", // Sử dụng đúng method DELETE
                            data: {
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire("Đã hủy!",
                                    "Bài đăng đã được hủy thành công.",
                                    "success");
                                setTimeout(() => location.reload(), 1000);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire("Lỗi!",
                                    `Có lỗi xảy ra: ${xhr.responseText}`,
                                    "error");
                            }

                        });
                    }
                });
            });
        });
    </script>
@endsection
