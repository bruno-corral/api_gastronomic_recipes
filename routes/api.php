<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/recipe/{recipe}/comment', [CommentController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/validate', [AuthController::class, 'validate']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('recipe', RecipeController::class);
});
