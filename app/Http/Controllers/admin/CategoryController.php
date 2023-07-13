<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;


class CategoryController extends Controller
{
    public function categories()
    {
     Session::put('page','categories');
     $categories=Category::with(['section','parentcategory'])->get()->toArray();
     //dd($categories);
    return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request)
    {
if($request->ajax())
{
 $data= $request->all();

 if($data['status']=="Active"){
     $status=0;

 }else
 {
     $status=1;
 }
 Category::where('id',$data['category_id'])->update(['status'=>$status]);
 return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
}
    }
    public function addEditCategory(Request $request, $id=null)
    {
        Session::put('page','categories');
        if($id==""){
            $title="Add Category";
            $category= new Category;
            $getCategories=array();
            $message="Category Added Successfully";

        }else
        {
            $title="Edit Section";
            $category= Category::find($id);
            $getCategories=Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$category['section_id']])->get();

            $message="Category updated Successfully";
        }

if($request->isMethod('post'))
{
    $data=$request->all();
//print_r($data);
//die;
$rules = [
    'categoryname'=>'required' ,
    'sectionid' =>'required',
    'url' =>'required',
];
$customMessage=[
    'categoryname.required'=>'Category Name is required',

    'sectionid.required' =>'Section  is required',
    'url.required' =>'URL  is required',
];

$this->validate($request,$rules,$customMessage);

if($data['categorydiscount']=="")
{
    $data['categorydiscount']=0;
}
if($data['categorydescription']=="")
{
    $data['categorydescription']="";
}


if($request->hasFile('image')){
    $image_tmp=$request->file('image');
   if($image_tmp->isValid()){
    $extension=$image_tmp->getClientOriginalExtension();
    $imageName=rand(111,99999).''.$extension;
    $imagepath='front/images/category/'.$imageName;
 Image::make($image_tmp)->save($imagepath);
 $category->category_image=$imageName;

   }
}
   else{
    $category->category_image="";
   }


$category->section_id=$data['sectionid'];
$category->parent_id=$data['parentid'];
$category->category_name=$data['categoryname'];
$category->category_discount=$data['categorydiscount'];
$category->description=$data['categorydescription'];
$category->url=$data['url'];
$category->meta_title=$data['metatitle'];
$category->meta_description=$data['metadescription'];
$category->meta_keywords=$data['metakeywords'];
$category->status=1;
$category->save();

return redirect('admin/categories')->with('success_message',$message);

}
     $getSections=Section::get()->toArray();




        return view('admin.categories.add_edit_category')->with(compact('title','category','getSections','getCategories'));
       }


      public function appendCategoriesLevel(Request $request){

        if($request->ajax())
        {
            $data=$request->all();
            $getCategories=Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$data['section_id']])->get()->toArray();
            return view('admin.categories.append_categorieslevel')->with(compact('getCategories'));
        }


      }
       public function deleteCategory($id)
       {
      Category::where('id',$id)->delete();
      $message="Category has been deleted Successfully ";
      return redirect()->back()->with('success_message',$message);
       }

       public function deleteCategoryImage($id)
       {
        $categoryImage= Category::select('category_image')->where('id',$id)->first();
        $category_image_path='front/images/category/';

        if(file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }
        Category::where('id',$id)->update(['category_image'=>'']);
        $message="Category Image  has been deleted Successfully ";
        return redirect()->back()->with('success_message',$message);
       }
    }