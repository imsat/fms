<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('/v1')->group(function () {
//    Route::controller(LoginController::class)->group(function(){
//        Route::post('login', 'login');
//        Route::post('logout', 'logout');
//    });
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [LoginController::class, 'logout']);
        Route::apiResource('forms', FormController::class);
        Route::apiResource('feedbacks',FeedbackController::class)->only('store');
    });
});


