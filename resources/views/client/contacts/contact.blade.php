@extends('layouts.client')
@section('content')
<!-- ==========Banner-Section========== -->
<section class="main-page-header speaker-banner bg_img" data-background="./assets/images/banner/banner07.jpg">
    <div class="container">
        <div class="speaker-banner-content">
            <h2 class="title">Liên Hệ</h2>
            <ul class="breadcrumb">
                <li>
                    <a href="/">
                        Trang chủ
                    </a>
                </li>
                <li>
                    Liên hệ
                </li>
            </ul>
        </div>
    </div>
</section>
<!-- ==========Banner-Section========== -->

<!-- ==========Contact-Section========== -->
<section class="contact-section padding-top">
    <div class="contact-container">
        <div class="bg-thumb bg_img" data-background="./assets/images/contact/contact.jpg"></div>
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-7 col-lg-6 col-xl-5">
                    <div class="section-header-3 left-style">
                        <span class="cate">Liên hệ với chúng tôi</span>
                        <h2 class="title">Để lại lời nhắn của bạn</h2>
                        <p>Chúng tôi luôn mong muốn được làm việc cùng bạn. Hãy gửi đi ý kiến của bạn và chúng tôi sẽ phản hồi sớm nhất có thể.</p>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </div>
                    @endif
                    <form class="contact-form" id="contact_form_submit" method="POST" action="{{route('contact.send')}}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Họ tên <span>*</span></label>
                            <input type="text" placeholder="Nhập họ và tên" name="name" id="" value="{{old('name')}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Số điện thoại <span>*</span></label>
                            <input type="text" placeholder="Nhập số điện thoại" name="phone" id="" value="{{old('phone')}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span>*</span></label>
                            <input type="text" placeholder="Nhập email của bạn" name="email" id="email" value="{{old('email')}}">
                        </div>
                        <div class="form-group">
                            <label for="subject">Tiêu đề <span>*</span></label>
                            <input type="text" placeholder="Nhập tiêu đề của bạn" name="subject" id="subject" value="{{old('subject')}}">
                        </div>
                        <div class="form-group">
                            <label for="message">Nội dung <span>*</span></label>
                            <textarea name="message" id="message" placeholder="Nhập nội dung tin nhắn">
                            {{old('message')}}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Gửi thư">
                        </div>
                    </form>
                </div>
                <div class="col-md-5 col-lg-6">
                    <div class="padding-top padding-bottom contact-info">
                        <div class="info-area">
                            <div class="info-item">
                                <div class="info-thumb">
                                    <img src="./assets/images/contact/contact01.png" alt="contact">
                                </div>
                                <div class="info-content">
                                    <h6 class="title">Số điện thoại</h6>
                                    <a href="Tel:82828282034">+1234 56789</a>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-thumb">
                                    <img src="./assets/images/contact/contact02.png" alt="contact">
                                </div>
                                <div class="info-content">
                                    <h6 class="title">Email</h6>
                                    <a href="Mailto:info@gmail.com">info@Boleto.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==========Contact-Section========== -->

<!-- ==========Contact-Counter-Section========== -->
<section class="contact-counter padding-top padding-bottom">
    <div class="container">
        <div class="row justify-content-center mb-30-none">
            <div class="col-sm-6 col-md-3">
                <div class="contact-counter-item">
                    <div class="contact-counter-thumb">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                    <div class="contact-counter-content">
                        <div class="counter-item">
                            <h5 class="title odometer" data-odometer-final="130">0</h5>
                            <h5 class="title">k</h5>
                        </div>
                        <p>Followers</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="contact-counter-item active">
                    <div class="contact-counter-thumb">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="contact-counter-content">
                        <div class="counter-item">
                            <h5 class="title odometer" data-odometer-final="35">0</h5>
                            <h5 class="title">k</h5>
                        </div>
                        <p>Members</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="contact-counter-item">
                    <div class="contact-counter-thumb">
                        <i class="fab fa-twitter"></i>
                    </div>
                    <div class="contact-counter-content">
                        <div class="counter-item">
                            <h5 class="title odometer" data-odometer-final="47">0</h5>
                            <h5 class="title">k</h5>
                        </div>
                        <p>Followers</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="contact-counter-item">
                    <div class="contact-counter-thumb">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-counter-content">
                        <div class="counter-item">
                            <h5 class="title odometer" data-odometer-final="291">0</h5>
                            <h5 class="title">k</h5>
                        </div>
                        <p>Subscribers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==========Contact-Counter-Section========== -->
@endsection