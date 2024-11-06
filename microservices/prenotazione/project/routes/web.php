<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


Route::get('/', function () :Factory|View {
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