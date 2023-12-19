@extends('layouts.admin_master')
@section('page_title', 'Admin - Dashboard')
@section('admin_main_content')
<div class="row mt-4">
    <div class="col-12">
        <div class="Container-fluid ml-5 mr-5">
            <h6 class="mb-25 text-center">{{ isset($Data)? 'Update' :'Create new' }} Books </h6>

            <form class="row  mx-auto" action="{{ isset($Data)? route('post.update',$Data->id) : route('post.store') }}" method="POST" enctype="multipart/form-data">
                @isset($Data)
                @method('PUT')
                        @endisset
                @csrf


                <div class="col-lg-12">
                    <div class="input-style-1">
                    <label for=""> Title</label>
                    <input name="title" placeholder="title" value="{{ isset($Data)? $Data->title :'' }}" class="form-control mb-4" type="text">
                    @error('title')
                    <p class="text-danger">{{ $message}}</p>
                              @enderror
                </div>
                </div>


                <div class="col-lg-4">
                    <div class="select-style-1">
                        <label>Category</label>
                        <div class="select-position">

                          <select name="category"id="category">
                            <option selected disabled>Select category</option>
                        @foreach ($categories as $category )
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                          </select>
                        </div>
                        @error('category')
            <p class="text-danger">{{ $message}}</p>
                      @enderror
                      </div>
            </div>

            <div class="col-lg-4">
                <div class="select-style-1">
                    <label>SubCategory</label>
                    <div class="select-position">
                      <select name="subcategory"id="subcategory">
                        <option selected disabled>No subcategory found!</option>
                  </select>
                    </div>
                    @error('subcategory')
            <p class="text-danger">{{ $message}}</p>
                      @enderror
                  </div>
        </div>
        <div class="col-lg-4">
            <div class="select-style-1">
                <label>author</label>
                <div class="select-position">
                  <select name="author"id="author">
                    <option selected disabled> Select Author</option>
@foreach ( $authors as $author  )
<option value="{{$author->id}}">{{ $author->name }} </option>
@endforeach

                  </select>
                </div>
                @error('author')
        <p class="text-danger">{{ $message}}</p>
                  @enderror
              </div>
    </div>

                <div class="col-lg-6">
                    <div class="input-style-1">
                    <label for=""> Featured_image </label>
                    <input name="featured_image"class="form-control mb-4" type="file">
                    @error('featured_image')
                    <p class="text-danger">{{ $message}}</p>
                              @enderror
                              <p>{{ asset('/storage/posts/'.isset($Data)? $Data->featured_image:'')}}</p>
                </div>

                </div>

                <div class="col-lg-6">
                    <div class="input-style-1">
                    <label for="">price </label>
                    <input name="price"class="form-control mb-4"value="{{ isset($Data)? $Data->price:'' }}" type="">
                    @error('price')
                    <p class="text-danger">{{ $message}}</p>
                              @enderror
                </div>

                </div>
                <div class="col-lg-12">
                    <div class="input-style-1">
                    <label for=""> Short_Description</label>
                    <textarea rows="5" name="short_description" placeholder="Short_Description"  class="form-control mb-4">{{  isset($Data)? $Data->short_description:''  }}</textarea>
                    @error('short_description')
                    <p class="text-danger">{{ $message}}</p>
                              @enderror
                </div>
                </div>
                <div class="col-lg-12">
                    <div class="input-style-1">
                    <label for=""> Description</label>
                    <textarea  id="description_editor" placeholder="Description" name="description"class="form-control mb-4">{{ isset($Data)? $Data->description:'' }}</textarea>
                    @error('description')
                    <p class="text-danger">{{ $message}}</p>
                              @enderror
                </div>
                </div>


                <div class="col-lg-12  ">
                    <div class="input-style-1">
                        <button type="submit"class="main-btn primary-btn btn-hover w-100"style="color:rgb(14, 13, 13); background-color:aqua ">{{ isset($Data)? 'Update' :'Create new' }}Books</button>
                                  </div>
                 </form>
                </div>

            </form>

        </div>



    </div>

</div>





@endsection
@push('additional.css')
<style>
.ck-editor__editable[role="textbox"] {

                min-height: 200px;}
</style>
@endpush
@push('additional_js')

<script src="{{ asset('backend/assets/js/ckeditor.js') }}"> </script>
<script>
    ClassicEditor
        .create( document.querySelector( '#description_editor') )
        .catch( error => {
            console.error( error );
        } );

        $('#category').on('change',function(){

$.ajax({
    url:`{{ route('subcategory.getSubcategory') }}`,
    method: 'GET',
    data: {
         category: $(this).val()
 },
 success: function(res){



    if (res.length >0){
        let options=[`<option value="" selected disabled> Select Sub Category </option>`];
    res.forEach(function(subcategory){
let option =`<option value="${subcategory.id}">${subcategory.name}</option>`;

  options.push(option);
        });
        $('#subcategory').html(options)
    }else{
        $('#subcategory').html(`<option selected disabled>No subcategory found!</option>`)
    }


 }
})
})







</script>
@endpush
@push('additional.css')
<style>
body{
    background-color:rgb(229, 223, 223);
}
</style>
@endpush

