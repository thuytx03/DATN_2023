<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
           ['name' => 'Hành động','slug' => 'hanh-dong','_lft' => 1,'_rgt' => 2],
           ['name' => 'Hài','slug' => 'hai','_lft' => 3,'_rgt' => 4],
           ['name' => 'Kinh Dị','slug' => 'kinh-di','_lft' => 5,'_rgt' => 6],
           ['name' => 'Tình Cảm','slug' => 'tinh-cam','_lft' => 7,'_rgt' => 8],
           ['name' => 'Viễn Tưởng','slug' => 'vien-tuong','_lft' => 9,'_rgt' => 10],
           ['name' => 'Hoạt Hình','slug' => 'hoat-hinh','_lft' => 11,'_rgt' => 12],
           ['name' => 'Phiêu Lưu','slug' => 'phieu-luu','_lft' => 13,'_rgt' => 14],
           ['name' => 'Khoa Học Viễn Tưởng và Hành Động','slug' => 'khoa-hoc-vien-tuong-va-hanh-dong','_lft' => 14,'_rgt' => 15],
        ]);
    }
}
