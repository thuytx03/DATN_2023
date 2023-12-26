<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            RoomTypeSeeder::class,
            ProvincesSeeder::class,
            CinemaSeeder::class,
            RoomSeeder::class,
            GenreSeeder::class,
            MovieSeeder::class,
            MemberLevelSeeder::class,
           SeatTypeSeeder::class,
            FoodSeeder::class,
            PermissionTableSeeder::class,
            RolesTableSeeder::class,
            CreateAdminSeeder::class,
            CreateAdminUserSeeder::class,
        ]);
    }
}
