<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Vaccines\VaccineController;

Route::middleware('auth:api')->group(function () {

    Route::get('/vaccines/all', [VaccineController::class, 'index']);
    Route::get('/vaccines/report', [VaccineController::class, 'generatePdf']);
    Route::post('/vaccines/create', [VaccineController::class, 'store']);
    Route::delete('/vaccines/{id}', [VaccineController::class, 'destroy']);
    Route::delete('/vaccines/forceDelete/{id}', [VaccineController::class, 'forceDelete']);
    Route::put('/vaccines/update/{id}', [VaccineController::class, 'update']);
    Route::get('/vaccines/count', [VaccineController::class, 'count']);
    Route::get('/vaccines/last', [VaccineController::class, 'lastVaccine']);

});
