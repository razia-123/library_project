<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){

        $categories = Category::latest()->paginate(5);
        return view('admin.author.list', compact('categories'));

      }


      public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255'
            ]);

            $category_slug = str($request->name)->slug();
    $slug_count = Category::where('slug','LIKE','%' .$category_slug.'%')->count();

    if ($slug_count > 0){
        $category_slug.= "-" . $slug_count + 1;
    }

    $category = new Category();
    $category->name = $request->name;
    $category->slug = $category_slug;

    $category->save();
    return back();



      }
      public function edit($id){
        $categories = Category::paginate(5);
        $editData = Category::findOrFail($id,['id','name']);
        return view('admin.author.list', compact('categories', 'editData'));

      }
      public function update(Request $request,$id){
        $request->validate([
            'name'=>'required|string|max:255'
            ]);

            $category_slug = str($request->name)->slug();
    $slug_count = Category::where('slug','LIKE','%' .$category_slug.'%')->count();

    if ($slug_count > 0){
        $category_slug.= "-" . $slug_count + 1;
    }

    $category = Category::find($id);
    $category->name = $request->name;
    $category->slug = $category_slug;

    $category->save();
    return back();


      }
      public function delete($id)
      {
       $category_count = Category::count();
       if($category_count > 1 ){
        $category = Category::find($id);
        $category->delete();

       }
       return back();
      }
}
