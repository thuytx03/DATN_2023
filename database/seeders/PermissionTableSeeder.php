<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            //Thống kê
            ['name' => 'dashboard-user', 'display_name' => 'Thống kê tài khoản', 'group' => 'Thống kê'],
            ['name' => 'dashboard-invoice-day', 'display_name' => 'Thống kê doanh thu theo ngày', 'group' => 'Thống kê'],
            ['name' => 'dashboard-invoice-seven-day', 'display_name' => 'Thống kê doanh thu theo 7 ngày', 'group' => 'Thống kê'],
            ['name' => 'dashboard-invoice-twentyeight-day', 'display_name' => 'Thống kê doanh thu theo 28 ngày', 'group' => 'Thống kê'],
            ['name' => 'dashboard-invoice-calendar-day', 'display_name' => 'Thống kê doanh thu theo lịch', 'group' => 'Thống kê'],
            ['name' => 'dashboard-invoice-week', 'display_name' => 'Thống kê doanh thu theo tuần', 'group' => 'Thống kê'],
            ['name' => 'dashboard-invoice-month', 'display_name' => 'Thống kê doanh thu theo tháng', 'group' => 'Thống kê'],

            //Tài khoản
            ['name' => 'user-list', 'display_name' => 'Danh sách tài khoản', 'group' => 'Tài khoản'],
            ['name' => 'user-add', 'display_name' => 'Thêm mới tài khoản', 'group' => 'Tài khoản'],
            ['name' => 'user-edit', 'display_name' => 'Chỉnh sửa tài khoản', 'group' => 'Tài khoản'],
            ['name' => 'user-delete', 'display_name' => 'Xoá tài khoản', 'group' => 'Tài khoản'],
            ['name' => 'user-trash', 'display_name' => 'Thùng rác tài khoản', 'group' => 'Tài khoản'],

            //Vai trò
            ['name' => 'role-list', 'display_name' => 'Danh sách vai trò', 'group' => 'Vai trò'],
            ['name' => 'role-add', 'display_name' => 'Thêm mới vai trò', 'group' => 'Vai trò'],
            ['name' => 'role-edit', 'display_name' => 'Chỉnh sửa vai trò', 'group' => 'Vai trò'],
            ['name' => 'role-delete', 'display_name' => 'Xoá vai trò', 'group' => 'Vai trò'],

            //Quyền
            ['name' => 'permission-list', 'display_name' => 'Danh sách quyền', 'group' => 'Quyền'],
            ['name' => 'permission-add', 'display_name' => 'Thêm mới quyền', 'group' => 'Quyền'],
            ['name' => 'permission-edit', 'display_name' => 'Chỉnh sửa quyền', 'group' => 'Quyền'],
            ['name' => 'permission-delete', 'display_name' => 'Xoá quyền', 'group' => 'Quyền'],

            //Danh mục phim
            ['name' => 'category-movie-list', 'display_name' => 'Danh sách danh mục phim', 'group' => 'Danh mục phim'],
            ['name' => 'category-movie-add', 'display_name' => 'Thêm mới danh mục phim', 'group' => 'Danh mục phim'],
            ['name' => 'category-movie-edit', 'display_name' => 'Chỉnh sửa danh mục phim', 'group' => 'Danh mục phim'],
            ['name' => 'category-movie-delete', 'display_name' => 'Xoá danh mục phim', 'group' => 'Danh mục phim'],
            ['name' => 'category-movie-trash', 'display_name' => 'Thùng rác danh mục phim', 'group' => 'Danh mục phim'],

            //Phim
            ['name' => 'product-list', 'display_name' => 'Danh sách Phim', 'group' => 'Phim'],
            ['name' => 'product-add', 'display_name' => 'Thêm mới Phim', 'group' => 'Phim'],
            ['name' => 'product-edit', 'display_name' => 'Chỉnh sửa Phim', 'group' => 'Phim'],
            ['name' => 'product-delete', 'display_name' => 'Xoá Phim', 'group' => 'Phim'],
            ['name' => 'product-trash', 'display_name' => 'Thùng rác Phim', 'group' => 'Phim'],

            //Logo
            ['name' => 'logo-interface', 'display_name' => 'Logo Website', 'group' => 'Logo'],

            //slider
            ['name' => 'slider-list', 'display_name' => 'Danh sách slider', 'group' => 'Slider'],
            ['name' => 'slider-add', 'display_name' => 'Thêm mới slider', 'group' => 'Slider'],
            ['name' => 'slider-edit', 'display_name' => 'Chỉnh sửa slider', 'group' => 'Slider'],
            ['name' => 'slider-delete', 'display_name' => 'Xoá slider', 'group' => 'Slider'],

            //Mã giảm giá
            ['name' => 'coupon-list', 'display_name' => 'Danh sách mã giảm giá', 'group' => 'Mã giảm giá'],
            ['name' => 'coupon-add', 'display_name' => 'Thêm mới mã giảm giá', 'group' => 'Mã giảm giá'],
            ['name' => 'coupon-edit', 'display_name' => 'Chỉnh sửa mã giảm giá', 'group' => 'Mã giảm giá'],
            ['name' => 'coupon-delete', 'display_name' => 'Xoá mã giảm giá', 'group' => 'Mã giảm giá'],
            ['name' => 'coupon-trash', 'display_name' => 'Thùng rác mã giảm giá', 'group' => 'Mã giảm giá'],

            //Danh mục bài viết
            ['name' => 'type-list', 'display_name' => 'Danh sách danh mục bài viết', 'group' => 'Danh mục bài viết'],
            ['name' => 'type-add', 'display_name' => 'Thêm mới danh mục bài viết', 'group' => 'Danh mục bài viết'],
            ['name' => 'type-edit', 'display_name' => 'Chỉnh sửa danh mục bài viết', 'group' => 'Danh mục bài viết'],
            ['name' => 'type-delete', 'display_name' => 'Xoá danh mục bài viết', 'group' => 'Danh mục bài viết'],
            ['name' => 'type-trash', 'display_name' => 'Thùng rác danh mục bài viết', 'group' => 'Danh mục bài viết'],

            //Bài viết
            ['name' => 'blog-list', 'display_name' => 'Danh sách bài viết', 'group' => 'Bài viết'],
            ['name' => 'blog-add', 'display_name' => 'Thêm mới bài viết', 'group' => 'Bài viết'],
            ['name' => 'blog-edit', 'display_name' => 'Chỉnh sửa bài viết', 'group' => 'Bài viết'],
            ['name' => 'blog-delete', 'display_name' => 'Xoá bài viết', 'group' => 'Bài viết'],
            ['name' => 'blog-trash', 'display_name' => 'Thùng rác bài viết', 'group' => 'Bài viết'],


            //Thành viên
            ['name' => 'member-list', 'display_name' => 'Danh sách thành viên', 'group' => 'Thành viên'],
            ['name' => 'member-add', 'display_name' => 'Thêm mới thành viên', 'group' => 'Thành viên'],
            ['name' => 'member-edit', 'display_name' => 'Chỉnh sửa thành viên', 'group' => 'Thành viên'],
            ['name' => 'member-delete', 'display_name' => 'Xoá thành viên', 'group' => 'Thành viên'],
            ['name' => 'member-trash', 'display_name' => 'Thùng rác thành viên', 'group' => 'Thành viên'],

            //Cấp bậc thành viên
            ['name' => 'member-level-list', 'display_name' => 'Danh sách cấp bậc thành viên', 'group' => 'Cấp bậc thành viên'],
            ['name' => 'member-level-add', 'display_name' => 'Thêm mới cấp bậc thành viên', 'group' => 'Cấp bậc thành viên'],
            ['name' => 'member-level-edit', 'display_name' => 'Chỉnh sửa cấp bậc thành viên', 'group' => 'Cấp bậc thành viên'],
            ['name' => 'member-level-delete', 'display_name' => 'Xoá cấp bậc thành viên', 'group' => 'Cấp bậc thành viên'],
            ['name' => 'member-level-trash', 'display_name' => 'Thùng rác cấp bậc thành viên', 'group' => 'Cấp bậc thành viên'],

            //Phòng 
            ['name'=>'room-list','display_name'=>'Danh sách phòng', 'group'=>'Phòng'],
            ['name'=>'room-add','display_name'=>'Thêm mới phòng', 'group'=>'Phòng'],
            ['name'=>'room-edit','display_name'=>'Chỉnh sửa phòng', 'group'=>'Phòng'],
            ['name'=>'room-delete','display_name'=>'Xoá phòng', 'group'=>'Phòng'],
            ['name'=>'room-trash','display_name'=>'Thùng rác phòng', 'group'=>'Phòng'],

            // Loại pLoại phòng
            ['name'=>'room-type-list','display_name'=>'Danh sách loại phòng', 'group'=>'Loại phòng'],
            ['name'=>'room-type-add','display_name'=>'Thêm mới loại phòng', 'group'=>'Loại phòng'],
            ['name'=>'room-type-edit','display_name'=>'Chỉnh sửa loại phòng', 'group'=>'Loại phòng'],
            ['name'=>'room-type-delete','display_name'=>'Xoá loại phòng', 'group'=>'Loại phòng'],
            ['name'=>'room-type-trash','display_name'=>'Thùng rác loại phòng', 'group'=>'Loại phòng'],

            //order-food
            ['name'=>'order-food','display_name'=>'Đơn đặt đồ ăn', 'group'=>'Đơn đặt đồ ăn'],

            //booking
            ['name'=>'booking','display_name'=>'Đơn đặt phim', 'group'=>'Đơn đặt phim'],

            //comment 
            ['name'=>'comment','display_name'=>'Bình luận', 'group'=>'Bình luận'],

            //rely
            ['name'=>'rely','display_name'=>'Trả lời bình luận', 'group'=>'Trả lời bình luận'],

            //Loại đồ ăn
            ['name'=>'food-type-list','display_name'=>'Danh sách loại đồ ăn', 'group'=>'Loại đồ ăn'],
            ['name'=>'food-type-add','display_name'=>'Thêm mới loại đồ ăn', 'group'=>'Loại đồ ăn'],
            ['name'=>'food-type-edit','display_name'=>'Chỉnh sửa loại đồ ăn', 'group'=>'Loại đồ ăn'],
            ['name'=>'food-type-delete','display_name'=>'Xoá loại đồ ăn', 'group'=>'Loại đồ ăn'],
            ['name'=>'food-type-trash','display_name'=>'Thùng rác loại đồ ăn', 'group'=>'Loại đồ ăn'],

            //Đồ ăn
            ['name'=>'food-list','display_name'=>'Danh sách đồ ăn', 'group'=>'Đồ ăn'],
            ['name'=>'food-add','display_name'=>'Thêm mới đồ ăn', 'group'=>'Đồ ăn'],
            ['name'=>'food-edit','display_name'=>'Chỉnh sửa đồ ăn', 'group'=>'Đồ ăn'],
            ['name'=>'food-delete','display_name'=>'Xoá đồ ăn', 'group'=>'Đồ ăn'],
            ['name'=>'food-trash','display_name'=>'Thùng rác đồ ăn', 'group'=>'Đồ ăn'],

            //Ghế
            ['name'=>'seat-list','display_name'=>'Danh sách ghế', 'group'=>'Ghế'],
            ['name'=>'seat-add','display_name'=>'Thêm mới ghế', 'group'=>'Ghế'],
            ['name'=>'seat-edit','display_name'=>'Chỉnh sửa ghế', 'group'=>'Ghế'],
            ['name'=>'seat-delete','display_name'=>'Xoá ghế', 'group'=>'Ghế'],
            ['name'=>'seat-trash','display_name'=>'Thùng rác ghế', 'group'=>'Ghế'],

            //Loại ghế
            ['name'=>'seat-type-list','display_name'=>'Danh sách loại ghế', 'group'=>'Loại ghế'],
            ['name'=>'seat-type-add','display_name'=>'Thêm mới loại ghế', 'group'=>'Loại ghế'],
            ['name'=>'seat-type-edit','display_name'=>'Chỉnh sửa loại ghế', 'group'=>'Loại ghế'],
            ['name'=>'seat-type-delete','display_name'=>'Xoá loại ghế', 'group'=>'Loại ghế'],
            ['name'=>'seat-type-trash','display_name'=>'Thùng rác loại ghế', 'group'=>'Loại ghế'],

            //Lịch chiếu 
            ['name'=>'show-time-list','display_name'=>'Danh sách lịch chiếu', 'group'=>'Lịch chiếu'],
            ['name'=>'show-time-add','display_name'=>'Thêm mới lịch chiếu', 'group'=>'Lịch chiếu'],
            ['name'=>'show-time-edit','display_name'=>'Chỉnh sửa lịch chiếu', 'group'=>'Lịch chiếu'],
            ['name'=>'show-time-delete','display_name'=>'Xoá lịch chiếu', 'group'=>'Lịch chiếu'],
            ['name'=>'show-time-trash','display_name'=>'Thùng rác lịch chiếu', 'group'=>'Lịch chiếu'],

            //Tỉnh 
            ['name'=>'province-list','display_name'=>'Danh sách tỉnh', 'group'=>'Tỉnh'],
            ['name'=>'province-add','display_name'=>'Thêm mới tỉnh', 'group'=>'Tỉnh'],
            ['name'=>'province-edit','display_name'=>'Chỉnh sửa tỉnh', 'group'=>'Tỉnh'],
            ['name'=>'province-delete','display_name'=>'Xoá tỉnh', 'group'=>'Tỉnh'],
            ['name'=>'province-trash','display_name'=>'Thùng rác tỉnh', 'group'=>'Tỉnh'],

            //Thành phố

            ['name'=>'country-list','display_name'=>'Danh sách thành phố', 'group'=>'Thành phố'],
            ['name'=>'country-add','display_name'=>'Thêm mới thành phố', 'group'=>'Thành phố'],
            ['name'=>'country-edit','display_name'=>'Chỉnh sửa thành phố', 'group'=>'Thành phố'],
            ['name'=>'country-delete','display_name'=>'Xoá thành phố', 'group'=>'Thành phố'],
            ['name'=>'country-trash','display_name'=>'Thùng rác thành phố', 'group'=>'Thành phố'],

            //Liên hệ
            ['name'=>'contact','display_name'=>'Liên hệ', 'group'=>'Liên hệ'],
            
            //Đặt vé

        ];
        foreach ($permissions as $permission) {
            Permission::updateOrCreate($permission);
        }
    }
}
