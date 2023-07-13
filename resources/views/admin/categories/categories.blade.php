@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">



        <div class="col-lg-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Categories</h4>
              <a  style ="max-width:150px; float: right; display:inline-block;" href="{{url('admin/add-edit-category') }}" class="btn btn-block btn-primary">Add Section</a>
              @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success:</strong> {{Session::get('success_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              @endif
              <div class="table-responsive pt-3">
                <table id="section" class="table table-bordered">
                  <thead>
                    <tr>

                      <th>
                      Id
                      </th>
                      <th>Category</th>
                      <th>Parent Category</th>
                      <th>Section</th>
                      <th>URL</th>
                <th>
                        Status
                       </th>
                       <th>
                        Action
                       </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($categories as $categories)
                    @if(isset($category['parentcategory']['category_name'])&&!empty($category['parentcategory']['category_name']))
                  <?php  $parent_category=$category['parentcategory']['category_name'];?>
                    @else
                  <?php  $parent_category="Root"; ?>
                    @endif
                    <tr>
                      <td>
                        {{$categories['id']}}
                      </td>
                      <td>
                        {{ $categories['category_name']}}
                      </td>
                      <td>
                          {{ $parent_category }}
                      </td>
                      <td>
                        {{ $categories['section']['name']}}
                      </td>
                      <td>
                        {{ $categories['url']}}
                      </td>
                      <td>
                        @if($categories['status']==1)
                       <a class="updateCategoryStatus" id ="category-{{ $categories['id']}}" category_id="{{$categories['id']}}" href="javascript:void(0)" ><i style ="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i></a>
                        @else
                        <a class="updateCategoryStatus" id ="category-{{$categories['id']}}" category_id="{{$categories['id']}}" href="javascript:void(0)" ><i style ="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a>
                        @endif
                      </td>
                      <td>


                        <a href ="{{ url('admin/add-edit-category/'.$categories['id']) }}"><i style ="font-size:25px;" class="mdi mdi-pencil-box"></i></a>

                        <a  title ="Section" class="confirmDelete" module="category" moduleid="{{$categories['id']}}" href ="javascript:void(0)" ><i style ="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>

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
