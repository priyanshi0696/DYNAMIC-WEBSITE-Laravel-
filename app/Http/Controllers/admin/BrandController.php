<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    public function brands()
    {
    Session::put('page','categories');
     $brands=Brand::get()->toArray();
     //dd($categories);
    return view('admin.brands.brand')->with(compact('brands'));
    }
    public function updatebrandStatus(Request $request)
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
    Brand::where('id',$data['brand_id'])->update(['status'=>$status]);
    return response()->json(['status'=>$status,'brand_id'=>$data['brand_id']]);
 }
       }

       public function deletebrand($id)
       {
    Brand::where('id',$id)->delete();
        $message="Section Has Been deleted Successfully";
        return redirect()->back()->with('success_message',$message);
       }

       public function addEditbrand(Request $request, $id=null)
       {
        Session::put('page','brand');
        if($id==""){
            $title="Add Section";
            $brand= new Brand;
            $message="Section Added Successfully";

        }else
        {
            $title="Edit Section";
            $brand= Brand::find($id);
            $message="Section updated Successfully";
        }

        if($request->isMethod('post')){
            $data=$request->all();
            $rules = [
                'sectionname'=>'required' ,
            ];

            $brand->name=$data['sectionname'];
            $brand->status=1;
             $brand->save();
             return redirect('admin/brands')->with('sucesss_message',$message);


        }




        return view('admin.brands.add_edit_brand')->with(compact('title','brand'));
       }
}