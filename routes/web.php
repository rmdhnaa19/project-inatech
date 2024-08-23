<?php

use App\Http\Controllers\CobaController;
use App\Http\Controllers\DashboardController;
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
    Route::get('/', [UserController::class, 'index'])->name('kelolaPengguna.index');
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create'])->name('kelolaPengguna.create');
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show'])->name('kelolaPengguna.show');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('kelolaPengguna.edit');
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');