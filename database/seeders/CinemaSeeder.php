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
           ['name' => 'Beta Thanh Xuân','slug' => 'beta-thanh-xuan','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 1],
           ['name' => 'Beta Giải phóng','slug' => 'beta-giai-phong','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 1],
           ['name' => 'Beta Bắc Giang','slug' => 'beta-bac-giang','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 2],
           ['name' => 'Beta Biên Hòa','slug' => 'beta-bien-hoa','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 3],
           ['name' => 'Beta Thái Nguyên','slug' => 'beta-thai-nguyen','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 5],
           ['name' => 'Beta Nha Trang','slug' => 'beta-nha-trang','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 4],
           ['name' => 'Beta Thanh Hóa','slug' => 'beta-thanh-hoa','open_hours' => $openHour->format('H:i:s'),'close_hours' => $closeHour->format('H:i:s'),'province_id' => 6],
        ]);
    }
}
