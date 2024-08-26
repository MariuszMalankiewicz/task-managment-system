<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Authentication\AuthenticationUserController;

Route::post('user/registration', [AuthenticationUserController::class, 'register'])->name('user.registration');

Route::post('user/login', [AuthenticationUserController::class, 'login'])->name('user.login');

Route::post('user/logout', [AuthenticationUserController::class, 'logout'])->name('user.logout')->middleware('auth:sanctum');

