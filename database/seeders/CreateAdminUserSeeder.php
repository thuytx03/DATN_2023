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

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);

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
            'email' => 'staff1@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Trần Ngọc Lĩnh',
            'email' => 'staff2@gmail.com',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'name' => 'Trịnh Công Tín',
            'email' => 'staff3@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $role = Role::create(['name' => 'Admin', 'display_name' => 'Chủ tịch', 'group' => 'admin']);
//         $role = Role::create(['name' => 'Admin','display_name'=>'Chủ tịch','group'=>'admin']);
        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
