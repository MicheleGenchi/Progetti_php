<?php


use App\Http\Controllers\Controller;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::view('home', 'home');
Route::get('xdebug', [Controller::class, 'xdebug']);
Route::view('connessione', 'connessione');
Route::get('testconnessione', [Controller::class, 'testconnessione']);
Route::view('sceltaTemplate', 'sceltaTemplate');
Route::post('upload', [UploadController::class, 'upload']);