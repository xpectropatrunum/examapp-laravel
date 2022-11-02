<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\ExamController as ApiExamController;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/4', function () {
    //return  phpinfo(); 
    Admin::updateOrCreate(["name" =>  "amir", "username" => "amir", "password" => Hash::make("123"),]);
});

Route::prefix("admin")->name("admin.")->group(function () {
Route::get('login', [LoginController::class, 'index'])->name("login");

    Route::get('logout', [LoginController::class, 'logout'])->name("logout");
    Route::post('login/attemp', [LoginController::class, 'loginAttemp'])->name("login.attemp");
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name("dashboard");



        Route::resource('users', UserController::class);
        Route::post('users/{user}/status', [UserController::class, 'changeStatus'])->name('users.status');

        Route::resource('exams', ExamController::class);
        Route::post('exams/{user}/status', [ExamController::class, 'changeStatus'])->name('exams.status');
        Route::post('exams/save-question/{exam}', [ExamController::class, 'saveQuestion'])->name('exams.save-question');

        Route::resource('settings', SettingController::class);

    });
});

Route::get('/pdf/{hash}',[ApiExamController::class, "pdf"])->name("pdf");
