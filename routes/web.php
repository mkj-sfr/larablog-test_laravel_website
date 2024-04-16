<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
})->name('home');
// Crud on blogs
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');

Route::get('blogs/{blog}', [BlogController::class, 'show']);

Route::get('/blogs/create', [BlogController::class,'create'])->middleware('WriterRole');
Route::get('/blogs/store', [BlogController::class,'store'])->middleware('WriterRole');

Route::get('/blogs/{blog}/edit', [BlogController::class,'edit'])->middleware('WriterRole');
Route::get('/blogs/{blog}/update', [BlogController::class,'update'])->middleware('WriterRole');

Route::get('/blogs/{blog}/delete', [BlogController::class,'delete'])->middleware('WriterRole');

// Crud on categories

Route::get('/categories', [CategoryController::class, 'index'])->name('categories')->middleware('WriterRole');

Route::get('/categories/create', [CategoryController::class,'create'])->middleware('ManagerRole');
Route::get('/blogs/store', [BlogController::class,'store'])->middleware('ManagerRole');

Route::get('/blogs/{blog}/edit', [BlogController::class,'edit'])->middleware('ManagerRole');
Route::get('/blogs/{blog}/update', [BlogController::class,'update'])->middleware('ManagerRole');

Route::get('/blogs/{blog}/delete', [BlogController::class,'delete'])->middleware('ManagerRole');

// Crud on comments
Route::get('/comments', [CommentController::class, 'index'])->middleware(

Route::get('/comments/store', [Comment::class,'store']);

Route::get('/blogs/{blog}/edit', [Blog::class,'edit']);
Route::get('/blogs/{blog}/update', [Blog::class,'update']);

Route::get('/blogs/{blog}/delete', [Blog::class,'delete']);

