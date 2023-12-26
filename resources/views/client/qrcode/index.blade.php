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

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">

z
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

                  <div class="card-body">
                    <h5 class="card-title">{{ $booking->name }}</h5>
                    <p class="card-text">Tên Phim :{{$movie->name}}</p>
                    <p class="card-text">Ngày chiếu: {{ $showtime->start_date }}</p>

                    <p class="card-text">Địa điểm: {{$room->name}}</p>
                    <p class="card-text">Email: {{ $booking->email }}</p>
                    <p class="card-text">Phone: {{ $booking->phone }}</p>
                    <p class="card-text">Seats: {{ $booking->list_seat }}</p>
                    <p class="card-text">Payment: {{ $booking->payment }}</p>
                    <p class="card-text">Total: {{ $booking->total }}</p>
                    <a href="#" class="btn btn-primary">Cảm Ơn Đã Đặt Vé</a>
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


        </div>
       {{-- Tạo đường dẫn QR code --}}


{{-- Hiển thị mã QR code mà không hiển thị đường dẫn --}}

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
