<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Section;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductsAttributes;
use App\Models\ProductsImage;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
//use Auth;

use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function products(){
        Session::put('page','products');
        $adminType=Auth::guard('admin')->user()->type;

        $vendor_id=Auth::guard('admin')->user()->vendor_id;
        if($adminType=="vendor")
        {
            $vendorStatus=Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/update-vendor-details/personal")->with('error_message','Your Vendor Account is not approved yet');
            }
        }
        $product=Product::with(['section'=>function($query){
            $query->select('id','name');
        },'category'=>function($query){
            $query->select('id','category_name');
        }]);
        if($adminType=="vendor"){
            $product=$product->where('vendor_id',$vendor_id);
        }
        $product=$product->get()->toArray();
//dd($product);
        return view('admin.products.product')->with(compact('product'));

         }

         public function updateproductStatus(Request $request)
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
      Product::where('id',$data['product_id'])->update(['status'=>$status]);
      return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
   }
         }

         public function deleteproduct($id)
         {
      Product::where('id',$id)->delete();
          $message="Section Has Been deleted Successfully";
          return redirect()->back()->with('success_message',$message);
         }

         public function addEditProduct(Request $request, $id=null)
         {
            Session::put('page','product');
            if($id==""){
                $title="Add Product";
                $product= new Product;
                $message="Product Added Successfully";

            }else
            {
                $title="Edit Product";
                $product= Product::find($id);

                $message="Product updated Successfully";
            }
           if($request->isMethod('post'))
           {
            $data=$request->all();
           // print_r($data);

           $rules=[
            'category_id'=>'required',
             'productname'=>'required',
             'productcode'=>'required|regex:/^\w+$/',

             'productprice'=>'required|numeric',
             'productcolor'=>'required'


           ];
           $customMessage=[
            'category_id.required'=>'Category is Required',
            'productname.required'=>'Product Name is Required',
            //'productname.regex'=>'Valid Product Name  is Required',
            'productcode.required'=>'Product Code is Required',
            'productcode.regex'=>'Valid Product Code is Required',
            'productprice.required'=>'Product Price is Required',
            'productprice.numeric'=>'Valid Product Price is Required',
            'productcolor.required'=>'Product  Color is Required',
           ];
            $this->validate($request,$rules,$customMessage);
             if($request->hasFile('image')){
                $image_tmp=$request->file('image');
                if($image_tmp->isValid()){
                 $extension=$image_tmp->getClientOriginalExtension();
                 $imageName=rand(111,99999).''.$extension;
                 $imagelargepath='front/images/product/large/'.$imageName;
                 $imagemediumpath='front/images/product/medium/'.$imageName;
                 $imagesmallpath='front/images/product/small/'.$imageName;
              Image::make($image_tmp)->resize(1000,1000)->save($imagelargepath);
              Image::make($image_tmp)->resize(500,500)->save($imagemediumpath);
              Image::make($image_tmp)->resize(250,250)->save($imagesmallpath);
              $product->product_image = $imageName;

                }
            }
            if($request->hasFile('video')){
                $video_tmp=$request->file('video');
                if($video_tmp->isValid()){
                    //$videoname=$video_tmp->getClientOriginalName();
                    $extension=$video_tmp->getClientOriginalExtension();
                    $videoName= rand(111,99999).'.'.$extension;
                    $videopath='front/Video/productvideo/';
                    $video_tmp->move($videopath,$videoName);
                    $product->product_video = $videoName;
                }
            }



           $categoryDetails=Category::find($data['category_id']);
           $product->section_id = $categoryDetails['section_id'];
           $product->category_id=$data['category_id'];
           $product->brand_id=$data['brand_id'];

           $adminType =Auth::guard('admin')->user()->type;
           $vendor_id =Auth::guard('admin')->user()->vendor_id;
           $admin_id =Auth::guard('admin')->user()->id;

           $product->admin_type=$adminType;
           $product->admin_id=$admin_id;
             if($adminType=="vendor")
             {
           $product->vendor_id=$vendor_id;
             }
             else{
                $product->vendor_id=0;
             }

             if(empty($data['productdiscount']))
             {
                $data['productdiscount']=0;
             }
             if(empty($data['productweight']))
             {
                $data['productweight']=0;
             }
 $product->product_name=$data['productname'];
 $product->product_code=$data['productcode'];
 $product->product_color=$data['productcolor'];
 $product->product_price=$data['productprice'];
 $product->product_discount=$data['productdiscount'];
 $product->product_weight=$data['productweight'];
 $product->description=$data['productdescription'];
 $product->meta_title=$data['metatitle'];
 $product->meta_description=$data['metadescription'];
 $product->meta_keywords=$data['metakeywords'];
 if(!empty($data['is_featured'])){
    $product->is_featured=$data['is_featured'];
 }else
 {
    $product->is_featured="No";

 }
 if(!empty($data['is_bestseller'])){
    $product->is_bestseller=$data['is_bestseller'];
 }else
 {
    $product->is_bestseller="No";

 }
 $product->status=1;
 $product->save();

 return redirect('admin/products')->with('success_message',$message);

             }


          $categories=Section::with('categories')->get()->toArray();
          $brands=Brand::where('status',1)->get()->toArray();




            return view('admin.products.add_edit_product')->with(compact('title','product','categories','brands'));
         }

      public function   deleteproductimage($id)
      {
        $productImage = Product::select('product_image')->where('id',$id)->first();
        $smallimagepath='front/images/product/small/';
        $mediumimagepath='front/images/product/medium/';
        $largeimagepath='front/images/product/large/';

        if(file_exists($smallimagepath.$productImage->product_image))
        {
            unlink($smallimagepath.$productImage->product_image);
        }
        if(file_exists($mediumimagepath.$productImage->product_image))
        {
            unlink($mediumimagepath.$productImage->product_image);
        }
        if(file_exists($largeimagepath.$productImage->product_image))
        {
            unlink($largeimagepath.$productImage->product_image);
        }

        Product::where('id', $id)->update(['product_image' =>'']);
        $message="Product Image Has Been deleted Successfully";
        return redirect()->back()->with('success_message',$message);
      }
      public function deleteproductvideo($id)
      {
        $productvideo = Product::select('product_video')->where('id',$id)->first();
        $productvideopath= 'front/Video/productvideo/';
        if(file_exists($productvideopath.$productvideo->product_video))
        {
            unlink($productvideopath.$productvideo->product_video);
        }
        Product::where('id', $id)->update(['product_video' =>'']);
        $message="Product Video Has Been deleted Successfully";
        return redirect()->back()->with('success_message',$message);

      }

      public function addattributes(Request $request , $id){

      $product=Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('attributes')->find($id);
      //$product=json_decode(json_encode($product),true);
      //dd($product);
      if($request->isMethod('post'))
      {
        $data=$request->all();
       foreach($data['sku'] as $key =>$value){
        if(!empty($value))
        {
          $skuCount=ProductsAttributes::where('sku',$value)->count();
          if($skuCount>0){

            return redirect()->back()->with('error_message',"SKU Already Exists!!");
           }

           $sizeCount = ProductsAttributes::where([
            'product_id' => $id,
            'size' => $data['size'][$key]
        ])->count();

        if ($sizeCount > 0) {
            return redirect()->back()->with('error_message', "Size Already Exists!!");
        }

            $attribute=new ProductsAttributes;
            $attribute->product_id=$id;
            $attribute->sku=$value;
            $attribute->size=$data['size'][$key];
            $attribute->price=$data['price'][$key];
            $attribute->stock=$data['stock'] [$key];
            $attribute->status=1;
            $attribute->save();

        }
       }
       $message="Product Attributes Has Been Added  Successfully";
       return redirect()->back()->with('success_message',$message);
      }
      return view('admin.attributes.addedit_attributes')->with(compact('product'));

      }
     public function  updateAttributeStatus(Request $request){
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
           ProductsAttributes::where('id',$data['attribute_id'])->update(['status'=>$status]);
           return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
     }
     public function editattributes(Request $request ,$id)
     {
     if($request->isMethod('post'))
     {
        $data=$request->all();
foreach($data['attributeid'] as $key =>$attribute){

    if(!empty($attribute)){
        ProductsAttributes::where(['id' =>$data['attributeid'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
    }


}
$message="Product Attributes Has Been Updated Successfully";
       return redirect()->back()->with('success_message',$message);
     }
     }

     public function  addimages($id,Request $request){
        $product=Product::select('id','product_name','product_code','product_color','product_price','product_image')->with('images')->find($id);

        if($request->isMethod('post')){
           if($request->hasFile('images')){
           $images= $request->file('images');
           foreach($images as $key =>$image)
           {
            $image_tmp=Image::make($image);
            $image_name=$image->getClientOriginalName();

                $extension=$image->getClientOriginalExtension();
                $imageName = pathinfo($image_name, PATHINFO_FILENAME) . '_' . rand(111, 99999) . '.' . $extension;

                $imagelargepath='front/images/product/large/'.$imageName;
                $imagemediumpath='front/images/product/medium/'.$imageName;
                $imagesmallpath='front/images/product/small/'.$imageName;
             Image::make($image_tmp)->resize(1000,1000)->save($imagelargepath);
             Image::make($image_tmp)->resize(500,500)->save($imagemediumpath);
             Image::make($image_tmp)->resize(250,250)->save($imagesmallpath);

             $image= new ProductsImage;

             $image->image = $imageName;
             $image->product_id = $id;
             $image->status=1;
             $image->save();


           }
           }
           $message="Images Has Been Updated Successfully";
       return redirect()->back()->with('success_message',$message);
        }

        return view('admin.images.addedit_images')->with(compact('product'));

     }
     public function updateimageStatus(Request $request)
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
           ProductsImage::where('id',$data['image_id'])->update(['status'=>$status]);
           return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
        }
     }
     public function deleteimage($id){

        $productImage = ProductsImage::select('image')->where('id',$id)->first();
        $smallimagepath='front/images/product/small/';
        $mediumimagepath='front/images/product/medium/';
        $largeimagepath='front/images/product/large/';

        if(file_exists($smallimagepath.$productImage->image))
        {
            unlink($smallimagepath.$productImage->image);
        }
        if(file_exists($mediumimagepath.$productImage->image))
        {
            unlink($mediumimagepath.$productImage->image);
        }
        if(file_exists($largeimagepath.$productImage->image))
        {
            unlink($largeimagepath.$productImage->image);
        }

        ProductsImage::where('id', $id)->delete();
        $message="Product Image Has Been deleted Successfully";
        return redirect()->back()->with('success_message',$message);

     }
    }