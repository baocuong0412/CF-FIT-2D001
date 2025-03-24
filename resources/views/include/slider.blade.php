<div>
    {{-- Start Carousel --}}
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            @foreach ($sliders as $index => $slider)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ $slider->imageSlider }}" class="d-block mx-auto w-75" style="height: 500px;"
                        alt="imageSlider">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{ $slider->title }}</h5>
                        <p>{{ $slider->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    {{-- End Carousel --}}

    {{-- Start Search --}}
    <div class="mt-2 bg-warning mx-auto rounded w-75 p-3" style="height: 70px;">
        <form action="{{ route('search') }}" method="get">
            <div class="d-grid gap-2" style="grid-template-columns: 3fr 2fr 2fr 2fr 2fr 1fr;">
                {{-- Categories --}}
                <select name="category" id="category" class="form-select">
                    <option value="">---Chọn loại hình---</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->type }}</option>
                    @endforeach
                </select>

                {{-- City --}}
                <select name="city_id" id="city" class="form-select">
                    <option value="">---Tỉnh,Thành phố---</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->fullname }}</option>
                    @endforeach
                </select>

                {{-- District --}}
                <select name="district_id" id="district" class="form-select">
                    <option value="">---Quận, Huyện---</option> {{-- Giữ lại option mặc định --}}
                    @foreach ($districts as $city_id => $cityDistricts)
                        @foreach ($cityDistricts as $district)
                            <option value="{{ $district->id }}" data-city="{{ $city_id }}">
                                {{ $district->fullname }}
                            </option>
                        @endforeach
                    @endforeach
                </select>

                {{-- Ward --}}
                <select name="ward_id" id="ward" class="form-select">
                    <option value="">---Phường, Xã---</option> {{-- Giữ lại option mặc định --}}
                    @foreach ($wards as $district_id => $citywards)
                        @foreach ($citywards as $ward)
                            <option value="{{ $ward->id }}" data-district="{{ $district_id }}">
                                {{ $ward->fullname }}
                            </option>
                        @endforeach
                    @endforeach
                </select>

                {{-- Price --}}
                <select name="price" id="price" class="form-select">
                    @if (request()->segment(2) === 'Cho-thue-mat-bang')
                        <option value="">---Chọn Giá---</option>
                        <option value="10-20">10 - 20 triệu</option>
                        <option value="20-40">20 - 40 triệu</option>
                        <option value="40-60">40 - 60 triệu</option>
                        <option value="60-100">60 - 100 triệu</option>
                        <option value="0">Thỏa thuận</option>
                    @elseif (request()->segment(2) === 'Tim-nguoi-o-ghep')
                        <option value="">---Số Người---</option>
                        <option value="1-3">1 - 3 người</option>
                        <option value="3-6">3 - 6 người</option>
                        <option value="6-999">Trên 6 người</option>
                    @else
                        <option value="">---Chọn Giá---</option>
                        <option value="0-3">Dưới 3 triệu</option>
                        <option value="3-5">3 - 5 triệu</option>
                        <option value="5-8">5 - 8 triệu</option>
                        <option value="8-10">8 - 10 triệu</option>
                        <option value="10-15">10 - 15 triệu</option>
                        <option value="15-999">Trên 15 triệu</option>
                    @endif
                </select>

                {{-- Button Tìm kiếm --}}
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
        </form>
    </div>
    {{-- End Search --}}
</div>

<script>
    < script src = "https://code.jquery.com/jquery-3.7.1.slim.min.js" >
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Giữ trạng thái active cho menu khi load trang
        $("nav li").each(function() {
            if ($(this).find("a").attr("href") === window.location.href) {
                $(this).addClass("active");
            }
        });

        // Click menu để thêm active
        $("nav li a").on("click", function() {
            $("nav li").removeClass("active");
            $(this).parent().addClass("active");
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

    });
</script>
