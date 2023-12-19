<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Author;
use App\Models\Category;

use App\Models\Subcategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(){
        $categories = Category::latest()->get(['id','name']);
        $authors = Author::latest()->get(['id','name']);
        $subcategories = Subcategory::latest()->get(['id','name']);

                return view('admin.bookCategory.create', compact('categories','subcategories','authors'));

              }

              public function index(){

        $posts = Post::with(['category:id,name','author:id,name'])->latest()->select(['id','title','category_id','author_id','featured_image','price','status','is_feature','created_at'])->paginate(10);
                        return view('admin.bookCategory.book_list', compact('posts'));

                      }
                      public function store(Request $request){
                        $request->validate([


        "title" => "required|string|max:255",
        "category" => "required|exists:categories,id",
        "author" => "required|exists:authors,id",
        "subcategory" =>"required|exists:subcategories,id",
        "short_description" =>"required|string|max:255",
        "description" => "required|string",
        "featured_image" => 'required|image|mimes:png,jpg,webp,jpeg',
        "price" => "required|string|max:255"

        ]);
        //slug
        $post_slug = str($request->title)->slug();
        $slug_count = Post::where('slug','LIKE','%' .$post_slug.'%')->count();

        if ($slug_count > 0){
            $post_slug.= "-" . $slug_count + 1;
        }

        //image
        if($request->hasFile('featured_image')){
            $featured_image = str()->random(5).time().'.'.$request->featured_image->extension();
            $request->featured_image->storeAs('posts',$featured_image,'public');

            }

        $post = new Post();
        $post->title = $request->title;
        $post->slug = $post_slug ;

        $post->category_id = $request->category;
        $post->author_id = $request->author;
        $post->subcategory_id = $request->subcategory;
        $post->featured_image = $featured_image;
        $post->price = $request->price;
        $post->short_description = $request->short_description;
        $post->description = $request->description;

        $post->save();
        return back();

                      }


                      public function change_status(Request $request){
                        $post = Post::find($request->post_id);
                        if ($post->status ){
                        $post->status =false;

                    }else{
                        $post->status = true;

                    }

                        $post->save();
                      }

                      public function change_feature(Request $request){
                        $post = Post::find($request->feature_id);
                        if ($post->is_feature ){
                            $post->is_feature = false;
                            return false;

                    }else{
                        $post->is_feature = true;
                        return true;

                    }

                        $post->save();
                      }


//delete

                      public function delete($id)
                      {
                       $category_count = Post::count();
                       if($category_count > 1 ){
                        $post = Post::find($id);
                        $post->delete();

                       }
                       return back();
                      }



                      //update
                      public function update(Request $request,$id){
                        $request->validate([


        "title" => "required|string|max:255",
        "category" => "required|exists:categories,id",
        "author" => "required|exists:authors,id",
        "subcategory" =>"required|exists:subcategories,id",
        "short_description" =>"required|string|max:255",
        "description" => "required|string",
        "featured_image" => 'required|image|mimes:png,jpg,webp,jpeg',
        "price" => "required|string|max:255"

        ]);
        //slug
        $post_slug = str($request->title)->slug();
        $slug_count = Post::where('slug','LIKE','%' .$post_slug.'%')->count();

        if ($slug_count > 0){
            $post_slug.= "-" . $slug_count + 1;
        }

        //image
        if($request->hasFile('featured_image')){
            $featured_image = str()->random(5).time().'.'.$request->featured_image->extension();
            $request->featured_image->storeAs('posts',$featured_image,'public');

            }

            $post = Subcategory::find($id);
            $post =Category::find($id);
            $post = Author::find($id);


        $post->title = $request->title;
        $post->slug = $post_slug ;

        $post->category_id = $request->category;
        $post->author_id = $request->author;
        $post->subcategory_id = $request->subcategory;
        $post->featured_image = $featured_image;
        $post->price = $request->price;
        $post->short_description = $request->short_description;
        $post->description = $request->description;



        $post->save();
        return back();

                      }


                //edit

                public function edit($id){


                    $posts = Post::with(['category:id,name','author:id,name','subcategory:id,name'])->latest()->paginate(5);
                    $categories = Category::latest()->select(['id','name'])->get();
                    $subcategories = Subcategory::latest()->select(['id','name'])->get();
                    $authors = Author::latest()->select(['id','name'])->get();
                    $posts = Post::latest()->select(['id','title','category_id','author_id','featured_image','price','short_description','description','status','is_feature','created_at'])->get();
                    $Data = Post::findOrFail($id,['id','title','category_id','author_id','featured_image','price','short_description','description','status','is_feature','created_at']);
                    return view('admin.bookCategory.create',compact('posts','subcategories','authors','Data','categories'));

                  }


}
