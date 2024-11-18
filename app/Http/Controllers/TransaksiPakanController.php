<?php

namespace App\Http\Controllers;

use App\Models\DetailPakanModel;
use App\Models\TransaksiPakanModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TransaksiPakanController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Transaksi Pakan',
            'paragraph' => 'Berikut ini merupakan data transaksi pakan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaPakan.index')],
                ['label' => 'Kelola Pakan ke Gudang', 'url' => route('admin.kelolaPakanGudang.index')],
                ['label' => 'Kelola Transaksi Pakan'],
            ]
        ];
        $activeMenu = 'kelolaTransaksiPakan';
        $pakanGudang = DetailPakanModel::all();
        return view('admin.kelolaTransaksiPakan.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'pakanGudang' => $pakanGudang]);
    }

    public function list(Request $request)
    {
        $transaksiPakans = TransaksiPakanModel::with(['detailPakan.gudang', 'detailPakan.pakan'])
            ->select('transaksi_pakan.*', 'pakan.nama as nama_pakan', 'gudang.nama as nama_gudang')
            ->join('detail_pakan', 'transaksi_pakan.id_detail_pakan', '=', 'detail_pakan.id_detail_pakan')
            ->join('pakan', 'detail_pakan.id_pakan', '=', 'pakan.id_pakan')
            ->join('gudang', 'detail_pakan.id_gudang', '=', 'gudang.id_gudang');

        return DataTables::of($transaksiPakans)
            ->addColumn('pakan_gudang', function ($transaksi) {
                return $transaksi->nama_pakan . ' - ' . $transaksi->nama_gudang;
            })
            ->filterColumn('pakan_gudang', function($query, $keyword) {
                $query->whereRaw("CONCAT(pakan.nama, ' - ', gudang.nama) like ?", ["%{$keyword}%"]);
            })
            ->make(true);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Transaksi Pakan',
            'paragraph' => 'Berikut ini merupakan form tambah data transaksi pakan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaPakan.index')],
                ['label' => 'Kelola Pakan ke Gudang', 'url' => route('admin.kelolaPakanGudang.index')],
                ['label' => 'Kelola Transaksi Pakan', 'url' => route('admin.kelolaTransaksiPakan.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaTransaksiPakan';
        $pakanGudang = DetailPakanModel::with(['pakan', 'gudang'])->get();
        return view('admin.kelolaTransaksiPakan.create', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu, 
            'pakanGudang' => $pakanGudang
        ]);
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kd_transaksi_pakan' => 'required|string|unique:transaksi_pakan,kd_transaksi_pakan',
            'tipe_transaksi' => 'required|string',
            'quantity' => 'required|integer',
            'id_detail_pakan' => 'required|integer'
        ]);

        $id_pakanGudang = $request->id_detail_pakan;
        $qty = $request->quantity;
        $qty_old = DetailPakanModel::find($id_pakanGudang)->stok_pakan;
        $tipe_transaki = $request->tipe_transaksi;

        if ($tipe_transaki == 'Masuk') {
            TransaksiPakanModel::create([
                'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                'tipe_transaksi' => $tipe_transaki,
                'quantity' => $qty,
                'id_detail_pakan' => $id_pakanGudang
            ]);
            DetailPakanModel::find($id_pakanGudang)->update([
                'stok_pakan' => $qty_old + $qty
            ]);
        }elseif ($tipe_transaki == 'Keluar' || $tipe_transaki == 'Kadaluarsa' || $tipe_transaki == 'Rusak') {
            if ($qty_old < $qty) {
                Alert::toast('Data transaksi keluar gagal ditambahkan karena stok kurang', 'error');
                return redirect()->back();
            }else {
                TransaksiPakanModel::create([
                    'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                    'tipe_transaksi' => $tipe_transaki,
                    'quantity' => $qty,
                    'id_detail_pakan' => $id_pakanGudang
                ]);
                DetailPakanModel::find($id_pakanGudang)->update([
                    'stok_pakan' => $qty_old - $qty
                ]);
            }
        }

        Alert::toast('Data transaksi pakan berhasil ditambah', 'success');

        // Redirect ke halaman kelola pengguna
        return redirect()->route('admin.kelolaTransaksiPakan.index');
    }

    public function show($id)
    {
        $transaksiPakan = TransaksiPakanModel::with('detailPakan')->find($id); // Ambil data tambak dengan relasi gudang
        if (!$transaksiPakan) {
            return response()->json(['error' => 'Transaksi pakan tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaTransaksiPakan.show', compact('transaksiPakan'))->render();
        return response()->json(['html' => $view]);
    }

    public function edit(string $id){
        $transaksiPakan = TransaksiPakanModel::find($id);
        $pakanGudang = DetailPakanModel::with(['pakan', 'gudang'])->get();

        $breadcrumb = (object) [
            'title' => 'Edit Data Transaksi Pakan',
            'paragraph' => 'Berikut ini merupakan form edit data transaksi pakan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaPakan.index')],
                ['label' => 'Kelola Pakan ke Gudang', 'url' => route('admin.kelolaPakanGudang.index')],
                ['label' => 'Kelola Transaksi Pakan', 'url' => route('admin.kelolaTransaksiPakan.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaTransaksiPakan';

        return view('admin.kelolaTransaksiPakan.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'transaksiPakan' => $transaksiPakan, 'pakanGudang' => $pakanGudang]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'kd_transaksi_pakan' => 'required|string|unique:transaksi_pakan,kd_transaksi_pakan,'.$id.',id_transaksi_pakan',
            'tipe_transaksi' => 'required|string',
            'quantity' => 'required|integer',
            'id_detail_pakan' => 'required|integer'
        ]);

        $transaksiPakan = TransaksiPakanModel::find($id);
        
        $qty_new = $request->quantity;
        $qty_old = $transaksiPakan->quantity;
        $tipeTransaksi_new = $request->tipe_transaksi;
        $tipeTransaksi_old = $transaksiPakan->tipe_transaksi;
        $idDetailPakan_new = $request->id_detail_pakan;
        $idDetailPakan_old = $transaksiPakan->id_detail_pakan;
        
        $detailPakan_old = DetailPakanModel::find($idDetailPakan_old);
        $detailPakan_new = DetailPakanModel::find($idDetailPakan_new);

        $stok_old = $detailPakan_old->stok_pakan;
        $stok_new = $detailPakan_new->stok_pakan;

        $stokQty_old = $stok_old+$qty_old;
        $totalQty = $qty_new + $qty_old;
        $stokOld_qtyNew = $stok_old + $qty_new;

        if ($idDetailPakan_new != $idDetailPakan_old) {
            if ($tipeTransaksi_new != $tipeTransaksi_old) {
                if ($tipeTransaksi_new == 'Masuk') {
                    $detailPakan_old->update([
                        'stok_pakan' => $stok_old + $qty_old,
                    ]);
                    $transaksiPakan->update([
                        'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                        'tipe_transaksi' => $tipeTransaksi_new,
                        'quantity' => $qty_new,
                        'id_detail_pakan' => $idDetailPakan_new,
                    ]);
                    $detailPakan_new->update([
                        'stok_pakan' => $stok_new + $qty_new,
                    ]);
                       
                    Alert::toast('Data transaksi pakan berhasil diubah', 'success');
                    return redirect()->route('admin.kelolaTransaksiPakan.index');
                }elseif (in_array($tipeTransaksi_new, ['Keluar', 'Kadaluarsa', 'Rusak'])) {
                    if ($tipeTransaksi_old == 'Masuk' && in_array($tipeTransaksi_new, ['Keluar', 'Kadaluarsa', 'Rusak'])) {
                        if ($stok_old < $qty_old){
                            Alert::toast('Data transaksi pakan gagal ditambahkan karena stok kurang dari kuantitas lama', 'error');
                            return redirect()->back();
                        }elseif ($stok_old >= $qty_old){
                            if ($stok_new < $qty_new) {
                                Alert::toast('Data transaksi pakan gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                                return redirect()->back();
                            }elseif ($stok_new >= $qty_new){
                                $detailPakan_old->update([
                                    'stok_pakan' => $stok_old - $qty_old,
                                ]);
                                $transaksiPakan->update([
                                    'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                                    'tipe_transaksi' => $tipeTransaksi_new,
                                    'quantity' => $qty_new,
                                    'id_detail_pakan' => $idDetailPakan_new,
                                ]);
                                $detailPakan_new->update([
                                    'stok_pakan' => $stok_new - $qty_new,
                                ]);
    
                                Alert::toast('Data transaksi pakan berhasil diubah', 'success');
                                return redirect()->route('admin.kelolaTransaksiPakan.index');
                            }
                        }
                    }else if(($tipeTransaksi_old == 'Keluar' && in_array($tipeTransaksi_new, ['Kadaluarsa', 'Rusak'])) || 
                    ($tipeTransaksi_old == 'Kadaluarsa' && in_array($tipeTransaksi_new, ['Keluar', 'Rusak'])) || 
                    ($tipeTransaksi_old == 'Rusak' && in_array($tipeTransaksi_new, ['Keluar', 'Kadaluarsa']))){
                        if ($stok_new < $qty_new) {
                            Alert::toast('Data transaksi pakan gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                            return redirect()->back();
                        }elseif ($stok_new >= $qty_new){
                            $detailPakan_old->update([
                                'stok_pakan' => $stok_old + $qty_old,
                            ]);
                            $transaksiPakan->update([
                                'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                                'tipe_transaksi' => $tipeTransaksi_new,
                                'quantity' => $qty_new,
                                'id_detail_pakan' => $idDetailPakan_new,
                            ]);
                            $detailPakan_new->update([
                                'stok_pakan' => $stok_new - $qty_new,
                            ]);

                            Alert::toast('Data transaksi pakan berhasil diubah', 'success');
                            return redirect()->route('admin.kelolaTransaksiPakan.index');
                        }
                    }
                }
            }elseif ($tipeTransaksi_new == $tipeTransaksi_old){
                if ($tipeTransaksi_new == 'Masuk') {
                    if ($stok_old < $qty_old) {
                        Alert::toast('Data transaksi pakan gagal ditambahkan karena stok kurang dari kuantitas lama', 'error');
                        return redirect()->back();
                    }elseif($stok_old >= $qty_old){
                        $detailPakan_old->update([
                            'stok_pakan' => $stok_old - $qty_old,
                        ]);
                        $transaksiPakan->update([
                            'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                            'tipe_transaksi' => $tipeTransaksi_new,
                            'quantity' => $qty_new,
                            'id_detail_pakan' => $idDetailPakan_new,
                        ]);
                        $detailPakan_new->update([
                            'stok_pakan' => $stok_new + $qty_new,
                        ]);

                        Alert::toast('Data transaksi pakan berhasil diubah', 'success');
                        return redirect()->route('admin.kelolaTransaksiPakan.index');
                    }
                }elseif (in_array($tipeTransaksi_new, ['Keluar', 'Kadaluarsa', 'Rusak'])) {
                    if ($stok_new < $qty_new) {
                        Alert::toast('Data transaksi pakan gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                        return redirect()->back();
                    }elseif ($stok_new >= $qty_new){
                        $detailPakan_old->update([
                            'stok_pakan' => $stok_old + $qty_old,
                        ]);
                        $transaksiPakan->update([
                            'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                            'tipe_transaksi' => $tipeTransaksi_new,
                            'quantity' => $qty_new,
                            'id_detail_pakan' => $idDetailPakan_new,
                        ]);
                        $detailPakan_new->update([
                            'stok_pakan' => $stok_new - $qty_new,
                        ]);

                        Alert::toast('Data transaksi pakan berhasil diubah', 'success');
                        return redirect()->route('admin.kelolaTransaksiPakan.index');
                    }
                }
            }
        }elseif ($idDetailPakan_new == $idDetailPakan_old){
            if ($tipeTransaksi_new != $tipeTransaksi_old) {
                if ($tipeTransaksi_new == 'Masuk') {
                        $transaksiPakan->update([
                            'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                            'tipe_transaksi' => $tipeTransaksi_new,
                            'quantity' => $qty_new,
                            'id_detail_pakan' => $idDetailPakan_new,
                        ]);
                        $detailPakan_new->update([
                            'stok_pakan' => $stok_old + $qty_old + $qty_new,
                        ]);

                        Alert::toast('Data transaksi pakan berhasil diubah', 'success');
                        return redirect()->route('admin.kelolaTransaksiPakan.index');
                }elseif (in_array($tipeTransaksi_new, ['Keluar', 'Kadaluarsa', 'Rusak'])) {
                    if ($tipeTransaksi_old == 'Masuk' && in_array($tipeTransaksi_new, ['Keluar', 'Kadaluarsa', 'Rusak'])) {
                        if ($stok_old < $totalQty) {
                            Alert::toast('Data transaksi pakan gagal ditambahkan karena stok kurang dari kuantitas baru dan lama', 'error');
                            return redirect()->back();
                        }elseif ($stok_old >= $totalQty){
                            $transaksiPakan->update([
                                'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                                'tipe_transaksi' => $tipeTransaksi_new,
                                'quantity' => $qty_new,
                                'id_detail_pakan' => $idDetailPakan_new,
                            ]);
                            $detailPakan_new->update([
                                'stok_pakan' => $stok_old - $totalQty,
                            ]);

                            Alert::toast('Data transaksi pakan berhasil diubah', 'success');
                            return redirect()->route('admin.kelolaTransaksiPakan.index');
                        }
                    }elseif (($tipeTransaksi_old == 'Keluar' && in_array($tipeTransaksi_new, ['Kadaluarsa', 'Rusak'])) || 
                    ($tipeTransaksi_old == 'Kadaluarsa' && in_array($tipeTransaksi_new, ['Keluar', 'Rusak'])) || 
                    ($tipeTransaksi_old == 'Rusak' && in_array($tipeTransaksi_new, ['Keluar', 'Kadaluarsa']))) {
                        if ($stokQty_old < $qty_new) {
                            Alert::toast('Data transaksi pakan gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                            return redirect()->back();
                        }elseif ($stokQty_old >= $qty_new) {
                            $transaksiPakan->update([
                                'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                                'tipe_transaksi' => $tipeTransaksi_new,
                                'quantity' => $qty_new,
                                'id_detail_pakan' => $idDetailPakan_new,
                            ]);
                            $detailPakan_new->update([
                                'stok_pakan' => $stokQty_old - $qty_new,
                            ]);
    
                            Alert::toast('Data transaksi pakan berhasil diubah', 'success');
                            return redirect()->route('admin.kelolaTransaksiPakan.index');
                        }
                    }
                }
            }elseif ($tipeTransaksi_new == $tipeTransaksi_old){
                if ($tipeTransaksi_new == 'Masuk') {
                    if ($stokOld_qtyNew < $qty_old) {
                        Alert::toast('Data transaksi pakan gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                        return redirect()->back();
                    }elseif ($stokOld_qtyNew >= $qty_old) {
                        $transaksiPakan->update([
                            'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                            'tipe_transaksi' => $tipeTransaksi_new,
                            'quantity' => $qty_new,
                            'id_detail_pakan' => $idDetailPakan_new,
                        ]);
                        $detailPakan_new->update([
                            'stok_pakan' =>$stokOld_qtyNew - $qty_old,
                        ]);
    
                        Alert::toast('Data transaksi pakan berhasil diubah', 'success');
                        return redirect()->route('admin.kelolaTransaksiPakan.index');
                    }
                }elseif ($tipeTransaksi_new == 'Keluar' || $tipeTransaksi_new == 'Kadaluarsa' || $tipeTransaksi_new == 'Rusak') {
                    if ($stokQty_old < $qty_new) {
                        Alert::toast('Data transaksi pakan gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                        return redirect()->back();
                    }elseif ($stokQty_old >= $qty_new) {
                        $transaksiPakan->update([
                            'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                            'tipe_transaksi' => $tipeTransaksi_new,
                            'quantity' => $qty_new,
                            'id_detail_pakan' => $idDetailPakan_new,
                        ]);
                        $detailPakan_new->update([
                            'stok_pakan' => $stokQty_old - $qty_new,
                        ]);
    
                        Alert::toast('Data transaksi pakan berhasil diubah', 'success');
                        return redirect()->route('admin.kelolaTransaksiPakan.index');
                    }
                }
            }
        }
    }

    // public function destroy($id) {
    //     $check = UserModel::find($id);
    //     if (!$check) {
    //         Alert::toast('Data pengguna tidak ditemukan', 'error');
    //         return redirect('/kelolaPengguna');
    //     }
    //     try{
    //         $kelolaPengguna = UserModel::find($id);
    //         if ($kelolaPengguna->foto != '') {
    //             Storage::disk('public')->delete($kelolaPengguna->foto);
    //             UserModel::destroy($id);
    //         } else {
    //             UserModel::destroy($id);
    //         }
    //         Alert::toast('Data pengguna berhasil dihapus', 'success');
    //         return redirect('/kelolaPengguna');
    //     }catch(\Illuminate\Database\QueryException $e){
    //         Alert::toast('Data pengguna gagal dihapus', 'error');
    //         return redirect('/kelolaPengguna');
    //     }
    // }
}
