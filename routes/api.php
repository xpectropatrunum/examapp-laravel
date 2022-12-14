<?php

use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;
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

Route::group([
    'middleware' => ['cors'],
], function ($router) {

    Route::get('/', function () {
        echo "Hello World!";
    })->name("api");
    Route::get('user', [LoginController::class, "user"]);
    Route::post('refresh', [LoginController::class, "refresh"]);
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
    Route::middleware("auth")->group(function () {
        Route::prefix('users')->group(function () {
            Route::post("update", [UserController::class, "update"]);
            Route::post("change-image", [UserController::class, "changeImage"]);
        });
        Route::prefix('exams')->group(function () {
            Route::get("get", [ExamController::class, "index"]);
            Route::get("init/{exam}", [ExamController::class, "init"]);
            Route::get("get/{exam}", [ExamController::class, "get"]);
            Route::post("{exam}/submit-answer", [ExamController::class, "submitAnswer"]);
            Route::post("{exam}/finish", [ExamController::class, "finishExam"]);
            Route::get("exam-reports", [ExamController::class, "examReports"]);
            Route::get("exam-reports/{report}", [ExamController::class, "getReport"]);
            //Route::post("change-image", [UserController::class, "changeImage"]);
        });
    });
});
