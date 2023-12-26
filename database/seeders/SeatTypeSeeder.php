<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seat_types')->insert([
            ['name' => 'Thường', 'slug' => 'thuong', 'status' => 1],
            ['name' => 'Vip', 'slug' => 'vip', 'status' => 1],
            ['name' => 'Đôi', 'slug' => 'doi', 'status' => 1],
        ]);
    }
}
