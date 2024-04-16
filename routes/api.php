<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class);

Route::post('products/{product}/review', [ProductController::class, 'review'])
    ->name('products.add_review');

Route::controller(\App\Http\Controllers\UserController::class)->group(function(){
   Route::post('login','login')->name('login');
});
