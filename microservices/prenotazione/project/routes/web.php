<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/prenotazione', function ():Factory|View {
    return view('home');
});

Route::get('/prenotazione/sportello', function ():Factory|View {
    return view('sportello1');
});

Route::get('/prenotazione/tabellone', function ():Factory|View {
    return view('tabellone');
});