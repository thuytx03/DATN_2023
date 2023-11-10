<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thông tin vé xem phim</title>
  <!-- Link Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">

<div class="container">
  <h2 class="text-center mb-4">Thông Tin Vé Xem Phim</h2>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <img src="path/to/movie_poster.jpg" class="card-img-top" alt="Movie Poster">
        <div class="card-body">
          <h5 class="card-title">Tên phim</h5>
          <p class="card-text">Mô tả ngắn về phim.</p>
          <p class="card-text">Ngày chiếu: 01/01/2023</p>
          <p class="card-text">Giờ chiếu: 19:30</p>
          <p class="card-text">Địa điểm: Rạp chiếu phim ABC</p>
          <a href="#" class="btn btn-primary">Đặt vé ngay</a>
         
       
        </div>
       {{-- Tạo đường dẫn QR code --}}
<?php $qrCodeUrl = route('qr.redirect', ['param' => 'generate-barcode']); ?>

{{-- Hiển thị mã QR code mà không hiển thị đường dẫn --}}
<div class="d-flex justify-content-center mb-3">
    {!! DNS2D::getBarcodeHTML($qrCodeUrl, 'QRCODE') !!}
</div>
      </div>
    </div>
    <!-- Thêm các phần thông tin vé khác ở đây nếu cần -->
  </div>
</div>

<!-- Link Bootstrap JS và Popper.js -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>