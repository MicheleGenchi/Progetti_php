<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testconnection', function () {
    return view('connection');
});

/* pagine per utente */
Route::get('/utente/registra', function () {
    return view('utente/registra');
});

Route::get('/utente/visualizza', function () {
    return view('utente/visualizza');
});
