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
            'name' => 'Bùi Duy Dũng',
            'email' => 'manage1@gmail.com',
            'password' => bcrypt('123456')
        ]);
        
        User::create([
            'name' => 'Đặng Xuân Dũng',
            'email' => 'manage2@gmail.com',
            'password' => bcrypt('123456')
        ]);

        
        User::create([
            'name' => 'Bùi Khắc Phong',
            'email' => 'manage3@gmail.com',
            'password' => bcrypt('123456')
        ]);
        
        User::create([
            'name' => 'Phạm Xuân Thanh',
            'email' => 'staff11@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Phạm Xuân Thanh',
            'email' => 'staff12@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Phạm Xuân Thanh',
            'email' => 'staff13@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Phạm Xuân Thanh',
            'email' => 'staff14@gmail.com',
            'password' => bcrypt('123456')
        ]);
        
        User::create([
            'name' => 'Phạm Xuân Thanh',
            'email' => 'staff15@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Trần Ngọc Lĩnh',
            'email' => 'staff21@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Trần Ngọc Lĩnh',
            'email' => 'staff22@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Trần Ngọc Lĩnh',
            'email' => 'staff23@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Trần Ngọc Lĩnh',
            'email' => 'staff24@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Trần Ngọc Lĩnh',
            'email' => 'staff25@gmail.com',
            'password' => bcrypt('123456')
        ]);
        
        User::create([
            'name' => 'Trịnh Công Tín',
            'email' => 'staff31@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Trịnh Công Tín',
            'email' => 'staff32@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Trịnh Công Tín',
            'email' => 'staff33@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Trịnh Công Tín',
            'email' => 'staff34@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Trịnh Công Tín',
            'email' => 'staff35@gmail.com',
            'password' => bcrypt('123456')
        ]);

    }
}
