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
        Role::create(['name' => 'Staff-Booking-HaNoi','display_name'=>'Nhân viên quản lý đơn đặt vé Hà Nội','group'=>'booking']);
        Role::create(['name' => 'Staff-Qr-HaNoi','display_name'=>'Nhân viên quản lý mã qr Hà Nội','group'=>'qr']);

        Role::create(['name' => 'Manage-HaiPhong','display_name'=>'Quản lý rạp Hải Phòng','group'=>'manage']);
        Role::create(['name' => 'Staff-Booking-HaiPhong','display_name'=>'Nhân viên quản lý đơn đặt vé Hải Phòng','group'=>'booking']);
        Role::create(['name' => 'Staff-Qr-HaiPhong','display_name'=>'Nhân viên quản lý mã qr Hải Phòng','group'=>'qr']);

        Role::create(['name' => 'Manage-ThaiBinh','display_name'=>'Quản lý rạp Thái Bình ','group'=>'manage']);
        Role::create(['name' => 'Staff-Booking-ThaiBinh','display_name'=>'Nhân viên quản lý đơn đặt vé Thái Bình','group'=>'booking']);
        Role::create(['name' => 'Staff-Qr-ThaiBinh','display_name'=>'Nhân viên quản lý mã qr Thái Bình','group'=>'qr']);

        Role::create(['name' => 'Manage-NamDinh','display_name'=>'Quản lý rạp Nam Định ','group'=>'manage']);
        Role::create(['name' => 'Staff-Booking-NamDinh','display_name'=>'Nhân viên quản lý đơn đặt vé Nam Định','group'=>'booking']);
        Role::create(['name' => 'Staff-Qr-NamDinh','display_name'=>'Nhân viên quản lý mã qr Nam Định','group'=>'qr']);
       
        
        Role::create(['name' => 'Manage-NinhBinh','display_name'=>'Quản lý rạp Ninh Bình ','group'=>'manage']);
        Role::create(['name' => 'Staff-Booking-NinhBinh','display_name'=>'Nhân viên quản lý đơn đặt vé Ninh Bình','group'=>'booking']);
        Role::create(['name' => 'Staff-Qr-NinhBinh','display_name'=>'Nhân viên quản lý mã qr Ninh Bình','group'=>'qr']);
        
    }
}
