@extends('welcome')

@section('content')
    <div class="container mt-5 pt-3">
        <h1 class="pt-5">Chi tiết về {{ $room->category->type }}</h1>
        <div class="row g-0">
            <div class="col-sm-6 col-md-8 rounded pe-2">
                {{-- Hinh anh cua bai dang --}}
                <div>
                    <div id="carouselExample" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ $room->image_logo }}" class="d-block w-100 rounded" alt="image"
                                    style="height: 500px;">
                            </div>
                            @foreach ($roomImage as $value)
                                <div class="carousel-item">
                                    <img src="{{ $value->images }}" class="d-block w-100 rounded" alt="images"
                                        style="height: 500px;">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="border">
                    {{-- Ten bai dang --}}
                    <div class="pt-3 ps-3 d-flex flex-row">
                        <div id="stars" class="pe-2 text-center" style="width: 130px;">
                            @for ($i = 0; $i < ($room->new_type_id ?? 0); $i++)
                                <i class="fa-solid fa-star text-warning"></i>
                            @endfor
                        </div>
                        <div>
                            <h5 class="text-danger">{{ $room->title }}</h5>
                        </div>
                    </div>

                    {{-- Chuyen muc --}}
                    <div class="pt-2 ps-3">
                        <span>Chuyên mục: <strong class="text-primary">{{ $room->category->name }},
                                {{ $room->ward->fullname }}</strong></span>
                    </div>

                    {{-- Dia Chi --}}
                    <div class="pt-2 ps-3">
                        <p>
                            <i class="fa-solid fa-location-dot text-primary"></i>
                            {{ $room->street ?? 'Không xác định' }},
                            {{ $room->ward->fullname ?? 'Không xác định' }},
                            {{ $room->district->fullname ?? 'Không xác định' }},
                            {{ $room->city->fullname ?? 'Không xác định' }}
                        </p>
                    </div>

                    <!-- Giá, diện tích, thời gian -->
                    <div class="pt-2 ps-3 d-flex">
                        <h5 class="me-4 text-primary">
                            <i class="fa-solid fa-money-bill-wave me-2"></i>
                            {{ number_format($room->price) ?? 'Liên hệ' }}/tháng
                        </h5>
                        <h5 class="me-4">
                            <i class="fa-solid fa-chart-area me-2"></i>
                            {{ $room->area ?? 'N/A' }}m&sup2;
                        </h5>
                        <p class=""><i class="fa-regular fa-clock me-2"></i>{{ $room->time_elapsed ?? 'Mới đăng' }}
                        </p>
                    </div>

                    {{-- Mo ta chi tiet --}}
                    <div class="pt-2 ps-3">
                        <h5>Mô tả chi tiết</h5>
                        <p>{!! $room->description !!}</p>
                    </div>

                    {{-- Bình luận  --}}
                    <div class="mt-3 p-2 border shadow-lg bg-body-tertiary rounded">
                        <h2 class="ps-3">Bình Luận</h2>
                        <form action="{{ route('comment', ['id' => $room->id]) }}" method="post">
                            @csrf
                            <label for="content" class="mb-2">Viết bình luận:</label>
                            <textarea name="content" id="content" cols="111" rows="5"></textarea>
                            @error('content')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary mt-2">Gửi</button>
                            </div>
                        </form>
                        <hr>
                        <div>
                            @if ($comments->isEmpty())
                                <p>Chưa có bình luận nào.</p>
                            @else
                                @foreach ($comments as $comment)
                                    <div class="comment-box">
                                        <div>
                                            <img src="{{ $comment->user->avatar }}" alt="avata" class="rounded-circle"
                                                style="width: 40px;">
                                            <strong>{{ $comment->user->name }}</strong> <!-- Hiển thị tên người dùng -->
                                            <small>{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                    <!-- Chỉ hiển thị "Trả lời" nếu người đang xem là chủ bài đăng -->
                                    @if (auth()->id() === $room->user_id)
                                        <div>
                                            <a href="#" class="reply" data-id="{{ $comment->id }}">Trả lời</a>
                                        </div>
                                    @endif

                                    <!-- Hiển thị danh sách phản hồi -->
                                    @if ($comment->reply->isNotEmpty())
                                        <div class="replies">
                                            @foreach ($comment->reply as $reply)
                                                <div class="reply-box" style="margin-left: 40px;">
                                                    <div>
                                                        <img src="{{ $reply->user->avatar }}" alt="avatar"
                                                            class="rounded-circle" style="width: 40px; height: 40px;">
                                                        <strong>{{ $reply->user->name }}</strong>
                                                        <small>{{ $reply->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <p>{{ $reply->reply_content }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <hr>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 border shadow-lg bg-body-tertiary rounded text-center" style="height: 336px;">
                <div class="rounded" style="background-color: #f1c40f">
                    {{-- Hinh anh --}}
                    <div class="pt-3">
                        <img src="{{ $user->avatar }}" alt="avatar" class="rounded-circle"
                            style="width: 100px; height: 100px;">
                    </div>

                    {{-- Ten nguoi dang bai --}}
                    <div class="pt-3">
                        <h3>{{ $user->name }}</h3>
                    </div>

                    {{-- Cach lien he --}}
                    <div class="pb-3">
                        @php
                            // Ẩn số điện thoại (chỉ hiển thị 4 số cuối)
                            $hiddenPhone = str_repeat('*', strlen($user->phone) - 4) . substr($user->phone, -4);
                        @endphp
                        <a href="javascript:void(0);" class="btn btn-primary w-75" onclick="showPhoneNumber(this)"
                            data-fullphone="{{ $user->phone }}">
                            <i class="fa-solid fa-phone-volume pe-3 fs-5"></i>
                            <span class="phone-text fs-4">{{ $hiddenPhone }}</span>
                        </a>
                        @if (isset($room->user) && ($room->user->zalo || $room->user->facebook))
                            <a href="https://zalo.me/{{ $room->user->zalo }}"
                                class="btn btn-outline-success w-75 mt-3 fs-5">Nhắn Zalo</a>
                            <a href="https://{{ $room->user->facebook }}"
                                class="btn btn-outline-success w-75 mt-3 fs-5">Facebook</a>
                        @else
                            <span class="text-muted fs-5">Không có thông tin liên hệ</span>
                        @endif
                    </div>
                </div>

                {{-- Bài viết liên quan --}}
                @if ($relatedRooms->count() > 0)
                    <div class="border border-1 rounded mt-5 shadow-lg bg-body-tertiary">
                        <h3 class="p-3 text-center">Bài viết liên quan</h3>
                        @foreach ($relatedRooms as $relatedRoom)
                            <a href="{{ route('detail', ['id' => $relatedRoom->id]) }}" class="text-decoration-none">
                                <div class="d-flex p-1">
                                    <div>
                                        <img src="{{ $relatedRoom->image_logo }}" alt="{{ $relatedRoom->title }}"
                                            style="width: 100px; height: 100px;">
                                    </div>

                                    <div class="ps-3 text-start" style="width: 400px;">
                                        <h5 class="text-secondary-emphasis">{{ $relatedRoom->title }}</h5>
                                        <p class="text-secondary-emphasis"><i
                                                class="fa-solid fa-money-bill-wave me-2 text-primary"></i>{{ number_format($relatedRoom->price) }}/tháng
                                        </p>
                                        <p class="text-secondary-emphasis"><i
                                                class="fa-solid fa-chart-area me-2 text-primary"></i>{{ $relatedRoom->area }}m&sup2;
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function showPhoneNumber(el) {
            let fullPhone = el.getAttribute('data-fullphone');
            el.querySelector('.phone-text').textContent = fullPhone;
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.reply').click(function(e) {
                e.preventDefault();
                var id = $(this).data("id"); // Lấy ID bình luận cần trả lời

                Swal.fire({
                    title: "Trả lời bình luận",
                    width: "600px",
                    html: `
                    <textarea name="reply_content" id="reply_content" cols="60" rows="5"></textarea>
                `,
                    confirmButtonText: "Gửi",
                    showCancelButton: true,
                    cancelButtonText: 'Hủy',
                    preConfirm: () => {
                        return {
                            reply_content: $("#reply_content").val()
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('replie', '') }}/" +
                            id, // Gửi request đến route
                            type: "POST",
                            data: {
                                reply_content: result.value.reply_content,
                                _token: "{{ csrf_token() }}" // Thêm CSRF Token
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire('Thành công!', response.message,
                                        'success');
                                    location
                                        .reload(); // Reload trang để cập nhật phản hồi
                                }
                            },
                            error: function(xhr) {
                                var errors = xhr.responseJSON.errors;
                                Swal.fire('Lỗi!', errors.reply_content[0], 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection

<style>
    a:hover {
        opacity: 0.7;
    }

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
