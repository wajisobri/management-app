<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectFileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::get('/email/verify', [EmailVerificationController::class, 'verify'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'doVerify'])->middleware(['signed.email'])->name('verification.verify');
Route::post('/email/verification-notification', [EmailVerificationController::class, 'doResend'])->middleware(['throttle:6,1'])->name('verification.send');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::group(['middleware' => 'verified'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/list', [ProjectController::class, 'list'])->name('projects.list');
        // Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        // Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
        Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

        Route::get('/projects/{id}/files', [ProjectFileController::class, 'index'])->name('projects.files.index');
        Route::post('/projects/{id}/files', [ProjectFileController::class, 'store'])->name('projects.files.store');
        Route::delete('/projects/{id}/files/{fileId}', [ProjectFileController::class, 'destroy'])->name('projects.files.destroy');
        Route::get('/projects/{id}/files/{fileId}', [ProjectFileController::class, 'download'])->name('projects.files.download');
    });
});
