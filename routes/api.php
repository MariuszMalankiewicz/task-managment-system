<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;

Route::post('user/registration', [AuthController::class, 'register'])->name('user.registration');

Route::post('user/login', [AuthController::class, 'login'])->name('user.login');

Route::post('user/logout', [AuthController::class, 'logout'])->name('user.logout')->middleware('auth:sanctum');

Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store')->middleware('auth:sanctum');

Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index')->middleware('auth:sanctum');

Route::put('tasks/{id}', [TaskController::class, 'update'])->name('tasks.update')->middleware('auth:sanctum');

Route::delete('tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.delete')->middleware('auth:sanctum');