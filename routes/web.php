<?php

use App\Http\Controllers\CobaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TambakController;
use App\Http\Controllers\KolamController;
use Illuminate\Support\Facades\Route;

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

Route::get('/coba',[CobaController::class, 'index']);

Route::get('/', [LoginController::class, 'index']);
Route::get('/login', [LoginController::class, 'authenticate']);

Route::group(['prefix' => 'kelolaPengguna'], function(){
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::group(['prefix' => 'manajemenTambak'], function(){
    Route::get('/', [TambakController::class, 'index']);
    Route::post('/list', [TambakController::class, 'list']);
    Route::get('/create', [TambakController::class, 'create']);
    Route::post('/', [TambakController::class, 'store']);
    Route::get('/{id}', [TambakController::class, 'show']);
    Route::get('/{id}/edit', [TambakController::class, 'edit']);
    Route::put('/{id}', [TambakController::class, 'update']);
    Route::delete('/{id}', [TambakController::class, 'destroy']);
});

Route::group(['prefix' => 'manajemenKolam'], function(){
    Route::get('/', [KolamController::class, 'index']);
    Route::post('/list', [KolamController::class, 'list']);
    Route::get('/create', [KolamController::class, 'create']);
    Route::post('/', [KolamController::class, 'store']);
    Route::get('/{id}', [KolamController::class, 'show']);
    Route::get('/{id}/edit', [KolamController::class, 'edit']);
    Route::put('/{id}', [KolamController::class, 'update']);
    Route::delete('/{id}', [KolamController::class, 'destroy']);
});