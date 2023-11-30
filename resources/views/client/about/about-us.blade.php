@extends('layouts.client')
@section('content')
<!-- ==========Banner-Section========== -->
<section class="main-page-header speaker-banner bg_img" data-background="./assets/images/banner/banner07.jpg">
    <div class="container">
        <div class="speaker-banner-content">
            <h2 class="title"> Giới thiệu</h2>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('index') }}">
                        Trang Chủ
                    </a>
                </li>
                <li>
                    Giới thiệu
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
                        <h2 class="text-center" style="margin-bottom: 20px;">Giới thiệu</h2>
                    </div>
                    <div class="post-header">

                        <p>
                            BOLETO là một trong năm Cụm Rạp Chiếu Phim lớn nhất toàn cầu và BOLETO Việt Nam là Nhà Phát Hành, nhà quản lý và vận hành Cụm Rạp Chiếu Phim BOLETO Cinemas lớn nhất tại Việt Nam. Mục tiêu của BOLETO Việt Nam là trở thành công ty giải trí điển hình, đóng góp cho sự phát triển không ngừng của lĩnh vực điện ảnh Việt Nam nói riêng và công nghiệp văn hóa mang đậm bản sắc Việt Nam nói chung.
                        </p>
                        <blockquote>
                            BOLETO Việt Nam hội nhập, hài hòa và góp phần tạo nên khái niệm độc đáo về việc chuyển đổi cụm rạp chiếu phim truyền thống thành tổ hợp văn hóa “Cultureplex”, nơi khán giả không chỉ đến để thưởng thức điện ảnh đa dạng thông qua các công nghệ tiên tiến như SCREENX, IMAX, STARIUM, 4DX, Dolby Atmos, mà còn để thưởng thức ẩm thực hoàn toàn mới và khác biệt với các trải nghiệm dịch vụ chất lượng nhất tại Cụm Rạp Chiếu Phim BOLETO Cinemas.
                        </blockquote>
                        <p>
                            BOLETO Việt Nam hướng sự quan tâm đến phát triển nội tại của công nghiệp văn hóa tại Việt Nam, đồng hành cùng điện ảnh nước nhà. Thông qua những nỗ lực trong việc xây dựng chương trình Nhà biên kịch tài năng, Dự án phim ngắn CJ, Lớp học làm phim TOTO, BOLETO ArtHouse, phối hợp Học Viện Điện Ảnh Hàn Quốc (KAFA) tổ chức Khóa đào tạo cho các đạo diễn xuất sắc của Dự án phim ngắn CJ, BOLETO Việt Nam mong muốn sẽ đồng hành và hỗ trợ phát triển cho các nhà làm phim trẻ tài năng của Việt Nam. Ngoài ra, bằng những nỗ lực của doanh nghiệp, BOLETO Việt Nam đã và đang phối hợp với các bên liên quan nhằm đưa các tác phẩm điện ảnh có nội hàm và đậm bản sắc Việt Nam tham gia các Liên Hoan Phim Quốc tế uy tín; tài trợ cho các hoạt động Liên Hoan Phim uy tín tổ chức tại Việt Nam như Liên Hoan Phim Quốc tế Hà Nội, Liên Hoan Phim Việt Nam,…
                        </p>

                        <p>
                            BOLETO Việt Nam trên hành trình mang điện ảnh đến mọi miền Tổ quốc, cũng tập trung đến đối tượng khán giả ở các khu vực ít có điều kiện tiếp cận với điện ảnh, bằng cách tạo cơ hội để người dân địa phương có thể thưởng thức những tác phẩm điện ảnh chất lượng thông qua các chương trình vì cộng đồng như Trăng cười và Điện ảnh cho mọi người
                        </p>
                        <p>
                            BOLETO Việt Nam cam kết nỗ lực, tiếp tục cuộc hành trình bền bỉ trong việc góp phần xây dựng một nền công nghiệp điện ảnh Việt Nam ngày càng vững mạnh cùng các khách hàng tiềm năng, các nhà làm phim, các đối tác kinh doanh uy tín, và cùng toàn thể xã hội.
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
                            <li><a href="{{route('chinh-sach-bao-mat')}}">Chính sách bảo mật  </a></li>
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