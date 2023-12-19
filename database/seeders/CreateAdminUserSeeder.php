<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'Quản lý Hà Nội',
            'email' => 'quanlyhanoi@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Quản lý Hải Phòng',
            'email' => 'quanlyhaiphong@gmail.com',
            'password' => bcrypt('123456')
        ]);


        User::create([
            'name' => 'Quản lý Thái Bình',
            'email' => 'quanlythaibinh@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Quản lý Nam Định',
            'email' => 'quanlynamdinh@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Quản lý Ninh Bình',
            'email' => 'quanlyninhbinh@gmail.com',
            'password' => bcrypt('123456')
        ]);
        User::create([
            'name' => 'Nhân viên Hà Nội',
            'email' => 'nhanvienhn1@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên Hà Nội',
            'email' => 'nhanvienhn2@gmail.com',
            'password' => bcrypt('123456')
        ]);
        User::create([
            'name' => 'Nhân viên Hải Phòng',
            'email' => 'nhanvienhp1@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên Hải Phòng',
            'email' => 'nhanvienhp2@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên Thái Bình',
            'email' => 'nhanvientb1@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên Thái Bình',
            'email' => 'nhanvientb2@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên Nam Định',
            'email' => 'nhanviennd1@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên Nam Định',
            'email' => 'nhanviennd2@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên Ninh Bình',
            'email' => 'nhanviennb1@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên Ninh Bình',
            'email' => 'nhanviennb2@gmail.com',
            'password' => bcrypt('123456')
        ]);

    }
}
