<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

Route::View('/', 'welcome');
Route::Get('testconnessione', [Controller::class, 'testconnection']);
Route::View('connessione', 'connessione');
