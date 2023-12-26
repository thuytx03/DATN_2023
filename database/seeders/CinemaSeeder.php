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
           ['name' => 'Boleto Thanh Xuân','slug' => 'Boleto-thanh-xuan','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 1],
           ['name' => 'Boleto Tiên Lãng','slug' => 'Boleto-tien-lang','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 2],
           ['name' => 'Boleto Quỳnh Côi','slug' => 'Boleto-quynh-coi','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 3],
           ['name' => 'Boleto Cửa Bắc','slug' => 'Boleto-cua-bac','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 4],
           ['name' => 'Boleto Gia Thắng','slug' => 'Boleto-gia-thang','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 5],
        ]);
    }
}
