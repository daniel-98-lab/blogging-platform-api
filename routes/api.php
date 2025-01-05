<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::apiResource('categories', CategoryController::class);
Route::get('/categories/{categoryId}/posts', [PostController::class, 'getPostsByCategory']);
Route::apiResource('tags',  TagController::class);
Route::get('/tags/{tagId}/posts', [PostController::class, 'getPostsByTag']);
Route::apiResource('posts', PostController::class);
