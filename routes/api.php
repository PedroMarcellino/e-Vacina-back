<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\LoginController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);