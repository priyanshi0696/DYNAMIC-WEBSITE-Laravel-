<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productRecords=[
            ['id'=>1,'category_id'=>5,'section_id'=>2,'brand_id'=>9,'vendor_id'=>1,'admin_id'=>0,'admin_type'=>'vendor','product_code'=>'RN11','product_name'=>'Redmi Note 11','product_color'=>'blue','product_price'=>'15000','product_discount'=>10,'product_weight'=>'500','product_video'=>'','product_image'=>'','description'=>'','meta_title'=>'','meta_keywords'=>'','meta_description'=>'','is_featured'=>'Yes','status'=>1],
            ['id'=>2,'category_id'=>6,'section_id'=>1,'brand_id'=>2,'vendor_id'=>0,'admin_id'=>1,'admin_type'=>'superadmin','product_code'=>'RC01','product_name'=>'Red Casual Tshirt','product_color'=>'Red','product_price'=>'1000','product_discount'=>20,'product_weight'=>'200','product_video'=>'','product_image'=>'','description'=>'','meta_title'=>'','meta_keywords'=>'','meta_description'=>'','is_featured'=>'Yes','status'=>1],
        ];
        Product::insert($productRecords);
    }
}
