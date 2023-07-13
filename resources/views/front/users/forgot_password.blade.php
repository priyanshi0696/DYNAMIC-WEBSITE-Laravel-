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
                    <h2 class="account-h2 u-s-m-b-20">Forgot Password</h2>
                    <h6 class="account-h6 u-s-m-b-30">Welcome back! Sign in to your account.</h6>
                    <p id="forgot-success"></p>
                    <form id="forgotform"  action="javascript:;" method="post">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="user-email"> Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" name="email"  id="usersemail" class="text-field" placeholder="Username / Email">
                            <p id="forgot-email"></p>
                        </div>
                        <div class="m-b-45">
                            <button type= "submit" class="button button-outline-secondary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Login /- -->
            <!-- Register -->
            <div class="col-lg-6">
                <div class="reg-wrapper">
                    <h2 class="account-h2 u-s-m-b-20">Register</h2>
                    <h6 class="account-h6 u-s-m-b-30">Registering for this site allows you to access your order status and history.</h6>
                    <p id="register-success"></p>
                    <form id="registerform" action="javascript:;" method="post">@csrf
                        <div class="u-s-m-b-30">
                            <label for="name">Name

                            </label>
                            <input type="text" id="name"  name="name" class="text-field" placeholder="Name" >
                            <p id="register-name"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="Address">Address

                            </label>
                            <input type="text" id="address"  name="address" class="text-field" placeholder="Address" >
                            <p id="register-address"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="city">City

                            </label>
                            <input type="text" id="city"  name="city" class="text-field" placeholder="City" >
                            <p id="register-city"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="state">State

                            </label>
                            <input type="text" id="state"  name="state" class="text-field" placeholder="State" >
                            <p id="register-state"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="country">Country

                            </label>
                            <input type="text" id="country"  name="country" class="text-field" placeholder="Country" >
                            <p id="register-country"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="pincode">Pincode

                            </label>
                            <input type="text" id="pincode"  name="pincode" class="text-field" placeholder="Pincode" >
                            <p id="register-pincode"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="mobile">Mobile
                                <span class="astk">*</span>
                            </label>
                            <input type="text" id="mobile"  name="mobile" class="text-field" placeholder="Mobile">
                            <p id="register-mobile"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="email">Email
                                <span class="astk">*</span>
                            </label>
                            <input type="text" id="email" name="email" class="text-field" placeholder="Email">
                            <p id="register-email"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="password">Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" id="password" name="password" class="text-field" placeholder="Password">
                            <p id="register-password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <input type="checkbox" name="accept" class="check-box" id="accept">

                            <label class="label-text no-color" for="accept">I’ve read and accept the
                                <a href="terms-and-conditions.html" class="u-c-brand">terms & conditions</a>
                            </label>
                            <p id="register-accept"></p>
                        </div>
                        <div class="u-s-m-b-45">
                            <button class="button button-primary w-100">Register</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Register /- -->
        </div>
    </div>
</div>
@endsection
