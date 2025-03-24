@extends('admin.layout.master')

@section('content_admin')
    <div>
        <h1 class="border-bottom pb-2 mb-3">Trang quản lý</h1>
        <div class="row">
            @php
                $cards = [
                    [
                        'title' => 'Tin chưa thanh toán',
                        'count' => $unpaidRoom ?? 0,
                        'color' => 'primary',
                        'link' => route('admin.post-unpaid'),
                        'text' => 'Xem ngay',
                    ],
                    [
                        'title' => 'Tin đang chờ duyệt',
                        'count' => $pendingRoom ?? 0,
                        'color' => 'warning',
                        'link' => route('admin.post-pending'),
                        'text' => 'Duyệt tin',
                    ],
                    [
                        'title' => 'Tin đã duyệt',
                        'count' => $approvedRoom ?? 0,
                        'color' => 'success',
                        'link' => route('admin.post-approved'),
                        'text' => 'Xem ngay',
                    ],
                    [
                        'title' => 'Phản hồi mới',
                        'count' => $newFeedback ?? 0,
                        'color' => 'danger',
                        'link' => route('admin.unresolved_feedback'),
                        'text' => 'Giải quyết',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-{{ $card['color'] }} text-white mb-4">
                        <div class="card-body">
                            <p>{{ $card['title'] }}</p>
                            <p class="count-number">{{ $card['count'] }}</p>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ $card['link'] }}">{{ $card['text'] }}</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Biểu đồ doanh thu -->
        <h1 class="border-bottom pb-2 mb-3">Biểu đồ thống kê doanh thu</h1>

        <!-- Chọn tháng và năm -->
        <div class="form-contact form-validator">
            <select name="month" id="month" class="autobox form-focus boder-ra-5" style="width: 20%;">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ now()->month == $i ? 'selected' : '' }}>Tháng {{ $i }}
                    </option>
                @endfor
            </select>

            <select name="year" id="year" class="autobox form-focus boder-ra-5" style="width: 20%;">
                @for ($i = 2025; $i <= 2030; $i++)
                    <option value="{{ $i }}" {{ now()->year == $i ? 'selected' : '' }}>{{ $i }}
                    </option>
                @endfor
            </select>
        </div>


        <!-- Biểu đồ doanh thu theo từng ngày trong tháng -->
        <div id="revenue_by_day" style="width: 100%; height: 500px;"></div>

        <!-- Biểu đồ doanh thu theo loại thanh toán -->
        <div id="revenue_by_payment_method" style="width: 100%; height: 500px;"></div>

        <!-- Biểu đồ doanh thu theo tháng -->
        <div id="revenue_by_month" style="width: 100%; height: 500px;"></div>
    </div>
@endsection

@section('js_admin')
    <!-- Google Charts -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- Thêm CSRF token vào trang -->
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });

        google.charts.setOnLoadCallback(drawCharts);

        // Gọi biểu đồ lần đầu với giá trị mặc định
        function drawCharts() {
            let month = document.getElementById('month').value;
            let year = document.getElementById('year').value;

            drawRevenueByDay(month, year);
            drawRevenueByPaymentMethod(month, year);
            drawRevenueByMonth(year);
        }

        // Sự kiện khi chọn tháng/năm
        document.getElementById('month').addEventListener('change', drawCharts);
        document.getElementById('year').addEventListener('change', drawCharts);

        // Biểu đồ doanh thu theo ngày
        function drawRevenueByDay(month, year) {
            fetch(`/admin/chart/revenue-by-day?month=${month}&year=${year}`)
                .then(response => response.json())
                .then(data => {
                    let chartData = [
                        ['Ngày', 'Doanh thu']
                    ];
                    data.forEach(row => {
                        chartData.push([row.date, parseInt(row.total)]);
                    });

                    let chart = new google.visualization.LineChart(document.getElementById('revenue_by_day'));
                    chart.draw(google.visualization.arrayToDataTable(chartData), {
                        title: `Doanh thu theo ngày - Tháng ${month}/${year}`,
                        curveType: 'function',
                        legend: {
                            position: 'bottom'
                        }
                    });
                });
        }

        // Biểu đồ doanh thu theo phương thức thanh toán
        function drawRevenueByPaymentMethod(month, year) {
            fetch(`/admin/chart/revenue-by-payment-method?month=${month}&year=${year}`)
                .then(response => response.json())
                .then(data => {
                    let chartData = [
                        ['Phương thức thanh toán', 'Doanh thu']
                    ];
                    data.forEach(row => {
                        chartData.push([row.payment_method, parseInt(row.total)]);
                    });

                    let chart = new google.visualization.PieChart(document.getElementById('revenue_by_payment_method'));
                    chart.draw(google.visualization.arrayToDataTable(chartData), {
                        title: `Doanh thu theo phương thức thanh toán - Tháng ${month}/${year}`
                    });
                });
        }

        // Biểu đồ doanh thu theo tháng
        function drawRevenueByMonth(year) {
            fetch(`/admin/chart/revenue-by-month?year=${year}`)
                .then(response => response.json())
                .then(data => {
                    let chartData = [
                        ['Tháng', 'Doanh thu']
                    ];
                    data.forEach(row => {
                        chartData.push([row.month, parseInt(row.total)]);
                    });

                    let chart = new google.visualization.ColumnChart(document.getElementById('revenue_by_month'));
                    chart.draw(google.visualization.arrayToDataTable(chartData), {
                        title: `Doanh thu theo tháng - Năm ${year}`
                    });
                });
        }
    </script>
@endsection
