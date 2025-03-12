{{-- ----------------------------------------------------- --}}
{{-- Trang đăng tin --}}
{{-- ----------------------------------------------------- --}}
@extends('clients.layout.master')

@section('content_client')
    <div class="mt-3 ps-4" style="width: 1570px">
        <div>
            <h1 class="pt-2">Tạo tin đăng mới</h1>
            <hr>
            <div class="alert alert-warning p-3">
                <h5>Lưu ý khi đăng tin</h5>
                <ul>
                    <li>Nội dung phải viết bằng tiếng Việt có dấu</li>
                    <li>Tiêu đề tin không dài quá 100 kí tự</li>
                    <li>Điền đầy đủ thông tin để tin đăng hiệu quả hơn.</li>
                    <li>Hình ảnh rõ ràng giúp tăng lượng xem và giao dịch nhanh chóng!</li>
                    <li>Chọn loại tin, ngày bắt đầu và kết thúc trước khi gửi.</li>
                </ul>
            </div>
        </div>
        <hr>
        <form action="{{ route('client.create.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <h3>Thông Tin Người Đăng</h3>
                {{-- Hiển thị thông tin người dùng --}}
                <div class="d-flex gap-3">
                    <div>
                        <label class="form-label">Mã Thành Viên</label>
                        <input type="text" class="form-control" value="#KH{{ auth()->user()->id }}" disabled>
                    </div>
                    <div>
                        <label class="form-label">Tên Người Dùng</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                    </div>
                    <div>
                        <label class="form-label">Số Điện Thoại</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->phone }}" disabled>
                    </div>
                </div>
                {{-- End Hiển thị thông tin người dùng --}}

                {{--  Hiển thị thông tin mô tả --}}
                <h3 class="mt-3">Thông Tin Mô Tả</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Chuyên mục bài đăng</label>
                        <select class="form-select" name="category_id">
                            <option value="">--- Danh mục ---</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- End Hiển thị thông tin mô tả --}}

                {{-- Hiển thị thông tin bài đăng --}}
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

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Giá Cho Thuê (VNĐ)</label>
                        <span class="text-danger">Vui lòng nhập đủ số tiền. Ví dụ 2 triệu: 2000000</span>
                        <input type="number" name="price" class="form-control" placeholder="Nhập giá cho thuê">
                        @error('price')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Diện Tích (m²)</label>
                        <input type="number" name="area" class="form-control" placeholder="Nhập diện tích">
                        @error('area')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- Hình ảnh --}}
                <div class="input-file form-validator mt-3">
                    <p>Hình ảnh đại diện</p>
                    <div style="height: 50px;">
                        <div class="input-img">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            Tải hình đại diện
                            <input type="file" name="image_logo" class="upload-img" id="upload-img">
                        </div>
                    </div>
                    @error('image_logo')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <p class="form-message"></p>
                    <div id="display-img" class="d-flex flex-wrap gap-2"></div>
                </div>

                <div class="input-file form-validator mt-3">
                    <p>Hình ảnh chi tiết</p>
                    <div style="height: 50px;">
                        <div class="input-img">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                            Tải hình ảnh chi tiết
                            <input type="file" name="images[]" class="upload-img" id="upload-imgs" multiple>
                        </div>
                    </div>
                    @error('images')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <p class="form-message"></p>
                    <div id="display-imgs" class="d-flex flex-wrap gap-2"></div>
                </div>
                {{-- End hình ảnh --}}


                <h3 class="mt-3">Địa chỉ cho thuê</h3>
                <div class="d-flex mb-3">
                    <div class="col ms-4">
                        <label for="city">Tỉnh/Thành Phố</label>
                        <select name="city_id" id="city" class="form-select">
                            <option value="">Tỉnh,Thành phố</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->fullname }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col ms-4">
                        <label for="district">Quận/Huyện</label>
                        <select name="district_id" id="district" class="form-select">
                            <option value="">Quận, Huyện</option>
                            @foreach ($districts as $city_id => $cityDistricts)
                                @foreach ($cityDistricts as $district)
                                    <option value="{{ $district->id }}" data-city="{{ $city_id }}">
                                        {{ $district->fullname }}</option>
                                @endforeach
                            @endforeach
                        </select>
                        @error('district_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col ms-4">
                        <label for="ward">Phường/Xã</label>
                        <select name="ward_id" id="ward" class="form-select">
                            <option value="">Phường, Xã</option>
                            @foreach ($wards as $district_id => $citywards)
                                @foreach ($citywards as $ward)
                                    <option value="{{ $ward->id }}" data-district="{{ $district_id }}">
                                        {{ $ward->fullname }}</option>
                                @endforeach
                            @endforeach
                        </select>
                        @error('ward_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col ms-4">
                        <label for="street">Tên Đường</label>
                        <input type="text" name="street" class="form-control" placeholder="Nhập tên đường ...">
                        @error('street')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <h3>Loại Tin Đăng</h3>
                <div class="d-flex justify-content-between">
                    <div>
                        <label for="new_type" class="form-label">Loại Tin Đăng</label>
                        <select name="new_type_id" id="new_type" class="form-select">
                            <option value="">--- Chọn loại tin ---</option>
                            @foreach ($newType as $item)
                                <option value="{{ $item->id }}">
                                    {{ sprintf('%s (%s VNĐ)', $item->name_type, $item->price) }}</option>
                            @endforeach
                        </select>
                        @error('new_type_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Ngày Bắt Đầu</label>
                        <input type="date" name="time_start" id="start_date" class="form-control">
                        @error('time_start')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label">Ngày Kết Thúc</label>
                        <input type="date" name="time_end" id="end_date" class="form-control">
                        @error('time_end')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                {{-- End Hiển thị thông tin bài đăng --}}


                <div class="mt-5 mb-5">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Tiếp Tục</button>
                </div>
            </div>

        </form>
    </div>
@endsection

@section('js_client')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            ClassicEditor.create(document.querySelector('#description')).catch(error => console.error(error));

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

            $("#upload-imgs").on("change", function() {
                console.log(this.files); // Kiểm tra danh sách ảnh tải lên
                handleImageUpload(this, $("#display-imgs"));
            });

            // Lọc option theo attribute
            function filterOptions(selector, attribute, value) {
                $(selector).each(function() {
                    $(this).toggle($(this).data(attribute) == value);
                });
            }

            // Lọc quận huyện theo tỉnh thành phố
            $("#city").on("change", function() {
                filterOptions("#district option", "city", $(this).val());
            });

            // Lọc quận huyện theo tỉnh thành phố
            $("#district").on("change", function() {
                filterOptions("#ward option", "district", $(this).val());
            });

            // Đặt ngày bắt đầu và ngày kết thúc mặc định
            $("#new_type").change(function() {
                let today = new Date();
                $("#start_date").val(today.toISOString().split('T')[0]);
                $("#end_date").val(new Date(today.setDate(today.getDate() + 5)).toISOString().split('T')[
                    0]);
            });
        });
    </script>
@endsection
{{-- ----------------------------------------------------- --}}
{{-- End Trang đăng tin --}}
{{-- ----------------------------------------------------- --}}
