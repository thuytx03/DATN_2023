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

        Role::create(['name' => 'Manage-HaNoi','display_name'=>'Quản lý rạp Hà Nội','group'=>'manage']);
        Role::create(['name' => 'Staff-Booking-HaNoi','display_name'=>'Nhân viên quản lý đơn đặt vé Hà Nội','group'=>'staff']);
        Role::create(['name' => 'Staff-Qr-HaNoi','display_name'=>'Nhân viên quản lý mã qr Hà Nội','group'=>'staff']);
        Role::create(['name' => 'Staff-Room-HaNoi','display_name'=>'Nhân viên quản lý phòng Hà Nội','group'=>'staff']);
        Role::create(['name' => 'Staff-Showtime-HaNoi','display_name'=>'Nhân viên quản lý lịch chiếu Hà Nội','group'=>'staff']);
        Role::create(['name' => 'Staff-Seat-HaNoi','display_name'=>'Nhân viên quản lý ghế Hà Nội','group'=>'staff']);

        Role::create(['name' => 'Manage-HaiPhong','display_name'=>'Quản lý rạp Hải Phòng','group'=>'manage']);
        Role::create(['name' => 'Staff-Booking-HaiPhong','display_name'=>'Nhân viên quản lý đơn đặt vé Hải Phòng','group'=>'staff']);
        Role::create(['name' => 'Staff-Qr-HaiPhong','display_name'=>'Nhân viên quản lý mã qr Hải Phòng','group'=>'staff']);
        Role::create(['name' => 'Staff-Room-HaiPhong','display_name'=>'Nhân viên quản lý phòng Hải Phòng','group'=>'staff']);
        Role::create(['name' => 'Staff-Showtime-HaiPhong','display_name'=>'Nhân viên quản lý lịch chiếu Hải Phòng','group'=>'staff']);
        Role::create(['name' => 'Staff-Seat-HaiPhong','display_name'=>'Nhân viên quản lý ghế Hải Phòng','group'=>'staff']);

        Role::create(['name' => 'Manage-ThaiBinh','display_name'=>'Quản lý rạp Thái Bình ','group'=>'manage']);
        Role::create(['name' => 'Staff-Booking-ThaiBinh','display_name'=>'Nhân viên quản lý đơn đặt vé Thái Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Qr-ThaiBinh','display_name'=>'Nhân viên quản lý mã qr Thái Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Room-ThaiBinh','display_name'=>'Nhân viên quản lý phòng Thái Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Showtime-ThaiBinh','display_name'=>'Nhân viên quản lý lịch chiếu Thái Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Seat-ThaiBinh','display_name'=>'Nhân viên quản lý ghế Thái Bình','group'=>'staff']);

        Role::create(['name' => 'Manage-NamDinh','display_name'=>'Quản lý rạp Nam Định ','group'=>'manage']);
        Role::create(['name' => 'Staff-Booking-NamDinh','display_name'=>'Nhân viên quản lý đơn đặt vé Nam Định','group'=>'staff']);
        Role::create(['name' => 'Staff-Qr-NamDinh','display_name'=>'Nhân viên quản lý mã qr Nam Định','group'=>'staff']);
        Role::create(['name' => 'Staff-Room-NamDinh','display_name'=>'Nhân viên quản lý phòng Nam Định','group'=>'staff']);
        Role::create(['name' => 'Staff-Showtime-NamDinh','display_name'=>'Nhân viên quản lý lịch chiếu Nam Định','group'=>'staff']);
        Role::create(['name' => 'Staff-Seat-NamDinh','display_name'=>'Nhân viên quản lý ghế Nam Định','group'=>'staff']);
        
        Role::create(['name' => 'Manage-NinhBinh','display_name'=>'Quản lý rạp Ninh Bình ','group'=>'manage']);
        Role::create(['name' => 'Staff-Booking-NinhBinh','display_name'=>'Nhân viên quản lý đơn đặt vé Ninh Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Qr-NinhBinh','display_name'=>'Nhân viên quản lý mã qr Ninh Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Room-NinhBinh','display_name'=>'Nhân viên quản lý phòng Ninh Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Showtime-NinhBinh','display_name'=>'Nhân viên quản lý lịch chiếu Ninh Bình','group'=>'staff']);
        Role::create(['name' => 'Staff-Seat-NinhBinh','display_name'=>'Nhân viên quản lý ghế Ninh Bình','group'=>'staff']);
    }
}
