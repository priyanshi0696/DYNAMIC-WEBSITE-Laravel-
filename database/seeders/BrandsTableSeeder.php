<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandsRecord=[
            ['id'=>1,'name'=>'Arrow','status'=>1],
            ['id'=>2,'name'=>'Gap','status'=>1],
            ['id'=>3,'name'=>'Lee','status'=>1],
            ['id'=>4,'name'=>'Sumsung','status'=>1],
            ['id'=>5,'name'=>'LG','status'=>1],
            ['id'=>6,'name'=>'Lenovo','status'=>1],
            ['id'=>7,'name'=>'MI','status'=>1],
            ['id'=>8,'name'=>'OnePlus','status'=>1],
        ];
        Brand::insert($brandsRecord);
    }
}
