<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
})->name('home');
// Crud on blogs
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');

Route::get('blogs/{blog}', [BlogController::class, 'show']);

Route::get('/blogs/create', [BlogController::class,'create'])->middleware('WriterRole');
Route::post('/blogs/store', [BlogController::class,'store'])->middleware('WriterRole');

Route::post('blogs/{blog}/store_comment', [BlogController::class, 'store_comment']);

Route::get('/blogs/{blog}/edit', [BlogController::class,'edit'])->middleware('WriterRole');
Route::put('/blogs/{blog}/update', [BlogController::class,'update'])->middleware('WriterRole');

Route::delete('/blogs/{blog}/delete', [BlogController::class,'delete'])->middleware('WriterRole');

// Crud on categories

Route::get('/categories', [CategoryController::class, 'index'])->name('categories')->middleware('WriterRole');

Route::get('/categories/create', [CategoryController::class,'create'])->middleware('ManagerRole');
Route::post('/blogs/store', [BlogController::class,'store'])->middleware('ManagerRole');

Route::get('/blogs/{blog}/edit', [BlogController::class,'edit'])->middleware('ManagerRole');
Route::put('/blogs/{blog}/update', [BlogController::class,'update'])->middleware('ManagerRole');

Route::delete('/blogs/{blog}/delete', [BlogController::class,'delete'])->middleware('ManagerRole');

// Crud on comments
Route::get('/comments', [CommentController::class, 'index'])->name('comments')->middleware('ManagerRole');

Route::delete('/comments/{comment}/destroy', [CommentController::class,'destroy'])->middleware('ManagerRole');

// Route::get('/comments/store', [Comment::class,'store']);

// Route::get('/blogs/{blog}/edit', [Blog::class,'edit']);
// Route::get('/blogs/{blog}/update', [Blog::class,'update']);

// Route::get('/blogs/{blog}/delete', [Blog::class,'delete']);

