<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Vaccines\VaccineController;

Route::middleware('auth:api')->group(function () {

    Route::get('/vaccines/all', [VaccineController::class, 'getAllVaccines']);
    Route::post('/vaccines/create', [VaccineController::class, 'store']);;
    
});