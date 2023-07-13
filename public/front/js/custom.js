$(document).ready(function () {
    //  $(".loader").show();
    $("#sort").on("change", function () {
        // this.form.submit();

        var sort = $("#sort").val();
        var url = $("#url").val();
        //alert(url);
        //return false;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'Post',
            data: { sort: sort, url: url },
            success: function (data) {
                $('.filter_products').html(data);

            }, error: function () {
                alert("Error");
            }
        })


    });

    $("#getPrice").change(function () {
        var size = $(this).val();
        var product_id = $(this).attr("product-id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/get-product-price',
            method: 'Post',
            data: { size: size, product_id: product_id },
            success: function (resp) {
                // alert(resp['discount']);
                if (resp['discount'] > 0) {

                    $(".getAttributePrice").html("<div class='price'><h4>Rs." + resp['final_price'] + "</h4></div><div class='orginal-price'><span>Original Price:</span><span>Rs." + resp['product_price'] + "</span></div>");

                } else {
                    //alert("test");
                    $(".getAttributePrice").html("<div class='price'><h4>Rs." + resp['final_price'] + "</h4></div>");
                }

            }, error: function () {
                alert("Error");
            }


        });
    });

    $(document).on('click', '.updateCartItem', function () {
        if ($(this).hasClass('plus-a')) {
            var quantity = $(this).data('qty');
            new_qty = parseInt(quantity) + 1;
            // alert(new_qty);

        }
        if ($(this).hasClass('minus-a')) {
            var quantity = $(this).data('qty');
            if (quantity <= 1) {
                alert("Item Quantity must be 1 or greater!");
                return false;

            }
            new_qty = parseInt(quantity) - 1;
            // alert(new_qty);

        }
        var cartid = $(this).data('cartid');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            data: { cartid: cartid, qty: new_qty },
            url: '/cart/update/',
            method: 'Post',
            success: function (resp) {
                if (resp.status == false) {
                    alert(resp.message);
                }
                $(".appendCartItems").html(resp.view);

            }, error: function () {
                alert("Error");
            }


        });

    });

    $(document).on('click', '.deletecartitem', function () {
        var cartid = $(this).data('cartid');
        var result = confirm("Are you sure to delete this cart item");
        //alert(cartid);
        if (result) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: { cartid: cartid },
                url: '/cart/delete/',
                method: 'post',
                success: function (resp) {

                    $(".appendCartItems").html(resp.view);

                }, error: function () {
                    alert("Error");
                }


            });
        }


    });

    $("#registerform").submit(function () {
        $(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url: "/user/register",
            type: "post",
            data: formdata,
            success: function (resp) {
                if (resp.type == "error") {
                    $(".loader").hide();
                    $.each(resp.errors, function (i, error) {
                        $("#register-" + i).attr('style', 'color:red');
                        $("#register-" + i).html(error);

                        setTimeout(function () {
                            $("#register-" + i).css({
                                'display': 'none'
                            });
                        }, 3000);

                    });
                } else if (resp.type == "success") {
                    //alert(resp.message);
                    $(".loader").hide();
                    $("#register-success").attr('style', 'color:green');
                    $("#register-success").html(resp.message);


                }


            },
            error: function () {
                alert("Error");
            }


        })

    });

    $("#forgotform").submit(function () {
        //$(".loader").show();
        var formdata = $(this).serialize();
        $.ajax({
            url: "/user/forgot-password",
            type: "post",
            data: formdata,
            success: function (resp) {
                if (resp.type == "error") {
                    //  $(".loader").hide();
                    $.each(resp.errors, function (i, error) {
                        $("#forgot-" + i).attr('style', 'color:red');
                        $("#forgot-" + i).html(error);

                        setTimeout(function () {
                            $("#forgot-" + i).css({
                                'display': 'none'
                            });
                        }, 3000);

                    });
                } else if (resp.type == "success") {
                    //alert(resp.message);
                    //  $(".loader").hide();
                    $("#forgot-success").attr('style', 'color:green');
                    $("#forgot-success").html(resp.message);


                }


            },
            error: function () {
                alert("Error");
            }


        })

    });
    $("#loginform").submit(function () {
        var formdata = $(this).serialize();
        $.ajax({
            url: "/user/login",
            type: "post",
            data: formdata,
            success: function (resp) {
                if (resp.type == "error") {
                    $.each(resp.errors, function (i, error) {
                        $("#login-" + i).attr('style', 'color:red');
                        $("#login-" + i).html(error);

                        setTimeout(function () {
                            $("#login-" + i).css({
                                'display': 'none'
                            });
                        }, 3000);

                    });
                } else if (resp.type == "incorrect") {
                    $("#login-error").attr('style', 'color:red');
                    $("#login-error").html(resp.message);
                    // alert(resp.message);
                }
                else if (resp.type == "inactive") {
                    $("#login-error").attr('style', 'color:red');
                    $("#login-error").html(resp.message);
                    // alert(resp.message);
                } else if (resp.type == "success") {
                    window.location.href = resp.url;

                }

            },
            error: function () {
                alert("Error");
            }


        })

    });

    $(document).on('click', '.editAddress', function () {
        var addressid = $(this).data("addressid");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'get-delivery-address',
            type: 'post',
            data: { addressid: addressid },
            success: function (resp) {
                $("#showdifferent").removeClass("collapse");
                $(".newAddress").hide();
                $(".deliveryText").text("Edit Delivery Address");
                $('[name=delivery_id').val(resp.address['id']);
                $('[name=name').val(resp.address['name']);
                $('[name=address').val(resp.address['address']);
                $('[name=city').val(resp.address['city']);
                $('[name=state').val(resp.address['state']);
                $('[name=country').val(resp.address['country']);
                $('[name=pincode').val(resp.address['pincode']);
                $('[name=email').val(resp.address['email']);
                $('[name=mobile').val(resp.address['mobile']);
            }, error: function () {
                alert("Error");
            }
        });

    });

    $(document).on('click', '.removeAddress', function () {

        //alert(addressid);
        if (confirm("Are you sure to remove this?")) {
            var addressid = $(this).data("addressid");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/remove-delivery-address',
                type: 'post',
                data: { addressid: addressid },
                success: function (resp) {
                    $("#deliveryAddresses").html(resp.view);
                    location.reload();

                }, error: function () {
                    alert("Error");
                }

            });
        }

    });

    $(document).on('submit', "#addressformaddedit", function () {

        var formdata = $("#addressformaddedit").serialize();
        //alert(formdata);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            url: 'save-delivery-address',
            type: 'post',
            data: formdata,
            success: function (resp) {
                location.reload();
                $("#deliveryAddresses").html(resp.view);

            }, error: function () {
                alert("Error");

            }
        });
    });
});



