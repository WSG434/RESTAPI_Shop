<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::controller(\App\Http\Controllers\UserController::class)->group(function(){
    Route::post('login','login')->name('login');
});
