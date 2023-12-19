<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index(){

        $subcategories = Subcategory::with('category')->latest()->paginate(5);
        $categories = Category::latest()->select('id','name')->get();
        return view('admin.author.subcategory_list',compact('categories','subcategories'));

      }


      public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'category'=>'required|exists:categories,id',
            ]);

            $category_slug = str($request->name)->slug();
    $slug_count = Subcategory::where('slug','LIKE','%' .$category_slug.'%')->count();

    if ($slug_count > 0){
        $category_slug.= "-" . $slug_count + 1;
    }

    $category = new Subcategory();
    $category->name = $request->name;
    $category->category_id = $request->category;
    $category->slug = $category_slug;

    $category->save();
    return back();



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

    $category = Subcategory::find($id);

    $category->name = $request->name;
    $category->slug = $category_slug;


    $category->category_id = $request->category;


    $category->save();
    return back();


      }
        public function edit($id){


    $subcategories = Subcategory::with(['category:id,name'])->latest()->paginate(5);

    $categories = Category::latest()->select(['id','name'])->get();
    $Data = Subcategory::findOrFail($id,['id','name']);
    return view('admin.author.subcategory_list',compact('subcategories', 'Data','categories'));

  }
  public function delete($id)
  {
   $category_count = Subcategory::count();
   if($category_count > 1 ){
    $subcategory = Subcategory::find($id);
    $subcategory->delete();

   }
   return back();
  }
  public function getSubcategory(Request $request){


$subcategories = Subcategory::where('category_id',$request->category)->latest()->get(['id','name']);
return $subcategories;


}
}
