<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class BannersController extends Controller
{
    public function banners(){
        Session::put('page','banners');
        $banners= Banner::get()->toArray();
       // dd($banners);
       return view('admin.banners.banners')->with(compact('banners'));
    }
    public function updatebannerStatus(Request $request)
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
          Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
          return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
       }
    }
    public function deletebanner($id){

        $bannerImage = Banner::select('image')->where('id',$id)->first();
        $imagepath='front/images/bannerimages';


        if(file_exists($imagepath.$bannerImage->image))
        {
            unlink($imagepath.$bannerImage->image);
        }


        Banner::where('id', $id)->delete();
        $message="Banner Image Has Been deleted Successfully";
        return redirect()->back()->with('success_message',$message);

     }
     public function addbanner(Request $request,$id=null){
        Session::put('page','banners');
        echo "test";

        if($id=="")
        {
  $banner=new Banner();
  $title="Add Banner Image";
  $message="Banner Image Added Successfully";
        }else{
            $banner=Banner::find($id);
            $title="Edit Banner Image";
            $message="Banner Image Updated Successfully";

        }

        if($request->isMethod('post'))
        {
            $data=$request->all();
            //print_r($data);
            //die;

$banner->link=$data['link'];
$banner->title=$data['title'];
$banner->alt=$data['alt'];
$banner->status=1;

            if($request->hasFile('image')){
                $image_tmp=$request->file('image');
               if($image_tmp->isValid()){
                $extension=$image_tmp->getClientOriginalExtension();
                $imageName=rand(111,99999).''.$extension;
                $imagepath='front/images/bannerimage/'.$imageName;
             Image::make($image_tmp)->resize(1920,720)->save($imagepath);
             $banner->image=$imageName;

               }
            }
               else{
                $banner->image="";
               }

               $banner->save();
               return redirect('admin/banners')->with('success_message',$message);


        }
        return view('admin.banners.addedit_banner')->with(compact('title','banner'));

     }
}
