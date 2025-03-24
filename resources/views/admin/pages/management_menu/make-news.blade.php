@extends('admin.layout.master')

@section('content_admin')
    <div class="p-0">
        <form action="{{ route('admin.make-news.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <h1>Tạo tin tức mới</h1>
            <hr>
            <div class="bg-warning p-2 rounded-4">
                <h4 class="text-danger p-2">Lưu ý khi tạo bài viết</h4>
                <ul>
                    <li class="text-danger p-2">Nội dung phải viết bằng tiếng Việt có dấu</li>
                    <li class="text-danger p-2">Tiêu đề tin không dài quá 100 kí tự</li>
                    <li class="text-danger p-2">Trong bài viết phải yêu cầu có ít nhất 01 ảnh</li>
                </ul>
            </div>
            <hr>
            <div class="mt-3">
                <label class="form-label">Tiêu đề bài đăng</label>
                <input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề bài đăng">
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3">
                <label class="form-label">Nội dung bài đăng</label>
                <textarea name="description" class="form-control" id="description"></textarea>
                @error('description')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-3">
                <label class="form-label me-3">Trạng thái</label>
                <input class="form-check-input" type="radio" name="status" id="flexRadioDefault1" value="1">
                <label class="form-check-label me-3" for="flexRadioDefault1"> Hiển thị </label>

                <input class="form-check-input" type="radio" name="status" id="flexRadioDefault2" value="0" checked>
                <label class="form-check-label" for="flexRadioDefault2"> Ẩn </label>
            </div>

            <div class="mt-3">
                <label class="form-label">Hình ảnh đại diện</label>
                <div>
                    <div class="input-img">
                        <i class="fa-solid fa-arrow-up-from-bracket"></i>
                        <span>Tải hình đại diện</span>
                        <input type="file" name="image_new" class="upload-img" id="upload-img">
                    </div>
                </div>
                @error('image_new')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <p class="form-message"></p>
                <div id="display-img" class="image-preview"></div>
            </div>

            <button type="submit" class="btn btn-success" style = "width: 100%;height: 45px;font-size: 18px;">Tạo
                mới</button>

        </form>
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


@section('js_admin')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            ClassicEditor.create(document.querySelector('#description'))
                .catch(error => console.error(error));

            function handleImageUpload(input, displayContainer) {
                displayContainer.empty();
                Array.from(input.files).forEach(file => {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        let imgWrapper = $("<div>").addClass("position-relative d-inline-block");
                        let newImage = $("<img>").attr("src", event.target.result)
                            .addClass("img-thumbnail rounded shadow")
                            .css({
                                width: "200px",
                                height: "200px",
                                "object-fit": "cover",
                                "border": "2px solid #ddd"
                            });
                        let removeBtn = $("<button>").html("&times;")
                            .addClass("btn btn-danger btn-sm position-absolute top-0 end-0")
                            .css("transform", "translate(50%, -50%)")
                            .on("click", () => imgWrapper.remove());
                        imgWrapper.append(newImage, removeBtn);
                        displayContainer.append(imgWrapper);
                    };
                    reader.readAsDataURL(file);
                });
            }

            $("#upload-img").on("change", function() {
                handleImageUpload(this, $("#display-img"));
            });

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
@endsection

<style>
    .input-img {
        padding: 12px 18px;
        height: 50px;
        background: #00ad2d;
        border: 1px solid #00ad2d;
        position: relative;
        color: #fff;
        border-radius: 5px;
        text-align: center;
        float: left;
        cursor: pointer;
        font-size: 18px;
    }

    .upload-img {
        position: absolute;
        z-index: 1000;
        opacity: 0;
        cursor: pointer;
        right: 0;
        top: 0;
        height: 100%;
        font-size: 0px;
        width: 100%;
    }
</style>
