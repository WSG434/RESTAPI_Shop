<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\ProductController::class)
    ->prefix('products')
    ->group(function (){
        Route::get('', 'index')->name('products.index');
        Route::get('{product}', 'show')->name('products.show');
        Route::post('', 'store')->name('products.store');
        Route::post('{product}/review', 'review')->name('products.review.store');
        Route::put('{product}', 'update')->name('products.update');
        Route::patch('{product}', 'update')->name('products.update');
        Route::delete('{product}', 'destroy')->name('products.destroy');
    });


