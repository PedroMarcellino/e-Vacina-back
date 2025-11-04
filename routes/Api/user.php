<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Users\UserController;

Route::middleware('auth:api')->group(function () {
    Route::post('/users/upload-photo', [UserController::class, 'uploadPhoto']);
    Route::put('/users/update/{id}', [UserController::class, 'update']);
});