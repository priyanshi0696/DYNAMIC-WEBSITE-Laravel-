@extends('admin.layout.layout')
@section('content')

<div class="main-panel">

        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Catalogue Management</h3>
                  <h5 class="font-weight-normal mb-0">Categories</h5>
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
                  <form class="forms-sample" @if(empty($category['id'])) action="{{ url('admin/add-edit-category')}}" @else action="{{ url('admin/add-edit-category/'.$category['id'])}}" @endif method="post" name="updateadminform" id="updateadminform" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                      <label for="categoryname">Category Name</label>
                      <input type="text" class="form-control" id="categoryname" name="categoryname" placeholder="Category Name"  @if (!empty($category['category_name'])) value="{{ $category['category_name'] }}" @else value="{{ old('categoryname') }}" @endif required>
                    </div>
                    <div class="form-group">
                        <label for="sectionname">Section Name</label>
                        <select name="sectionid" id="sectionid" class="form-control" style="color:#000;">
                            <option value="">Select</option>
                            @foreach($getSections as $section)
                            <option value="{{ $section['id'] }}" @if(!empty($category['section_id']) && $category['section_id']==$section['id']) selected="" @endif>{{ $section['name'] }}</option>
                            @endforeach
                        </select>
                      </div>
                     <div id="appendCategoriesLevel">
                        @include('admin.categories.append_categorieslevel')
                     </div>
                      <div class="form-group">
                        <label for="image">Category Image</label>
                        <input type="file" class="form-control" id="image"name="image" >
                        @if(!empty($category['category_image']))
                        <a target ="_blank" href="{{ url('front/images/category/'.$category['category_image']) }}">ViewImage</a>&nbsp;|&nbsp;
                        <a class="confirmDelete" module="category-image" moduleid="{{$category['id']}}" href ="javascript:void(0)">Delete Image</a>
                        @endif

                      </div>
                      <div class="form-group">
                        <label for="categorydiscount">Category Discount</label>
                        <input type="text" class="form-control" id="categorydiscount" name="categorydiscount" placeholder="Category Discount"  @if (!empty($category['category_discount'])) value="{{ $category['category_discount'] }}" @else value="{{ old('categorydiscount') }}" @endif >
                      </div>
                      <div class="form-group">
                        <label for="categorydescription">Category Description</label>
                        <textarea class="form-control"id="categorydescription" name="categorydescription" rows="3"></textarea>

                      </div>
                      <div class="form-group">
                        <label for="url">URL</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="url"  @if (!empty($category['url'])) value="{{ $category['url'] }}" @else value="{{ old('url') }}" @endif >
                      </div>
                      <div class="form-group">
                        <label for="meta title">Meta Title</label>
                        <input type="text" class="form-control" id="metatitle" name="metatitle" placeholder="Meta Title"  @if (!empty($category['meta_title'])) value="{{ $category['meta_title'] }}" @else value="{{ old('metatitle') }}" @endif >
                      </div>
                      <div class="form-group">
                        <label for="meta description">Meta Description</label>
                        <input type="text" class="form-control" id="metadescription" name="metadescription" placeholder="Meta Description"  @if (!empty($category['meta_description'])) value="{{ $category['meta_description'] }}" @else value="{{ old('metadescription') }}" @endif >
                      </div>
                      <div class="form-group">
                        <label for="meta keywords">Meta Keywords</label>
                        <input type="text" class="form-control" id="metakeywords" name="metakeywords" placeholder="metakeywords"  @if (!empty($category['meta_keyword'])) value="{{ $category['meta_keyword'] }}" @else value="{{ old('metakeywords') }}" @endif >
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
