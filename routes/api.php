<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){
    Route::post('/login', [\App\Http\Controllers\Api\v1\AuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\Api\v1\AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [\App\Http\Controllers\Api\v1\AuthController::class, 'register']);
    Route::get('/myuser', [\App\Http\Controllers\Api\v1\AuthController::class, 'myUser'])->middleware('auth:sanctum');
    
    Route::apiResource('/users', \App\Http\Controllers\Api\v1\UserController::class)->middleware('auth:sanctum');
});
