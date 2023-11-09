<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_types')->insert([
           ['name' => 'Phòng VIP','slug' => 'phong-vip','image' => '123','description' => ' Phòng này thường có ít ghế hơn so với phòng tiêu chuẩn, nhưng mang lại trải nghiệm thoải mái hơn với ghế sofa hoặc ghế bành. Dịch vụ phục vụ thường cũng cao cấp hơn.'],
           ['name' => 'Phòng 3D','slug' => 'phong-3d','image' => '123','description' => 'Được thiết kế để chiếu phim 3D, với màn hình và kính 3D để tạo ra trải nghiệm hình ảnh sâu động.'],
           ['name' => 'Phòng IMAX','slug' => 'phong-imax','image' => '123','description' => 'Với màn hình rộng và chất lượng hình ảnh và âm thanh cao cấp, phòng IMAX mang lại trải nghiệm chiếu phim sống động và sống động.'],
           ['name' => 'Phòng chiếu phim dành cho trẻ em','slug' => 'phong-chieu-danh-cho-tre-em','image' => '123','description' => 'Thiết kế với môi trường thân thiện với trẻ em, có thể có các ghế đặc biệt cho trẻ nhỏ và chơi trò chơi trước khi bắt đầu phim..'],
        ]);
    }
}
