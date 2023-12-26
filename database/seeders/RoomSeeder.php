<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            ['name' => 'Galaxy Deluxe','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 1,'room_type_id' => 1],
            ['name' => 'DreamCinema 3D','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 2,'room_type_id' => 2],
            ['name' => 'IMAX Experience','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 3,'room_type_id' => 3],
            ['name' => 'Family Fun Zone','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 4,'room_type_id' => 1],
            ['name' => 'Premiere Pavilion','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 5,'room_type_id' => 2],
            ['name' => 'EpicXperience','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 1,'room_type_id' => 4],
            ['name' => 'Silver Screen Serenity','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 2,'room_type_id' => 1],
            ['name' => 'Kids Korner','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 3,'room_type_id' => 3],
            ['name' => 'TechTrend Theater','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 4,'room_type_id' => 1],
            ['name' => 'Premiere Jungx','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 5,'room_type_id' => 1],
            ['name' => 'Xperience','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 1,'room_type_id' => 2],
            ['name' => 'Screen Serenity','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 3,'room_type_id' => 3],
            ['name' => 'Kids Family','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 4,'room_type_id' => 4],
            ['name' => 'TechTrend Vip','description' => 'Mô tả phòng chiếu','image' => '132','cinema_id' => 5,'room_type_id' => 1],
        ]);
    }
}
