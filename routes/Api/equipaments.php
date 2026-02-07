<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Equipaments\EquipamentController;

Route::middleware('auth:api')->group(function () {

   Route::get('/equipaments/all', [EquipamentController::class, 'index']);
   Route::get('/equipaments/report', [EquipamentController::class, 'generatePdf']);
   Route::post('/equipaments/create', [EquipamentController::class, 'store']);
   Route::delete('/equipaments/{id}', [EquipamentController::class, 'destroy']);
   Route::delete('/equipaments/forceDelete/{id}', [EquipamentController::class, 'forceDelete']);
   Route::put('/equipaments/update/{id}', [EquipamentController::class, 'update']);
   Route::get('/equipaments/count', [EquipamentController::class, 'count']);
   Route::get('/equipaments/last', [EquipamentController::class, 'lastVaccine']);
   
});
