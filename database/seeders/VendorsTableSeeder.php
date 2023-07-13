<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords =[['id'=>1,'name'=>'john','address'=>'Cp-112','city'=>'surat','state'=>'gujrat' ,'country'=>'india','pincode'=>'395501','mobile'=>'7885458888','email'=>'john@gmail.com','status'=>0],
    ];
    Vendor::insert($vendorRecords);
    }
}
