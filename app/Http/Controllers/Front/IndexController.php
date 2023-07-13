<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;

class IndexController extends Controller
{
    public function index(){
        $banners=Banner::where('status',1)->get()->toArray();
        $newproducts=Product::orderBy('id','Desc')->where('status',1)->limit(8)->get()->toArray();

        $bestSellers=Product::where(['is_bestseller'=>'Yes','status'=>1])->inRandomOrder()->get()->toArray();
        $discountproduct=Product::where('product_discount','>',0)->where('status',1)->limit(6)->inRandomOrder()->get()->toArray();
        $featureproduct=Product::where(['is_featured'=>'Yes','status'=>1])->inRandomOrder()->get()->toArray();
        //dd($discountproduct);
      
        
        return view('front.index')->with(compact('banners','newproducts','bestSellers','discountproduct','featureproduct'));
    }
}