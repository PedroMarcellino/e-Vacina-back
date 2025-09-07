<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Leads\LeadController;

Route::middleware('auth:api')->group(function () {
        
    Route::get('/leads/all', [LeadController::class, 'getAll']); 
    Route::post('/leads/create', [LeadController::class, 'store']);
    Route::delete('/leads/{id}', [LeadController::class, 'destroy']);
    Route::delete('/leads/forceDelete/{id}', [LeadController::class, 'forceDelete']);
    Route::put('/leads/update/{id}', [LeadController::class, 'update']);
    Route::get('/leads/count', [LeadController::class, 'count']);
        
});

