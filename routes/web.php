<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reset-password/{token}', function (string $token) {
    $email = request('email');
    $front = env('FRONTEND_URL', 'http://localhost:4200/reset-password');
    return redirect()->away($front.'?token='.$token.'&email='.urlencode($email));
})->name('password.reset');


Route::get('/mail-test', function () {
    Mail::raw('Teste Gmail Laravel funcionando 👍', function($m){
        $m->to('pedromarcellino302@gmail.com')->subject('Teste Gmail');
    });
    return 'ok';
});
