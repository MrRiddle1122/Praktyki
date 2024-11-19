<?php

use App\Http\Controllers\Callendar;
use App\Http\Controllers\Day_plan;
use App\Http\Controllers\Show_logs;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [Callendar::class, 'index']);
Route::get('/{month}', [Callendar::class, 'index']);
Route::get('/day_plan/{month}', [Day_plan::class, 'index']);
Route::post('/day_plan/{month}', [Day_plan::class, 'insert_data']);
Route::get('/show/logs', [Show_logs::class, 'index']);

