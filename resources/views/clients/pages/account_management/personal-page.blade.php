{{-- ----------------------------------------------------- --}}
{{-- Thông tin cá nhân --}}
{{-- ----------------------------------------------------- --}}
@extends('clients.layout.master')

@section('content_client')
    <div class="mx-3 mt-3" style="width: 1570px">
        <div class="row">
            <div class="col-md-12">
                <h1 class="pt-2">Thông tin cá nhân</h1>
                <hr>

                <form action="{{ route('client.update-personal-page') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row text-center">
                        <div>
                            <h5>Ảnh đại diện</h5>
                        </div>
                        <div>
                            <div class="position-relative d-inline-block">
                                <img id="avatar-img"
                                    src="{{ Auth::user()->avatar ?? 'https://cdn.vectorstock.com/i/500p/52/38/avatar-icon-vector-11835238.jpg' }}"
                                    alt="avatar" width="200px" height="200px"
                                    class="border border-2 rounded-circle shadow" name="avatar">
                                <button id="remove-btn"
                                    class="btn btn-danger btn-sm position-absolute top-100 start-50 translate-middle"
                                    style="display: none;">
                                    Xóa ảnh
                                </button>
                            </div>
                        </div>
                        <div class="position-relative d-inline-block mt-5">
                            <div class="input-file form-validator mt-3 position-absolute top-50 start-50 translate-middle">
                                <div style="height: 50px;">
                                    <div class="input-img">
                                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                        Sửa ảnh
                                        <input type="file" class="upload-img" id="upload-img" name="avatar">
                                    </div>
                                </div>
                                <p class="form-message"></p>
                            </div>
                        </div>
                    </div>

                    <div class="container col-md-8 mt-5">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mã thành viên:</label>
                                <input type="text" class="form-control" name="member_id"
                                    value="#KH{{ Auth::user()->id }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tên hiển thị:</label>
                                <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Số điện thoại:</label>
                                <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email:</label>
                                <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Zalo:</label>
                                <input type="text" class="form-control" name="zalo" value="{{ Auth::user()->zalo }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Facebook:</label>
                                <input type="text" class="form-control" name="facebook" placeholder="Đường link facebook"
                                    value="{{ Auth::user()->facebook }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Địa chỉ:</label>
                                <input type="text" class="form-control" name="address"
                                    value="{{ Auth::user()->address }}">
                            </div>

                            <div class="col-md-6 mb-3 d-flex align-items-center">
                                <label class="form-label me-5">Mật khẩu:</label>

                                <!-- Nút Đổi mật khẩu -->
                                <button type="button" id="changePasswordBtn" class="btn btn-primary">Đổi mật khẩu</button>

                                <!-- Form nhập mật khẩu (ẩn ban đầu) -->
                                <div id="passwordFields" style="display: none;" class="ms-3">
                                    <input type="password" id="newPassword" name="new_password" class="form-control"
                                        placeholder="Nhập mật khẩu mới">
                                </div>

                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" style="width: 100%">Lưu thay đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- ----------------------------------------------------- --}}
{{-- End thông tin cá nhân --}}
{{-- ----------------------------------------------------- --}}

@section('js_client')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#changePasswordBtn').click(function() {
            $('#passwordFields').toggle(); // Hiển thị/ẩn input mật khẩu
        });

        function ImageFileAsUrl() {
            const fileInput = $("#upload-img")[0];
            const avatarImg = $("#avatar-img");
            const removeBtn = $("#remove-btn");

            if (fileInput.files.length > 0) {
                const fileToLoad = fileInput.files[0];
                const fileReader = new FileReader();

                fileReader.onload = function(event) {
                    avatarImg.attr("src", event.target.result);
                    removeBtn.show();
                };

                fileReader.readAsDataURL(fileToLoad);
            }
        }

        function removeImage(event) {
            event.preventDefault();
            $("#avatar-img").attr("src", "https://cdn.vectorstock.com/i/500p/52/38/avatar-icon-vector-11835238.jpg");
            $("#remove-btn").hide();
            $("#upload-img").val(""); // Clear file input
        }

        $(document).ready(function() {
            $("#upload-img").off().on("change", ImageFileAsUrl);
            $("#remove-btn").off().on("click", removeImage);

            let successMessage = @json(session('success'));
            let errorMessage = @json(session('error'));

            if (successMessage) {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: successMessage,
                    showConfirmButton: false,
                    timer: 2000
                });
            }

            if (errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: errorMessage,
                    showConfirmButton: true
                });
            }

        });
    </script>
@endsection
