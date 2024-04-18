<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class);
Route::post('products/{product}/review', [ProductController::class, 'addReview'])
    ->name('products.addReview');
