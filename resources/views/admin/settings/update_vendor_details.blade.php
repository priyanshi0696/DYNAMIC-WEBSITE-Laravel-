@extends('admin.layout.layout')
@section('content')


<div class="main-panel">

        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Update Vendor Details</h3>
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
          @if($slug=="personal")
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Update Personal Information</h4>
                  <p class="card-description"></p>
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
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal')}}" method="post" name="updateadminform" id="updateadminform" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="exampleInputUsername1">Vendor Username/Email</label>
                      <input type="text" class="form-control" id="email" value="{{ Auth::guard('admin')->user()->email}}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{Auth::guard('admin')->user()->name}}"required>
                    </div>
                    <div class="form-group">
                      <label for="mobile">Mobile</label>
                      <input type="text" class="form-control" id="mobile"name="mobile" placeholder="Conatct Number"value="{{Auth::guard('admin')->user()->mobile }}" maxlength="10" minlength="10" required>
                    </div>
                    <div class="form-group">
                      <label for="address">Address</label>
                      <input type="text" class="form-control" id="address"name="address" placeholder="Address"value="{{$vendorDetails['address']}}"  required>
                    </div>
                    <div class="form-group">
                      <label for="city">City</label>
                      <input type="text" class="form-control" id="city"name="city" placeholder="City"value="{{$vendorDetails['city'] }}"  required>
                    </div>
                    <div class="form-group">
                      <label for="state">State</label>
                      <input type="text" class="form-control" id="state"name="state" placeholder="State"value="{{$vendorDetails['state']  }}"  required>
                    </div>
                    <div class="form-group">
                      <label for="country">Country</label>

                      <select class="form-control" id="country" name="country">
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                        <option value="{{ $country['country_name'] }}" @if($country['country_name'] ==$vendorDetails['country']) selected @endif >{{$country['country_name']}}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="pincode">Pincode</label>
                      <input type="text" class="form-control" id="pincode"name="pincode" placeholder="Pincode"value="{{$vendorDetails['pincode']  }}" required>
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
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>



            @elseif($slug=="bussiness")
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Update Bussiness Information</h4>
                      <p class="card-description"></p>
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
                      <form class="forms-sample" action="{{ url('admin/update-vendor-details/bussiness')}}" method="post" name="updateadminform" id="updateadminform" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="email">Vendor Username/Email</label>
                          <input type="text" class="form-control" id="email" value="{{ Auth::guard('admin')->user()->email}}" readonly>
                        </div>

                        <div class="form-group">
                          <label for="shopname">Shop Name</label>
                          <input type="text" class="form-control" id="shopname" name="shopname" placeholder="ShopName" @if(isset($vendorDetails['shop_name'])) value="{{$vendorDetails['shop_name'] }}"  @endif required>
                        </div>
                        <div class="form-group">
                          <label for="mobile">Shop Mobile</label>
                          <input type="text" class="form-control" id="shopmobile"name="shopmobile" placeholder="Shop Number"   @if(isset($vendorDetails['shop_mobile'])) value="{{$vendorDetails['shop_mobile']  }}" @endif maxlength="10" minlength="10" required>
                        </div>
                        <div class="form-group">
                          <label for="shop_address">Shop Address</label>
                          <input type="text" class="form-control" id="shopaddress"name="shopaddress" placeholder="Shop Address"  @if(isset($vendorDetails['shop_address']))value="{{$vendorDetails['shop_address']}}" @endif required>
                        </div>
                        <div class="form-group">
                          <label for="shop_city">Shop City</label>
                          <input type="text" class="form-control" id="shopcity"name="shopcity" placeholder="shopCity"  @if(isset($vendorDetails['shop_city'])) value="{{$vendorDetails['shop_city'] }}" @endif  required>
                        </div>
                        <div class="form-group">
                          <label for="shopstate">Shop State</label>
                          <input type="text" class="form-control" id="shopstate"name="shopstate" placeholder="ShopState"  @if(isset($vendorDetails['shop_state'])) value="{{$vendorDetails['shop_state']  }}"  @endif required>
                        </div>
                        <div class="form-group">
                          <label for="shopcountry">Shop Country</label>

                          <select class="form-control" id="shopcountry" name="shopcountry">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                            <option value="{{ $country['country_name'] }}" @if(isset($vendorDetails['shop_country']) && $country['country_name'] ==$vendorDetails['shop_country']) selected @endif >{{$country['country_name']}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="shoppincode">Shop Pincode</label>
                          <input type="text" class="form-control" id="shoppincode"name="shoppincode" placeholder="ShopPincode"  @if(isset($vendorDetails['shop_pincode']))value="{{$vendorDetails['shop_pincode']  }}" @endif required>
                        </div>
                        <div class="form-group">
                            <label for="addressproof">Address Proof</label>
                            <select class="form-control" name="address_proof" id="address_proof">
                              <option value="Passport" @if(isset($vendorDetails['shop_addressproof']) && $vendorDetails['shop_addressproof']=="Passport")selected @endif>Passport</option>
                               <option value="Voting Card"  @if(isset($vendorDetails['shop_addressproof']) && $vendorDetails['shop_addressproof']=="Voting Card")selected @endif>Voting Card</option>
                                <option value="PAN"  @if(isset($vendorDetails['shop_addressproof']) && $vendorDetails['shop_addressproof']=="PAN")selected @endif>PAN</option>
                                 <option value="Driving License"  @if(isset($vendorDetails['shop_addressproof']) && $vendorDetails['shop_addressproof']=="Driving License")selected @endif>Driving License</option>
                                  <option value="Aadhar Card"  @if(isset($vendorDetails['shop_addressproof']) && $vendorDetails['shop_addressproof']=="Aadhar Card") selected @endif>Aadhar Card</option>
                            </select>
                          </div>
                           <div class="form-group">
                          <label for="bussinesslicencenumber">Bussiness Licence Number</label>
                          <input type="text" class="form-control" id="licencenumber"name="licencenumber" placeholder="ShopCountry"  @if(isset($vendorDetails['bussiness_licence_number']))value="{{$vendorDetails['bussiness_licence_number']  }}"  @endif  required>
                        </div>
                         <div class="form-group">
                          <label for="gstnumber">GST Number</label>
                          <input type="text" class="form-control" id="gstnumber"name="gstnumber"  @if(isset($vendorDetails['gst_number'])) value="{{$vendorDetails['gst_number']  }}" @endif required>
                        </div>
                         <div class="form-group">
                          <label for="pannumber">PAN Number</label>
                          <input type="text" class="form-control" id="pannumber"name="pannumber"  @if(isset($vendorDetails['pan_number'])) value="{{$vendorDetails['pan_number']  }}" @endif required>
                        </div>

                        <div class="form-group">
                          <label for="image">AddressProofImage</label>
                          <input type="file" class="form-control" id="addressproofimage"name="addressproofimage" >
                          @if(!empty($vendorDetails['addressproofimage']))
                           <a target="_blank"  href="{{url('admin/images/proofs/'.$vendorDetails['addressproofimage'])}}">ViewImage</a>
                           <input type="hidden" name="current_image" value="{{$vendorDetails['addressproofimage']}}"/>
                          @endif
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button type="reset"  class="btn btn-light">Cancel</button>
                      </form>
                    </div>
                  </div>
                </div>
            @elseif($slug=="bank")
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Update Bank Information</h4>
                      <p class="card-description"></p>
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
                      <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank')}}" method="post" name="updateadminform" id="updateadminform" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="email">Vendor Username/Email</label>
                          <input type="text" class="form-control" id="email" value="{{ Auth::guard('admin')->user()->email}}" readonly>
                        </div>

                        <div class="form-group">
                          <label for="accountholdername">Account HolderName</label>
                          <input type="text" class="form-control" id="accountholdername" name="accountholdername" @if(isset($vendorDetails['account_holder_name']))  value="{{$vendorDetails['account_holder_name'] }}" @endif>
                        </div>
                        <div class="form-group">
                          <label for="bankname">Bank Name</label>
                          <input type="text" class="form-control" id="bankname"name="bankname"@if(isset($vendorDetails['bank_name'])) value="{{$vendorDetails['bank_name']  }}" @endif  >
                        </div>
                        <div class="form-group">
                          <label for="bankifsc">Bank IFSC Code</label>
                          <input type="text" class="form-control" id="bankifsc"name="bankifsc" @if(isset($vendorDetails['bank_ifsc_code'])) value="{{$vendorDetails['bank_ifsc_code']}}" @endif  >
                        </div>
                        <div class="form-group">
                          <label for="accountnumber">Account Number</label>
                          <input type="text" class="form-control" id="accountnumber"name="accountnumber"@if(isset($vendorDetails['account_number'])) value="{{$vendorDetails['account_number'] }}" @endif  >
                        </div>

                     <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                      </form>
                    </div>
                  </div>
                </div>

            @endif







          </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->

        <!-- partial -->
      </div>
      @endsection



