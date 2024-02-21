<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function(){
    Route::post('/login', [\App\Http\Controllers\Api\v1\AuthController::class, 'login']);
    Route::post('/register', [\App\Http\Controllers\Api\v1\AuthController::class, 'register']);
    Route::get('/myuser', [\App\Http\Controllers\Api\v1\AuthController::class, 'myUser'])->middleware('auth:sanctum');
    
    Route::apiResource('/users', \App\Http\Controllers\Api\v1\UserController::class)->middleware('auth:sanctum');
});
