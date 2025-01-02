<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProvaApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

/* prefisso api/auth */
Route::group([
    'prefix' => 'auth'
], function () {
    // Rotte pubbliche
    Route::middleware(['prevent.authenticated:api'])->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });

    // Rotte autenticate senza controllo del tipo utente
    Route::middleware(['auth:api'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });

    // Rotte che richiedono controllo del tipo utente
    Route::middleware(['auth:api', 'check.usertype:user'])->group(function () {
        Route::post('me', [AuthController::class, 'me']);
        // altre rotte che necessitano verifica del tipo utente
    });
});

// Rotta pubblica di test
Route::get('/allutenti', [ProvaApiController::class, 'prova']);
