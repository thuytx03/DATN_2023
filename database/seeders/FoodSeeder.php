<?php

namespace Database\Seeders;

use App\Models\Foodstypes;
use App\Models\MovieFood;
use App\Models\MovieFoodsTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MovieFood::create([
            'name' => 'Nước chanh',
            'slug' => 'nuoc-chanh',
            'price' => '15000',
            'quantity' => '100',
            'image' => 'abc',
            'description' => 'Ngon bổ rẻ'
        ]);

        MovieFood::create([
            'name' => 'Nước chanh leo',
            'slug' => 'nuoc-chanh-leo',
            'price' => '15000',
            'quantity' => '100',
            'image' => 'abc',
            'description' => 'Ngon bổ rẻ'
        ]);

        MovieFood::create([
            'name' => 'Nước ngọt 7up',
            'slug' => 'nuoc-coca-cola',
            'price' => '10000',
            'quantity' => '100',
            'image' => 'abc',
            'description' => 'Ngon bổ rẻ'
        ]);

        MovieFood::create([
            'name' => 'Nước ngọt pepsi',
            'slug' => 'nuoc-pepsi',
            'price' => '10000',
            'quantity' => '100',
            'image' => 'abc',
            'description' => 'Ngon bổ rẻ'
        ]);

        MovieFood::create([
            'name' => 'Bắp rang bơ phomai',
            'slug' => 'bap-rang-bo-phomai',
            'price' => '25000',
            'quantity' => '100',
            'image' => 'abc',
            'description' => 'Ngon bổ rẻ'
        ]);

        MovieFood::create([
            'name' => 'Bắp rang bơ nướng',
            'slug' => 'bap-rang-bo-nuong',
            'price' => '25000',
            'quantity' => '100',
            'image' => 'abc',
            'description' => 'Ngon bổ rẻ'
        ]);

        Foodstypes::create([
            'name'=>'Nước hoa quả',
            'parent_id'=>'1',
            'slug'=>'nuoc-hoa-qua',
            'image'=>'abc',
            'description'=>'Ngon bổ rẻ'
        ]);
        Foodstypes::create([
            'name'=>'Nước ngọt',
            'parent_id'=>'1',
            'slug'=>'nuoc-ngot',
            'image'=>'abc',
            'description'=>'Ngon bổ rẻ'
        ]);
        Foodstypes::create([
            'name'=>'Bắp rang bơ',
            'parent_id'=>'1',
            'slug'=>'bap-rang-bo',
            'image'=>'abc',
            'description'=>'Ngon bổ rẻ'
        ]);

        MovieFoodsTypes::create([
            'food_id' => '1',
            'food_type_id' => '1'
        ]);
        MovieFoodsTypes::create([
            'food_id' => '2',
            'food_type_id' => '1'
        ]);
        MovieFoodsTypes::create([
            'food_id' => '3',
            'food_type_id' => '2'
        ]);
        MovieFoodsTypes::create([
            'food_id' => '4',
            'food_type_id' => '2'
        ]);
        MovieFoodsTypes::create([
            'food_id' => '5',
            'food_type_id' => '3'
        ]);
        MovieFoodsTypes::create([
            'food_id' => '6',
            'food_type_id' => '3'
        ]);
    }
}
