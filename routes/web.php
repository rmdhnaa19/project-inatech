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
use App\Http\Controllers\EditProfileController;
use App\Http\Controllers\KualitasAirController;
use App\Http\Controllers\PenangananController;
use App\Http\Controllers\SamplingController;
use App\Http\Controllers\PakanHarianController;
use App\Http\Controllers\KematianUdangController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ObatGudangController;
use App\Http\Controllers\PakanController;
use App\Http\Controllers\PakanGudangController;
use App\Http\Controllers\PJGudangController;
use App\Http\Controllers\TransaksiAlatController;
use App\Http\Controllers\TransaksiObatController;
use App\Http\Controllers\TransaksiPakanController;
use App\Models\PakanHarianModel;
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
Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout')->middleware(['auth', 'no-back']);
Route::group(['prefix' => 'profile'], function(){
    Route::get('/{id}/edit', [EditProfileController::class, 'edit'])->name('profile.edit')->middleware(['auth', 'no-back']);
    Route::put('/{id}', [EditProfileController::class, 'update'])->name('profile.update')->middleware(['auth', 'no-back']);
    Route::get('/logout-notice', [EditProfileController::class, 'logoutNotice'])->name('profile.logout-notice')->middleware(['auth', 'no-back']);

});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


// ROUTE SUPER ADMIN
Route::middleware(['auth', 'no-back', 'role:1'])->group(function () {
    Route::group(['prefix' => 'kelolaPengguna'], function(){
        Route::get('/', [UserController::class, 'index'])->name('admin.kelolaPengguna.index');
        Route::post('/list', [UserController::class, 'list'])->name('admin.kelolaPengguna.list');
        Route::get('/create', [UserController::class, 'create'])->name('admin.kelolaPengguna.create');
        Route::post('/', [UserController::class, 'store'])->name('admin.kelolaPengguna.store');
        Route::get('/{id}', [UserController::class, 'show'])->name('admin.kelolaPengguna.show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.kelolaPengguna.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('admin.kelolaPengguna.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.kelolaPengguna.destroy');
    });
    
    Route::group(['prefix' => 'kelolaGudang'], function(){
        Route::get('/', [GudangController::class, 'index'])->name('admin.kelolaGudang.index');
        Route::post('/list', [GudangController::class, 'list'])->name('admin.kelolaGudang.list');
        Route::get('/create', [GudangController::class, 'create'])->name('admin.kelolaGudang.create');
        Route::post('/', [GudangController::class, 'store'])->name('admin.kelolaGudang.store');
        Route::get('/{id}', [GudangController::class, 'show'])->name('admin.kelolaGudang.show');
        Route::get('/{id}/edit', [GudangController::class, 'edit'])->name('admin.kelolaGudang.edit');
        Route::put('/{id}', [GudangController::class, 'update'])->name('admin.kelolaGudang.update');
        Route::delete('/{id}', [GudangController::class, 'destroy'])->name('admin.kelolaGudang.destroy');
    });
    
    Route::group(['prefix' => 'kelolaPJGudang'], function(){
        Route::get('/', [PJGudangController::class, 'index'])->name('admin.kelolaPJGudang.index');
        Route::post('/list', [PJGudangController::class, 'list'])->name('admin.kelolaPJGudang.list');
        Route::get('/create', [PJGudangController::class, 'create'])->name('admin.kelolaPJGudang.create');
        Route::post('/', [PJGudangController::class, 'store'])->name('admin.kelolaPJGudang.store');
        Route::get('/{id}', [PJGudangController::class, 'show'])->name('admin.kelolaPJGudang.show');
        Route::get('/{id}/edit', [PJGudangController::class, 'edit'])->name('admin.kelolaPJGudang.edit');
        Route::put('/{id}', [PJGudangController::class, 'update'])->name('admin.kelolaPJGudang.update');
        Route::delete('/{id}', [PJGudangController::class, 'destroy'])->name('admin.kelolaPJGudang.destroy');
    });
    
    Route::group(['prefix' => 'kelolaPakan'], function(){
        Route::get('/', [PakanController::class, 'index'])->name('admin.kelolaPakan.index');
        Route::post('/list', [PakanController::class, 'list'])->name('admin.kelolaPakan.list');
        Route::get('/create', [PakanController::class, 'create'])->name('admin.kelolaPakan.create');
        Route::post('/', [PakanController::class, 'store'])->name('admin.kelolaPakan.store');
        Route::get('/{id}', [PakanController::class, 'show'])->name('admin.kelolaPakan.show');
        Route::get('/{id}/edit', [PakanController::class, 'edit'])->name('admin.kelolaPakan.edit');
        Route::put('/{id}', [PakanController::class, 'update'])->name('admin.kelolaPakan.update');
        Route::delete('/{id}', [PakanController::class, 'destroy'])->name('admin.kelolaPakan.destroy');
    });
    
    Route::group(['prefix' => 'kelolaPakanGudang'], function(){
        Route::get('/', [PakanGudangController::class, 'index'])->name('admin.kelolaPakanGudang.index');
        Route::post('/list', [PakanGudangController::class, 'list'])->name('admin.kelolaPakanGudang.list');
        Route::get('/create', [PakanGudangController::class, 'create'])->name('admin.kelolaPakanGudang.create');
        Route::post('/', [PakanGudangController::class, 'store'])->name('admin.kelolaPakanGudang.store');
        Route::get('/{id}', [PakanGudangController::class, 'show'])->name('admin.kelolaPakanGudang.show');
        Route::get('/{id}/edit', [PakanGudangController::class, 'edit'])->name('admin.kelolaPakanGudang.edit');
        Route::put('/{id}', [PakanGudangController::class, 'update'])->name('admin.kelolaPakanGudang.update');
        Route::delete('/{id}', [PakanGudangController::class, 'destroy'])->name('admin.kelolaPakanGudang.destroy');
    });
    
    Route::group(['prefix' => 'kelolaTransaksiPakan'], function(){
        Route::get('/', [TransaksiPakanController::class, 'index'])->name('admin.kelolaTransaksiPakan.index');
        Route::post('/list', [TransaksiPakanController::class, 'list'])->name('admin.kelolaTransaksiPakan.list');
        Route::get('/create', [TransaksiPakanController::class, 'create'])->name('admin.kelolaTransaksiPakan.create');
        Route::post('/', [TransaksiPakanController::class, 'store'])->name('admin.kelolaTransaksiPakan.store');
        Route::get('/{id}', [TransaksiPakanController::class, 'show'])->name('admin.kelolaTransaksiPakan.show');
        Route::get('/{id}/edit', [TransaksiPakanController::class, 'edit'])->name('admin.kelolaTransaksiPakan.edit');
        Route::put('/{id}', [TransaksiPakanController::class, 'update'])->name('admin.kelolaTransaksiPakan.update');
        Route::delete('/{id}', [TransaksiPakanController::class, 'destroy'])->name('admin.kelolaTransaksiPakan.destroy');
    });
    
    Route::group(['prefix' => 'kelolaAlat'], function(){
        Route::get('/', [AlatController::class, 'index'])->name('admin.kelolaAlat.index');
        Route::post('/list', [AlatController::class, 'list'])->name('admin.kelolaAlat.list');
        Route::get('/create', [AlatController::class, 'create'])->name('admin.kelolaAlat.create');
        Route::post('/', [AlatController::class, 'store'])->name('admin.kelolaAlat.store');
        Route::get('/{id}', [AlatController::class, 'show'])->name('admin.kelolaAlat.show');
        Route::get('/{id}/edit', [AlatController::class, 'edit'])->name('admin.kelolaAlat.edit');
        Route::put('/{id}', [AlatController::class, 'update'])->name('admin.kelolaAlat.update');
        Route::delete('/{id}', [AlatController::class, 'destroy'])->name('admin.kelolaAlat.destroy');
    });
    
    Route::group(['prefix' => 'kelolaAlatGudang'], function(){
        Route::get('/', [AlatGudangController::class, 'index'])->name('admin.kelolaAlatGudang.index');
        Route::post('/list', [AlatGudangController::class, 'list'])->name('admin.kelolaAlatGudang.list');
        Route::get('/create', [AlatGudangController::class, 'create'])->name('admin.kelolaAlatGudang.create');
        Route::post('/', [AlatGudangController::class, 'store'])->name('admin.kelolaAlatGudang.store');
        Route::get('/{id}', [AlatGudangController::class, 'show'])->name('admin.kelolaAlatGudang.show');
        Route::get('/{id}/edit', [AlatGudangController::class, 'edit'])->name('admin.kelolaAlatGudang.edit');
        Route::put('/{id}', [AlatGudangController::class, 'update'])->name('admin.kelolaAlatGudang.update');
        Route::delete('/{id}', [AlatGudangController::class, 'destroy'])->name('admin.kelolaAlatGudang.destroy');
    });

    Route::group(['prefix' => 'kelolaTransaksiAlat'], function(){
        Route::get('/', [TransaksiAlatController::class, 'index'])->name('admin.kelolaTransaksiAlat.index');
        Route::post('/list', [TransaksiAlatController::class, 'list'])->name('admin.kelolaTransaksiAlat.list');
        Route::get('/create', [TransaksiAlatController::class, 'create'])->name('admin.kelolaTransaksiAlat.create');
        Route::post('/', [TransaksiAlatController::class, 'store'])->name('admin.kelolaTransaksiAlat.store');
        Route::get('/{id}', [TransaksiAlatController::class, 'show'])->name('admin.kelolaTransaksiAlat.show');
        Route::get('/{id}/edit', [TransaksiAlatController::class, 'edit'])->name('admin.kelolaTransaksiAlat.edit');
        Route::put('/{id}', [TransaksiAlatController::class, 'update'])->name('admin.kelolaTransaksiAlat.update');
        Route::delete('/{id}', [TransaksiAlatController::class, 'destroy'])->name('admin.kelolaTransaksiAlat.destroy');
    });
    
    Route::group(['prefix' => 'kelolaObat'], function(){
        Route::get('/', [ObatController::class, 'index'])->name('admin.kelolaObat.index');
        Route::post('/list', [ObatController::class, 'list'])->name('admin.kelolaObat.list');
        Route::get('/create', [ObatController::class, 'create'])->name('admin.kelolaObat.create');
        Route::post('/', [ObatController::class, 'store'])->name('admin.kelolaObat.store');
        Route::get('/{id}', [ObatController::class, 'show'])->name('admin.kelolaObat.show');
        Route::get('/{id}/edit', [ObatController::class, 'edit'])->name('admin.kelolaObat.edit');
        Route::put('/{id}', [ObatController::class, 'update'])->name('admin.kelolaObat.update');
        Route::delete('/{id}', [ObatController::class, 'destroy'])->name('admin.kelolaObat.destroy');
    });
    
    Route::group(['prefix' => 'kelolaObatGudang'], function(){
        Route::get('/', [ObatGudangController::class, 'index'])->name('admin.kelolaObatGudang.index');
        Route::post('/list', [ObatGudangController::class, 'list'])->name('admin.kelolaObatGudang.list');
        Route::get('/create', [ObatGudangController::class, 'create'])->name('admin.kelolaObatGudang.create');
        Route::post('/', [ObatGudangController::class, 'store'])->name('admin.kelolaObatGudang.store');
        Route::get('/{id}', [ObatGudangController::class, 'show'])->name('admin.kelolaObatGudang.show');
        Route::get('/{id}/edit', [ObatGudangController::class, 'edit'])->name('admin.kelolaObatGudang.edit');
        Route::put('/{id}', [ObatGudangController::class, 'update'])->name('admin.kelolaObatGudang.update');
        Route::delete('/{id}', [ObatGudangController::class, 'destroy'])->name('admin.kelolaObatGudang.destroy');
    });

    Route::group(['prefix' => 'kelolaTransaksiObat'], function(){
        Route::get('/', [TransaksiObatController::class, 'index'])->name('admin.kelolaTransaksiObat.index');
        Route::post('/list', [TransaksiObatController::class, 'list'])->name('admin.kelolaTransaksiObat.list');
        Route::get('/create', [TransaksiObatController::class, 'create'])->name('admin.kelolaTransaksiObat.create');
        Route::post('/', [TransaksiObatController::class, 'store'])->name('admin.kelolaTransaksiObat.store');
        Route::get('/{id}', [TransaksiObatController::class, 'show'])->name('admin.kelolaTransaksiObat.show');
        Route::get('/{id}/edit', [TransaksiObatController::class, 'edit'])->name('admin.kelolaTransaksiObat.edit');
        Route::put('/{id}', [TransaksiObatController::class, 'update'])->name('admin.kelolaTransaksiObat.update');
        Route::delete('/{id}', [TransaksiObatController::class, 'destroy'])->name('admin.kelolaTransaksiObat.destroy');
    });

    Route::group(['prefix' => 'tambak'], function(){
        Route::get('/', [TambakController::class, 'index'])->name('admin.tambak.index');
        Route::post('/list', [TambakController::class, 'list'])->name('admin.tambak.list');
        Route::get('/create', [TambakController::class, 'create'])->name('admin.tambak.create');
        Route::post('/', [TambakController::class, 'store'])->name('admin.tambak.store');
        Route::get('/{id}', [TambakController::class, 'show'])->name('admin.tambak.show');
        Route::get('/{id}/edit', [TambakController::class, 'edit'])->name('admin.tambak.edit');
        Route::put('/{id}', [TambakController::class, 'update'])->name('admin.tambak.update');
        Route::delete('/{id}', [TambakController::class, 'destroy'])->name('admin.tambak.destroy');
    });
    
    // Route manajemen kolam
    Route::group(['prefix' => 'kolam'], function(){
        Route::get('/', [KolamController::class, 'index'])->name('admin.kolam.index');
        Route::post('/list', [KolamController::class, 'list'])->name('admin.kolam.list');
        Route::get('/create', [KolamController::class, 'create'])->name('admin.kolam.create');
        Route::post('/', [KolamController::class, 'store'])->name('admin.kolam.store');
        Route::get('/{id}', [KolamController::class, 'show'])->name('admin.kolam.show');
        Route::get('/{id}/edit', [KolamController::class, 'edit'])->name('admin.kolam.edit');
        Route::put('/{id}', [KolamController::class, 'update'])->name('admin.kolam.update');
        Route::delete('/{id}', [KolamController::class, 'destroy'])->name('admin.kolam.destroy');
    });
    
    // Route fase tambak
    Route::group(['prefix' => 'fasekolam'], function(){
        Route::get('/', [FaseKolamController::class, 'index'])->name('admin.fasekolam.index');
        Route::post('/list', [FaseKolamController::class, 'list'])->name('admin.fasekolam.list');
        Route::get('/create', [FaseKolamController::class, 'create'])->name('admin.fasekolam.create');
        Route::post('/', [FaseKolamController::class, 'store'])->name('admin.fasekolam.store');
        Route::get('/{id}', [FaseKolamController::class, 'show'])->name('admin.fasekolam.show');
        Route::get('/{id}/edit', [FaseKolamController::class, 'edit'])->name('admin.fasekolam.edit');
        Route::put('/{id}', [FaseKolamController::class, 'update'])->name('admin.fasekolam.update');
        Route::delete('/{id}', [FaseKolamController::class, 'destroy'])->name('admin.fasekolam.destroy');
    });
    
    // Route manajemen pj tambak
    Route::group(['prefix' => 'pjTambak'], function(){
        Route::get('/', [PjTambakController::class, 'index'])->name('admin.pjTambak.index');
        Route::post('/list', [PjTambakController::class, 'list'])->name('admin.pjTambak.list');
        Route::get('/create', [PjTambakController::class, 'create'])->name('admin.pjTambak.create');
        Route::post('/', [PjTambakController::class, 'store'])->name('admin.pjTambak.store');
        Route::get('/{id}', [PjTambakController::class, 'show'])->name('admin.pjTambak.show');
        Route::get('/{id}/edit', [PjTambakController::class, 'edit'])->name('admin.pjTambak.edit');
        Route::put('/{id}', [PjTambakController::class, 'update'])->name('admin.pjTambak.update');
        Route::delete('/{id}', [PjTambakController::class, 'destroy'])->name('admin.pjTambak.destroy');
    });
    
    Route::group(['prefix' => 'anco'], function(){
        Route::get('/', [AncoController::class, 'index'])->name('admin.anco.index');
        Route::post('/list', [AncoController::class, 'list'])->name('admin.anco.list');
        Route::get('/create', [AncoController::class, 'create'])->name('admin.anco.create');
        Route::post('/', [AncoController::class, 'store'])->name('admin.anco.store');
        Route::get('/{id}', [AncoController::class, 'show'])->name('admin.anco.show');
        Route::get('/{id}/edit', [AncoController::class, 'edit'])->name('admin.anco.edit');
        Route::put('/{id}', [AncoController::class, 'update'])->name('admin.anco.update');
        Route::delete('/{id}', [AncoController::class, 'destroy'])->name('admin.anco.destroy');
    });

    Route::group(['prefix' => 'kualitasair'], function(){
        Route::get('/', [KualitasAirController::class, 'index'])->name('admin.kualitasair.index');
        Route::post('/list', [KualitasAirController::class, 'list'])->name('admin.kualitasair.list');
        Route::get('/create', [KualitasAirController::class, 'create'])->name('admin.kualitasair.create');
        Route::post('/', [KualitasAirController::class, 'store'])->name('admin.kualitasair.store');
        Route::get('/{id}', [KualitasAirController::class, 'show'])->name('admin.kualitasair.show');
        Route::get('/{id}/edit', [KualitasAirController::class, 'edit'])->name('admin.kualitasair.edit');
        Route::put('/{id}', [KualitasAirController::class, 'update'])->name('admin.kualitasair.update');
        Route::delete('/{id}', [KualitasAirController::class, 'destroy'])->name('admin.kualitasair.destroy');
    });

    Route::group(['prefix' => 'penanganan'], function(){
        Route::get('/', [PenangananController::class, 'index'])->name('admin.penanganan.index');
        Route::post('/list', [PenangananController::class, 'list'])->name('admin.penanganan.list');
        Route::get('/create', [PenangananController::class, 'create'])->name('admin.penanganan.create');
        Route::post('/', [PenangananController::class, 'store'])->name('admin.penanganan.store');
        Route::get('/{id}', [PenangananController::class, 'show'])->name('admin.penanganan.show');
        Route::get('/{id}/edit', [PenangananController::class, 'edit'])->name('admin.penanganan.edit');
        Route::put('/{id}', [PenangananController::class, 'update'])->name('admin.penanganan.update');
        Route::delete('/{id}', [PenangananController::class, 'destroy'])->name('admin.penanganan.destroy');
    });

    Route::group(['prefix' => 'sampling'], function(){
        Route::get('/', [SamplingController::class, 'index'])->name('admin.sampling.index');
        Route::post('/list', [SamplingController::class, 'list'])->name('admin.sampling.list');
        Route::get('/create', [SamplingController::class, 'create'])->name('admin.sampling.create');
        Route::post('/', [SamplingController::class, 'store'])->name('admin.sampling.store');
        Route::get('/{id}', [SamplingController::class, 'show'])->name('admin.sampling.show');
        Route::get('/{id}/edit', [SamplingController::class, 'edit'])->name('admin.sampling.edit');
        Route::put('/{id}', [SamplingController::class, 'update'])->name('admin.sampling.update');
        Route::delete('/{id}', [SamplingController::class, 'destroy'])->name('admin.sampling.destroy');
    });

    Route::group(['prefix' => 'pakanHarian'], function(){
        Route::get('/', [PakanHarianController::class, 'index'])->name('admin.pakanharian.index');
        Route::post('/list', [PakanHarianController::class, 'list'])->name('admin.pakanharian.list');
        Route::get('/create', [PakanHarianController::class, 'create'])->name('admin.pakanharian.create');
        Route::post('/', [PakanHarianController::class, 'store'])->name('admin.pakanharian.store');
        Route::get('/{id}', [PakanHarianController::class, 'show'])->name('admin.pakanharian.show');
        Route::get('/{id}/edit', [PakanHarianController::class, 'edit'])->name('admin.pakanharian.edit');
        Route::put('/{id}', [PakanHarianController::class, 'update'])->name('admin.pakanharian.update');
        Route::delete('/{id}', [PakanHarianController::class, 'destroy'])->name('admin.pakanharian.destroy');
    }); 

    Route::group(['prefix' => 'kematianUdang'], function(){
        Route::get('/', [KematianUdangController::class, 'index'])->name('admin.kematianudang.index');
        Route::post('/list', [KematianUdangController::class, 'list'])->name('admin.kematianudang.list');
        Route::get('/create', [KematianUdangController::class, 'create'])->name('admin.kematianudang.create');
        Route::post('/', [KematianUdangController::class, 'store'])->name('admin.kematianudang.store');
        Route::get('/{id}', [KematianUdangController::class, 'show'])->name('admin.kematianudang.show');
        Route::get('/{id}/edit', [KematianUdangController::class, 'edit'])->name('admin.kematianudang.edit');
        Route::post('/{id}', [KematianUdangController::class, 'update'])->name('admin.kematianudang.update');
        Route::delete('/{id}', [KematianUdangController::class, 'destroy'])->name('admin.kematianudang.destroy');
    });
});

// ROUTE USER GUDANG
Route::middleware(['auth', 'no-back', 'role:2'])->group(function () {
    Route::group(['prefix' => 'pakanGudang'], function(){
        Route::get('/', [PakanGudangController::class, 'index'])->name('user.pakanGudang.index');
    });
    
    Route::group(['prefix' => 'transaksiPakan'], function(){
        Route::get('/', [TransaksiPakanController::class, 'index'])->name('user.transaksiPakan.index');
        Route::post('/list', [TransaksiPakanController::class, 'list'])->name('user.transaksiPakan.list');
        Route::get('/create', [TransaksiPakanController::class, 'create'])->name('user.transaksiPakan.create');
        Route::post('/', [TransaksiPakanController::class, 'store'])->name('user.transaksiPakan.store');
        Route::get('/{id}', [TransaksiPakanController::class, 'show'])->name('user.transaksiPakan.show');
    });

    Route::group(['prefix' => 'alatGudang'], function(){
        Route::get('/', [AlatGudangController::class, 'index'])->name('user.alatGudang.index');
    });

    Route::group(['prefix' => 'transaksiAlat'], function(){
        Route::get('/', [TransaksiAlatController::class, 'index'])->name('user.transaksiAlat.index');
        Route::post('/list', [TransaksiAlatController::class, 'list'])->name('user.transaksiAlat.list');
        Route::get('/create', [TransaksiAlatController::class, 'create'])->name('user.transaksiAlat.create');
        Route::post('/', [TransaksiAlatController::class, 'store'])->name('user.transaksiAlat.store');
        Route::get('/{id}', [TransaksiAlatController::class, 'show'])->name('user.transaksiAlat.show');
    });

    Route::group(['prefix' => 'obatGudang'], function(){
        Route::get('/', [ObatGudangController::class, 'index'])->name('user.obatGudang.index');
    });

    Route::group(['prefix' => 'transaksiObat'], function(){
        Route::get('/', [TransaksiObatController::class, 'index'])->name('user.transaksiObat.index');
        Route::post('/list', [TransaksiObatController::class, 'list'])->name('user.transaksiObat.list');
        Route::get('/create', [TransaksiObatController::class, 'create'])->name('user.transaksiObat.create');
        Route::post('/', [TransaksiObatController::class, 'store'])->name('user.transaksiObat.store');
        Route::get('/{id}', [TransaksiObatController::class, 'show'])->name('user.transaksiObat.show');
    });
});

// ROUTE USER TAMBAK
Route::middleware(['auth', 'no-back', 'role:3'])->group(function (){
    Route::group(['prefix' => 'Kolam'], function(){
        Route::get('/', [KolamController::class, 'index'])->name('user.kolam.index');
    });

    Route::group(['prefix' => 'faseKolam'], function(){
        Route::get('/', [FaseKolamController::class, 'index'])->name('user.fasekolam.index');
        Route::get('/create', [FaseKolamController::class, 'create'])->name('user.fasekolam.create');
        Route::post('/list', [FaseKolamController::class, 'list'])->name('user.fasekolam.list');
        Route::post('/', [FaseKolamController::class, 'store'])->name('user.fasekolam.store');
        Route::get('/{id}', [FaseKolamController::class, 'show'])->name('user.fasekolam.show');
    });

    Route::group(['prefix' => 'adminTambak/anco'], function(){
        Route::get('/', [AncoController::class, 'indexAdminTambak'])->name('user.anco.index');
        Route::get('/create', [AncoController::class, 'createAdminTambak'])->name('user.anco.create');
        Route::post('/', [AncoController::class, 'storeAdminTambak'])->name('user.anco.store');
        Route::get('/{id}', [AncoController::class, 'showAdminTambak'])->name('user.anco.show');
    });

    Route::group(['prefix' => 'adminTambak/kualitasair'], function(){
        Route::get('/', [KualitasAirController::class, 'indexAdminTambak'])->name('user.kualitasair.index');
        Route::get('/create', [KualitasAirController::class, 'createAdminTambak'])->name('user.kualitasair.create');
        Route::post('/', [KualitasAirController::class, 'storeAdminTambak'])->name('user.kualitasair.store');
        Route::get('/{id}', [KualitasAirController::class, 'showAdminTambak'])->name('user.kualitasair.show');
    });

    Route::group(['prefix' => 'adminTambak/penanganan'], function(){
        Route::get('/', [PenangananController::class, 'indexAdminTambak'])->name('user.penanganan.index');
        Route::get('/create', [PenangananController::class, 'createAdminTambak'])->name('user.penanganan.create');
        Route::post('/', [PenangananController::class, 'storeAdminTambak'])->name('user.penanganan.store');
        Route::get('/{id}', [PenangananController::class, 'showAdminTambak'])->name('user.penanganan.show');
    });

    Route::group(['prefix' => 'adminTambak/sampling'], function(){
        Route::get('/', [SamplingController::class, 'indexAdminTambak'])->name('user.sampling.index');
        Route::get('/create', [SamplingController::class, 'createAdminTambak'])->name('user.sampling.create');
        Route::post('/', [SamplingController::class, 'storeAdminTambak'])->name('user.sampling.store');
        Route::get('/{id}', [SamplingController::class, 'showAdminTambak'])->name('user.sampling.show');
    });

    Route::group(['prefix' => 'adminTambak/pakanHarian'], function(){
        Route::get('/', [PakanHarianController::class, 'indexAdminTambak'])->name('user.pakanharian.index');
        Route::get('/create', [PakanHarianController::class, 'createAdminTambak'])->name('user.pakanharian.create');
        Route::post('/', [PakanHarianController::class, 'storeAdminTambak'])->name('user.pakanharian.store');
        Route::get('/{id}', [PakanHarianController::class, 'showAdminTambak'])->name('user.pakanharian.show');
    });

    Route::group(['prefix' => 'adminTambak/kematianUdang'], function(){
        Route::get('/', [KematianUdangController::class, 'indexAdminTambak'])->name('user.kematianudang.index');
        Route::get('/create', [KematianUdangController::class, 'createAdminTambak'])->name('user.kematianudang.create');
        Route::post('/', [KematianUdangController::class, 'storeAdminTambak'])->name('user.kematianudang.store');
        Route::get('/{id}', [KematianUdangController::class, 'showAdminTambak'])->name('user.kematianudang.show');
    });
});