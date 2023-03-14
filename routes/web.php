<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ParkirController;
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

Route::middleware(['auth_check'])->group(function(){
    Route::get('/', [ParkirController::class, 'index']);
});
Route::get('/login', [LoginController::class, 'index']);

// API
Route::prefix('/api')->group(function(){
    Route::get('/parkir', [ParkirController::class, 'getAll']);
    Route::post('/parkir', [ParkirController::class, 'insert']);
    Route::get('/parkir/{id}', [ParkirController::class, 'getOne']);
    Route::get('/parkir/{startDate}/{endDate}', [ParkirController::class, 'getByDateRange']);
    Route::delete('/parkir/{id}', [ParkirController::class, 'delete']);
    Route::put('/parkir/keluar', [ParkirController::class, 'keluarParkir']);
    Route::post('/login-process', [LoginController::class, 'loginProcess']);
});
