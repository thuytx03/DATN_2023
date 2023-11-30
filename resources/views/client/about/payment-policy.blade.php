@extends('layouts.client')
@section('content')
<!-- ==========Banner-Section========== -->
<section class="main-page-header speaker-banner bg_img" data-background="./assets/images/banner/banner07.jpg">
    <div class="container">
        <div class="speaker-banner-content">
            <h2 class="title"> CHÍNH SÁCH THANH TOÁN</h2>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('index') }}">
                        Trang Chủ
                    </a>
                </li>
                <li>
                    CHÍNH SÁCH THANH TOÁN
                </li>
            </ul>
        </div>
    </div>
</section>
<!-- ==========Banner-Section========== -->

<!-- ==========Blog-Section========== -->
<section class="blog-section padding-top padding-bottom">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 mb-50 mb-lg-0">
                <div class="content">
                    <div>
                        <h2 class="text-center" style="margin-bottom: 20px;">CHÍNH SÁCH THANH TOÁN</h2>
                    </div>
                    <div class="post-header">
                        <h6 class="title6">1. QUY ĐỊNH VỀ THANH TOÁN</h6>
                        <p class="paragraph-spacing">
                            Quý Khách hàng có thể lựa chọn các hình thức thanh toán sau để thanh toán cho giao dịch đặt vé trên Ứng Dụng của CGV Việt Nam:
                            <br>

                            (i) Thẻ Thanh toán Quốc tế hoặc thẻ Thanh toán Nội địa;
                            <br>

                            (ii) Ví điện tử (Momo, Zalopay, ShopeePay, Viettelpay);
                            <br>

                            (iii) Các cổng thanh toán Payoo, VNPAY và ứng dụng QR code;
                            <br>

                            (iv) Thẻ quà Tặng CGV Cinemas (CGV Gift cards, CGV E-Gift cards), Phiếu đổi vé Xem phim CGV Cinemas (CGV vouchers, CGV E-vouchers);
                            <br>

                            (v) Thẻ CGVIANS và thẻ CJ Members; và
                            <br>

                            (vi) Điểm thưởng tích lũy của Thành viên CGV Việt Nam theo chương trình tích lũy điểm thưởng tại từng thời điểm.
                        </p>
                        <h6 class="title6">2. CHI TIẾT CÁC HÌNH THỨC THANH TOÁN</h6>
                        <p class="paragraph-spacing">
                            - Điểm thưởng tích lũy của Thành viên CGV Việt Nam (Membership Point): Mỗi 01 điểm thưởng tương đương với 1.000 VND. Điểm thưởng này, bạn có thể sử dụng để (1) Thanh toán vé xem phim; (2) Mua các sản phẩm đồ ăn thức uống tại hệ thống CGV; (3) Đổi sang hàn trăm ngàn voucher ưu đãi các sản phẩm/dịch vụ của các bên đối tác thứ 3 trên CGV Reward/Đổi ưu đãi. Khi sử dụng điểm thưởng, bạn vui lòng xuất trình thẻ thành viên để được nhân viên hỗ trợ thanh toán. Điểm thưởng được sử dụng phải từ 20 điểm trở lên (Chưa có quy định cụ thể về mức điểm sử dụng tối thiểu đối với các sản phẩm voucher trên CGV Reward).

                            Để kiểm tra điểm thưởng, bạn vui lòng truy cập vào mục Tài Khoản CGV trên Ứng Dụng.
                            <br>
                            <br>

                            - Thẻ quà Tặng CGV Cinemas (CGV Gift cards, CGV E-Gift cards), Phiếu đổi vé Xem phim CGV Cinemas (CGV vouchers, CGV E-vouchers): Với Thẻ Quà Tặng CGV Cinemas hoặc Phiếu đổi vé Xem phim CGV Cinemas vật lý, bạn có thể tìm mua tại các Cụm Rạp Chiếu Phim CGV Cinemas toàn quốc với các mệnh giá từ 100.000đ. Với Thẻ Quà Tặng CGV Cinemas hoặc Phiếu đổi vé Xem phim CGV Cinemas trực tuyến (CGV E-Gift cards, CGV E-vouchers) bạn có thể dễ dàng mua tại Ứng Dụng có các mệnh giá: 100.000đ - 200.000đ - 300.000đ - 500.000đ - 1.000.000đ.

                            Mỗi loại Phiếu đổi vé Xem phim CGV Cinemas sẽ có giá trị quy đổi và thời hạn sử dụng khác nhau. Bạn vui lòng đọc kỹ các điều khoản sử dụng ở mặt sau Phiếu đổi vé Xem phim CGV Cinemas để biết thêm chi tiết. Khi thanh toán trực tuyến, bạn vui lòng đăng ký mã Phiếu đổi vé Xem phim CGV Cinemas và mã PIN để thực hiện thanh toán. Xin lưu ý Phiếu đổi vé Xem phim CGV Cinemas vật lý sau khi mất lớp tráng bạc sẽ không thể đổi vé tại quầy.

                            Đặc biệt, bạn có thể gửi kèm lời chúc bí mật dành cho "người thương" qua Thẻ quà Tặng CGV Cinemas (CGV Gift cards, CGV E-Gift cards).
                            <br>
                            <br>

                            - Ví Điện Tử (Momo, Zalopay, ShopeePay, Viettelpay) làm phương thức thanh toán trên Ứng Dụng. Hoặc nhanh chóng hơn bằng cách mở Ví MoMo và chọn mục "Mua Vé Xem Phim", xem thông tin chi tiết: Tại đây
                            <br>
                            <br>

                            - Thẻ ATM (Thẻ ghi nợ/thanh toán /trả trước nội địa): Để thanh toán bằng thẻ ngân hàng nội địa, thẻ của khách hàng phải được đăng ký sử dụng tính năng thanh toán trực tuyến, hoặc ngân hàng điện tử của Ngân hàng. Giao dịch phải được ghi nhận thành công từ thông báo cấp phép thành công do hệ thống cổng thanh toán trả về (đảm bảo số dư/hạn mức và xác thực khách hàng theo quy định sử dụng của thẻ).
                            <br>
                            <br>

                            - Thẻ tín dụng, thẻ thanh toán quốc tế, thẻ trả trước quốc tế: Thẻ tín dụng/ghi nợ/trả trước VISA, MasterCard, JCB, Union Pay, Amex của các Ngân hàng trong nước và nước ngoài phát hành. Giao dịch phải được ghi nhận cấp phép thành công do đúng hệ thống cổng thanh toán trả về (đảm bảo số dư/hạn mức và xác thực khách hàng theo quy định sử dụng của thẻ).
                        </p>
                        <h6 class="title6">3. DANH SÁCH THẺ ĐƯỢC CHẤP NHẬN THANH TOÁN TRỰC TUYẾN</h6>
                        <p class="paragraph-spacing">
                            (Cập nhật theo thông báo của nhà cung cấp dịch vụ)
                            <br>

                            Thẻ quốc tế:
                            <br>

                            - Visa
                            <br>

                            - MasterCard
                            <br>

                            - JCB
                            <br>

                            - American Express
                            <br>

                            - Union Pay
                            <br>

                            Thẻ nội địa:
                            <br>

                            - Ngân hàng Nông nghiệp và phát triển nông thôn - Agribank.
                            <br>

                            - Ngân hàng TMCP Ngoại thương Việt Nam - Vietcombank.
                            <br>

                            - Ngân hàng TMCP Đông Á – Dong A bank.
                            <br>

                            - Ngân hàng TMCP Công thương Việt Nam - Vietinbank.
                            <br>

                            - Ngân hàng TMCP Kỹ thương Việt Nam – Techcombank.
                            <br>

                            - Ngân hàng TMCP Quốc tế Việt Nam – VIB.
                            <br>

                            - Ngân hàng TMCP Tiên phong – TienphongBank.
                            <br>

                            - Ngân hàng TMCP Phát triển Nhà Tp.HCM – HDBank.
                            <br>

                            - Ngân hàng TMCP Sài gòn – Hà Nội – SHB.
                            <br>

                            - Ngân hàng Xuất nhập khẩu Việt Nam – Eximbank.
                            <br>

                            - Ngân hàng TMCP Hàng Hải Việt Nam – MSB.
                            <br>

                            - Ngân hàng Việt Á - VietA Bank.
                            <br>

                            - Ngân hàng Quân đội – MB.
                            <br>

                            - Ngân hàng TMCP Nam Á - Nam A Bank.
                            <br>

                            - Ngân hàng TMCP Sài Gòn Thương Tín – Sacombank.
                            <br>

                            - Ngân Hàng TMCP Đông Nam Á – SeABank.
                            <br>

                            - Ngân Hàng TMCP Đại Dương – OceanBank.
                            <br>

                            - Ngân Hàng Đầu Tư và Phát triển Việt Nam – BIDV.
                            <br>

                            - Ngân hàng Việt Nam Thịnh Vượng – VPBank.
                            <br>

                            - Ngân Hàng TMCP Bắc Á - BAC A BANK.
                            <br>

                            - Ngân hàng TMCP AN BÌNH – ABBANK.
                        </p>
                        <h6 class="title6">4. TRƯỜNG HỢP GIAO DỊCH THANH TOÁN KHÔNG THÀNH CÔNG</h6>
                        <p class="paragraph-spacing">
                            Giao dịch thanh toán không thành công có thể do nhiều nguyên nhân. Bạn tham khảo các nguyên nhân sau:
                            <br>

                            - Chưa đăng ký chức năng thanh toán trên Internet với Ngân hàng
                            <br>

                            - Đối với thẻ Visa, MasterCard: Trong quá trình thanh toán, có thể bạn được yêu cầu nhập Mật khẩu của chương trình Verified by Visa hoặc MasterCard SecureCode... nhưng bạn đã không hoàn thành bước xác thực này.
                            <br>

                            - Thẻ không đủ hạn mức/ số dư để thanh toán. Một số Ngân hàng có quy định cả hạn mức chi tiêu theo ngày cho thẻ.
                            <br>

                            - Nhập sai thông tin thẻ.
                            <br>

                            Vui lòng liên hệ hotline 1900 6017 hoặc Ngân hàng phát hành thẻ để tìm hiểu nguyên nhân chính xác.
                        </p>
                    </div>

                </div>
            </div>
            <div class="col-lg-4 col-sm-10 col-md-8">
                <aside>
                    <div class="widget widget-categories">
                        <h5 class="title">Danh Mục</h5>
                        <ul>
                            <li><a href="{{route('gioi-thieu')}}">Giới thiệu </a></li>
                            <li><a href="{{route('dieu-khoan-chung')}}">Điều khoản chung </a></li>
                            <li><a href="{{route('dieu-khoan-giao-dich')}}">Điều khoản giao dịch </a></li>
                            <li><a href="{{route('chinh-sach-thanh-toan')}}">Chính sách thanh toán </a></li>
                            <li><a href="{{route('chinh-sach-bao-mat')}}">Chính sách bảo mật </a></li>
                            <li>
                        <a href="{{route('thanh-vien')}}">Thành Viên</a>
                    </li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
<style>
    .paragraph-spacing {
        margin-bottom: 50px;
    }

    /* Giới hạn nội dung trong 2 dòng */

    .title6 {
        margin-bottom: 30px;

    }

    .date {
        font-size: 16px;
        font-weight: bold;
        color: blue;
    }

    /* Giới hạn nội dung trong 2 dòng */



    /* Tùy chỉnh CSS cho số trang trong phân trang */
    .pagination li {
        display: inline-block;
        margin: 0 5px;
        /* Khoảng cách giữa các số trang */
        padding: 5px 10px;
        /* Định dạng kích thước và khoảng cách xung quanh số trang */
        border: 1px solid #ccc;
        background-color: #fff;
        color: #333;
        cursor: pointer;
        border-radius: 3px;
        text-align: center;
    }

    /* CSS cho số trang hiện tại */
    .pagination .active {
        background-color: #007BFF;
        color: #fff;
        border: 1px solid #007BFF;
    }
</style>
<!-- ==========Blog-Section========== -->
@endsection
@push('style')
<link rel="stylesheet" type="text/css" href="styles.css">
<style>
    .date {
        font-size: 16px;
        font-weight: bold;
        color: blue;
    }

    /* Giới hạn nội dung trong 2 dòng */



    /* Tùy chỉnh CSS cho số trang trong phân trang */
    .pagination li {
        display: inline-block;
        margin: 0 5px;
        /* Khoảng cách giữa các số trang */
        padding: 5px 10px;
        /* Định dạng kích thước và khoảng cách xung quanh số trang */
        border: 1px solid #ccc;
        background-color: #fff;
        color: #333;
        cursor: pointer;
        border-radius: 3px;
        text-align: center;
    }

    /* CSS cho số trang hiện tại */
    .pagination .active {
        background-color: #007BFF;
        color: #fff;
        border: 1px solid #007BFF;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/momentjs/2.29.1/moment.min.js"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var titles = $('.post-item'); // Select all the <h4> elements initially
        $('#search').on('input', function() {
            var searchText = $(this).val().toLowerCase();
            titles.each(function() {
                var text = $(this).text().toLowerCase();
                if (text.indexOf(searchText) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    });
</script>

<script>
    function submitForm(element) {
        var postType = element.querySelector('.post-type').getAttribute('data-value');
        var form = document.getElementById('postTypeSearch');
        var hiddenField = document.createElement('input');
        hiddenField.type = 'hidden';
        hiddenField.name = 'postTypes';
        hiddenField.value = postType;
        form.appendChild(hiddenField);
        form.submit();
    }
</script>



@endpush