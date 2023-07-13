<?php use App\Models\Product;?>

<div class="container">
    <div class="page-intro">
        <h2>Cart</h2>
        <ul class="bread-crumb">
            <li class="has-separator">
                <i class="ion ion-md-home"></i>
                <a href="index.html">Home</a>
            </li>
            <li class="is-marked">
                <a href="cart.html">Cart</a>
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
        <div class="col-lg-12">
            <form>
                <!-- Products-List-Wrapper -->
                <div class="table-wrapper u-s-m-b-60">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total_price=0 @endphp
                            @foreach($getCartItems as $item)
                            <?php $getDiscountAttributePrice=Product:: getDiscountAttributePrice($item['product_id'],$item['size'])
                            ?>
                            <tr>
                                <td>
                                    <div class="cart-anchor-image">
                                        <a href="{{ url('product/'.$item['product_id']) }}">
                                            <img src="{{ asset('front/images/product/small/'.$item['product']['product_image']) }}" alt="Product">
                                            <h6>{{ $item['product']['product_name'] }}({{$item['product']['product_code']  }})-
                                                {{ $item['size'] }}<br>
                                                Color:-{{ $item['product']['product_color'] }}



                                            </h6>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="cart-price">
                                        @if($getDiscountAttributePrice['discount']>0)
                                        <div class="price-template">
                                            <div class="item-new-price">
                                               Rs.{{$getDiscountAttributePrice['final_price']}}
                                            </div>
                                            <div class="item-old-price"style="margin-left:-40px;">
                                               Rs.{{$getDiscountAttributePrice['product_price']}}
                                            </div>
                                        </div>
                                        @else
                                        <div class="price-template">
                                            <div class="item-new-price" >
                                                Rs.{{$getDiscountAttributePrice['final_price']}}
                                            </div>

                                        </div>
                                        @endif

                                    </div>
                                </td>
                                <td>
                                    <div class="cart-quantity">
                                        <div class="quantity">
                                            <input type="text" class="quantity-text-field" value="{{ $item['quantity'] }}">
                                            <a class="plus-a updateCartItem " data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" data-max="1000">&#43;</a>
                                            <a class="minus-a updateCartItem"  data-cartid="{{ $item['id'] }}" data-qty="{{ $item['quantity'] }}" data-min="1">&#45;</a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="cart-price">
                                       Rs.{{$getDiscountAttributePrice['final_price'] * $item['quantity'] }}
                                    </div>
                                </td>
                                <td>
                                    <div class="action-wrapper">
                                       <!--- <button class="button button-outline-secondary fas fa-sync"></button> -->
                                        <button class="button button-outline-secondary fas fa-trash deletecartitem" data-cartid="{{ $item['id'] }}"></button>
                                    </div>
                                </td>
                            </tr>
                            @php  $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['quantity'] ) @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- Products-List-Wrapper /- -->
                <!-- Coupon -->
                <div class="coupon-continue-checkout u-s-m-b-60">

                    <div class="button-area">
                       <!-- <a href="shop-v1-root-category.html" class="continue">Continue Shopping</a>-->
                        <a href="{{ url('/deliveryaddress') }}" class="checkout">Proceed to Checkout</a>
                    </div>
                </div>
                <!-- Coupon /- -->
            </form>
            <!-- Billing -->
            <div class="calculation u-s-m-b-60">
                <div class="table-wrapper-2">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Cart Totals</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <h3 class="calc-h3 u-s-m-b-0">Sub Total</h3>
                                </td>
                                <td>
                                    <span class="calc-text">Rs.{{$total_price  }}</span>
                                </td>
                            </tr>


                            <tr>
                                <td>
                                    <h3 class="calc-h3 u-s-m-b-0"> Grand Total</h3>
                                </td>
                                <td>
                                    <span class="calc-text">Rs.{{$total_price  }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Billing /- -->
        </div>
    </div>
</div>
</div>









