<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;

    public static function getCartItem(){
 if(Auth::check()){
    $getCartItems =Cart::with(['product'=>function($query){
        $query->select('id','category_id','product_name','product_code','product_color','product_image');

    }])->orderby('id','Desc')->where('user_id',Auth::user()->id)->get()->toArray();
 }
 else
 {
    $getCartItems=Cart::with(['product'=>function($query){
        $query->select('id','category_id','product_name','product_code','product_color','product_image');

    }])->orderby('id','Desc')->where('session_id',Session::get('session_id'))->get()->toArray();
 }
 return   $getCartItems;
    }

    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }
}