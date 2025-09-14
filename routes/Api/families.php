<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Families\FamilyController;

Route::middleware('auth:api')->group(function () {
    Route::get('/families/all', [FamilyController::class, 'getAllFamily']);
    Route::post('/families/create', [FamilyController::class, 'store']);
    Route::delete('/families/{id}', [FamilyController::class, 'destroy']);
    Route::delete('/families/forceDelete/{id}', [FamilyController::class, 'forceDelete']);
    Route::put('/families/update/{id}', [FamilyController::class, 'update']);
    Route::get('/families/count', [FamilyController::class, 'count']);
});