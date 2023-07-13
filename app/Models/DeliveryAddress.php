<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DeliveryAddress extends Model
{
    use HasFactory;
    protected $fillable=['user_id', 'name','address','city','state','country','pincode','status','email','mobile'];
    public static function deliveryAddress(){
        $deliveryAddress=DeliveryAddress::where('user_id',Auth::user()->id)->get()->toArray();
        return $deliveryAddress;
    }
}