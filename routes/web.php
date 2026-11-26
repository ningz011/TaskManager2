<?php

use App\Http\Controllers\Api\TaskApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('tasks.index'));
    Route::resource('tasks', TaskController::class);

    Route::prefix('api')->group(function () {
        Route::get('/tasks', [TaskApiController::class, 'index']);
        Route::patch('/tasks/{task}/toggle', [TaskApiController::class, 'toggle']);
    });
});