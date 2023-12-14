-composer install
-Ckeditor 4: npm install --save ckeditor4
-Mạng xã hội: composer require laravel/socialite
-Thư viện confirm: composer require realrashid/sweet-alert
-Thư viện thông báo: composer require yoeunes/toastr
-Thư viện phân quyền: composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
 php artisan optimize:clear
  php artisan config:clear
-Hình ảnh: php artisan storage:link
-TEST VNPAY :
    https://sandbox.vnpayment.vn/apis/vnpay-demo/
    Ngân hàng: NCB
    Số thẻ: 9704198526191432198
    Tên chủ thẻ:NGUYEN VAN A
    Ngày phát hành:07/15
    Mật khẩu OTP:123456

- Thư Viện PayPal : composer require srmklive/paypal
- Thêm Cái này vào .env
PAYPAL_MODE=sandbox
PAYPAL_SANDBOX_CLIENT_ID=Aalxnx2lkv6_b93R7jKtOE7WseMMtHlAR854DJ4gCBuoMEATfk9OoED2Pm20kfouaJOiku0osAe0fi03
PAYPAL_SANDBOX_CLIENT_SECRET=EHzeNtvo021R4vIFN9Lhb61RWZEXMSJIBvuH6nUPfnuxKoiOU_QQNS1nMfIreqQJA0QYqbpnAizYdAmL 
 
  - Tài khoản test paypal : 
      email : sb-ybezt28014971@personal.example.com
      mk : 4Fdq@16*
      test hết tiền thì báo t tăng hạn mức 
- Cấp Độ Thành Viên :  sau khi pull về vào db members chèn 1 bản ghi có dữ liệu là :
member max_limit = 4.000.000 benefits = 5 benefits_food = 3;
thư viện qrcode : 
composer require endroid/qr-code
thư viện word :
composer require phpoffice/phpword
đối với laragon : 
+ chuột phải vào icon laragon ở bên góc phải -> php -> php.init -> search(dynamic) tìm chỗ có các extention -> bỏ dấu phẩy ở chỗ zip (đầu tiên : ;extension=zip bỏ phẩy đi thành -> extension=zip) 
- Chạy seeder trước khi đăng kí để không bị lỗi 
- Thư Viện PDF :
 + composer require barryvdh/laravel-dompdf 

