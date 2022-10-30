<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('user', [LoginController::class, "user"]);
Route::get('logout', [LoginController::class, "logout"]);

Route::prefix('login')->group(function () {
    Route::get('check', [LoginController::class, "check"]);
    Route::post('/', [LoginController::class, "attempt"]);
});
Route::prefix('register')->group(function () {
    Route::post('verify-code', [LoginController::class, "verify"]);
    Route::post('resend-code', [LoginController::class, "resendCode"]);
    Route::post('finish', [LoginController::class, "finish"]);
});
