{{-- ------------------------------------------------------ --}}
{{-- Bai dang chua thanh toan --}}
{{-- ------------------------------------------------------ --}}

@extends('clients.layout.master')

@section('content_client')
    <div class="mx-3 mt-3" style="width: 1570px">
        <div class="row">
            <div class="col-md-12">
                <h1 class="pt-2">Quản lý tin chưa thanh toán</h1>
                <hr>
                {{-- Hien thi danh sach tin da dang --}}
                <div class=" mt-3 text-center">
                    <h3 class="text-center mb-3">Danh sách tin chưa thanh toán</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã tin</th>
                                <th>Ảnh đại diện</th>
                                <th>Tiêu đề</th>
                                <th>Giá</th>
                                <th>Thời gian</th>
                                <th>Trạng thái</th>
                                <th>Chức Năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rooms as $item)
                                <tr>
                                    <td>#MTR{{ $item->id }}</td>

                                    <td>
                                        <img src="{{ $item->image_logo }}" alt=""
                                            style="width: 100px; height: 100px;">
                                    </td>
                                    <td class="row">
                                        <div>
                                            {{ $item->title }}
                                        </div>
                                        <div>
                                            <a href="{{ route('client.create.edit', ['id' => $item->id]) }}"
                                                class="text-warning me-2">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                Sửa
                                            </a>
                                            <a href="#" class="text-danger delete-btn" data-id="{{ $item->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                                Xóa
                                            </a>

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
                                    <td class="{{ !$item->status ? 'text-warning' : '' }}">
                                        {{ !$item->status ? 'Chưa thanh toán' : '' }}
                                    </td>

                                    <td>
                                        <button data-room-id="{{ $item->id }}" type="button"
                                            class="btn btn-primary pay-by-balance">
                                            Thanh Toán
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_client')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $(".pay-by-balance").on("click", async function(e) {
                e.preventDefault();
                const roomId = $(this).data("room-id");
                const url = `{{ route('client.pay-by-balance', '') }}/${roomId}`;

                try {
                    const response = await fetch(url);
                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || "Có lỗi xảy ra!");
                    }

                    // Hiển thị thông tin xác nhận thanh toán
                    const {
                        room_code,
                        start_date,
                        end_date,
                        balance,
                        priceNewType
                    } = data;
                    const formattedBalance = new Intl.NumberFormat().format(balance);
                    const formattedPrice = new Intl.NumberFormat().format(priceNewType);

                    Swal.fire({
                        title: "Xác nhận thanh toán",
                        html: `
                    <p><strong>Mã tin:</strong> #MTR${room_code}</p>
                    <p><strong>Ngày bắt đầu:</strong> ${start_date}</p>
                    <p><strong>Ngày kết thúc:</strong> ${end_date}</p>
                    <p><strong>Số dư tài khoản:</strong> ${formattedBalance} VNĐ</p>
                    <p><strong>Số tiền cần thanh toán:</strong> ${formattedPrice} VNĐ</p>
                `,
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonText: "Thanh toán",
                        cancelButtonText: "Hủy",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            confirmPayment(roomId);
                        }
                    });
                } catch (error) {
                    showError(error.message);
                }
            });

            async function confirmPayment(roomId) {
                const paymentUrl = `{{ route('client.pay-by-balance.confirm') }}/${roomId}`;

                try {
                    const response = await fetch(paymentUrl, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json",
                        },
                    });

                    const data = await response.json();
                    if (!response.ok) {
                        throw new Error(data.error || "Không thể thực hiện thanh toán.");
                    }

                    Swal.fire({
                        icon: "success",
                        title: "Thanh toán thành công!",
                        text: "Cảm ơn bạn đã thanh toán!",
                        confirmButtonText: "OK",
                    }).then(() => {
                        location.reload();
                    });
                } catch (error) {
                    showError(error.message);
                }
            }

            function showError(message) {
                Swal.fire({
                    icon: "error",
                    title: "Lỗi!",
                    text: message,
                    confirmButtonText: "OK",
                });
            }



            $(".delete-btn").on("click", function(e) {
                e.preventDefault();
                let id = $(this).data("id");

                Swal.fire({
                    title: "Bạn có chắc chắn muốn xóa?",
                    text: "Hành động này không thể hoàn tác!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Xóa",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/client/delete-post/${id}`,
                            type: "DELETE", // Sử dụng đúng method DELETE
                            data: {
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire("Đã xóa!",
                                    "Bài đăng đã được xóa thành công.",
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
