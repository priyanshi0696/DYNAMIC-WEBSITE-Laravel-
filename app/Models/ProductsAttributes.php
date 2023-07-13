<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsAttributes extends Model
{
    use HasFactory;
    public static function isstockAvailable($product_id,$size){
$getProductStock=ProductsAttributes::select('stock')->where(['product_id'=>$product_id,'size'=>$size])->first();
return $getProductStock->stock;

    }
}