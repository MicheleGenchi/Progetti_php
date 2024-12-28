<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome'); // laravel page 
Route::view('/testconnection','connection'); // test connessione al database

/* pagine per utente */
Route::view('/utente/registra', 'utente/registra');//registra un nuovo utente
Route::view('/utente/visualizza', 'utente/visualizza');//visualizza utenti

