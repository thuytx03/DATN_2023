<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('membership_levels')->insert([
            ['name' => 'Member', 'min_limit' => 0, 'max_limit' => 4000000, 'benefits' => 5, 'status' => 1, 'Description' => 'Silver membership level', 'benefits_food' => '3'],
            ['name' => 'Vip', 'min_limit' => 4000000, 'max_limit' => 8000000, 'benefits' => 7, 'status' => 1, 'Description' => 'Gold membership level', 'benefits_food' => '5'],
            ['name' => 'Vipp', 'min_limit' => 8000000, 'max_limit' => null, 'benefits' => 10, 'status' => 1, 'Description' => 'Platinum membership level', 'benefits_food' => '7'],
        ]);
    }
}
