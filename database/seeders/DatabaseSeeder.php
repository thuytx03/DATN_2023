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
            RolesTableSeeder::class,
            MemberLevelSeeder::class,
            CreateAdminUserSeeder::class,
            SeatTypeSeeder::class,
            FoodSeeder::class,
            CreateAdminSeeder::class,
            CreateAdminUserSeeder::class,
            RolesTableSeeder::class,
            PermissionTableSeeder::class,
        ]);
    }
}
