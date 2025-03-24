@extends('welcome')

@section('content')
    <div class="container">
        <h2>Kết quả tìm kiếm</h2>

        @if ($rooms->isEmpty())
            <p>Không tìm thấy phòng nào phù hợp.</p>
        @else
            <div class="row">
                @foreach ($rooms as $room)
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <img src="{{ $room->image_logo }}" class="card-img-top" alt="{{ $room->title }}" style="width: 416px; height: 300px;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $room->title }}</h5>
                                <p class="card-text"><strong>Giá:</strong> {{ number_format($room->price) }} VNĐ/tháng</p>
                                <p class="card-text"><strong>Diện tích:</strong> {{ $room->area }} m²</p>
                                <a href="{{ route('detail', ['id' => $room->id]) }}" class="btn btn-primary">Xem chi
                                    tiết</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
