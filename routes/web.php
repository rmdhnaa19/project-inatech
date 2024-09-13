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
use App\Http\Controllers\AncoController;
use App\Http\Controllers\KualitasAirController;
use App\Http\Controllers\PenangananController;
use App\Http\Controllers\SamplingController;
use App\Http\Controllers\PakanHarianController;
use App\Http\Controllers\KematianUdangController;
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

Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

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
    Route::post('/list', [GudangController::class, 'list'])->name('kelolaGudang.list');
    Route::get('/create', [GudangController::class, 'create'])->name('kelolaGudang.create');
    Route::post('/', [GudangController::class, 'store'])->name('kelolaGudang.store');
    Route::get('/{id}', [GudangController::class, 'show'])->name('kelolaGudang.show');
    Route::get('/{id}/edit', [GudangController::class, 'edit'])->name('kelolaGudang.edit');
    Route::put('/{id}', [GudangController::class, 'update'])->name('kelolaGudang.update');
    Route::delete('/{id}', [GudangController::class, 'destroy'])->name('kelolaGudang.destroy');
});

// manajemen tambak
Route::group(['prefix' => 'tambak'], function(){
    Route::get('/', [TambakController::class, 'index'])->name('tambak.index');
    Route::post('/list', [TambakController::class, 'list'])->name('tambak.list');
    Route::get('/create', [TambakController::class, 'create'])->name('tambak.create');
    Route::post('/', [TambakController::class, 'store'])->name('tambak.store');
    Route::get('/{id}', [TambakController::class, 'show'])->name('tambak.show');
    Route::get('/{id}/edit', [TambakController::class, 'edit'])->name('tambak.edit');
    Route::put('/{id}', [TambakController::class, 'update'])->name('tambak.update');
    Route::delete('/{id}', [TambakController::class, 'destroy'])->name('tambak.destroy');
});

// Route manajemen kolam
Route::group(['prefix' => 'kolam'], function(){
    Route::get('/', [KolamController::class, 'index'])->name('kolam.index');
    Route::post('/list', [KolamController::class, 'list'])->name('kolam.list');
    Route::get('/create', [KolamController::class, 'create'])->name('kolam.create');
    Route::post('/', [KolamController::class, 'store'])->name('kolam.store');
    Route::get('/{id}', [KolamController::class, 'show'])->name('kolam.show');
    Route::get('/{id}/edit', [KolamController::class, 'edit'])->name('kolam.edit');
    Route::put('/{id}', [KolamController::class, 'update']);
    Route::delete('/{id}', [KolamController::class, 'destroy']);
});

// Route fase tambak
Route::group(['prefix' => 'fasekolam'], function(){
    Route::get('/', [FaseKolamController::class, 'index'])->name('fasekolam.index');
    Route::post('/list', [FaseKolamController::class, 'list'])->name('fasekolam.list');
    Route::get('/create', [FaseKolamController::class, 'create'])->name('fasekolam.create');
    Route::post('/', [FaseKolamController::class, 'store'])->name('fasekolam.store');
    Route::get('/{id}', [FaseKolamController::class, 'show'])->name('fasekolam.show');
    Route::get('/{id}/edit', [FaseKolamController::class, 'edit'])->name('fasekolam.edit');
    Route::put('/{id}', [FaseKolamController::class, 'update'])->name('fasekolam.update');
    Route::delete('/{id}', [FaseKolamController::class, 'destroy'])->name('fasekolam.destroy');
});

// Route manajemen pj tambak
Route::group(['prefix' => 'pjTambak'], function(){
    Route::get('/', [PjTambakController::class, 'index'])->name('pjTambak.index');
    Route::post('/list', [PjTambakController::class, 'list'])->name('pjTambak.list');
    Route::get('/create', [PjTambakController::class, 'create'])->name('pjTambak.create');
    Route::post('/', [PjTambakController::class, 'store'])->name('pjTambak.store');
    Route::get('/{id}', [PjTambakController::class, 'show'])->name('pjTambak.show');
    Route::get('/{id}/edit', [PjTambakController::class, 'edit'])->name('pjTambak.edit');
    Route::put('/{id}', [PjTambakController::class, 'update'])->name('pjTambak.update');
    Route::delete('/{id}', [PjTambakController::class, 'destroy'])->name('pjTambak.destroy');
});

// Route anco
Route::group(['prefix' => 'anco'], function(){
    Route::get('/', [AncoController::class, 'index'])->name('anco.index');
    Route::post('/list', [AncoController::class, 'list']);
    Route::get('/create', [AncoController::class, 'create'])->name('anco.create');
    Route::post('/', [AncoController::class, 'store'])->name('anco.store');
    Route::get('/{id}', [AncoController::class, 'show'])->name('anco.show');
    Route::get('/{id}/edit', [AncoController::class, 'edit'])->name('anco.edit');
    Route::put('/{id}', [AncoController::class, 'update']);
    Route::delete('/{id}', [AncoController::class, 'destroy']);
});

// Route kualitas air
Route::group(['prefix' => 'kualitasair'], function(){
    Route::get('/', [KualitasAirController::class, 'index'])->name('kualitasair.index');
    Route::post('/list', [KualitasAirController::class, 'list']);
    Route::get('/create', [KualitasAirController::class, 'create'])->name('kualitasair.create');
    Route::post('/', [KualitasAirController::class, 'store'])->name('kualitasair.store');
    Route::get('/{id}', [KualitasAirController::class, 'show'])->name('kualitasair.show');
    Route::get('/{id}/edit', [KualitasAirController::class, 'edit'])->name('kualitasair.edit');
    Route::put('/{id}', [KualitasAirController::class, 'update']);
    Route::delete('/{id}', [KualitasAirController::class, 'destroy']);
});

// Route penanganan
Route::group(['prefix' => 'penanganan'], function(){
    Route::get('/', [PenangananController::class, 'index'])->name('penanganan.index');
    Route::post('/list', [PenangananController::class, 'list']);
    Route::get('/create', [PenangananController::class, 'create'])->name('penanganan.create');
    Route::post('/', [PenangananController::class, 'store'])->name('penanganan.store');
    Route::get('/{id}', [PenangananController::class, 'show'])->name('penanganan.show');
    Route::get('/{id}/edit', [PenangananController::class, 'edit'])->name('penanganan.edit');
    Route::put('/{id}', [PenangananController::class, 'update']);
    Route::delete('/{id}', [PenangananController::class, 'destroy']);
});

// Route sampling
Route::group(['prefix' => 'sampling'], function(){
    Route::get('/', [SamplingController::class, 'index'])->name('sampling.index');
    Route::post('/list', [SamplingController::class, 'list']);
    Route::get('/create', [SamplingController::class, 'create'])->name('sampling.create');
    Route::post('/', [SamplingController::class, 'store'])->name('sampling.store');
    Route::get('/{id}', [SamplingController::class, 'show'])->name('sampling.show');
    Route::get('/{id}/edit', [SamplingController::class, 'edit'])->name('sampling.edit');
    Route::put('/{id}', [SamplingController::class, 'update']);
    Route::delete('/{id}', [SamplingController::class, 'destroy']);
});

// Route pakan harian
Route::group(['prefix' => 'pakanHarian'], function(){
    Route::get('/', [PakanHarianController::class, 'index'])->name('pakanharian.index');
    Route::post('/list', [PakanHarianController::class, 'list']);
    Route::get('/create', [PakanHarianController::class, 'create'])->name('pakanharian.create');
    Route::post('/', [PakanHarianController::class, 'store'])->name('pakanharian.store');
    Route::get('/{id}', [PakanHarianController::class, 'show'])->name('pakanharian.show');
    Route::get('/{id}/edit', [PakanHarianController::class, 'edit'])->name('pakanharian.edit');
    Route::put('/{id}', [PakanHarianController::class, 'update']);
    Route::delete('/{id}', [PakanHarianController::class, 'destroy']);
});

// Route kematian udang
Route::group(['prefix' => 'kematianUdang'], function(){
    Route::get('/', [KematianUdangController::class, 'index'])->name('kematianudang.index');
    Route::post('/list', [KematianUdangController::class, 'list']);
    Route::get('/create', [KematianUdangController::class, 'create'])->name('kematianudang.create');
    Route::post('/', [KematianUdangController::class, 'store'])->name('kematianudang.store');
    Route::get('/{id}', [KematianUdangController::class, 'show'])->name('kematianudang.show');
    Route::get('/{id}/edit', [KematianUdangController::class, 'edit'])->name('kematianudang.edit');
    Route::put('/{id}', [KematianUdangController::class, 'update']);
    Route::delete('/{id}', [KematianUdangController::class, 'destroy']);
});