<?php use App\Models\Product;?>
@extends('front.layout.layout')
@section('content')

<div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Cart</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="#">Proceed to Payment</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Cart-Page -->
    <div class="page-cart u-s-p-t-80">
        <div class="container">
            <div class="row">

                <div class="col-lg-12" align="center">
<h3>Please Make Payment for your Order</h3>
<form action="{{ route('payment') }}" method="post">@csrf
    <input type="hidden" name="amount" value="{{ round(Session::get('grand_total')/80,2) }}">
    <input type="image" src="https://www.paypalobjects.com/webstatic/en_AU/i/buttons/btn_paywith_primary_l.png"/>

</form>

                </div>
            </div>
        </div>
    </div>

@endsection
