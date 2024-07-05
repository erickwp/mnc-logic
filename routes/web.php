<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/soal1', [TestController::class, 'soal1']);
Route::get('/soal2', [TestController::class, 'soal2']);
Route::get('/soal3', [TestController::class, 'soal3']);
Route::get('/soal4', [TestController::class, 'soal4']);
