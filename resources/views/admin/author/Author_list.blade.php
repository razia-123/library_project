@extends('layouts.admin_master')
@section('page_title', 'Admin - Dashboard')
@section('admin_main_content')


<div class="row mt-4 mx-auto ">
    <div class="col-lg-8 ">
        <div class="card-style mb-30 ">
            <h3 class="mb-10 text-center">Author Section</h3>

            <div class="table-wrapper table-responsive">
              <table class="table table-bordered table-striped table-hover col-lg-6 text-center  col-md-12 col-12 mt-5">
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
                          <h6>Status</h6>
                        </th>
                        <th>
                            <h6>Action</h6>
                          </th>
                      </tr>
                  <!-- end table row-->
                </thead>
                <tbody>

    @forelse ( $authors as $key=> $author )
    <tr>
        <td>
          <h6 class="text-sm">#{{ $authors->firstItem()+$key }}</h6>
        </td>
        <td>
          <p>{{ $author->name }}</p>
        </td>
        <td>
          <p>{{ $author->slug }}</p>
        </td>
        <td>
         <div class="form-check form-switch toggle-switch">
            <input class="form-check-input" type="checkbox" id="toggleSwitch2"{{ $author->status ?'checked':'' }}>

          </div>
        </td>
        <td class="d-flex" >
            <a href="{{ route('author.edit', $author->id) }}" class="btn btn-sm btn-warning btn-hover"><i class="fas fa-edit"></i></a>

           <button class="btn  btn-sm btn-danger btn-hover delete_btn">
            <i class="fas fa-trash"></i>
        </button>
     <form  action="{{ route('author.delete', $author->id)}}"method="POST">
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
    {{$authors->links() }}
    </div>
          </div>
    </div>
    <div class="col-lg-4">
        <div class="card-style bg-white mb-30">
            <h5 class="mb-25 text-center">{{ isset($editData)? 'Update' :'Create new' }} Author </h5>
           <form action=" {{ isset($editData)? route('author.update',$editData->id) : route('author.store') }}" method="POST">
            @isset($editData)
    @method('PUT')
            @endisset

            @csrf
            <div class="input-style-1 mb-4">
                <label>Author Name :</label>
                <input class="mt-4" type="text" placeholder=" author Name "name="name"value="{{ isset($editData)? $editData->name :'' }}">
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                            @enderror
              </div>
              <div class="input-style-1">
                  <button type="submit"class="main-btn primary-btn
                  btn-hover w-100" style="color:rgb(14, 13, 13); background-color:aqua ">{{ isset($editData)? 'Update' :'Create new' }} Author</button>
                            </div>
           </form>

          </div>
    </div>
    </div>






@endsection
@push('additional.css')

@endpush
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
