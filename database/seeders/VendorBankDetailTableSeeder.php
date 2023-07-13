<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail;

class VendorBankDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorRecords =[['id'=>1,'vendor_id'=>1,'account_holder_name'=>'John Joshi','bank_name'=>'HDFC','bank_ifsc_code'=>'HDFC2002' ,'account_number'=>'198445485552'],
    ];
    VendorsBankDetail::insert($vendorRecords);
    }
}
