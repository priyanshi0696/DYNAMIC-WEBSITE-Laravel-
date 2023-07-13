<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;
class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveryRecords=[
            ['id'=>1,'user_id'=>'1','name'=>'priyanshi','address'=>'surat','city'=>'surat','state'=>'gujrat','country'=>'india','pincode'=>'395007','mobile'=>'989885858','status'=>1],
            ['id'=>2,'user_id'=>'1','name'=>'priyanshi','address'=>'mds','city'=>'mds','state'=>'gujrat','country'=>'india','pincode'=>'458001','mobile'=>'989885858','status'=>1]
        ];
        DeliveryAddress::insert($deliveryRecords);
    }
}