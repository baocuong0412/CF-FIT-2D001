@extends('welcome')

<style>
    .features {
        list-style: none;
        /* Bỏ dấu chấm mặc định */
        padding-left: 0;
        /* Xóa padding mặc định */
    }

    .features li::before {
        content: "✔️";
        /* Thêm dấu tích */
        margin-right: 8px;
        /* Tạo khoảng cách giữa dấu tích và nội dung */
        color: green;
        /* Màu dấu tích */
        font-weight: bold;
        /* Đậm hơn */
    }
</style>
@section('content')
    <div class="container" style="margin-top: 108px">
        <h1 class="title">Giới thiệu về Tìm Phòng Nhanh</h1>
        <div class="border border-secondary rounded">
            <div class="p-5">
                <p class="subtitle">ĐỪNG ĐỂ PHÒNG TRỐNG THÊM BẤT CỨ NGÀY NÀO! Đăng tin ngay tại Tìm Phòng Nhanh và tất cả các
                    vấn đề
                    sẽ được giải quyết một cách nhanh nhất.</p>
                <h5>ƯU ĐIỂM TÌM PHÒNG NHANH:</h5>
                <ul class="features">
                    <li class="pb-3">Top đầu google về từ khóa: cho thuê phòng trọ, thuê phòng trọ, phòng trọ hồ chí minh,
                        phòng trọ hà nội, thuê
                        nhà nguyên căn, cho thuê căn hộ, tìm người ở ghép... với lưu lượng truy cập (traffic) cao nhất trong
                        lĩnh vực.
                    </li>
                    <li class="pb-3">Tìm phòng nhanh tuân thủ có số lượng dữ liệu bài đăng lớn nhất trong lĩnh vực cho thuê
                        phòng trọ với hơn
                        <strong>105.000</strong> tin trên hệ thống và tiếp tục tăng.
                    </li>
                    <li class="pb-3">Tìm phòng nhanh tự hào có số lượng người dùng lớn nhất trong lĩnh vực cho thuê phòng
                        trọ với hơn
                        <strong>300.000</strong> khách truy cập thường xuyên.
                    </li>
                    <li class="pb-3">Tìm phòng nhanh tự hào được sự tin tưởng sử dụng của hơn <strong>116.998</strong>
                        khách hàng là chủ
                        nhà, đại
                        lý, môi giới đăng tin thường xuyên tại website.</li>
                    <li>Tìm phòng nhanh tự hào ghi nhận hơn <strong>80.000</strong> giao dịch thành công khi sử dụng dịch vụ
                        tại
                        web, mức độ hiệu quả đạt xấp xỉ <strong>85%</strong> tổng tin đăng.</li>
                </ul>
            </div>
        </div>

        <div class="border border-secondary rounded mt-4">
            <h1 class="text-center p-3 border-bottom">Bảng Giá Dịch Vụ</h1>
            <div class="p-5">
                <p>Nếu bạn muốn tiếp cận với những người thuê trọ, nhà, căn hộ, homestay... một cách nhanh chóng và hiệu quả nhất
                    thông qua website tìm phòng nhanh của chúng tôi. Bạn có thể chọn loại gói tin đăng mà bạn muốn để viết của mình
                    hiện lên và tiếp cận với nhiều người.</p>
                <p>Dưới đây là bảng giá chi tiết các gói tin mà bạn có thể lựa chọn</p>
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center ">
                            <th style="width: 171px;"></th>
                            <th style="width: 171px; background-color: #d63031">Tin VIP nổi bật</th>
                            <th style="width: 171px; background-color: #e84393">Tin VIP 1</th>
                            <th style="width: 171px; background-color: #e17055">Tin VIP 2</th>
                            <th style="width: 171px; background-color: #0984e3">Tin VIP 3</th>
                            <th style="width: 171px; background-color: #6c5ce7">Tin thông thường</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 171px;"><strong>Ưu điểm</strong></td>
                            <td style="width: 171px;">
                                <p>- Lượt xem nhiều <strong>gấp 30 lần</strong> so với tin thường.</p> <br>

                                <p>- Ưu việt, tiếp cận <strong>tối đa</strong> khách hàng.</p> <br>

                                <p>- Xuất hiện vị trí <strong>đầu tiên</strong> ở trang chủ.</p><br>

                                <p>- Đứng <strong>trên tất cả</strong> các loại tin VIP khác.</p><br>

                                <p>- Xuất hiện <strong>đầu tiên</strong> ở mục tin nổi bật xuyên suốt khu vực chuyên mục đó.
                                </p><br>
                            </td>
                            <td style="width: 171px;">
                                <p>- Lượt xem nhiều so với tin thường.</p><br>

                                <p>- Tiếp cận <strong>rất nhiều</strong> khách hàng.</p><br>

                                <p>- Xuất hiện sau <strong>VIP NỔI BẬT</strong> và trước <strong>Vip 2, Vip 3, tin
                                        thường</strong>.</p><br>

                                <p>- Xuất hiện thêm ở mục tin nổi bật xuyên suốt khu vực chuyên mục đó.</p><br>
                            </td>
                            <td style="width: 171px;">
                                <p>- Lượt xem nhiều <strong>gấp 10</strong> lần so với tin thường.</p><br>

                                <p>- Tiếp cận khách hàng <strong>rất tốt.</strong></p><br>

                                <p>- Xuất hiện <strong>sau VIP 1</strong> và <strong>trước VIP 3, tin thường.</strong></p>
                                <br>

                                <p>- Xuất hiện thêm ở mục tin nổi bật xuyên suốt khu vực chuyên mục đó.</p><br>
                            </td>
                            <td style="width: 171px;">
                                <p>- Lượt xem nhiều <strong>gấp 5</strong> lần so với tin thường</p><br>

                                <p>- Tiếp cận khách hàng <strong>tốt.</strong></p><br>

                                <p>- Xuất hiện <strong>sau VIP 2</strong> và <strong>sau VIP 2.</strong></p><br>
                            </td>
                            <td style="width: 171px;">
                                <p>- Tiếp cận khách hàng <strong>khá tốt</strong></p>
                            </td><br>
                        </tr>
                        <tr>
                            <td style="width: 171px;"><strong>Phù hợp</strong></td>

                            <td style="width: 171px;">Phù hợp khách hàng là công ty/cá nhân sở hữu <strong>hệ thống
                                    lớn</strong> có từ 15-20 căn phòng/nhà trở lên hoặc phòng trống quá lâu, thường xuyên
                                đang cần <strong>cho thuê gấp.</strong>
                            </td>

                            <td style="width: 171px;">Phù hợp khách hàng cá nhân/môi giới có 10-15 căn phòng/nhà đang trống
                                thường xuyên, cần cho thuê <strong>nhanh nhất.</strong>
                            </td>
                            <td style="width: 171px;">Phù hợp khách hàng cá nhân/môi giới có lượng căn trống thường xuyên,
                                cần cho thuê <strong>nhanh hơn.</strong>
                            </td>

                            <td style="width: 171px;">Phù hợp loại hình phòng trọ chung chủ, KTX ở ghép hay khách hàng có
                                1-5 căn phòng/nhà cần cho thuê nhanh, <strong>tiếp cận khách hàng tốt hơn.</strong>
                            </td>
                            <td style="width: 171px;">Phù hợp tất cả các loại hình tuy nhiên lượng tiếp cận khách hàng
                                <strong>thấp hơn</strong> và cho thuê <strong>chậm hơn</strong> so với tin VIP.
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 171px;"><strong>Giá ngày</strong></td>
                            <td style="width: 171px;"><h4>20.000 đ/ngày</h4> (Tối thiểu 5 ngày)</td>
                            <td style="width: 171px;"><h4>15.000 đ/ngày</h4> (Tối thiểu 5 ngày)</td>
                            <td style="width: 171px;"><h4>10.000 đ/ngày</h4> (Tối thiểu 5 ngày)</td>
                            <td style="width: 171px;"><h4>5.000 đ/ngày</h4> (Tối thiểu 5 ngày)</td>
                            <td style="width: 171px;"><h4>2.000 đ/ngày</h4> (Tối thiểu 5 ngày)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
