<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail;

class VendorBussinessDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorrecords=[
            ['id'=>1,'vendor_id'=>1,'shop_name'=>'John Electronics Store','shop_address'=>'1234','shop_city'=>'surat','shop_state'=>'gujrat','shop_country'=>'india','shop_pincode'=>'395007','shop_mobile'=>'8989754858','shop_website'=>'websitemaker.in','shop_email'=>'john@gmail.com','shop_addressproof'=>'passport','addressproofimage'=>'test.jpg','bussiness_licence_number'=>'1234565','gst_number'=>'56454','pan_number'=>'5644855']

        ];
        VendorsBusinessDetail::insert($vendorrecords);
    }
}
