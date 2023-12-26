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
            ['name' => 'dashboard', 'display_name' => 'Thống kê', 'group' => 'Thống kê'],

            //Tài khoản
            ['name' => 'user', 'display_name' => 'Tài khoản', 'group' => 'Tài khoản'],

            //Vai trò
            ['name' => 'role', 'display_name' => ' Vai trò', 'group' => 'Vai trò'],

            //Quyền
            ['name' => 'permission', 'display_name' => 'Quyền', 'group' => 'Quyền'],

            //Danh mục phim
            ['name' => 'category-movie', 'display_name' => 'Danh mục phim', 'group' => 'Danh mục phim'],

            //Phim
            ['name' => 'movie', 'display_name' => 'Phim', 'group' => 'Phim'],

            //Logo
            ['name' => 'logo', 'display_name' => 'Logo Website', 'group' => 'Logo'],

            //slider
            ['name' => 'slider', 'display_name' => 'Slider', 'group' => 'Slider'],

            //Mã giảm giá
            ['name' => 'coupon', 'display_name' => 'Mã giảm giá', 'group' => 'Mã giảm giá'],

            //Danh mục bài viết
            ['name' => 'type', 'display_name' => 'Danh mục bài viết', 'group' => 'Danh mục bài viết'],

            //Bài viết
            ['name' => 'blog-list', 'display_name' => 'Danh sách bài viết', 'group' => 'Bài viết'],

            //Thành viên
            ['name' => 'member', 'display_name' => 'Thành viên', 'group' => 'Thành viên'],

            //Cấp bậc thành viên
            ['name' => 'member-level', 'display_name' => 'Cấp bậc thành viên', 'group' => 'Cấp bậc thành viên'],

            //Phòng 
            ['name' => 'room', 'display_name' => 'Phòng', 'group' => 'Phòng'],

            // Loại pLoại phòng
            ['name' => 'room-type', 'display_name' => 'Loại phòng', 'group' => 'Loại phòng'],

            //order-food
            ['name' => 'order-food', 'display_name' => 'Đơn đặt đồ ăn', 'group' => 'Đơn đặt đồ ăn'],

            //booking
            ['name' => 'booking', 'display_name' => 'Đơn đặt phim', 'group' => 'Đơn đặt phim'],

            //comment 
            ['name' => 'comment', 'display_name' => 'Bình luận', 'group' => 'Bình luận'],

            //rely
            ['name' => 'rely', 'display_name' => 'Trả lời bình luận', 'group' => 'Trả lời bình luận'],

            //Loại đồ ăn
            ['name' => 'food-type', 'display_name' => 'Đồ ăn', 'group' => 'Loại đồ ăn'],

            //Đồ ăn
            ['name' => 'food', 'display_name' => 'Đồ ăn', 'group' => 'Đồ ăn'],

            //Ghế
            ['name' => 'seat', 'display_name' => 'Ghế', 'group' => 'Ghế'],

            //Loại ghế
            ['name' => 'seat-type', 'display_name' => 'Loại ghế', 'group' => 'Loại ghế'],

            //Lịch chiếu 
            ['name' => 'show-time', 'display_name' => 'Lịch chiếu', 'group' => 'Lịch chiếu'],

            //Tỉnh 
            ['name' => 'province', 'display_name' => 'Tỉnh', 'group' => 'Tỉnh'],

            //Thành phố
            ['name' => 'country', 'display_name' => 'Thành phố', 'group' => 'Thành phố'],

            //Liên hệ
            ['name' => 'contact', 'display_name' => 'Liên hệ', 'group' => 'Liên hệ'],

            //Qr
            ['name' => 'qr', 'display_name' => 'Mã qr', 'group' => 'Qr'],


        ];
        foreach ($permissions as $permission) {
            Permission::updateOrCreate($permission);
        }
    }
}
