<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/prenotazione', function () {
    return view('home');
});

Route::get('/prenotazione/sportello', function () {
    return view('sportello1');
});

Route::get('/prenotazione/tabellone', function () {
    return view('tabellone');
});