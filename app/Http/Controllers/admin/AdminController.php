<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetail;
use App\Models\VendorsBankDetail;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
//use Hash;
//use Auth;
//use Image;

class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page','dashboard');
        return view('admin.dashboard');
    }
    public function login(Request $request)
    {

        if($request->isMethod('post'))
        {
            $rules = [
                'email'=>'required|email|max:255' ,
                'password' =>'required',
            ];
            $customMessage=[
                'email.required'=>'Email is required',
                'email.email' =>'Valid Email is required',
                'password.required' =>'Password is required',
            ];
            $this->validate($request,$rules,$customMessage);
            $data= $request->all();
           /* if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1]))
            {
             return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('Error Message', 'Invalid Email or Password');
            }*/
            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']]))
            {
                if(Auth::guard('admin')->user()->type=="vendor"&& Auth::guard('admin')->user()->confirm=="No"){
                    return redirect()->back()->with('error_message','Please confirm your email is activated your  vendor account');

                } else if(Auth::guard('admin')->user()->type!="vendor" && Auth::guard('admin')->user()->status=="0")
                {
                    return redirect()->back()->with('error_message','Your admin  account is not  activated');

                }
                else{
                    return redirect('admin/dashboard');
                }

            }else{
                return redirect()->back()->with('Error Message', 'Invalid Email or Password');
            }
        }

        return view('admin.login');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect ('admin/login');
    }
    public function updatepassword(Request $request)
    {Session::put('page','update_password');
        if($request->isMethod('post')){
            $data=$request->all();
            if(Hash::check($data['current_password'] ,Auth::guard('admin')->user()->password))
            {
      if($data['new_password']==$data['confrim_password'])
      {
        Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=> bcrypt($data['new_password'])]);
        return redirect()->back()->with("success_message","Password has been updated Successfully!! ");
      }else{
        return redirect()->back()->with("error_message","New Password and Confrim Password is not Matched!! ");
      }

            }else{
                return redirect()->back()->with("error_message","Your Current Password is Incorrect!!");
            }
            }

        $admindetails=Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('admindetails'));
    }

    public function checkadminpassword(Request $request)
    {

        $data= $request->all();
        if(Hash::check($data['current_password'] ,Auth::guard('admin')->user()->password)){
            return "true";
          }else{
            return "false";
          }
        }

       public function  updateadmindetails(Request $request)
       {
        Session::put('page','update_admin_details');
       if($request->isMethod('post'))
       {
       $data=$request->all();
       $rules=[
        'name'=>'required|regex:/^[\pL\s\-]+$/u',

        'mobile'=>'required|numeric',
        //'city'=>'required'
       ];
       $this->validate($request,$rules);

       if($request->hasFile('image')){
        $image_tmp=$request->file('image');
       if($image_tmp->isValid()){
        $extension=$image_tmp->getClientOriginalExtension();
        $imageName=rand(111,99999).''.$extension;
        $imagepath='admin/images/photos/'.$imageName;
     Image::make($image_tmp)->save($imagepath);

       }
       }else if(!empty($data['current_image'])){
        $imageName= $data['current_image'];
       }
       else{
         $imageName="";
       }

       Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['name'],'mobile'=>$data['mobile'],
    'image'=>$imageName]);
       return redirect()->back()->with('success_message','Admin details updated successfully!!');
       }
        return view('admin.settings.update_admin_details');
       }
       public function updatevendordetails($slug, Request $request)
      {

              if($slug=="personal")
              {
                Session::put('page','update_personal_details');
                if($request->isMethod('post'))
                {
                    $data=$request->all();

                    $rules=[
                        'name'=>'required|regex:/^[\pL\s\-]+$/u',
                        'mobile'=>'required|numeric',
                       ];
                       $this->validate($request,$rules);

                       if($request->hasFile('image')){
                        $image_tmp=$request->file('image');
                       if($image_tmp->isValid()){
                        $extension=$image_tmp->getClientOriginalExtension();
                        $imageName=rand(111,99999).''.$extension;
                        $imagepath='admin/images/photos/'.$imageName;
                     Image::make($image_tmp)->save($imagepath);

                       }
                       }else if(!empty($data['current_image'])){
                        $imageName= $data['current_image'];
                       }
                       else{
                         $imageName="";
                       }

                       Admin::where('id',Auth::guard('admin')->user()->id)->update(['name'=>$data['name'],'mobile'=>$data['mobile'],'image'=>$imageName]);
                       Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->update(['name'=>$data['name'],'mobile'=>$data['mobile'],'address'=>$data['address'] ,'city'=>$data['city'],'country'=>$data['country'],'state'=>$data['state'],'pincode'=>$data['pincode'],
                    'image'=>$imageName]);
                    return redirect()->back()->with('success_message','Vendor details updated successfully!!');

                }

                $vendorDetails = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();


              }
              else if($slug=="bussiness")
              {
                Session::put('page','update_business_details');
                if($request->isMethod('post'))
                {
                    $data=$request->all();
                   //print_r($data);
                  // die;
                    $rules=[
                        'shopname'=>'required|regex:/^[\pL\s\-]+$/u',
                        'shopcity' =>'required|regex:/^[\pL\s\-]+$/u',
                        'shopmobile'=>'required|numeric',
                        'address_proof' =>'required',

                       ];
                       $this->validate($request,$rules);

                       if($request->hasFile('addressproofimage')){
                        $image_tmp=$request->file('addressproofimage');
                       if($image_tmp->isValid()){
                        $extension=$image_tmp->getClientOriginalExtension();
                        $imageName=rand(111,99999).''.$extension;
                        $imagepath='admin/images/proofs/'.$imageName;
                     Image::make($image_tmp)->save($imagepath);

                       }
                       }else if(!empty($data['current_image'])){
                        $imageName= $data['current_image'];
                       }
                       else{
                         $imageName="";
                       }
                   $vendorCount=VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                   if($vendorCount>0){
                    VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['shop_name'=>$data['shopname'],'shop_mobile'=>$data['shopmobile'],'shop_address'=>$data['shopaddress'] ,'shop_city'=>$data['shopcity'],'shop_state'=>$data['shopstate'],'shop_country'=>$data['shopcountry'],'shop_pincode'=>$data['shoppincode'],
                    'shop_addressproof'=>$data['address_proof'],'bussiness_licence_number'=>$data['licencenumber'],'gst_number'=>$data['gstnumber'],'pan_number'=>$data['pannumber'],
                 'addressproofimage'=>$imageName]);

                   }else{
                    VendorsBusinessDetail::insert(['vendor_id'=> Auth::guard('admin')->user()->vendor_id , 'shop_name'=>$data['shopname'],'shop_mobile'=>$data['shopmobile'],'shop_address'=>$data['shopaddress'] ,'shop_city'=>$data['shopcity'],'shop_state'=>$data['shopstate'],'shop_country'=>$data['shopcountry'],'shop_pincode'=>$data['shoppincode'],
                    'shop_addressproof'=>$data['address_proof'],'bussiness_licence_number'=>$data['licencenumber'],'gst_number'=>$data['gstnumber'],'pan_number'=>$data['pannumber'],
                 'addressproofimage'=>$imageName]);

                   }

                    return redirect()->back()->with('success_message','Vendor Bussiness details updated successfully!!');

                }
                $vendorCount=VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
                if($vendorCount>0){
                    $vendorDetails = VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();

                }else{
                    $vendorDetails=array();
                }



              }else if($slug=="bank")
              {
                Session::put('page','update_bank_details');
                if($request->isMethod('post'))
                {

                    $data=$request->all();
                   // print_r($data);
                    $rules=[
                        'accountholdername'=>'required|regex:/^[\pL\s\-]+$/u',
                        'bankname' =>'required',
                        'bankifsc'=>'required',
                        'accountnumber'=>'required|numeric',


                       ];
                       $this->validate($request,$rules);

                       $vendorCount=VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                       if($vendorCount>0){

                        VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['account_holder_name'=>$data['accountholdername'],'bank_name'=>$data['bankname'],'bank_ifsc_code'=>$data['bankifsc'] ,'account_number'=>$data['accountnumber']]);

                       }else{

                        VendorsBankDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'account_holder_name'=>$data['accountholdername'],'bank_name'=>$data['bankname'],'bank_ifsc_code'=>$data['bankifsc'] ,'account_number'=>$data['accountnumber'] ]);


                       }




                    return redirect()->back()->with('success_message','Vendor Bussiness details updated successfully!!');

                }

                $vendorCount=VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->count();
                if($vendorCount>0){
                    $vendorDetails = VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();

                }else{
                    $vendorDetails=array();
                }
                //$vendorDetails = VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
              }
              $countries=Country::where('status',1)->get()->toArray();;
              return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails','countries'));

       }

       public function admins($type=null)
       {


        $admins=Admin::query();
        if(!empty($type))
        {
        $admins= $admins->where('type',$type);
        $title=ucfirst($type);

        Session::put('page','view_'.strtolower($title));
        }else
        {
            $title="All Admins/Subadmins/Vendors";
            Session::put('page','view_all');

        }
 $admins= $admins->get()->toArray();
//dd($admins);
return view('admin.admins.admins')->with(compact('admins','title'));
       }

       public function viewvendordetail($id)
       {
         $vendorDetails= Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id',$id)->first();
         $vendorDetails=json_decode(json_encode($vendorDetails),true);
         //dd($vendorDetails);
         return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));
       }
       public function updateAdminStatus(Request $request)
       {
 if($request->ajax())
 {
    $data= $request->all();
    //print_r($data); die;
    if($data['status']=="Active"){
        $status=0;

    }else
    {
        $status=1;
    }
    Admin::where('id',$data['admin_id'])->update(['status'=>$status]);
    $adminDetails=Admin::where('id',$data['admin_id'])->first()->toArray();
//$adminType=Auth::guard('admin')->user()->type;
if($adminDetails['type']=="vendor" && $status==1){
    Vendor::where('id',$adminDetails['vendor_id'])->update(['status'=>$status]);
$email=$adminDetails['email'];
    $messageData=[
        'email' =>$adminDetails['email'],
        'name' =>$adminDetails['name'],
        'mobile' =>$adminDetails['mobile']

    ];
    Mail::send('emails.vendor_approved',$messageData,function($message)use($email){
        $message->to($email)->subject(' Vendor Account is Approved');
    });
}
    return response()->json(['status'=>$status,'admin_id'=>$data['admin_id']]);
 }
       }

    }