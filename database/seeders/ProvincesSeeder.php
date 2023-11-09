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
           ['name' => 'Bắc Giang','slug' => 'bac-giang'],
           ['name' => 'Đồng Nai','slug' => 'dong-nai'],
           ['name' => 'Khánh Hòa','slug' => 'khanh-hoa'],
           ['name' => 'Thái Nguyên','slug' => 'thai-nguyen'],
           ['name' => 'Thanh hóa','slug' => 'thanh-hoa'],
           ['name' => 'Ninh Bình','slug' => 'ninh-binh'],
        ]);
    }
}
