<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(){

        $authors = Author::latest()->paginate(5);
        return view('admin.author.Author_list',compact('authors'));

      }


      public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255'
            ]);

            $author_slug = str($request->name)->slug();
    $slug_count = Author::where('slug','LIKE','%' .$author_slug.'%')->count();

    if ($slug_count > 0){
        $author_slug.= "-" . $slug_count + 1;
    }

    $author = new Author();
    $author->name = $request->name;
    $author->slug = $author_slug;

    $author->save();
    return back();



      }
      public function edit($id){
        $authors = Author::paginate(5);
        $editData= Author::findOrFail($id,['id','name']);
        return view('admin.author.Author_list', compact('authors', 'editData'));

      }
      public function update(Request $request,$id){
        $request->validate([
            'name'=>'required|string|max:255'
            ]);

            $author_slug = str($request->name)->slug();
    $slug_count = Author::where('slug','LIKE','%' . $author_slug.'%')->count();

    if ($slug_count > 0){
        $author_slug.= "-" . $slug_count + 1;
    }

    $author = Author::find($id);
    $author->name = $request->name;
    $author->slug =  $author_slug;

    $author->save();
    return back();


      }
      public function delete($id)
      {
        $author_count = Author::count();
       if( $author_count > 1 ){
        $author = Author::find($id);
        $author->delete();

       }
       return back();
      }

}
