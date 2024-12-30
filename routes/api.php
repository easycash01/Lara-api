<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerAuthController;
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

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});

//nello user la register non serve 
/* Route::post('/register', [AuthController::class, 'register']); */


Route::get('/allutenti', [ProvaApiController::class, 'prova']);

// Rotte per Customers
Route::group(['prefix' => 'customer'], function () {
    Route::post('/login', [CustomerAuthController::class, 'login']);
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::get('/profile', [CustomerAuthController::class, 'profile']);
});