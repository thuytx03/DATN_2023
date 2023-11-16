<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('country')->insert([
           ['name' => 'Việt Nam','slug' => 'viet-nam','status' => 1],
           ['name' => 'Hàn Quốc','slug' => 'han-quoc','status' => 1],
           ['name' => 'Trung Quốc','slug' => 'trung-quoc','status' => 1],
           ['name' => 'Nhật Bản','slug' => 'nhat-ban','status' => 1],
        ]);
    }
}
