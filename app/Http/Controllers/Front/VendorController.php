<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;
use App\Models\Vendor;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;


class VendorController extends Controller
{
    public function loginRegister(){
return view('front.vendors.login_registers');
    }
    public function register(Request $request)
    {
if($request->isMethod('post'))
{
    $data=$request->all();

    $rules=[
        "name"=>"required",
        "email"=>"required|email|unique:admins|unique:vendors",
        "mobile"=>"required|unique:admins|unique:vendors",
        "accept"=>"required",



    ];
    $customMessage=[
        "name.required"=>"Name is Required",
        "email.required"=>"Email is Required",
        "email.email"=>"Valid Email is Required",
        "email.unique"=>"Unique Mail Id ",
        "mobile.required"=>"Mobile is Required",
        "mobile.unique"=>"Unique Mobile Number",
        "accept.required"=>"Accept is Required",

    ];
    $validator =Validator::make($data,$rules,$customMessage);
    if($validator->fails()){
        return Redirect::back()->withErrors($validator);
    }
    DB::beginTransaction();
    $Vendor=new Vendor();
    $Vendor->name=$data['name'];
    $Vendor->mobile=$data['mobile'];
    $Vendor->email=$data['email'];
    //$Vendor->password=bcrypt($data['password']);
    //$Vendor->name=$data['name'];
    $Vendor->status=0;

    date_default_timezone_set("Asia/Kolkata");
    $Vendor->created_at=date("Y-m-d H:i:s");
    $Vendor->updated_at=date("Y-m-d H:i:s");
$Vendor->save();

$vendor_id=DB::getPdo()->lastInsertId();

$admin=new Admin();
$admin->type="vendor";
$admin->vendor_id=$vendor_id;
$admin->name=$data['name'];
$admin->mobile=$data['mobile'];
$admin->email=$data['email'];
$admin->password=bcrypt($data['password']);
//$Vendor->name=$data['name'];
$admin->status=0;

$admin->created_at=date("Y-m-d H:i:s");
$admin->updated_at=date("Y-m-d H:i:s");
$admin->save();

$email=$data['email'];
$messageData=[
    'email' =>$data['email'],
    'name' =>$data['name'],
    'code' =>base64_encode($data['email'])
];
Mail::send('emails.vendor_confirmation',$messageData,function($message)use($email){
    $message->to($email)->subject('Confrim Your Vendor Account');
});

DB::commit();



$message="Thanks for Registerting as Vendor Account! we will confrim account by email once your account is approved" ;

return redirect()->back()->with('success_message',$message);

}
    }

    public function confirmvendor($email)
    {
   $email=base64_decode($email);
 //die;

 $vendorCount =Vendor::where('email',$email)->count();
 if($vendorCount>0)
 {
    $vendorDetails=Vendor::where('email',$email)->first();
    if($vendorDetails->confirm=="Yes"){
        $message="Your Vendor Account is already Confrimed. You can login";
        return redirect('vendor/login-register')->with('error_message',$message);
    }else{
        Admin::where('email',$email)->update(['confirm'=>'Yes']);
        Vendor::where('email',$email)->update(['confirm'=>'Yes']);

$messageData=[
    'email' =>$email ,
    'name' =>$vendorDetails->name,
    'mobile' =>$vendorDetails->mobile,

];
Mail::send('emails.vendor_confirmed',$messageData,function($message)use($email){
    $message->to($email)->subject(' Your Vendor Account Confrimed!');
});


        $message="Your Vendor Email account is confirmed .You can login";
        return redirect('vendor/login-register')->with('success_message',$message);
    }
 }
 else{

    abort(404);
 }
    }
}