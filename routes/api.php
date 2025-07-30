<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', [LoginController::class, 'login']);

Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {

    Route::put('user/enable/{id}', [UserController::class, 'enable'])->name('user.enable');

    Route::put('/logout', [AuthController::class, 'logout'])->name('user.logout');

    Route::put('user/disable/{id}', [UserController::class, 'disable'])->name('user.disable');

    Route::put('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');

    Route::delete('user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
});