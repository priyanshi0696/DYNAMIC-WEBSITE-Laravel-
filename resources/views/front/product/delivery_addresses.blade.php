@extends('front.layout.layout')
@section('content')
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Delivery Address</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="">Home</a>
                </li>
                <li class="is-marked">
                    <a href="#">Checkout</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">

            <div class="row">
                <!-- Billing-&-Shipping-Details -->
<div class="col-lg-8" id="deliveryAddress">
@if(count($deliveryAddresses)>0)
<br>
<br>
<h4 class="section-h4"><center>Delivery Address</center></h4>
@foreach($deliveryAddresses as $address)
<div class="control-group" style="float:left; margin-right:5px;">
    <input type="radio" id="{{ $address['id'] }}" name="address_id" value="{{ $address['id'] }}"></div>

<div><label class="control-label">{{ $address['name'] }},{{ $address['address'] }},{{ $address['city'] }},{{ $address['state'] }},{{ $address['country'] }},({{ $address['mobile'] }})</label>
    <a  style="float:right; margin-left: 10px ;"  href="{{ url('/checkout/'.$address['id']) }}" class="checkout"> Checkout</a>
    <a style="float:right; margin-left: 10px ;" href="javascript:;" data-addressid="{{ $address['id'] }}" class="removeAddress">Remove</a>
<a style="float:right" href="javascript:;" data-addressid="{{ $address['id'] }}" class="editAddress">Edit</a>
</div>

                            @endforeach<br>
                            @endif

                            <h4 class="section-h4 deliveryText">Add New Delivery Address</h4>
                            <div class="u-s-m-b-24">
                                <input type="checkbox" class="check-box" id="ship-to-different-address" data-toggle="collapse" data-target="#showdifferent">
                                <label class="label-text newAddress" for="ship-to-different-address">Ship to a different address?</label>
                            </div>



                            <div class="collapse" id="showdifferent">
                                <form id="addressformaddedit" action="javascript:;" method="post">@csrf
                                    <input type="hidden" name="delivery_id">
                                    <div class="group-inline u-s-m-b-13">
                                        <div class="group-1 u-s-p-r-16">
                                            <label for="name">Name
                                                <span class="astk">*</span>
                                            </label>
                                            <input type="text" id="name"  name="name" class="text-field">
                                        </div>
                                        <div class="group-2">
                                            <label for="address">Address
                                                <span class="astk">*</span>
                                            </label>
                                            <input type="text" id="address" name="address" class="text-field">
                                        </div>
                                    </div>
                                    <div class="group-inline u-s-m-b-13">
                                        <div class="group-1 u-s-p-r-16">
                                            <label for="city">City
                                                <span class="astk">*</span>
                                            </label>
                                            <input type="text" id="city"  name="city" class="text-field">
                                        </div>
                                        <div class="group-2">
                                            <label for="state">State
                                                <span class="astk">*</span>
                                            </label>
                                            <input type="text" id="state" name="state" class="text-field">
                                        </div>
                                    </div>
                                    <div class="group-inline u-s-m-b-13">
                                        <div class="group-1 u-s-p-r-16">
                                            <label for="country">Country
                                                <span class="astk">*</span>
                                            </label>
                                            <input type="text" id="country"  name="country" class="text-field">
                                        </div>
                                        <div class="group-2">
                                            <label for="pincode">Pincode
                                                <span class="astk">*</span>
                                            </label>
                                            <input type="text" id="pincode" name="pincode" class="text-field">
                                        </div>
                                    </div>
                                    <div class="group-inline u-s-m-b-13">
                                        <div class="group-1 u-s-p-r-16">
                                            <label for="email">Email
                                                <span class="astk">*</span>
                                            </label>
                                            <input type="text" id="email"  name="email" class="text-field">
                                        </div>
                                        <div class="group-2">
                                            <label for="mobile">Mobile
                                                <span class="astk">*</span>
                                            </label>
                                            <input type="text" id="mobile" name="mobile" class="text-field">
                                        </div>
                                    </div>
                                    <div class="u-s-m-b-13">
                                        <button style="width: 100%;" type="submit" class="button button-outline-secondary">Save</button>
                                    </div>

                                </form>
                            </div>




                            <!-- Form-Fields /- -->

                </div>
            </div>
        </div>
    </div>
            @endsection
