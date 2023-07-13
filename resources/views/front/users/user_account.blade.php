@extends('front.layout.layout')
@section('content')

<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Account</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="index.html">Home</a>
                </li>
                <li class="is-marked">
                    <a href="account.html">Account</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Account-Page -->
<div class="page-account u-s-p-t-80">
    <div class="container">
        @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success:</strong> {{Session::get('success_message')}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        @if(Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Error:</strong> {{Session::get('error_message')}}
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
        <div class="row">

            <!-- Login -->
            <div class="col-lg-6">
                <div class="login-wrapper">

                    <h2 class="account-h6 u-s-m-b-20">Update Contact Details</h2>
                    <p id="account-error"></p>
                    <form id="accountform"  action="javascript:;" method="post">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="password">Current Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="cpassword"  id="cpassword" class="text-field" placeholder="Password">
                            <p id="password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="password">New Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name= "newpassword" id="newpassword" class="text-field" placeholder="Password">
                            <p id="account-password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="confirmpassword">Confirm Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name= "confirmpassword" id="confirmpassword" class="text-field" placeholder="Password">
                            <p id="account-password"></p>
                        </div>


                        <div class="m-b-45">
                            <button class="button button-outline-secondary w-100">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Login /- -->
            <!-- Register -->


            <!-- Register /- -->
        </div>
    </div>
</div>
@endsection
