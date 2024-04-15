<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\ProductController::class)
    ->prefix('products')
    ->group(function (){
    Route::get('', 'index')->name('products.index');
    Route::get('{product}', 'show')->name('products.show');
    });


