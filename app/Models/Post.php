<?php

namespace App\Models;

use App\Models\User;
use App\Models\Author;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class);
     }
     public function author(){
        return $this->belongsTo(Author::class);
     }



     public function category(){
        return $this->belongsTo(Category::class);
     }

     public function subcategory(){
        return $this->belongsTo(Subcategory::class);
     }
    //  public function comments(){
    //     return $this->hasMany(Comment::class)->with('user');
    //  }
}
