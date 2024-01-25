<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest', 'throttle:6,1'])->group(function () {

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('login');


    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->name('register');

    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed'])
        ->name('verification.verify');


    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->name('verification.send');


    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.reset');



});


Route::middleware(['auth:sanctum', 'throttle:100,1'])->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::post('profile', [UserController::class, 'index'])
        ->name('getProfile');


    Route::post('product-create', [ProductController::class, 'store'])
        ->name('getProducts');

    Route::post('product-edit/{product}', [ProductController::class, 'show'])
        ->name('editProducts');

    Route::post('product-update/{product}', [ProductController::class, 'update'])
        ->name('updateProducts');

    Route::post('product-delete/{product}', [ProductController::class, 'destroy'])
        ->name('deleteProducts');

});


Route::get('products', [ProductController::class, 'index'])
    ->name('getProducts');
