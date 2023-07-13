@extends('admin.layout.layout')
@section('content')


<div class="main-panel">

        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome {{Auth::guard('admin')->user()->name}}</h3>

                </div>
                <div class="col-12 col-xl-4">
                 <div class="justify-content-end d-flex">

                 </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Admin Details</h4>
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
                  <form class="forms-sample" action="{{ url('admin/update-admin-details')}}" method="post" name="updateadminform" id="updateadminform" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputUsername1">Admin Username/Email</label>
                      <input type="text" class="form-control" id="email" value="{{ Auth::guard('admin')->user()->email}}" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Admin Type</label>
                      <input type="email" class="form-control" id="type" value="{{Auth::guard('admin')->user()->type}}" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{Auth::guard('admin')->user()->name}}"required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Mobile</label>
                      <input type="text" class="form-control" id="mobile"name="mobile" placeholder="Conatct Number"value="{{Auth::guard('admin')->user()->mobile }}" maxlength="10" minlength="10" required>
                    </div>
                    <div class="form-group">
                      <label for="image">Image</label>
                      <input type="file" class="form-control" id="image"name="image" >
                      @if(!empty(Auth::guard('admin')->user()->image))
                       <a target="_blank"  href="{{url('admin/images/photos/'. Auth::guard('admin')->user()->image)}}">ViewImage</a>
                       <input type="hidden" name="current_image" value="{{Auth::guard('admin')->user()->image}}"/>
                      @endif
                    </div>

                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
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




