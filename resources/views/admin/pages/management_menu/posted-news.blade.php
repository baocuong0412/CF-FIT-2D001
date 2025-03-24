@extends('admin.layout.master')

@section('content_admin')
    <div>
        <h1>Quản lý tin tức</h1>
        <div class="text-end mb-2">
            <a href="{{ route('admin.make-news') }}" class="btn btn-post btn-add">Tạo tin tức</a>
        </div>

        <div class="main-right-table">
            <table class="table table-bordered table-post-list" id = "table-manage">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Nội dung</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($news as $new)
                        <tr>
                            <td>{{ $new->id }}</td>
                            <td>
                                <img src="{{ $new->image_new }}" alt="hinhanh" style="width: 200px; height: 200px;">
                            </td>
                            <td>{{ $new->title }}</td>
                            <td>{!! $new->description !!}</td>
                            <td>
                                @if ($new->status)
                                    <p class="text-success">Hiển thị</p>
                                @else
                                    <p class="text-warning">Ẩn</p>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.show', ['id' => $new->id]) }}" class="text-primary me-3">
                                    <i class="fa-solid fa-pen-to-square"></i>Sửa</a>

                                <a href="javascript:void(0)" class="text-danger delete-news" data-id="{{ $new->id }}">
                                    <i class="fa-solid fa-trash"></i> Xóa
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
        {{ $news->appends(request()->all())->links('pagination::bootstrap-5') }}
    </div>
@endsection

@section('js_admin')
    <script>
        $(document).ready(function() {
            $(".delete-news").click(function(e) {
                e.preventDefault();
                let newsId = $(this).data("id");

                Swal.fire({
                    title: "Bạn có chắc chắn muốn xóa?",
                    text: "Thao tác này không thể hoàn tác!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Xóa",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.delete') }}", // Định tuyến API xóa
                            type: "DELETE",
                            data: {
                                id: newsId,
                                _token: "{{ csrf_token() }}" // Bảo mật CSRF token
                            },
                            success: function(response) {
                                Swal.fire("Đã xóa!", "Bài viết đã được xóa thành công.",
                                    "success");
                                location.reload(); // Reload lại trang sau khi xóa
                            },
                            error: function() {
                                Swal.fire("Lỗi!", "Có lỗi xảy ra, vui lòng thử lại.",
                                    "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
