<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'loginView']);
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');


Route::get('/register_view', [AuthController::class, 'showRegistrationForm'])->name('register.form');


Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::get('logout', [AuthController::class, 'logout']);


Route::get('index', [PostController::class, 'index']);
Route::post('submit_post', [PostController::class, 'addPost'])->name('posts.store');
Route::get('single_post/{id}', [PostController::class, 'singlePost']);
Route::get('blog_list', [PostController::class, 'blogList']);
Route::get('edit_post/{id}', [PostController::class, 'editPost']);
Route::post('/post/update/{id}', [PostController::class, 'updatePost'])->name('post.update');
Route::delete('/delete_post/{id}', [PostController::class, 'deletePost'])->name('post.delete');
