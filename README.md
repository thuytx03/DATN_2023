php artisan make:controller TeacherController
php artisan make:model Teacher
php artisan make:migration create_tests_table
php artisan make:seeder UserSeeder 
php artisan make:factory StudentsFactory --model=Students
mỗi lần thay đổi trong file .env phải chạy lệnh sau php artisan config:cache để cập nhập lại .env
php artisan make:request StudentRequest
php artisan storage:link

#tạo controler resouce 
#php artisan make:controller ProductController --api 
#php artisan make:resource ProductResource 
#php artisan route:list --name=products

Loại Faker	Mô tả
address	Địa chỉ (đường, thành phố, quận/huyện, mã bưu điện, quốc gia)
name	Tên người (đầy đủ, họ, tên đệm, tên)
phoneNumber	Số điện thoại
email	Địa chỉ email
username	Tên người dùng
password	Mật khẩu
text	Đoạn văn bản ngẫu nhiên
sentence	Câu ngẫu nhiên
paragraph	Đoạn văn ngẫu nhiên
date	Ngày (hôm nay, ngày trong quá khứ, ngày trong tương lai)
time	Thời gian (giờ, phút, giây)
dateTime	Ngày và thời gian
number	Số ngẫu nhiên
randomElement	Lựa chọn ngẫu nhiên từ danh sách
boolean	Giá trị boolean ngẫu nhiên
uuid	UUID (định danh duy nhất ngẫu nhiên)
file	Tên tệp tin ngẫu nhiên
imageUrl	URL hình ảnh ngẫu nhiên
color	Mã màu ngẫu nhiên
company	Tên công ty
