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
            'name' => 'Quản lý 1',
            'email' => 'manage1@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Quản lý 2',
            'email' => 'manage2@gmail.com',
            'password' => bcrypt('123456')
        ]);


        User::create([
            'name' => 'Quản lý 3',
            'email' => 'manage3@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viê 1.1',
            'email' => 'staff11@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 1.2',
            'email' => 'staff12@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 1.3',
            'email' => 'staff13@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 1.4',
            'email' => 'staff14@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 1.5',
            'email' => 'staff15@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 2.1',
            'email' => 'staff21@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 2.2',
            'email' => 'staff22@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 2.3',
            'email' => 'staff23@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 2.4',
            'email' => 'staff24@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 2.5',
            'email' => 'staff25@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 3.1',
            'email' => 'staff31@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 3.2',
            'email' => 'staff32@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 3.3',
            'email' => 'staff33@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 3.4',
            'email' => 'staff34@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Nhân viên 3.5',
            'email' => 'staff35@gmail.com',
            'password' => bcrypt('123456')
        ]);

    }
}
