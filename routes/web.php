<?php

use App\Http\Controllers\DayFourController;
use App\Http\Controllers\DayOneController;
use App\Http\Controllers\DayThreeController;
use App\Http\Controllers\DayTwoController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/day1', DayOneController::class)->name('day1');

Route::get('/day2', DayTwoController::class)->name('day2');

Route::get('/day3', DayThreeController::class)->name('day3');

Route::get('/day4', DayFourController::class)->name('day4');
