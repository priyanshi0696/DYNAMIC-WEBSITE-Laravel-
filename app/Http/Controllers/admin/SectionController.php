<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Section;
use Illuminate\Support\Facades\Session;

class SectionController extends Controller
{

    public function sections()
    {
        Session::put('page','section');
   $section=Section::get()->toArray();
   //dd($section);
   return view('admin.sections.section')->with(compact('section'));

    }
    public function updateSectionStatus(Request $request)
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
    Section::where('id',$data['section_id'])->update(['status'=>$status]);
    return response()->json(['status'=>$status,'section_id'=>$data['section_id']]);
 }
       }

       public function deletesection($id)
       {
        Section::where('id',$id)->delete();
        $message="Section Has Been deleted Successfully";
        return redirect()->back()->with('success_message',$message);
       }

       public function addEditSection(Request $request, $id=null)
       {
        Session::put('page','section');
        if($id==""){
            $title="Add Section";
            $section= new Section;
            $message="Section Added Successfully";

        }else
        {
            $title="Edit Section";
            $section= Section::find($id);
            $message="Section updated Successfully";
        }

        if($request->isMethod('post')){
            $data=$request->all();
            $rules = [
                'sectionname'=>'required' ,
            ];

            $section->name=$data['sectionname'];
            $section->status=1;
             $section->save();
             return redirect('admin/section')->with('sucesss_message',$message);


        }




        return view('admin.sections.add_edit_section')->with(compact('title','section'));
       }

}