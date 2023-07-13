@extends('admin.layout.layout')
@section('content')

<div class="main-panel">

        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold"></h3>
                  <h6 class="font-weight-normal mb-0"></h6>
                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">
                  <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                    <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                     <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                      <a class="dropdown-item" href="#">January - March</a>
                      <a class="dropdown-item" href="#">March - June</a>
                      <a class="dropdown-item" href="#">June - August</a>
                      <a class="dropdown-item" href="#">August - November</a>
                    </div>
                  </div>
                 </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">{{ $title }}</h4>
                  <p class="card-description">

                  </p>
                  @if(Session::has('error_message'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error:</strong> {{Session::get('error_message')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
@if(Session::has('success_message'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success:</strong> {{Session::get('success_message')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">


            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
           </button>

    </div>
@endif
                  <form class="forms-sample" @if(empty($product['id'])) action="{{ url('admin/add-edit-product')}}" @else action="{{ url('admin/add-edit-product/'.$product['id'])}}" @endif method="post" name="updateproductform" id="updateproductform" enctype="multipart/form-data">
                    @csrf
                   <div class="form-group">
                    <label for="category_id">Select Category</label>
                    <select name="category_id" id="category_id" class="form-control" style="color:black">
                        <option value="">Select</option>
                        @foreach($categories as $section)
                        <optgroup label="{{ $section['name'] }}"></optgroup>
                        @foreach($section['categories'] as $category)
                        <option  @if (!empty($product['category_id']== $category['id'])) selected="" @endif value="{{$category['id']}}">&nbsp;&nbsp;&nbsp;---&nbsp;{{$category['category_name']}}</option>
                        @foreach($category['subcategories'] as $subcategory)
                        <option  @if (!empty($product['category_id']== $subcategory['id'])) selected="" @endif  value="{{$subcategory['id']}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp-&nbsp;{{$subcategory['category_name']}}</option>
                        @endforeach
                        @endforeach
                        @endforeach
                    </select>
                   </div>
                   <div class="form-group">
                    <label for="brand_id">Select Brand</label>
                    <select name="brand_id" id="brand_id" class="form-control" style="color:black">
                        <option value="">Select</option>
                        @foreach($brands as $brand)
                        <option @if (!empty($product['brand_id']== $brand['id'])) selected="" @endif  value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                        @endforeach
                    </select>
                   </div>
                  <div class="form-group">
                      <label for="productname">Product Name</label>
                      <input type="text" class="form-control" id="productname" name="productname" placeholder="Product Name"  @if (!empty($product['product_name'])) value="{{ $product['product_name'] }}" @else value="{{ old('productname') }}" @endif >
                    </div>
                    <div class="form-group">
                        <label for="productcode">Product Code</label>
                        <input type="text" class="form-control" id="productcode" name="productcode" placeholder="Product Code"  @if (!empty($product['product_code'])) value="{{ $product['product_code'] }}" @else value="{{ old('productcode') }}" @endif >
                      </div>
                      <div class="form-group">
                        <label for="productcolor">Product Color</label>
                        <input type="text" class="form-control" id="productcolor" name="productcolor" placeholder="Product Color"  @if (!empty($product['product_color'])) value="{{ $product['product_color'] }}" @else value="{{ old('productcolor') }}" @endif >
                      </div>
                      <div class="form-group">
                        <label for="productprice">Product Price</label>
                        <input type="text" class="form-control" id="productprice" name="productprice" placeholder="Product Price"  @if (!empty($product['product_price'])) value="{{ $product['product_price'] }}" @else value="{{ old('productprice') }}" @endif >
                      </div>
                      <div class="form-group">
                        <label for="productdiscount">Product Discount (%)</label>
                        <input type="text" class="form-control" id="productdiscount" name="productdiscount" placeholder="Product Discount"  @if (!empty($product['product_discount'])) value="{{ $product['product_discount'] }}" @else value="{{ old('productdiscount') }}" @endif >
                      </div>
                      <div class="form-group">
                        <label for="productweight">Product Weight</label>
                        <input type="text" class="form-control" id="productweight" name="productweight" placeholder="Product Weight"  @if (!empty($product['product_weight'])) value="{{ $product['product_weight'] }}" @else value="{{ old('productweight') }}" @endif >
                      </div>
                    <div class="form-group">
                      <label for="image">Product Image</label>
                      <input type="file" class="form-conrol" id="image"name="image">
                      @if(!empty($product['product_image']))
                      <a target ="_blank" href="{{ url('front/images/product/small/'.$product['product_image']) }}">ViewImage</a>&nbsp;|&nbsp;
                      <a class="confirmDelete" module="product-image" moduleid="{{$product['id']}}" href ="javascript:void(0)">Delete Image</a>
                      @endif

                    </div>
                    <div class="form-group">
                        <label for="video">Product Video</label>
                        <input type="file" class="form-control" id="video"name="video" >
                        @if(!empty($product['product_video']))
                        <a target ="_blank" href="{{ url('front/Video/productvideo/'.$product['product_video']) }}">ViewVideo</a>&nbsp;|&nbsp;
                        <a class="confirmDelete" module="product-video" moduleid="{{$product['id']}}" href ="javascript:void(0)">Delete Video</a>
                        @endif

                      </div>

                    <div class="form-group">
                      <label for="productdescription">Product Description</label>
                      <textarea class="form-control"id="productdescription" name="productdescription" rows="3">{{ $product['description'] }}</textarea>

                    </div>

                    <div class="form-group">
                      <label for="meta title">Meta Title</label>
                      <input type="text" class="form-control" id="metatitle" name="metatitle" placeholder="Meta Title"  @if (!empty($product['meta_title'])) value="{{ $product['meta_title'] }}" @else value="{{ old('metatitle') }}" @endif >
                    </div>
                    <div class="form-group">
                      <label for="meta description">Meta Description</label>
                      <input type="text" class="form-control" id="metadescription" name="metadescription" placeholder="Meta Description"  @if (!empty($product['meta_description'])) value="{{ $product['meta_description'] }}" @else value="{{ old('metadescription') }}" @endif >
                    </div>
                    <div class="form-group">
                      <label for="meta keywords">Meta Keywords</label>
                      <input type="text" class="form-control" id="metakeywords" name="metakeywords" placeholder="metakeywords"  @if (!empty($product['meta_keywords'])) value="{{ $product['meta_keywords'] }}" @else value="{{ old('metakeywords') }}" @endif >
                    </div>

                    <div class="form-group">
                        <label for="featuresitem">Features Item</label>
                        <input type="checkbox" name="is_featured" id="is_featured" value="Yes"
                        @if(!empty($product['is_featured']) && $product['is_featured'] =="Yes")checked=""@endif >
                    </div>
                    <div class="form-group">
                      <label for="bestseller">Best Seller</label>
                      <input type="checkbox" name="is_bestseller" id="is_bestseller" value="Yes"
                      @if(!empty($product['is_bestseller']) && $product['is_bestseller'] =="Yes")checked=""@endif >
                  </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>










          </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->

        <!-- partial -->
      </div>




@endsection
