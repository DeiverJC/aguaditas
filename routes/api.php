<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', \App\Http\Controllers\Restify\Auth\LoginController::class)
    ->middleware('throttle:6,1')
    ->name('restify.login');

// Route::post('register', \App\Http\Controllers\Restify\Auth\RegisterController::class)
//     ->name('restify.register');

Route::post('forgotPassword', \App\Http\Controllers\Restify\Auth\ForgotPasswordController::class)
    ->middleware('throttle:6,1')
    ->name('restify.forgotPassword');

Route::post('resetPassword', \App\Http\Controllers\Restify\Auth\ResetPasswordController::class)
    ->middleware('throttle:6,1')
    ->name('restify.resetPassword');

Route::post('verify/{id}/{hash}', \App\Http\Controllers\Restify\Auth\VerifyController::class)
    ->middleware('throttle:6,1')
    ->name('restify.verify');

Route::post('logout', \App\Http\Controllers\Restify\Auth\LogoutController::class)
    ->middleware('auth:sanctum')
    ->name('restify.logout');
