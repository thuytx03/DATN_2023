@extends('layouts.client')
@section('content')
<!-- ==========Banner-Section========== -->
<section class="main-page-header speaker-banner bg_img" data-background="./assets/images/banner/banner07.jpg">
    <div class="container">
        <div class="speaker-banner-content">
            <h2 class="title"> Thành Viên</h2>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('index') }}">
                        Trang Chủ
                    </a>
                </li>
                <li>
                    thành viên
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
                        <h2 class="text-center" style="margin-bottom: 20px;">Thành Viên</h2>
                    </div>
                    <div class="post-header">

                        <div class="container mt-5">
                            <ul class="nav nav-tabs" id="myTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab1">CHƯƠNG TRÌNH ĐIỂM THƯỞNG</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab3">CẤP ĐỘ THÀNH VIÊN</a>
                                </li>
                            </ul>

                            <div class="tab-content mt-2">
                                <div class="tab-pane fade show active" id="tab1">
                                    <p>
                                        <br>
                                        <br>
                                        Chương trình bao gồm 3 đối tượng thành viên  Member |  VIP và  VVIP, với những quyền lợi và mức ưu đãi khác nhau. Mỗi khi thực hiện giao dịch tại hệ thống rạp BOLETO, bạn sẽ nhận được một số điểm thưởng tương ứng với cấp độ thành viên:
                                        <br>

                                    <table class="table table-light">
                                        <thead>
                                            <tr>
                                                <th>điểm thưởng</th>
                                                <th>Member</th>
                                                <th>VIP</th>
                                                <th>VVIP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td> Vé</td>
                                                <td>5%</td>
                                                <td>7%</td>
                                                <td>10%</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>VD: 100,000 VND</td>
                                                <td>5000 Điểm</td>
                                                <td>7000 Điểm</td>
                                                <td>10000 Điểm</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Bắp Nước</td>
                                                <td>3%</td>
                                                <td>5%</td>
                                                <td>7%</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>VD: 100,000 VND</td>
                                                <td>3000 Điểm</td>
                                                <td>5000 Điểm</td>
                                                <td>7000 Điểm</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                     Điểm thưởng được dùng để đổi mã giảm giá trên tổng hóa đơn tương ứng tại Boleto.

                                    Cách làm tròn điểm thưởng:
                                    <br>
                                    - Từ 0.1 đến 0.4: làm tròn xuống (Ví dụ: 3.2 điểm sẽ được tích vào tài khoản 3 điểm)
                                    <br>
                                    - Từ 0.5 đến 0.9: làm tròn lên (Ví dụ: 3.6 điểm sẽ được tích vào tài khoản 4 điểm)
                                    <br>
                                    Lưu ý:
                                    <br>
                                    1. Điểm thưởng có thời hạn sử dụng là 01 năm. Ví dụ: Điểm của bạn được trong năm 2023 thì tính đến ngày cuối cùng của năm 2023 30/12 so với năm thường và 31/12 với năm nhuận
                                    <br>
                                    2. Điểm thưởng có giá trị sử dụng tại tất cả các rạp BOLETO trên toàn quốc.
                                    <br>
                                    3. Sau khi suất chiếu kết thúc, điểm thưởng sẽ được ghi nhận vào tài khoản của bạn sau khi rạp cập nhật .
                                    <br>



                                    </p>
                                </div>

                                <div class="tab-pane fade" id="tab3">
                                    <p>
                                    <div class="container mt-5">
                                        <ul class="nav nav-tabs" id="myTabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab4">THÀNH VIÊN  </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab5">THÀNH VIÊN VIP </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab6">THÀNH VIÊN VVIP </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content mt-2">
                                            <div class="tab-pane fade show active" id="tab4">
                                                <p>Khi tạo tài khoản người dùng sẽ được tạo thành viên:
                                                    <br>
                                                    - Tích lũy điểm 5% giá trị giao dịch tại quầy vé và 3% giá trị giao dịch tại quầy bắp nước.
                                                    <br>
                                                    - Cơ hội tham gia những chương trình đặc biệt khác chỉ áp dụng cho thành viên Boleto.
                                                    <br>
                                                </p>
                                            </div>
                                            <div class="tab-pane fade" id="tab5">
                                                <p>- Nâng hạng VIP dành cho các khách hàng có tổng chi tiêu là 4,000,000 VNĐ đến 7,999,999 VNĐ.
                                                <br>

                                                    <br>
                                                    Quyền lợi của VIP 2023:
                                                    <br>
                                                    - 1 thẻ giảm giá giảm giá 10% trên tổng hóa đơn
                                                    - 1 thẻ giảm giá 20,000VND trên tổng hóa đơn
                                                    <br>

                                                    - Tỷ lệ tích điểm hấp dẫn: 7% tại quầy vé & 5% tại quầy bắp nước.
                                                    <br>
                                                    Ghi chú:
                                                    <br>
                                                    - Cấp độ thành viên VIP và các ưu đãi kèm theo chỉ có giá trị đến hết 31/12/2023.
                                                    <br>
                                                    - Khách hàng tận hưởng ưu đãi tại các rạp BOLETO trên toàn quốc.
                                                    <br>
                                                    </p>
                                            </div>
                                            <div class="tab-pane fade" id="tab6">
                                                <p>- Nâng hạng VVIP 2023 dành cho khách hàng có tổng chi tiêu trong 2022 từ 8,000,000 VNĐ trở lên.
                                                <br>
                                                    (*) Tổng chi tiêu năm 2022 được tính từ ngày 01/01/2022 đến 31/12/2022
                                                    <br>
                                                    Quyền lợi của VVIP 2023:
                                                    <br>
                                                    - 5 thẻ giảm giá 15% trên tổng hóa đơn
                                                    - 10 thẻ giảm giá 20,000 trên tổng hóa đơn
                                                    <br>


                                                    <br>
                                                    Ghi chú:
                                                    <br>
                                                    - Cấp độ thành viên VVIP và các ưu đãi kèm theo chỉ có giá trị đến hết năm hiện tại VD: năm nay là 2023 thì sẽ có giá trị đến ngày 30/12/2023.


                                            </div>
                                        </div>
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </div>


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
                            <li><a href="{{route('thanh-vien')}}">Thành Viên </a></li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
<!-- ==========Blog-Section========== -->
@endsection
@push('styles')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>



@endpush
