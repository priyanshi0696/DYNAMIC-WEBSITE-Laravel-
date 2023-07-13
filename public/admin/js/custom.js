
$(document).ready(function () {

    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height:10px;"></div><input type="text" name="size[]" placeholder="Size" style="width: 120px;"/>&nbsp;<input type="text" name="sku[]" placeholder="SKU" style="width: 120px;"/>&nbsp;<input type="text" name="price[]" placeholder="Price" style="width: 120px;"/>&nbsp;<input type="text" name="stock[]" placeholder="Stock" style="width: 120px;"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function (e) {
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });

    $('#section').DataTable();
    $('#products').DataTable();
    $('#banner').DataTable();
    $('#users').DataTable();
    $('#orders').DataTable();



    $(".nav-item").removeClass("active");
    $(".nav-link").removeClass("active");

    $("#current_password").keyup(function () {
        var current_password = $("#current_password").val();
        // alert(current_password);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/check-current-password',
            data: { current_password: current_password },
            success: function (resp) {
                if (resp == "false") {
                    $("#verifycurrentpassword").html("Current Password not valid");
                } else if (resp == "true") {
                    $("#verifycurrentpassword").html("Current Password is valid");

                }

            },
            error: function () {
                alert("Error");

            }
        })
    });

    $(document).on("click", ".updateAdminStatus", function () {
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-admin-status',
            data: {
                status: status,
                admin_id: admin_id
            },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#admin-" + admin_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }
                else if (resp['status'] == 1) {
                    $("#admin-" + admin_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");

            }
        });
    });
    $(document).on("click", ".updateSectionStatus", function () {
        var status = $(this).children("i").attr("status");

        var section_id = $(this).attr("admin_id");



        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-section-status',
            data: {
                status: status,
                section_id: section_id
            },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#section-" + section_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }
                else if (resp['status'] == 1) {
                    $("#section-" + section_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");

            }
        });
    });
    $(document).on("click", ".updateuserStatus", function () {
        var status = $(this).children("i").attr("status");

        var user_id = $(this).attr("user_id");



        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-user-status',
            data: {
                status: status,
                user_id: user_id
            },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#user-" + user_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }
                else if (resp['status'] == 1) {
                    $("#user-" + user_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");

            }
        });
    });
    $(document).on("click", ".updateBannerStatus", function () {
        var status = $(this).children("i").attr("status");

        var banner_id = $(this).attr("banner_id");



        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-banner-status',
            data: {
                status: status,
                banner_id: banner_id
            },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#banner-" + banner_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }
                else if (resp['status'] == 1) {
                    $("#banner-" + banner_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");

            }
        });
    });
    $(document).on("click", ".updateattributeStatus", function () {
        var status = $(this).children("i").attr("status");

        var attribute_id = $(this).attr("attribute_id");



        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-attribute-status',
            data: {
                status: status,
                attribute_id: attribute_id
            },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#attribute-" + attribute_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }
                else if (resp['status'] == 1) {
                    $("#attribute-" + attribute_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");

            }
        });
    });
    $(document).on("click", ".updatebrandStatus", function () {
        var status = $(this).children("i").attr("status");

        var brand_id = $(this).attr("brand_id");



        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-brand-status',
            data: {
                status: status,
                brand_id: brand_id
            },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#brand-" + brand_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }
                else if (resp['status'] == 1) {
                    $("#brand-" + brand_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");

            }
        });
    });
    $(document).on("click", ".updateproductStatus", function () {
        var status = $(this).children("i").attr("status");

        var product_id = $(this).attr("product_id");



        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-product-status',
            data: {
                status: status,
                product_id: product_id
            },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#product-" + product_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }
                else if (resp['status'] == 1) {
                    $("#product-" + product_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");

            }
        });
    });
    $(document).on("click", ".updateAdminStatus", function () {
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-admin-status',
            data: {
                status: status,
                admin_id: admin_id
            },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#admin-" + admin_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }
                else if (resp['status'] == 1) {
                    $("#admin-" + admin_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");

            }
        });
    });
    $(document).on("click", ".updateCategoryStatus", function () {
        var status = $(this).children("i").attr("status");

        var category_id = $(this).attr("category_id");




        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-category-status',
            data: {
                status: status,
                category_id: category_id
            },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#category-" + category_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }
                else if (resp['status'] == 1) {
                    $("#category-" + category_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");

            }
        });
    });



    $(document).on("click", ".confirmDelete", function () {


        var module = $(this).attr('module');
        var moduleid = $(this).attr('moduleid');


        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                window.location = "/admin/delete-" + module + "/" + moduleid;
            }
        })



    })

    $("#sectionid").change(function () {
        var section_id = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'get',
            url: '/admin/append_categorieslevel',
            data: { section_id: section_id },
            success: function (resp) {

                $("#appendCategoriesLevel").html(resp);

            }, error: function () {
                alert("Error");
            }

        })

    })

    $(document).on("click", ".updateimageStatus", function () {
        var status = $(this).children("i").attr("status");

        var image_id = $(this).attr("image_id");



        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-image-status',
            data: {
                status: status,
                image_id: image_id
            },
            success: function (resp) {
                if (resp['status'] == 0) {
                    $("#image-" + image_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                }
                else if (resp['status'] == 1) {
                    $("#image-" + image_id).html("<i style ='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");

            }
        });
    });

});
