<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Authentication\AuthenticationUserController;

Route::post('user/registration', [AuthenticationUserController::class, 'register'])->name('user.registration');