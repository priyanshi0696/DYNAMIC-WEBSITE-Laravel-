@extends('admin.layout.layout')
@section('content')

<div class="main-panel">

        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Banners Management</h3>
                  <h5 class="font-weight-normal mb-0">Banner</h5>
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
                  <form class="forms-sample" @if(empty($banner['id'])) action="{{ url('admin/add-banner')}}" @else action="{{ url('admin/add-banner/'.$banner['id'])}}" @endif method="post" name="updateadminform" id="updateadminform" enctype="multipart/form-data">
                    @csrf

                   
                   
                    
                      <div class="form-group">
                        <label for="image">Banner Image</label>
                        <input type="file" class="form-control" id="image"name="image" >
                        @if(!empty($banner['image']))
                        <a target ="_blank" href="{{ url('front/images/bannerimage/'.$banner['image']) }}">ViewImage</a>&nbsp;|&nbsp;
                       
                        @endif

                      </div>
                     
                      <div class="form-group">
                        <label for="bannername">Banner Link</label>
                        <input type="text" class="form-control" id="link" name="link" placeholder="bannerLink"  @if (!empty($banner['link'])) value="{{ $banner['link'] }}" @else value="{{ old('link') }}" @endif required>
                      </div>
                      <div class="form-group">
                        <label for="bannername">Banner Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="banner Title"  @if (!empty($banner['title'])) value="{{ $banner['title'] }}" @else value="{{ old('title') }}" @endif required>
                      </div>
                      <div class="form-group">
                        <label for="bannername">Banner Alternate Text</label>
                        <input type="text" class="form-control" id="alt" name="alt" placeholder="banner Alt"  @if (!empty($banner['alt'])) value="{{ $banner['alt'] }}" @else value="{{ old('alt') }}" @endif required>
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
