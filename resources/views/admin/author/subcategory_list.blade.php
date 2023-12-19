@extends('layouts.admin_master')
@section('page_title', 'Admin - Dashboard')
@section('admin_main_content')

<div class="row mt-4 mx-auto ">
<div class="col-lg-8 text-center ">
    <div class="card-style mb-30 ">
        <h3 class="mb-10">All Categories</h3>

        <div class="table table-bordered table-striped table-hover col-lg-6 text-center  col-md-12 col-12 mt-5">
          <table class="table striped-table">
            <thead>
                <tr>
                    <th>Sl.No.</th>
                    <th>
                      <h6> Name</h6>
                    </th>
                    <th>
                      <h6>Slug</h6>
                    </th>
                    <th>
                        <h6>Parent Category</h6>
                      </th>
                    <th>
                      <h6>Status</h6>
                    </th>
                    <th>
                        <h6>Action</h6>
                      </th>
                  </tr>
              <!-- end table row-->
            </thead>
            <tbody>
@forelse ( $subcategories as $key=> $subcategory )
<tr>
    <td>
      <h6 class="text-sm">#{{ $subcategories->firstItem()+$key }}</h6>
    </td>
    <td>
      <p>{{ $subcategory->name }}</p>
    </td>
    <td>
      <p>{{ $subcategory->slug }}</p>
    </td>
    <td>
        <p>{{ $subcategory->category->name}}</p>
      </td>
    <td>
     <div class="form-check form-switch toggle-switch">
        <input class="form-check-input" type="checkbox" id="toggleSwitch2"{{ $subcategory->status ?'checked':'' }}>

      </div>
    </td>
    <td class="d-flex" >
        <a href="{{ route('subcategory.edit', $subcategory->id) }}" class="btn btn-sm btn-warning btn-hover"><i class="fas fa-edit"></i></a>

       <button class="btn  btn-sm btn-danger btn-hover delete_btn">
        <i class="fas fa-trash"></i>
    </button>
 <form  action="{{ route('subcategory.delete', $subcategory->id)}}"method="POST">
        @csrf
        @method('DELETE')

       </form>
    </td>
  </tr>
@empty
<tr>
    <td colspan="5"class="text-center text-danger"><strong>No Data Found</strong></td>
</tr>
@endforelse
              <!-- end table row -->

              <!-- end table row -->
            </tbody>
          </table>
          <!-- end table -->
        </div>
<div>
{{ $subcategories->links() }}
</div>
      </div>
</div>
<div class="col-lg-4">
    <div class="card-style mb-30">
        <h6 class="mb-25 text-center">{{ isset($Data)? 'Update' :'Create new' }} Sub Category</h6>
       <form action=" {{ isset($Data)? route('subcategory.update',$Data->id) : route('subcategory.store') }}" method="POST">
        @isset($Data)
@method('PUT')
        @endisset

        @csrf

        <div class="select-style-1 ">
            <label>Category</label><br><br>
            <div class="select-position">
              <select name="category">
                <option>Select category</option>
               @foreach ($categories as $category )
               <option value="{{ $category->id }}">{{ $category->name }}</option>
               @endforeach


              </select>
            </div>
          </div>


        <div class="input-style-1"><br>
            <label>Sub Category Name </label><br><br>
            <input type="text" placeholder="Sub Category Name"name="name"value="{{ isset($Data)? $Data->name :'' }}"><br><br>
            @error('category')
            <p class="text-danger">{{ $message }}</p>
                        @enderror
          </div>
          <div class="input-style-1">
              <button type="submit"class="main-btn primary-btn btn-hover w-100"style="color:rgb(14, 13, 13); background-color:aqua ">{{ isset($Data)? 'Update' :'Create new' }}Sub Category</button>
                        </div>
       </form>

      </div>
</div>
</div>
@endsection

@push('additional_js')
<script src="{{ asset('backend/assets/js/sweetalert2@11.js')}}"></script>
<script>
    $('.delete_btn').on('click' , function(){
        Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
$(this).next('form').submit();
      }
    });
    })
    </script>
@endpush
@push('additional.bd')
<style>
/* body{
    background-color:rgb(176, 220, 160);
} */
</style>
@endpush
