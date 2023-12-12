<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Role::create(['name' => 'Admin','display_name'=>'Chủ tịch','group'=>'admin']);
        Role::create(['name' => 'Mange-Hanoi','display_name'=>'Quản lý rạp Hà Nội','group'=>'manage']);
        Role::create(['name' => 'Staff-Movie-Hanoi','display_name'=>'Nhân viên quản lý phim Hà Nội','group'=>'staff']);
        Role::create(['name' => 'Staff-Booking-Hanoi','display_name'=>'Nhân viên quản lý đơn đặt vé Hà Nội','group'=>'staff']);
        Role::create(['name' => 'Staff-Qr-Hanoi','display_name'=>'Nhân viên quản lý mã qr Hà Nội','group'=>'staff']);
        Role::create(['name' => 'Staff-Room-Hanoi','display_name'=>'Nhân viên quản lý phòng Hà Nội','group'=>'staff']);
        Role::create(['name' => 'Staff-Showtime-Hanoi','display_name'=>'Nhân viên quản lý lịch chiếu Hà Nội','group'=>'staff']);
        Role::create(['name' => 'Staff-Seat-Hanoi','display_name'=>'Nhân viên quản lý ghế Hà Nội','group'=>'staff']);

        Role::create(['name' => 'Mange-HaiPhong','display_name'=>'Quản lý rạp Hải Phòng','group'=>'manage']);
        Role::create(['name' => 'Staff-Movie-HaiPhong','display_name'=>'Nhân viên quản lý phim Hải Phòng','group'=>'staff']);
        Role::create(['name' => 'Staff-Booking-HaiPhong','display_name'=>'Nhân viên quản lý đơn đặt vé Hải Phòng','group'=>'staff']);
        Role::create(['name' => 'Staff-Qr-HaiPhong','display_name'=>'Nhân viên quản lý mã qr Hải Phòng','group'=>'staff']);
        Role::create(['name' => 'Staff-Room-HaiPhong','display_name'=>'Nhân viên quản lý phòng Hải Phòng','group'=>'staff']);
        Role::create(['name' => 'Staff-Showtime-HaiPhong','display_name'=>'Nhân viên quản lý lịch chiếu Hải Phòng','group'=>'staff']);
        Role::create(['name' => 'Staff-Seat-HaiPhong','display_name'=>'Nhân viên quản lý ghế Hải Phòng','group'=>'staff']);

        Role::create(['name' => 'Mange-ThaiBinh','display_name'=>'Quản lý rạp Thái Bình ','group'=>'manage']);
        Role::create(['name' => 'Staff-Movie-ThaiBinh','display_name'=>'Nhân viên quản lý phim Thái Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Booking-ThaiBinh','display_name'=>'Nhân viên quản lý đơn đặt vé Thái Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Qr-ThaiBinh','display_name'=>'Nhân viên quản lý mã qr Thái Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Room-ThaiBinh','display_name'=>'Nhân viên quản lý phòng Thái Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Showtime-ThaiBinh','display_name'=>'Nhân viên quản lý lịch chiếu Thái Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Seat-ThaiBinh','display_name'=>'Nhân viên quản lý ghế Thái Bình','group'=>'staff']);

    }
}
