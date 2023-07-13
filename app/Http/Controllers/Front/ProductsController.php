<?php

namespace App\Http\Controllers\Front;
use App\Models\Country;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttributes;
use App\Models\Vendor;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;



class ProductsController extends Controller
{
    public function listing( Request $request ){
        if($request->ajax()){
            $data=$request->all();
           //print_r($data);
          // die;
           $url= $data['url'];
           $_GET['sort']=$data['sort'];
           $categoryCount=Category::where(['url'=>$url,'status'=>1])->count();
           if($categoryCount>0)
           {
               $categoryDetails= Category::categoryDetails($url);

               $categoryProducts=Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1);
              if(isset($_GET['sort']) && !empty($_GET['sort'])){
               if($_GET['sort']=="product_latest"){
                   $categoryProducts->orderby('products.id','Desc');


               } else if($_GET['sort']=="price_lowest"){
                   $categoryProducts->orderBy('products.product_price','Asc');
               }else if($_GET['sort']=="price_highest"){
                   $categoryProducts->orderBy('products.product_price','Desc');
               }else if($_GET['sort']=="name_z_a"){
                   $categoryProducts->orderBy('products.product_name','Asc');
               }else if($_GET['sort']=="name_a_z"){
                   $categoryProducts->orderBy('products.product_name','Desc');
               }
              }

               $categoryProducts=$categoryProducts->paginate(3);
   //dd($categoryDetails);
           //    echo "Category exits";
              // die;
              return view('front.product.ajaxproductslisting')->with(compact('categoryDetails','categoryProducts','url'));
           }else{
               abort(404);
           }
        }
        else{
            $url= Route::getFacadeRoot()->current()->uri();
        $categoryCount=Category::where(['url'=>$url,'status'=>1])->count();
        if($categoryCount>0)
        {
            $categoryDetails= Category::categoryDetails($url);

            $categoryProducts=Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1);
           if(isset($_GET['sort']) && !empty($_GET['sort'])){
            if($_GET['sort']=="product_latest"){
                $categoryProducts->orderby('products.id','Desc');


            } else if($_GET['sort']=="price_lowest"){
                $categoryProducts->orderBy('products.product_price','Asc');
            }else if($_GET['sort']=="price_highest"){
                $categoryProducts->orderBy('products.product_price','Desc');
            }else if($_GET['sort']=="name_z_a"){
                $categoryProducts->orderBy('products.product_name','Asc');
            }else if($_GET['sort']=="name_a_z"){
                $categoryProducts->orderBy('products.product_name','Desc');
            }
           }

            $categoryProducts=$categoryProducts->paginate(3);
//dd($categoryDetails);
        //    echo "Category exits";
           // die;
           return view('front.product.listing')->with(compact('categoryDetails','categoryProducts','url'));
        }else{
            abort(404);
        }
    }

        }
        public function details($id){
            $productDetails=Product::with(['section','category','brand','attributes'=>function($query){
                $query->where('stock','>',0);
            },'images','vendor'])->find($id)->toArray();
            $categoryDetails=Category::categoryDetails($productDetails['category']['url']);

$similarProducts=Product::with('brand')->where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->limit(4)->inRandomOrder()->get()->toArray();
if(empty(Session::get('session_id'))){
$session_id =md5(uniqid(rand(), true));



}else
{
    $session_id=Session::get('session_id');
}

Session::put('session_id',$session_id);
$countRecentlyViewedProducts=DB::table('recently_viewed_products')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
if($countRecentlyViewedProducts==0)
{
    DB::table('recently_viewed_products')->insert(['product_id'=>$id,'session_id'=>$session_id]);
}

$recentProductsIds=DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)->where('session_id',$session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');
$recentlyProducts=Product::with('brand')->whereIn('id',$recentProductsIds)->get()->toArray();
            $totalStock=ProductsAttributes::where('product_id',$id)->sum('stock');
            //dd($categoryDetails);
         return view('front.product.detail')->with(compact('productDetails','categoryDetails','totalStock','similarProducts','recentlyProducts'));
        }

        public function getProductPrice(Request $request){

if($request->ajax()){
$data=$request->all();
//print_r($data);
$getDiscountAttributePrice=Product::getDiscountAttributePrice($data['product_id'],$data['size']);
return $getDiscountAttributePrice;

}

        }

        public function vendorListing($vendorid){

            $getVendorShop = Vendor::getVendorDetails($vendorid);

            $vendorProducts=Product::with('brand')->where('vendor_id',$vendorid)->where('status',1);
            $vendorProducts=$vendorProducts->paginate(30);
           return view('front.product.vendor_listing')->with(compact('getVendorShop','vendorProducts'));



        }
public function cartadd(Request $request){
if($request->isMethod('post')){
    $data=$request->all();
  $getProductStock=ProductsAttributes::isstockAvailable($data['product_id'],$data['size']);
  if($getProductStock<$data['quantity']){
    return redirect()->back()->with('error_message','Required Quantity is not available');
  }
  $session_id=Session::get('session_id');
if(empty($session_id)){
    $session_id=Session::getId();
    Session::put('session_id',$session_id);
}
if(Auth::check())
{
      $user_id=Auth::user()->id;
$countProducts=Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>$user_id])->count();

}
else{
    $user_id=0;
    $countProducts=Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>$session_id])->count();
}
$item=new Cart;
$item->session_id=$session_id;
$item->user_id=$user_id;
$item->product_id=$data['product_id'];
$item->size=$data['size'];
$item->quantity=$data['quantity'];
$item->save();
return redirect()->back()->with('success_message','Product Has Been Added in cart <a style="text-decoration:underline" href="/cart">View Cart</a>');
}

}
public function cart(){
    $getCartItems=Cart::getCartItem();
   // dd($getCartItems);
return view('front.product.card')->with(compact('getCartItems'));
}
public function cartupdate(Request $request){
    if($request->ajax()){
        $data=$request->all();
        $cartDetails= Cart::find($data['cartid']);
        $availablestock=ProductsAttributes::select('stock')->where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();
        if($data['qty']>$availablestock['stock']){
            $getCartItems=Cart::getCartItem();
      return response()->json([
      'status'=>false,
      'message'=>'Product Stock is Not Available',
      'view'=>(String)View::make('front.product.cart_items')->with(compact('getCartItems'))
      ]);
        }
        $availablesize=ProductsAttributes::where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size'],'status'=>1])->count();
        if($availablesize==0){
            $getCartItems=Cart::getCartItem();
            return response()->json([
            'status'=>false,
            'message'=>'Product Size is Not Available',
            'view'=>(String)View::make('front.product.cart_items')->with(compact('getCartItems'))
            ]);

        }

Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
$getCartItems=Cart::getCartItem();
return response()->json([
    'status'=>true,
    'view'=>(String)View::make('front.product.cart_items')->with(compact('getCartItems'))
]);
    }

}

public function cartdelete(Request $request){

if($request->ajax()){
    $data=$request->all();
  Cart::where('id',$data['cartid'])->delete();
  $getCartItems=Cart::getCartItem() ;
  return response()->json([

    'view'=>(String)View::make('front.product.cart_items')->with(compact('getCartItems'))
]);

}


}
public function delivery(){
    $deliveryAddresses= DeliveryAddress::deliveryAddress();
    return view('front.product.delivery_addresses')->with(compact('deliveryAddresses'));
}
public function checkout(Request $request, $id=null){


    $deliveryAddresses= DeliveryAddress::deliveryAddress();
    $countries=Country::where('status',1)->get()->toArray();
    $getCartItems=Cart::getCartItem();
    if(count($getCartItems)==0){
        $message="Shopping Cart is empty! Please add product";
return redirect('cart')->with('error_message',$message);
    }
    if($request->isMethod('post')){
        $data=$request->all();


       if(empty($data['address_id'])){
       // $message="Please Select Delivery Address";
       // return redirect()->back()->with('error_message',$message);
       }

       if(empty($data['paymentgateway'])){
        $message="Please Select Payment Method";
        return redirect()->back()->with('error_message',$message);
       }
       if(empty($data['accept'])){
        $message="Please agree to Terms and Condition";
        return redirect()->back()->with('error_message',$message);
       }
     $deliveryAddress=DeliveryAddress::where('id',$data['address_id'])->first()->toArray();
      //$deliveryAddress=User::where('id',$data['addressid'])->first()->toArray();
      //dd($deliveryAddress);
      //dd('ghvhjj');
 // dd($deliveryAddress);
  if($data['paymentgateway']=="COD"){
    $payment_method="COD";
    $order_status="NEW";

  }else{
    $payment_method="Prepaid";
    $order_status="Pending";
  }
  DB::beginTransaction();
  $total_price=0;
  foreach($getCartItems as $item){
    $getDiscountAttributePrice=Product:: getDiscountAttributePrice($item['product_id'],$item['size']);
    $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity'] );

  }

  $shipping_charges=0;
  $grand_total=$total_price +$shipping_charges;

  Session::put('grand_total',$grand_total);

  $order=new Order;
$order->user_id=Auth::user()->id;
$order->name=$deliveryAddress['name'];
$order->address=$deliveryAddress['address'];
$order->city=$deliveryAddress['city'];
$order->state=$deliveryAddress['state'];
$order->country=$deliveryAddress['country'];
$order->pincode=$deliveryAddress['pincode'];
$order->mobile=$deliveryAddress['mobile'];
$order->email=Auth::user()->email;
$order->shippingcharges=$shipping_charges;
$order->order_status=$order_status;
$order->payment_method=$payment_method;
$order->payment_gateway=$data['paymentgateway'];
$order->grand_total=$grand_total;
$order->save();
$order_id=DB::getPdo()->lastInsertId();
foreach($getCartItems as $item){
    $cartitem=new OrdersProduct;
    $cartitem->order_id=$order_id;
    $cartitem->user_id=Auth::user()->id;
    $getProductDetails=Product::select('product_code','product_name','product_color','admin_id','vendor_id')->where('id',$item['product_id'])->first()->toArray();
    //dd($getProductDetails);

    $cartitem->admin_id=$getProductDetails['admin_id'];
    $cartitem->vendor_id=$getProductDetails['vendor_id'];
    $cartitem->product_id=$item['product_id'];
    $cartitem->product_code=$getProductDetails['product_code'];
    $cartitem->product_name=$getProductDetails['product_name'];
    $cartitem->product_color=$getProductDetails['product_color'];
    $cartitem->product_size=$item['size'];
    $getDiscountAttributePrice=Product:: getDiscountAttributePrice($item['product_id'],$item['size']);
    $cartitem->product_price=$getDiscountAttributePrice['final_price'];
    $cartitem->product_qty=$item['quantity'];
    $cartitem->save();



}
Session::put('order_id',$order_id);

DB::commit();
$orderDetails=Order::with('orders_product')->where('id',$order_id)->first()->toArray();
if($data['paymentgateway']=="COD")
{
   $email=Auth::user()->email;
   $messageData=[
    'email' => $email,
    'name' => Auth::user()->name,
    'order_id'=>$order_id,
    'orderDetails' =>$orderDetails
   ];
   Mail::send('emails.order',$messageData,function($message)use($email){
    $message->to($email)->subject('Order Placed - Developer');

   });
}
if($data['paymentgateway']=="Paypal")
{
    return redirect('/paypal');
}
else{
    echo "Other Prepaid Account";

}

return redirect('thanks');
    }

   // dd($getCartItems);
    //dd($deliveryAddress);
return view('front.product.checkout')->with(compact('deliveryAddresses','countries','getCartItems'));

}

public function thanks(){
return view('front.product.thanks');
}
}