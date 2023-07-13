<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function orders(){
        Session::put('page','orders');
        $adminType=Auth::guard('admin')->user()->type;

        $vendor_id=Auth::guard('admin')->user()->vendor_id;
        if($adminType=="vendor")
        {
            $vendorStatus=Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/update-vendor-details/personal")->with('error_message','Your Vendor Account is not approved yet');
            }
        }
        if($adminType=="vendor"){
            $orders=Order::with(['orders_product'=>function($query)use($vendor_id){
            $query->where('vendor_id',$vendor_id);
            }])->orderBy('id','Desc')->get()->toArray();
        }
        else{
            $orders=Order::with('orders_product')->orderBy('id','Desc')->get()->toArray();
        }

  //dd($orders);
  return view('admin.orders.orders')->with(compact('orders'));
    }
}