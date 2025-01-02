<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\AvatarController;

// Rotte per Customers api/customer/
Route::group([
    'prefix' => 'customer'
], function () {
    // Rotte che richiedono NON essere loggati
    Route::middleware(['prevent.authenticated:customer'])->group(function () {
        Route::post('login', [CustomerAuthController::class, 'login']);
        Route::post('register', [CustomerAuthController::class, 'register']);
    });

    // Rotte protette per customers
    Route::middleware(['auth:customer'])->group(function () {
        Route::get('profile', [CustomerAuthController::class, 'profile']);
        Route::post('logout', [CustomerAuthController::class, 'logout']);
        Route::post('refresh', [CustomerAuthController::class, 'refresh']);
        
        // Rotte per gli avatar
        Route::post('avatar/upload', [AvatarController::class, 'upload']);
        Route::delete('avatar/delete', [AvatarController::class, 'delete']);
    });
});
