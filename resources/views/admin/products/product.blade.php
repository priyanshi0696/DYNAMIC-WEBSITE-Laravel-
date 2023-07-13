@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">



        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Product</h4>
              <a  style ="max-width:150px; float: right; display:inline-block;" href="{{url('admin/add-edit-product')}}" class="btn btn-block btn-primary">Add Products</a>
              @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success:</strong> {{Session::get('success_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              <div class="table-responsive pt-3">
                <table id="products" class="table table-bordered">
                  <thead>
                    <tr>

                      <th>
                      Id
                      </th>
                      <th>
                      Product Name
                      </th>
                      <th>
                        Product Code
                        </th>
                        <th>
                            Product Color
                            </th>
                            <th>
                                Product Image
                                </th>
                            <th>
                                Category
                                </th>
                                <th>
                                    Section
                                    </th>
                                    <th>
                                        Added By
                                        </th>

                    <th>
                        Status
                       </th>
                       <th>
                        Action
                       </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($product as $product)
                    <tr>
                      <td>
                        {{$product['id']}}
                      </td>
                      <td>
                        {{$product['product_name']}}
                      </td>
                      <td>
                        {{$product['product_code']}}
                      </td>
                      <td>
                        {{$product['product_color']}}
                      </td>
                      <td>
                        @if(!empty($product['product_image']))
                        <img  style ="width:150px; height:150px; "src="{{ asset('front/images/product/small/'.$product['product_image']) }}">

                        @else
                        <img style ="width:150px; height:150px; " src="{{ asset('front/images/product/small/noimage.png') }}">

                        @endif
                      </td>
                      <td>
                        {{$product['category']['category_name']}}
                      </td>
                      <td>
                        {{$product['section']['name']}}
                      </td>
                       <td>
                        @if($product['admin_type']=="vendor")
                        <a target="_blank" href="{{ url('admin/view-vendor-details/'. $product['admin_id']) }}">{{ ucfirst($product['admin_type']) }}</a>
                        @else
                       {{ucfirst($product['admin_type']) }}
                        @endif
                       </td>
                      <td>
                        @if($product['status']==1)
                       <a class="updateproductStatus" id ="product-{{$product['id']}}" product_id="{{$product['id']}}" href="javascript:void(0)" ><i style ="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i></a>
                        @else
                        <a class="updateproductStatus" id ="product-{{$product['id']}}" product_id="{{$product['id']}}" href="javascript:void(0)" ><i style ="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a>
                        @endif
                      </td>
                      <td>


                        <a href ="{{ url('admin/add-edit-product/'.$product['id']) }}"><i style ="font-size:25px;" class="mdi mdi-pencil-box"></i></a>
                        <a href ="{{ url('admin/add-attributes/'.$product['id']) }}"><i style ="font-size:25px;" class="mdi mdi-plus-box"></i></a>
                        <a title= "Multiple Images" href ="{{ url('admin/add-images/'.$product['id']) }}"><i style ="font-size:25px;" class="mdi mdi-library-plus"></i></a>

                        <a  title ="Section" class="confirmDelete" module="product" moduleid="{{$product['id']}}" href ="javascript:void(0)" ><i style ="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>

                      </td>




                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    <!-- partial -->
  </div>



@endsection
