<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;

Route::post('user/registration', [AuthController::class, 'register'])->name('user.registration');

Route::post('user/login', [AuthController::class, 'login'])->name('user.login');

Route::post('user/logout', [AuthController::class, 'logout'])->name('user.logout')->middleware('auth:sanctum');

Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store')->middleware('auth:sanctum');