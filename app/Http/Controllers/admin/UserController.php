<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users(){
        $users=User::get()->toArray();
        return view('admin.users.users')->with(compact('users'));


    }
    public function updateuserStatus(Request $request)
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
          User::where('id',$data['user_id'])->update(['status'=>$status]);
          return response()->json(['status'=>$status,'user_id'=>$data['user_id']]);
       }
    }
}