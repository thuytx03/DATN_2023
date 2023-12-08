<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CinemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $openHour = Carbon::createFromTime(rand(0, 23), rand(0, 59), rand(0, 59));
        $closeHour = $openHour->copy()->addHours(rand(1, 5))->addMinutes(rand(0, 59))->addSeconds(rand(0, 59));
        DB::table('cinemas')->insert([
           ['name' => 'Boleto Hà Nội','slug' => 'Boleto-thanh-xuan','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 1],
           ['name' => 'Boleto Hải Phòng','slug' => 'Boleto-giai-phong','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 2],
           ['name' => 'Boleto Thái Bình','slug' => 'Boleto-bac-giang','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 3],
        ]);
    }
}
