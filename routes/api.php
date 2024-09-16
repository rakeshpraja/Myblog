<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\AuthController;


Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/get_all_post', [PostController::class, 'getAllPost']);
    Route::get('/single_post/{id}', [PostController::class, 'singlePost']);
    Route::post('/create_post', [PostController::class, 'createPost']);
    Route::delete('/delete_post/{id}', [PostController::class, 'deletePost']);
    Route::post('/posts', [PostController::class, 'updatePost']);
    Route::post('/logout', [AuthController::class, 'logout']);

});

