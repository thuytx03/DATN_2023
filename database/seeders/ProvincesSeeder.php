<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->insert([
           ['name' => 'Hà Nội','slug' => 'ha-noi'],
           ['name' => 'Hải Phòng','slug' => 'hai-phong'],
           ['name' => 'Thái Bình','slug' => 'thai-binh'],
           ['name' => 'Nam Định','slug' => 'nam-dinh'],
           ['name' => 'Quảng Ninh','slug' => 'quang-ninh'],
        ]);
    }
}
