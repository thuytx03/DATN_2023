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
                                    <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab2">QUÀ TẶNG SINH NHẬT
                                    </a>
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
                                        Chương trình bao gồm 4 đối tượng thành viên CGV Member | CGV VIP và CGV VVIP, với những quyền lợi và mức ưu đãi khác nhau. Mỗi khi thực hiện giao dịch tại hệ thống rạp CGV, bạn sẽ nhận được một số điểm thưởng tương ứng với cấp độ thành viên:
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
                                                <td>Tại Quầy Vé</td>
                                                <td>5%</td>
                                                <td>7%</td>
                                                <td>10%</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>VD: 100,000 VND</td>
                                                <td>5 Điểm</td>
                                                <td>7 Điểm</td>
                                                <td>10 Điểm</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Quầy Bắp Nước</td>
                                                <td>3%</td>
                                                <td>4%</td>
                                                <td>5%</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>VD: 100,000 VND</td>
                                                <td>3 Điểm</td>
                                                <td>4 Điểm</td>
                                                <td>5 Điểm</td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    1 điểm = 1.000 VND, có giá trị như tiền mặt, được dùng để mua vé xem phim, thức uống/ combo tương ứng tại CGV và đổi voucher ưu đãi trên CGV Reward. Ví dụ: Với giao dịch mua vé giá 100.000 VND bạn có thể:
                                    <br>
                                    - Thanh toán 80.000 VND + 20 điểm thưởng
                                    <br>
                                    - Thanh toán với 10.000 VND + 90 điểm thưởng
                                    <br>
                                    Cách làm tròn điểm thưởng:
                                    <br>
                                    - Từ 0.1 đến 0.4: làm tròn xuống (Ví dụ: 3.2 điểm sẽ được tích vào tài khoản 3 điểm)
                                    <br>
                                    - Từ 0.5 đến 0.9: làm tròn lên (Ví dụ: 3.6 điểm sẽ được tích vào tài khoản 4 điểm)
                                    <br>
                                    Lưu ý:
                                    <br>
                                    1. Điểm thưởng có thời hạn sử dụng là 01 năm. Ví dụ: Điểm của bạn được nhận vào 8h00 ngày 05/01/2023 sẽ hết hạn sử dụng vào lúc 8h00 ngày 05/01/2024.
                                    <br>
                                    2. Điểm thưởng có giá trị sử dụng tại tất cả các rạp CGV trên toàn quốc.
                                    <br>
                                    3. Sau khi suất chiếu diễn ra, điểm thưởng sẽ được ghi nhận vào tài khoản của bạn vào 8:00 sáng ngày tiếp theo. Ví dụ: suất chiếu của bạn diễn ra vào ngày 05/01/2023, điểm thưởng sẽ được ghi nhận vào tài khoản của bạn vào 8:00 sáng ngày 06/01/2023.
                                    <br>
                                    4. Bạn có thể dễ dàng kiểm tra điểm thưởng của mình trên CGV Website hoặc Ứng dụng CGV trên điện thoại (Mobile App).
                                    <br>
                                    5. Điểm thưởng tối thiểu được sử dụng cho mỗi giao dịch là 20 điểm trở lên.
                                    <br>
                                    6. Thành viên khi thanh toán trực tuyến trên Website/APP, trong 1 giao dịch, điểm thưởng chỉ được sử dụng thanh toán tối đa 90% giá trị đơn hàng.
                                    <br>
                                    7. Khi thực hiện các giao dịch sử dụng từ 500 điểm trở lên hoặc vé miễn phí trực tiếp tại rạp, khách hàng vui lòng xuất trình CMND hoặc giấy tờ tùy thân để xác nhận chính chủ tài khoản thành viên.
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="tab2">
                                    <p>Chính sách quà tặng sinh nhật cho từng hạng thành viên CGV:
                                        <br>
                                        - Thân Thiết & U22: 01 CGV Birthday Combo
                                        <br>
                                        - VIP: 01 CGV Birthday Combo + 01 Vé Xem Phim 2D/3D
                                        <br>
                                        - VVIP: CGV Birthday Combo + 02 Vé Xem Phim 2D/3D
                                        <br>
                                        Lưu ý: Vào sinh nhật lần thứ 23, thành viên U22 sẽ nhận thêm 01 vé xem phim 2D/3D bên cạnh CGV Birthday Combo.
                                        <br>
                                        (*) CGV Birthday Combo = 1 Bắp Ngọt size 44oz + 2 Nước size 22oz
                                        <br>
                                        Khi đến rạp đổi quà, khách hàng vui lòng xuất trình tài khoản thành viên (Thẻ cứng hoặc tài khoản online trên app CGV) và CCCD (Bản gốc hoặc ảnh chụp) cho nhân viên rạp để tiến hành xác thực (Lưu ý: Nhân viên rạp có quyền từ chối yêu cầu đổi quà sinh nhật nếu khách hàng quên mang theo CCCD, hoặc thông tin ngày
                                        <br>
                                        Điều Kiện và Điều Khoản
                                        <br>
                                        1. Để nhận quà sinh nhật, thành viên phải có ít nhất 01 giao dịch ghi nhận tích lũy chi tiêu (1) trong vòng 12 tháng gần nhất. (*) Không bao gồm các giao dịch phát sinh trong tháng sinh nhật năm trước đó của khách hàng. (2). Nếu chưa thỏa điều kiện, khách hàng có thể thực hiện 01 giao dịch mới ngay trong tháng sinh nhật và nhận quà sau đó 02 ngày kể từ khi tích lũy chi tiêu được ghi nhận (3), với điều kiện thời điểm đó vẫn còn nằm trong tháng sinh nhật (4).
                                        <br>
                                        Lưu ý:
                                        <br>
                                        (1) Giao dịch ghi nhận tích lũy chi tiêu là các giao dịch mua vé/bắp nước trên Web/App CGV hoặc tại rạp chiếu phim có xuất trình thẻ thành viên để tích điểm; KHÔNG tích lũy chi tiêu đối với các giao dịch đã áp dụng ưu đãi giảm giá từ các chương trình khuyến mãi do CGV hoặc đối tác tổ chức.
                                        <br>
                                        (2) Ví dụ: Nếu bạn thực hiện 01 giao dịch ghi nhận tích lũy chi tiêu vào tháng 07/2023 và có sinh nhật nằm trong khoảng thời gian từ tháng 07/2023 tới tháng 06/2024, bạn sẽ nhận quà sinh nhật từ CGV trong tháng sinh nhật sắp tới của mình.
                                        <br>
                                        (3) Đối với các giao dịch mua vé/Vé kèm bắp nước, tích lũy chi tiêu của bạn sẽ được ghi nhận sau khi suất chiếu hoàn thành; Đối với các giao dịch mua lẻ bắp nước, tích lũy chi tiêu của bạn sẽ được ghi nhận ngay sau khi giao dịch được thực hiện.
                                        <br>
                                        (4) (Trường hợp bạn có sinh nhật trong tháng 07)
                                        <br>
                                        Ví dụ:
                                        <br>
                                        - Thực hiện 01 giao dịch ghi nhận tích lũy chi tiêu vào ngày 29/07  Bạn sẽ được nhận quà sinh nhật vào ngày 31/07;
                                        <br>
                                        - Thực hiện 01 giao dịch ghi nhận tích lũy chi tiêu vào ngày 30/07  Bạn sẽ KHÔNG được nhận quà sinh nhật (Do thời điểm sau đó 02 ngày là 01/08).
                                        <br>
                                        - Thực hiện 01 giao dịch đặt vé vào ngày 29/07 cho suất chiếu kết thúc vào ngày 30/07 Bạn sẽ KHÔNG được nhật quà sinh nhận Do sau 02 ngày kể từ thời điểm tích lũy chi tiêu được ghi nhận (30/07) là 01/08).
                                        <br>
                                        2. Thời hạn nhận và sử dụng quà sinh nhật:
                                        <br>
                                        - Thời hạn nhận quà: Thành viên đủ điều kiện sẽ nhận quà sinh nhật từ CGV trong vòng 03 ngày đầu tiên của tháng sinh nhật. Để kiểm tra quà sinh nhật, bạn vui lòng truy cập mục “COUPON” trên app CGV sau khi đăng nhập tài khoản online (Nếu không dùng ứng dụng, thành viên vui lòng mang theo thẻ cứng & CCCD đến rạp và yêu cầu nhân viên hỗ trợ kiểm tra và đổi quà sinh nhật.)
                                        <br>
                                        - Thời hạn sử dụng: Coupon quà sinh nhật chỉ có giá trị sử dụng trong tháng sinh nhật (Sau khi qua tháng mới, coupon sẽ tự động mất đi). Nếu coupon sinh nhật của bạn là vé xem phim, bạn có thể sử dụng để đặt các suất chiếu diễn ra ở tháng kế tiếp, với điều kiện tại thời điểm đặt vé vẫn còn nằm trong tháng sinh nhật.
                                        <br>
                                        3. tháng năm sinh trên CCCD và tài khoản thành viên CGV không trùng khớp với nhau).
                                        <br>
                                        4. Để thay đổi thông tin ngày tháng năm sinh của tài khoản thành viên, khách hàng vui lòng mang theo CCCD và ghé rạp CGV gần nhất để được hỗ trợ. (Lưu ý: Mỗi tài khoản chỉ được yêu cầu thay đổi ngày tháng năm sinh tối đa 3 lần.)
                                        <br>
                                        5. Thành viên mới sẽ bắt đầu nhận quà sinh nhật sau 72 giờ kể từ ngày đăng ký thành viên & có phát sinh giao dịch ghi nhận tích lũy chi tiêu trước thời điểm nhận quà 02 ngày, với điều kiện thời gian nhận quà vẫn còn trong tháng sinh nhật.
                                        <br>
                                        6. Quà sinh nhật không có giá trị quy đổi thành tiền mặt hoặc hoàn trả lại tiền thừa.
                                        <br>
                                        7. Sau khi đổi quà sinh nhật tại quầy, khách hàng không được yêu cầu hoàn/hủy/nhận lại coupon quà sinh nhật.
                                        <br>
                                        8. 01 CGV Birthday Combo bao gồm: 01 Bắp Ngọt size 44oz và 02 Nước ngọt size 22oz, chỉ áp dụng trực tiếp tại quầy. Khi có nhu cầu đổi vị, bạn vui lòng thanh toán thêm khoản phụ thu.
                                        <br>
                                        9. Khách hàng VVIP vui lòng sử dụng cả 02 coupon vé xem phim trong phần quà tặng sinh nhật khi thực hiện giao dịch (không áp dụng tách lẻ vé cho nhiều giao dịch).
                                        <br>
                                        10. Mỗi vé xem phim trong combo quà sinh nhật tương đương với 01 vé 2D/3D hàng ghế thường hoặc VIP tại phòng chiếu thường - Không áp dụng cho: 4DX, IMAX, GOLD GLASS, SWEETBOX, STARIUM, L’AMOUR, DOLBY ATMOS, PREMIUM, SCREENX, CINE & FORÊT, CINE & LIVING ROOM.
                                        <br>
                                        11. Vé xem phim trong combo quà sinh nhật được áp dụng cho tất cả các ngày trong tuần bao gồm Lễ/ Tết, không áp dụng cho các suất chiếu sớm Sneak Show & Early Release.
                                        <br>
                                        12. Quá trình phục vụ đổi quà sinh nhật hàng ngày cho khách hàng tại rạp có thể tạm dừng trước thời hạn và không báo trước do phụ thuộc vào số lượng quà tặng thực tế còn lại trong ngày của mỗi rạp.
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="tab3">
                                    <p>
                                    <div class="container mt-5">
                                        <ul class="nav nav-tabs" id="myTabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="tab1-tab" data-toggle="tab" href="#tab4">THÀNH VIÊN THÂN THIẾT </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="tab2-tab" data-toggle="tab" href="#tab5">THÀNH VIÊN VIP 2023</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="tab3-tab" data-toggle="tab" href="#tab6">THÀNH VIÊN VVIP 2023</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content mt-2">
                                            <div class="tab-pane fade show active" id="tab4">
                                                <p>Thành viên thân thiết là thành viên từ 23 tuổi trở lên và nhận được các ưu đãi sau:
                                                    <br>
                                                    - 01 CGV Combo (01 bắp & 02 nước) miễn phí vào tháng sinh nhật.
                                                    <br>
                                                    - Tích lũy điểm 5% giá trị giao dịch tại quầy vé và 3% giá trị giao dịch tại quầy bắp nước.
                                                    <br>
                                                    - Cơ hội tham gia những chương trình đặc biệt khác chỉ áp dụng cho thành viên CGV.
                                                    <br>
                                                    Để nâng cao bảo mật tài khoản thành viên:
                                                    <br>
                                                    - Khi mua vé tại quầy và sử dụng từ 500 điểm trở lên, hoặc sử dụng vé miễn phí vui lòng xuất trình CMND hoặc giấy tờ tùy thân của bạn để xác nhận chính chủ sở hữu tài khoản.
                                                    <br>
                                                    - Khi mua vé online có sử dụng điểm, hệ thống sẽ yêu cầu bạn nhập mật mã thanh toán (gồm 06 chữ số, thông tin chi tiết vui lòng truy cập TẠI ĐÂY .</p>
                                            </div>
                                            <div class="tab-pane fade" id="tab5">
                                                <p>- Nâng hạng VIP 2023 dành cho các khách hàng có tổng chi tiêu trong 2022 là 4,000,000 VNĐ đến 7,999,999 VNĐ.
                                                <br>
                                                    (*) Tổng chi tiêu năm 2022 được tính từ ngày 01/01/2022 đến 31/12/2022.
                                                    <br>
                                                    Quyền lợi của VIP 2023:
                                                    <br>
                                                    - 08 vé 2D/3D miễn phí. (HSD: đến hết 31/12/2023).
                                                    <br>
                                                    - Quà sinh nhật đặc biệt (01 CGV Combo & 01 vé 2D/3D), áp dụng trong tháng sinh nhật.
                                                    <br>
                                                    - Tỷ lệ tích điểm hấp dẫn: 7% tại quầy vé & 4% tại quầy bắp nước.
                                                    <br>
                                                    Ghi chú:
                                                    <br>
                                                    - Cấp độ thành viên VIP và các ưu đãi kèm theo chỉ có giá trị đến hết 31/12/2023.
                                                    <br>
                                                    - Khách hàng tận hưởng ưu đãi tại các rạp CGV trên toàn quốc.
                                                    <br>
                                                    - Để tận hưởng các ưu đãi, bạn chỉ cần xuất trình thẻ thành viên điện tử VIP (trên ứng dụng/APP) và yêu cầu áp dụng ưu đãi tại quầy vé khi giao dịch, hoặc chọn hình thức giảm giá coupon khi thanh toán trên website hoặc ứng dụng CGV.
                                                    <br>
                                                    - Các ưu đãi vé xem phim 2D/3D không áp dụng tại các rạp chiếu phim đặc biệt: 4DX, IMAX, GOLD CLASS, SWEETBOX, STARIUM, L’AMOUR, DOLBY ATMOS, PREMIUM, SCREENX, CINE & FORÊT, CINE & LIVING ROOM, cũng như Suất Chiếu Sớm và Suất Chiếu Đặc Biệt.
                                                    <br>
                                                    - Các ưu đãi vé xem phim 2D/3D không được áp dụng cho các ngày Lễ, Tết, ngoại trừ vé 2D/3D trong tháng sinh nhật.
                                                    <br>
                                                    - Vì cấp độ thành viên mỗi năm được xét duyệt dựa trên tổng chi tiêu nên tổng chi tiêu tích lũy trong năm 2023 của bạn sẽ trở về 0 vào ngày 01/01/2024.
                                                    <br>
                                                    Để nâng cao bảo mật tài khoản thành viên:
                                                    <br>
                                                    - Khi mua vé tại quầy và sử dụng từ 500 điểm trở lên, hoặc sử dụng vé miễn phí vui lòng xuất trình CMND hoặc giấy tờ tùy thân của bạn để xác nhận chính chủ sở hữu tài khoản.
                                                    <br>
                                                    - Khi mua vé online có dử dụng điểm, hệ thống sẽ yêu cầu bạn nhập mật mã thanh toán (gồm 06 chữ số, thông tin chi tiết vui lòng truy cập TẠI ĐÂY .</p>
                                            </div>
                                            <div class="tab-pane fade" id="tab6">
                                                <p>- Nâng hạng VVIP 2023 dành cho khách hàng có tổng chi tiêu trong 2022 từ 8,000,000 VNĐ trở lên.
                                                <br>
                                                    (*) Tổng chi tiêu năm 2022 được tính từ ngày 01/01/2022 đến 31/12/2022
                                                    <br>
                                                    Quyền lợi của VVIP 2023:
                                                    <br>
                                                    - 10 vé 2D/3D miễn phí (HSD: đến hết 31/12/2023)
                                                    <br>
                                                    - Quà sinh nhật đặc biệt (01 CGV Combo & 02 vé 2D/3D), áp dụng trong tháng sinh nhật.
                                                    <br>
                                                    - Tỷ lệ tích điểm sốc: 10% tại quầy vé & 5% tại quầy bắp nước.
                                                    <br>
                                                    - 01 phần quà VVIP đặc biệt từ CGV
                                                    <br>
                                                    - 01 Movie Pass, áp dụng cho 01 vé xem phim bất kỳ tại các phòng chiếu đặc biệt GOLD CLASS, 4DX, IMAX, SCREENX, STARIUM, PREMIUM CINEMA, CINE & FORÊT, CINE & SUITE, DOLBY ATMOS. Áp dụng cho cả Lễ Tết/Sneakshow/Early Release, có thể áp dụng trực tiếp tại quầy (hạn sử dụng đến hết 31/12/2023).
                                                    <br>
                                                    Trong năm 2023, SAU KHI đạt cột mốc chi tiêu từ 8,000,000 VND, cứ mỗi 1,000,000 VND chi tiêu tiếp theo THÀNH VIÊN VVIP sẽ được tặng 01 vé 2D/3D miễn phí không giới hạn.
                                                    <br>
                                                    Ví dụ: Trong năm 2023, thành viên VVIP khi tích lũy chi tiêu đến 9,000,000 VND sẽ được tặng 01 vé 2D/3D. Và khi tích lũy chi tiêu đến 10,000,000 VND sẽ được tặng tiếp 01 vé 2D/3D,...
                                                    <br>
                                                    Lưu ý: Vé miễn phí sẽ được thêm vào tài khoản trong vòng 24h sau khi chi tiêu tích lũy được ghi nhận. Vé miễn phí có hạn sử dụng trong vòng 03 tháng kể từ ngày được thêm vào tài khoản thành viên.
                                                    <br>
                                                    Ghi chú:
                                                    <br>
                                                    - Cấp độ thành viên VVIP và các ưu đãi kèm theo chỉ có giá trị đến hết 31/12/2023.
                                                    <br>
                                                    - Để tận hưởng các quyền lợi, bạn chỉ cần xuất trình thẻ thành viên điện tử VVIP (trên ứng dụng/APP) và yêu cầu áp dụng ưu đãi tại quầy vé khi giao dịch, hoặc chọn hình thức giảm giá coupon khi thanh toán trên website hoặc ứng dụng CGV.
                                                    <br>
                                                    - Các ưu đãi vé xem phim 2D/3D không áp dụng tại các rạp chiếu phim đặc biệt: 4DX, IMAX, GOLD CLASS, SWEETBOX, STARIUM, L’AMOUR, DOLBY ATMOS, PREMIUM, SCREENX, CINE & FORÊT, CINE & LIVING ROOM, cũng như Suất Chiếu Sớm và Suất Chiếu Đặc Biệt.
                                                    <br>
                                                    - Các ưu đãi vé xem phim 2D/3D không được áp dụng cho các ngày lễ, Tết, ngoại trừ vé 2D/3D trong tháng sinh nhật
                                                    <br>
                                                    Để nâng cao bảo mật tài khoản thành viên:
                                                    <br>
                                                    - Khi mua vé tại quầy và sử dụng từ 500 điểm trở lên, hoặc sử dụng vé miễn phí vui lòng xuất trình CMND hoặc giấy tờ tùy thân của bạn để xác nhận chính chủ sở hữu tài khoản.
                                                    <br>
                                                    - Khi mua vé online có sử dụng điểm, hệ thống sẽ yêu cầu bạn nhập mật mã thanh toán (gồm 06 chữ số, thông tin chi tiết vui lòng truy cập TẠI ĐÂY .</p>
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