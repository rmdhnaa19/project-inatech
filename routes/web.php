<?php

use App\Http\Controllers\CobaController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TambakController;
use App\Http\Controllers\KolamController;
use App\Http\Controllers\FaseKolamController;
use App\Http\Controllers\PjTambakController;
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
    Route::post('/list', [UserController::class, 'list'])->name('kelolaPengguna.list');
    Route::get('/create', [UserController::class, 'create'])->name('kelolaPengguna.create');
    Route::post('/', [UserController::class, 'store'])->name('kelolaPengguna.store');
    Route::get('/{id}', [UserController::class, 'show'])->name('kelolaPengguna.show');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('kelolaPengguna.edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('kelolaPengguna.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('kelolaPengguna.destroy');
});

Route::group(['prefix' => 'kelolaGudang'], function(){
    Route::get('/', [GudangController::class, 'index'])->name('kelolaGudang.index');
    Route::post('/list', [GudangController::class, 'list']);
    Route::get('/create', [GudangController::class, 'create'])->name('kelolaGudang.create');
    Route::post('/', [GudangController::class, 'store']);
    Route::get('/{id}', [GudangController::class, 'show'])->name('kelolaGudang.show');
    Route::get('/{id}/edit', [GudangController::class, 'edit'])->name('kelolaGudang.edit');
    Route::put('/{id}', [GudangController::class, 'update']);
    Route::delete('/{id}', [GudangController::class, 'destroy']);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::group(['prefix' => 'manajemenTambak'], function(){
    Route::get('/', [TambakController::class, 'index'])->name('tambak.index');
    Route::post('/list', [TambakController::class, 'list']);
    Route::get('/create', [TambakController::class, 'create'])->name('tambak.create');
    Route::post('/', [TambakController::class, 'store']);
    Route::get('/{id}', [TambakController::class, 'show'])->name('tambak.show');
    Route::get('/{id}/edit', [TambakController::class, 'edit'])->name('tambak.edit');
    Route::put('/{id}', [TambakController::class, 'update']);
    Route::delete('/{id}', [TambakController::class, 'destroy']);
});

// Route manajemen kolam
Route::group(['prefix' => 'manajemenKolam'], function(){
    Route::get('/', [KolamController::class, 'index'])->name('kolam.index');
    Route::post('/list', [KolamController::class, 'list']);
    Route::get('/create', [KolamController::class, 'create'])->name('kolam.create');
    Route::post('/', [KolamController::class, 'store']);
    Route::get('/{id}', [KolamController::class, 'show'])->name('kolam.show');
    Route::get('/{id}/edit', [KolamController::class, 'edit'])->name('kolam.edit');
    Route::put('/{id}', [KolamController::class, 'update']);
    Route::delete('/{id}', [KolamController::class, 'destroy']);
});

// Route fase tambak
Route::group(['prefix' => 'faseKolam'], function(){
    Route::get('/', [FaseKolamController::class, 'index'])->name('fasekolam.index');
    Route::post('/list', [FaseKolamController::class, 'list']);
    Route::get('/create', [FaseKolamController::class, 'create'])->name('fasekolam.create');
    Route::post('/', [FaseKolamController::class, 'store']);
    Route::get('/{id}', [FaseKolamController::class, 'show'])->name('fasekolam.show');
    Route::get('/{id}/edit', [FaseKolamController::class, 'edit'])->name('fasekolam.edit');
    Route::put('/{id}', [FaseKolamController::class, 'update']);
    Route::delete('/{id}', [FaseKolamController::class, 'destroy']);
});

// Route manajemen pj tambak
Route::group(['prefix' => 'pjTambak'], function(){
    Route::get('/', [PjTambakController::class, 'index'])->name('pjtambak.index');
    Route::post('/list', [PjTambakController::class, 'list']);
    Route::get('/create', [PjTambakController::class, 'create'])->name('pjtambak.create');
    Route::post('/', [PjTambakController::class, 'store']);
    Route::get('/{id}', [PjTambakController::class, 'show'])->name('pjtambak.show');
    Route::get('/{id}/edit', [PjTambakController::class, 'edit'])->name('pjtambak.edit');
    Route::put('/{id}', [PjTambakController::class, 'update']);
    Route::delete('/{id}', [PjTambakController::class, 'destroy']);
});
