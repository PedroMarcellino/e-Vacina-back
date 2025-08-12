<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth\AuthController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use Laravel\Passport\Http\Controllers\TransientTokenController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/oauth/token', [AccessTokenController::class, 'issueToken'])
    ->middleware(['throttle']);
Route::middleware('auth:api')->get('/oauth/tokens', [AuthorizedAccessTokenController::class, 'forUser']);
Route::middleware('auth:api')->delete('/oauth/tokens/{token_id}', [AuthorizedAccessTokenController::class, 'destroy']);
Route::middleware('auth:api')->post('/oauth/personal-access-tokens', [PersonalAccessTokenController::class, 'store']);
Route::middleware('auth:api')->get('/oauth/personal-access-tokens', [PersonalAccessTokenController::class, 'forUser']);
Route::middleware('auth:api')->delete('/oauth/personal-access-tokens/{token_id}', [PersonalAccessTokenController::class, 'destroy']);
Route::middleware('auth:api')->get('/oauth/token/refresh', [TransientTokenController::class, 'refresh']);

