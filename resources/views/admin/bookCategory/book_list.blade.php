@extends('layouts.admin_master')
@section('page_title', 'Admin - Dashboard')
@section('admin_main_content')
<div class="row  container-fluied ">
    <div class="col-lg-12 ">
      <div class="card-style mb-30 ">
        <h3 class="mt-5 text-center"> All Books</h3>

        <div class="table-wrapper table-responsive">
          <table class="table  table-bordered table-striped table-hover col-lg-6 text-center  col-md-12 col-12 mt-5 ">
            <thead style="color:rgb(14, 13, 13); background-color:rgb(192, 254, 254) ">
              <tr>
                <th >
                  <h6>F.Image</h6>
                </th>
                <th >
                    <h6>Title</h6>
                  </th>
                <th >
                  <h6>Author</h6>
                </th>
                <th >
                  <h6>Category</h6>
                </th>
                <th >
                  <h6>Status</h6>
                </th>
                <th >
                    <h6>Price</h6>
                  </th>
                <th>
                  <h6>Is Featured?</h6>
                </th>
                <th>
                    <h6>Created At</h6>
                  </th>
                  <th>
                    <h6>Action</h6>
                  </th>
              </tr>
              <!-- end table row-->
            </thead>
            <tbody >
               @forelse ($posts as $post )
               <tr>
                <td class="min-width">


                      <img class="img-thumbnail text-center" src="{{ asset('storage/posts/'.$post->featured_image) }}"width="100" alt="">




                </td>
                <td class="min-width">
                  <p>{{ str($post->title)->substr(0,5)."....." }}</p>
                </td>
                <td class="min-width">
                  <p>{{ $post->author->name }}</p>
                </td>
                <td class="min-width">
                  <p>{{ $post->category->name }}</p>
                </td>
            </td>
            <td class="min-width">
                <div class="form-check form-switch toggle-switch ">
                    <input class="form-check-input change_status" type="checkbox"{{ $post->status ?'checked':'' }} data-post-id="{{ $post->id }}">

                  </div>
            </td>
            <td class="min-width">
                <p>{{ $post->price}}</p>
              </td>
            <td class="min-width">
                <button class="main-btn {{$post->is_feature ?'warning':'light' }}-btn btn-hover change_feature btn-sm"data-post-feature="{{ $post->id }}">
<i class="lni lni-star-{{ $post->is_feature ?'fill':'empty' }}"></i>

                </button>
            </td>
            <td class="min-width">
                <p>{{ Carbon\Carbon::parse($post->created_at)->format('d-M-Y /h:i a ') }}</p>
              </td>

          <td class="d-flex" >
                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-sm btn-success btn-hover"><i class="fas fa-edit"></i></a>
                <a href="{{ route('post.view', $post->id) }}" class="btn btn-sm btn-warning btn-hover"><i class="fas fa-eye"></i></a>
               <button class="btn  btn-sm btn-danger btn-hover delete_btn">
                <i class="fas fa-trash"></i>
            </button>
         <form  action="{{ route('post.delete', $post->id)}}"method="POST">
                @csrf
                @method('DELETE')

               </form>
            </td>
              </tr>
               @empty

               @endforelse

              <!-- end table row -->

              <!-- end table row -->
            </tbody>
          </table>
          <!-- end table -->
        </div>
      </div>
      <!-- end card -->
    </div>
    <!-- end col -->
  </div>
@endsection
@push('additional_js')
<script src="{{ asset('backend/assets/js/sweetalert2@11.js') }}">

</script>
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
    <script>
const Toast = Swal.mixin({
  toast: true,
  position: "bottom-end",
  showConfirmButton: false,
  timer: 2000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  }
});


$('.change_status').on('change',function(){
$.ajax({


    url: "{{ route('post.change_status') }}",
    method:"GET",
    data:{
post_id: $(this).data('post-id')
    },
    success: function(){
        Toast.fire({
  icon: "success",
  title: "Status Change successfully"
});


    }
})

})

    </script>

    <Script>




       $('.change_feature').on('click',function(){
        $.ajax({


url: "{{ route('post.change_feature') }}",
method:"GET",
data:{
    feature_id: $(this).data('post-feature')
},
success: function(res){
if(res){
    $('.change_feature').removeClass('light-btn')
    $('.change_feature').addClass('warning-btn')

}else{

    $('.change_feature').removeClass('warning-btn')
    $('.change_feature').addClass('light-btn')
}

    Toast.fire({
icon: "success",
title: "feature Change successfully"
});


}
})
       })

    </Script>


@endpush
