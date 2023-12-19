
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\SubcategoryController;




// Auth::routes();





Route::prefix('/admin/authors')->controller(AuthorController::class)->name('author.')->group(function(){
    Route::get('/','index')->name('index');

    Route::post('/store','store')->name('store');
    Route::put('/update/{id}','update')->name('update');
    Route::get('/edit/{id}','edit')->name('edit');
    Route::delete('delete/{id}','delete')->name('delete');
});


Route::prefix('/admin/categories')->controller(CategoryController::class)->name('category.')->group(function(){
    Route::get('/','index')->name('index');

    Route::post('/store','store')->name('store');
    Route::put('/update/{id}','update')->name('update');
    Route::get('/edit/{id}','edit')->name('edit');
    Route::delete('delete/{id}','delete')->name('delete');
});




Route::prefix('/admin/subcategories')->controller(SubcategoryController::class)->name('subcategory.')->group(function(){
    Route::get('/','index')->name('index');

    Route::post('/store','store')->name('store');
    Route::put('/update/{id}','update')->name('update');
    Route::get('/edit/{id}','edit')->name('edit');
    Route::delete('/delete/{id}','delete')->name('delete');
    Route::get('/get-subcategory-by-category','getSubcategory')->name('getSubcategory');
});



Route::prefix('/admin/posts')->controller(PostController::class)->name('post.')->group(function(){
    Route::get('/','index')->name('index');
    Route::get('/create','create')->name('create');
    Route::post('/store','store')->name('store');
    Route::get('/view','view')->name('view');
    Route::put('/update/{id}','update')->name('update');
    Route::get('/edit/{id}','edit')->name('edit');
    Route::delete('/delete/{id}','delete')->name('delete');
    Route::get('/change_status','change_status')->name('change_status');
    Route::get('/change_feature','change_feature')->name('change_feature');
});




