<?php

use Illuminate\Support\Facades\Route;


Route::fallback(function () {
    return view('index');
});


Route::get('auth/google', \App\Http\Controllers\AuthController::class . '@google');
Route::get('auth/google/back', \App\Http\Controllers\AuthController::class . '@google_back');


Route::get('auth/github', \App\Http\Controllers\AuthController::class . '@github');
Route::get('auth/github/back', \App\Http\Controllers\AuthController::class . '@github_back');
