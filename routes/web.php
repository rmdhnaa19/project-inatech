<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\AlatGudangController;
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
use App\Http\Controllers\PakanController;
use App\Http\Controllers\PakanGudangController;
use App\Http\Controllers\PJGudangController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [LoginController::class, 'index'])->name('login.index')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');
// Route::post('/logout', function () {
//     Auth::logout();
//     return redirect('/');
// })->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['auth', 'no-back']);

// Interface Admin
Route::group(['prefix' => 'kelolaPengguna'], function(){
    Route::get('/', [UserController::class, 'index'])->name('admin.kelolaPengguna.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [UserController::class, 'list'])->name('admin.kelolaPengguna.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [UserController::class, 'create'])->name('admin.kelolaPengguna.create')->middleware(['auth', 'no-back']);
    Route::post('/', [UserController::class, 'store'])->name('admin.kelolaPengguna.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [UserController::class, 'show'])->name('admin.kelolaPengguna.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.kelolaPengguna.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [UserController::class, 'update'])->name('admin.kelolaPengguna.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.kelolaPengguna.destroy')->middleware(['auth', 'no-back']);
});

Route::group(['prefix' => 'kelolaGudang'], function(){
    Route::get('/', [GudangController::class, 'index'])->name('admin.kelolaGudang.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [GudangController::class, 'list'])->name('admin.kelolaGudang.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [GudangController::class, 'create'])->name('admin.kelolaGudang.create')->middleware(['auth', 'no-back']);
    Route::post('/', [GudangController::class, 'store'])->name('admin.kelolaGudang.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [GudangController::class, 'show'])->name('admin.kelolaGudang.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [GudangController::class, 'edit'])->name('admin.kelolaGudang.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [GudangController::class, 'update'])->name('admin.kelolaGudang.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [GudangController::class, 'destroy'])->name('admin.kelolaGudang.destroy')->middleware(['auth', 'no-back']);
});

Route::group(['prefix' => 'kelolaPJGudang'], function(){
    Route::get('/', [PJGudangController::class, 'index'])->name('admin.kelolaPJGudang.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [PJGudangController::class, 'list'])->name('admin.kelolaPJGudang.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [PJGudangController::class, 'create'])->name('admin.kelolaPJGudang.create')->middleware(['auth', 'no-back']);
    Route::post('/', [PJGudangController::class, 'store'])->name('admin.kelolaPJGudang.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [PJGudangController::class, 'show'])->name('admin.kelolaPJGudang.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [PJGudangController::class, 'edit'])->name('admin.kelolaPJGudang.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [PJGudangController::class, 'update'])->name('admin.kelolaPJGudang.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [PJGudangController::class, 'destroy'])->name('admin.kelolaPJGudang.destroy')->middleware(['auth', 'no-back']);
});

Route::group(['prefix' => 'kelolaPakan'], function(){
    Route::get('/', [PakanController::class, 'index'])->name('admin.kelolaPakan.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [PakanController::class, 'list'])->name('admin.kelolaPakan.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [PakanController::class, 'create'])->name('admin.kelolaPakan.create')->middleware(['auth', 'no-back']);
    Route::post('/', [PakanController::class, 'store'])->name('admin.kelolaPakan.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [PakanController::class, 'show'])->name('admin.kelolaPakan.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [PakanController::class, 'edit'])->name('admin.kelolaPakan.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [PakanController::class, 'update'])->name('admin.kelolaPakan.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [PakanController::class, 'destroy'])->name('admin.kelolaPakan.destroy')->middleware(['auth', 'no-back']);
});

Route::group(['prefix' => 'kelolaPakanGudang'], function(){
    Route::get('/', [PakanGudangController::class, 'index'])->name('admin.kelolaPakanGudang.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [PakanGudangController::class, 'list'])->name('admin.kelolaPakanGudang.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [PakanGudangController::class, 'create'])->name('admin.kelolaPakanGudang.create')->middleware(['auth', 'no-back']);
    Route::post('/', [PakanGudangController::class, 'store'])->name('admin.kelolaPakanGudang.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [PakanGudangController::class, 'show'])->name('admin.kelolaPakanGudang.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [PakanGudangController::class, 'edit'])->name('admin.kelolaPakanGudang.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [PakanGudangController::class, 'update'])->name('admin.kelolaPakanGudang.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [PakanGudangController::class, 'destroy'])->name('admin.kelolaPakanGudang.destroy')->middleware(['auth', 'no-back']);
});

Route::group(['prefix' => 'kelolaAlat'], function(){
    Route::get('/', [AlatController::class, 'index'])->name('admin.kelolaAlat.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [AlatController::class, 'list'])->name('admin.kelolaAlat.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [AlatController::class, 'create'])->name('admin.kelolaAlat.create')->middleware(['auth', 'no-back']);
    Route::post('/', [AlatController::class, 'store'])->name('admin.kelolaAlat.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [AlatController::class, 'show'])->name('admin.kelolaAlat.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [AlatController::class, 'edit'])->name('admin.kelolaAlat.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [AlatController::class, 'update'])->name('admin.kelolaAlat.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [AlatController::class, 'destroy'])->name('admin.kelolaAlat.destroy')->middleware(['auth', 'no-back']);
});

Route::group(['prefix' => 'kelolaAlatGudang'], function(){
    Route::get('/', [AlatGudangController::class, 'index'])->name('admin.kelolaAlatGudang.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [AlatGudangController::class, 'list'])->name('admin.kelolaAlatGudang.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [AlatGudangController::class, 'create'])->name('admin.kelolaAlatGudang.create')->middleware(['auth', 'no-back']);
    Route::post('/', [AlatGudangController::class, 'store'])->name('admin.kelolaAlatGudang.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [AlatGudangController::class, 'show'])->name('admin.kelolaAlatGudang.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [AlatGudangController::class, 'edit'])->name('admin.kelolaAlatGudang.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [AlatGudangController::class, 'update'])->name('admin.kelolaAlatGudang.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [AlatGudangController::class, 'destroy'])->name('admin.kelolaAlatGudang.destroy')->middleware(['auth', 'no-back']);
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
    Route::put('/{id}', [KolamController::class, 'update'])->name('kolam.update');
    Route::delete('/{id}', [KolamController::class, 'destroy'])->name('kolam.destroy');
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
    Route::get('/', [AncoController::class, 'index'])->name('anco.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [AncoController::class, 'list'])->name('anco.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [AncoController::class, 'create'])->name('anco.create')->middleware(['auth', 'no-back']);
    Route::post('/', [AncoController::class, 'store'])->name('anco.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [AncoController::class, 'show'])->name('anco.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [AncoController::class, 'edit'])->name('anco.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [AncoController::class, 'update'])->name('anco.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [AncoController::class, 'destroy'])->name('anco.destroy')->middleware(['auth', 'no-back']);
});

// Route kualitas air
Route::group(['prefix' => 'kualitasair'], function(){
    Route::get('/', [KualitasAirController::class, 'index'])->name('kualitasair.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [KualitasAirController::class, 'list'])->name('kualitasair.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [KualitasAirController::class, 'create'])->name('kualitasair.create')->middleware(['auth', 'no-back']);
    Route::post('/', [KualitasAirController::class, 'store'])->name('kualitasair.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [KualitasAirController::class, 'show'])->name('kualitasair.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [KualitasAirController::class, 'edit'])->name('kualitasair.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [KualitasAirController::class, 'update'])->name('kualitasair.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [KualitasAirController::class, 'destroy'])->name('kualitasair.destroy')->middleware(['auth', 'no-back']);
});

// Route penanganan
Route::group(['prefix' => 'penanganan'], function(){
    Route::get('/', [PenangananController::class, 'index'])->name('penanganan.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [PenangananController::class, 'list'])->name('penanganan.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [PenangananController::class, 'create'])->name('penanganan.create')->middleware(['auth', 'no-back']);
    Route::post('/', [PenangananController::class, 'store'])->name('penanganan.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [PenangananController::class, 'show'])->name('penanganan.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [PenangananController::class, 'edit'])->name('penanganan.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [PenangananController::class, 'update'])->name('penanganan.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [PenangananController::class, 'destroy'])->name('penanganan.destroy')->middleware(['auth', 'no-back']);
});

// Route sampling
Route::group(['prefix' => 'sampling'], function(){
    Route::get('/', [SamplingController::class, 'index'])->name('sampling.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [SamplingController::class, 'list'])->name('sampling.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [SamplingController::class, 'create'])->name('sampling.create')->middleware(['auth', 'no-back']);
    Route::post('/', [SamplingController::class, 'store'])->name('sampling.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [SamplingController::class, 'show'])->name('sampling.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [SamplingController::class, 'edit'])->name('sampling.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [SamplingController::class, 'update'])->name('sampling.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [SamplingController::class, 'destroy'])->name('sampling.destroy')->middleware(['auth', 'no-back']);
});

// Route pakan harian
Route::group(['prefix' => 'pakanHarian'], function(){
    Route::get('/', [PakanHarianController::class, 'index'])->name('pakanharian.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [PakanHarianController::class, 'list'])->name('pakanharian.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [PakanHarianController::class, 'create'])->name('pakanharian.create')->middleware(['auth', 'no-back']);
    Route::post('/', [PakanHarianController::class, 'store'])->name('pakanharian.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [PakanHarianController::class, 'show'])->name('pakanharian.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [PakanHarianController::class, 'edit'])->name('pakanharian.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [PakanHarianController::class, 'update'])->name('pakanharian.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [PakanHarianController::class, 'destroy'])->name('pakanharian.destroy')->middleware(['auth', 'no-back']);
});

// Route kematian udang
Route::group(['prefix' => 'kematianUdang'], function(){
    Route::get('/', [KematianUdangController::class, 'index'])->name('kematianudang.index')->middleware(['auth', 'no-back']);
    Route::post('/list', [KematianUdangController::class, 'list'])->name('kematianudang.list')->middleware(['auth', 'no-back']);
    Route::get('/create', [KematianUdangController::class, 'create'])->name('kematianudang.create')->middleware(['auth', 'no-back']);
    Route::post('/', [KematianUdangController::class, 'store'])->name('kematianudang.store')->middleware(['auth', 'no-back']);
    Route::get('/{id}', [KematianUdangController::class, 'show'])->name('kematianudang.show')->middleware(['auth', 'no-back']);
    Route::get('/{id}/edit', [KematianUdangController::class, 'edit'])->name('kematianudang.edit')->middleware(['auth', 'no-back']);
    Route::post('/{id}', [KematianUdangController::class, 'update'])->name('kematianudang.update')->middleware(['auth', 'no-back']);
    Route::delete('/{id}', [KematianUdangController::class, 'destroy'])->name('kematianudang.destroy')->middleware(['auth', 'no-back']);
});