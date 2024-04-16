<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class);

Route::controller(\App\Http\Controllers\ProductController::class)
    ->prefix('products')
    ->group(function (){
        Route::post('{product}/review', 'addReview')->name('products.add_review');
    });


