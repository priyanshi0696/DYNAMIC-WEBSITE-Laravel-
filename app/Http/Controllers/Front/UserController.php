<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Sms;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function loginRegister(){
        return view("front.users.login_registers");


}
public function userregister(Request $request){

if($request->ajax()){
    $data=$request->all();
$validator=Validator::make($request->all(),[
    'name'=>'required|string|max:100',
    'address'=>'required',
    'city'=>'required',
    'state'=>'required',
    'country'=>'required',
    'pincode'=>'required',
    'mobile'=>'required|numeric|digits:10',
   'email'=>'required|email|max:150|unique:users',
   'password'=>'required|min:6',
   'accept'=>'required',


],
[
    'accept.required'=>'Please accept our Terms and Condition'
]);
if($validator->passes()){


$user = new User;
$user->name=$data['name'];
$user->address=$data['address'];
$user->city=$data['city'];
$user->state=$data['state'];
$user->country=$data['country'];
$user->pincode=$data['pincode'];
$user->mobile=$data['mobile'];
$user->email =$data['email'];
$user->password=bcrypt($data['password']);
$user->status=0;
$user->save();


$email=$data['email'];
$messageData=['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email'],'code'=>base64_encode($data['email'])];

Mail::send('emails.confirmation',$messageData,function($message)use($email){
    $message->to($email)->subject("Confrim Your  Project Account  ");
});
    $redirectTo=url('users/login-register');
    return response()->json(['type'=>'success','url'=>$redirectTo,'message'=>'Please confirm your email to activate your account']);

/*$email=$data['email'];
$messageData=['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']];
Mail::send('emails.register',$messageData,function($message)use($email){
$message->to($email)->subject("Welcome to Project");
})*/


/*$message="Dear Customer, You Have been Successfully registered";
$mobile=$data['mobile'];
Sms::sendSms($message,$mobile);*/

/*if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
    $redirectTo=url('cart');

    if(!empty(Session::get('session_id'))){
        $user_id=Auth::user()->id;
        $session_id=Session::get('session_id');
        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }
    return response()->json(['type'=>'success','url'=>$redirectTo]);


}*/

}
else{
return response()->json(['type'=>'error','errors'=>$validator->messages()]);
}

}
}
public function userlogin(Request $request){
    if($request->ajax()){
        $data=$request->all();
       // print_r($data);
        $validator=Validator::make($request->all(),[

           'email'=>'required|email|max:150|exists:users',
           'password'=>'required|min:6' ]
      );
      if($validator->passes()){
        if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
            if(Auth::user()->status==0){
                Auth::logout();
                return response()->json(['type'=>'inactive','message'=>'Your Account is Inactive.Please Confirm your Account']);

            }
            if(!empty(Session::get('session_id'))){
$user_id=Auth::user()->id;
$session_id=Session::get('session_id');
Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
            }
      $redirectTo= url('cart');
            return response()->json(['type'=>'success','url'=>$redirectTo]);


        }else{
            return response()->json(['type'=>'incorrect','message'=>'Incorrect Email or Password']);
        }

      }
      else{
        return response()->json(['type'=>'error','errors'=>$validator->messages()]);
    }

    }

}
public function confirmAccount($code){
    $email=base64_decode($code);
    $userCount=User::where('email',$email)->count();
    if($userCount>0){
$userDetails=User::where('email',$email)->first();
if($userDetails->status==1){
return redirect('users/login-register')->with('error_message','Your Account already activate'  );
}else{
    User::where('email',$email)->update(['status'=>1]);

$messageData=['name'=>$userDetails->name,'mobile'=>$userDetails->mobile,'email'=>$email];

Mail::send('emails.register',$messageData,function($message)use($email){
    $message->to($email)->subject("Welcome to   Project ");
});
return redirect('users/login-register')->with('success_message','Your Account is activated.You can login now'  );

}
    }
    else{
        abort(404);
    }

}

public function userlogout(){
    Auth::logout();
    return redirect('/');


}
public function forgotpassword(Request $request){

if($request->ajax()){
    $data=$request->all();
    $email=$data['email'];
    $validator=Validator::make($request->all(),[

        'email'=>'required|email|max:150|exists:users' ],
        [
            'email.exists'=>'Email does not exists'
        ]
   );
   if($validator->passes()){
    $userDetails=User::where('email',$email)->first();
    $newpassword=Str::random(16);
    User::where('email',$email)->update(['password'=>bcrypt($newpassword)]);
    $userDetails=User::where('email',$email)->first()->toArray();
    $messageData=['name'=>$userDetails['name'],'email'=>$email,'password'=>$newpassword];
    Mail::send('emails.user_forgotpassword',$messageData,function($message)use($email){
        $message->to($email)->subject('New Password');

    });

    return response()->json(['type'=>'success','message'=>'New Password Send to Registered Email']);
   }else{
    return response()->json(['type'=>'error','errors'=>$validator->messages()]);
   }


}
    return view('front.users.forgot_password');

}
public function userAccount(Request $request){
if($request->ajax()){

}else{
   // $countries=Country::where('status',1)->get()->toArray();
    return view('front.users.user_account');
}

}
}