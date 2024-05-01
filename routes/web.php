<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
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

Route::post('blogs/{blog}/store_comment', [BlogController::class, 'store_comment']); // store comment

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

// user routes
Route::get('/users/register', [UserController::class, 'create'])->middleware('guest');
Route::post('/users/register', [UserController::class, 'store'])->middleware('guest');

Route::get('/users/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/users/login', [UserController::class, 'authenticate'])->middleware('guest');

Route::post('/users/logout', [UserController::class, 'logout'])->middleware('auth');

Route::get('/users/panel', [UserController::class, 'index'])->middleware('auth');

Route::get('/users/panel/writer_request', [UserController::class, 'writer_request'])->middleware('auth');

Route::delete('/users/panel/delete', [UserController::class, 'destroy'])->middleware('auth');

Route::get('/users/panel/categories', [UserController::class, 'categories'])->middleware('WriterRole');

Route::get('/users/panel/users', [UserController::class, 'show_all_users'])->middleware('ManagerRole');

// Route::get('/users/panel/user', )


