<?php

use Illuminate\Support\Facades\Route;

////=====auth=====\\\
Route::post('login', \App\Http\Controllers\AuthController::class . '@login');
Route::post('register', \App\Http\Controllers\AuthController::class . '@register');
Route::get('logout', \App\Http\Controllers\AuthController::class . '@logout')->middleware('auth:api');



////=====user=====\\\
Route::get('rolecheck', \App\Http\Controllers\UserController::class . '@rolecheck')->middleware('authcheck');
Route::get('user-info', \App\Http\Controllers\UserController::class . '@userinfo')->middleware('authcheck');
Route::post('user-update', \App\Http\Controllers\UserController::class . '@user_update')->middleware('authcheck');



////=====admin=====\\\

///user
Route::post('get-users', \App\Http\Controllers\UserController::class . '@getusers')->middleware('rolecheck')->middleware('authcheck');
Route::get('update_user_status/{id}/{status}', \App\Http\Controllers\UserController::class . '@update_user_status')->middleware('rolecheck')->middleware('authcheck');
Route::get('delete_user/{id}', \App\Http\Controllers\UserController::class . '@delete_user')->middleware('rolecheck')->middleware('authcheck');
Route::get('user-info/{id}', \App\Http\Controllers\UserController::class . '@user_by_id')->middleware('rolecheck')->middleware('authcheck');
Route::post('user-update/{id}', \App\Http\Controllers\UserController::class . '@user_update_by_id')->middleware('rolecheck')->middleware('authcheck');


///categories
Route::post('create-category', \App\Http\Controllers\CategoryController::class . '@create')->middleware('rolecheck')->middleware('authcheck');
Route::get('get-category', \App\Http\Controllers\CategoryController::class . '@get_all')->middleware('rolecheck')->middleware('authcheck');
Route::get('update_category_status/{id}/{status}', \App\Http\Controllers\CategoryController::class . '@update_category_status')->middleware('rolecheck')->middleware('authcheck');




////=====upload=====\\\
Route::post('image-upload', \App\Http\Controllers\UploaderController::class . '@image');
Route::get('image-get', \App\Http\Controllers\UploaderController::class . '@get_images');
Route::post('image-delete', \App\Http\Controllers\UploaderController::class . '@delete_images');
