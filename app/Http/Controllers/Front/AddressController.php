<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;
use Auth;

use Illuminate\Support\Facades\View;

class AddressController extends Controller
{
 public function getdeliveryAddress(Request $request){
    if($request->ajax()){
        $data=$request->all();

        //$address=User::where('id',$data['addressid'])->first()->toArray();

       $address=DeliveryAddress::where('id',$data['addressid'])->first()->toArray();
       return response()->json(['address'=>$address]);

    }
}
    public function savedeliveryAddress(Request $request){
 //dd("hello");

        if($request->ajax()){
            $data=$request->all();
            $address=array();
            $address['user_id']=\Illuminate\Support\Facades\Auth::user()->id;
            $address['name']=$data['name'];
            $address['address']=$data['address'];
            $address['city']=$data['city'];
        $address['state']=$data['state'];
        $address['country']=$data['country'];
        $address['pincode']=$data['pincode'];
        $address['mobile']=$data['mobile'];
        $address['email']=$data['email'];

        //   print_r($data);
  if(!empty($data['delivery_id'])){


    DeliveryAddress::where('id',$data['delivery_id'])->update($address);
  }else{
//$address['status']=1;
DeliveryAddress::create($address);


  }
$deliveryAddresses=DeliveryAddress::deliveryAddress();
//$deliveryAddress=User::where('id',$data['addressid'])->first()->toArray();
//return response()->json(['view'=>(String)View::make('front.product.checkout')->with(compact('deliveryAddress'))
return response()->json(['view'=>(String)View::make('front.product.delivery_addresses')->with(compact('deliveryAddresses'))
]);

        }
    }

    public function removedeliveryAddress(Request $request){

 if($request->ajax()){
    $data=$request->all();
  DeliveryAddress::where('id',$data['addressid'])->delete();

  $deliveryAddresses=DeliveryAddress::deliveryAddress();

return response()->json(['view'=>(String)View::make('front.product.delivery_addresses')->with(compact('deliveryAddresses'))
 ]);
 }
    }

 }