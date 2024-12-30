<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerAuthController;


/* prefisso api/customer */

Route::post('login', [CustomerAuthController::class, 'login']);

Route::group([
    'middleware' => 'api'
], function ($router) {
    Route::get('profile', [CustomerAuthController::class, 'profile']);
    
});