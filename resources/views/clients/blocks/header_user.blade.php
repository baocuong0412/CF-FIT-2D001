<div class="bg-primary" style="position: fixed; top: 0; left: 0; right: 0; z-index: 1000;">
    <div class="d-flex justify-content-around">
        <div class="p-2 mt-1 text-white">
            <a href="{{ route('home') }}"  class="text-white text-decoration-none">
                <h5>TÌM PHÒNG NHANH</h5>
            </a>
        </div>
        {{-- start Navigate --}}
        <nav class="bg-primary">
            <ul class="nav justify-content-around mx-auto" style="width: 1200px;">
                <li class="nav-item p-3">
                    <a href="{{ route('home') }}" class="text-white text-decoration-none">Trang chủ</a>
                </li>

                @foreach ($categories as $key => $category)
                    <li class="nav-item p-3">
                        <a href="{{ route('category', ['slug' => $category->slug]) }}" class="text-decoration-none text-white">
                            {{ ucfirst($category->type) }}
                        </a>
                    </li>
                @endforeach

                <li class="nav-item p-3">
                    <a href="#" class="text-white text-decoration-none">Tin tức</a>
                </li>

                <li class="nav-item p-3">
                    <a href="{{ route('price-list') }}" class="text-white text-decoration-none">Bảng giá</a>
                </li>

                <li class="nav-item p-3">
                    <a href="{{ route('contact') }}" class="text-white text-decoration-none">Liên hệ</a>
                </li>
            </ul>
        </nav>
        {{-- end Navigate --}}
    </div>
</div>
