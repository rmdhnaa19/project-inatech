<?php

namespace App\Http\Controllers;

use App\Models\DetailObatModel;
use App\Models\TransaksiObatModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TransaksiObatController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Transaksi Obat',
            'paragraph' => 'Berikut ini merupakan data transaksi obat yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Obat', 'url' => route('admin.kelolaObat.index')],
                ['label' => 'Kelola Obat ke Gudang', 'url' => route('admin.kelolaObatGudang.index')],
                ['label' => 'Kelola Transaksi Obat'],
            ]
        ];
        $activeMenu = 'kelolaTransaksiObat';
        $obatGudang = DetailObatModel::all();
        return view('admin.kelolaTransaksiObat.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'obatGudang' => $obatGudang]);
    }

    public function list(Request $request)
    {
        $transaksiObats = TransaksiObatModel::with(['detailObat.gudang', 'detailObat.obat'])
            ->select('transaksi_obat.*', 'obat.nama as nama_obat', 'gudang.nama as nama_gudang')
            ->join('detail_obat', 'transaksi_obat.id_detail_obat', '=', 'detail_obat.id_detail_obat')
            ->join('obat', 'detail_obat.id_obat', '=', 'obat.id_obat')
            ->join('gudang', 'detail_obat.id_gudang', '=', 'gudang.id_gudang');

        return DataTables::of($transaksiObats)
            ->addColumn('obat_gudang', function ($transaksi) {
                return $transaksi->nama_obat . ' - ' . $transaksi->nama_gudang;
            })
            ->addColumn('created_at_formatted', function ($transaksi) {
                return Carbon::parse($transaksi->created_at)->translatedFormat('l, j F Y');
            })
            ->filterColumn('obat_gudang', function($query, $keyword) {
                $query->whereRaw("CONCAT(obat.nama, ' - ', gudang.nama) like ?", ["%{$keyword}%"]);
            })
            ->make(true);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Transaksi Obat',
            'paragraph' => 'Berikut ini merupakan form tambah data transaksi obat yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Obat', 'url' => route('admin.kelolaObat.index')],
                ['label' => 'Kelola Obat ke Gudang', 'url' => route('admin.kelolaObatGudang.index')],
                ['label' => 'Kelola Transaksi Obat', 'url' => route('admin.kelolaTransaksiObat.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaTransaksiObat';
        $obatGudang = DetailObatModel::with(['obat', 'gudang'])->get();
        return view('admin.kelolaTransaksiObat.create', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu, 
            'obatGudang' => $obatGudang
        ]);
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kd_transaksi_obat' => 'required|string|unique:transaksi_obat,kd_transaksi_obat',
            'tipe_transaksi' => 'required|string',
            'quantity' => 'required|integer',
            'id_detail_obat' => 'required|integer'
        ]);

        $id_obatGudang = $request->id_detail_obat;
        $qty = $request->quantity;
        $qty_old = DetailObatModel::find($id_obatGudang)->stok_obat;
        $tipe_transaki = $request->tipe_transaksi;

        if ($tipe_transaki == 'Masuk') {
            DetailObatModel::find($id_obatGudang)->update([
                'stok_obat' => $qty_old + $qty
            ]);
        }elseif (in_array($tipe_transaki, ['Keluar', 'Rusak', 'Kadaluarsa'])) {
            if ($qty_old < $qty) {
                Alert::toast('Data transaksi keluar gagal ditambahkan karena stok kurang', 'error');
                return redirect()->back();
            }else {
                DetailObatModel::find($id_obatGudang)->update([
                    'stok_obat' => $qty_old - $qty
                ]);
            }
        }
        TransaksiObatModel::create([
            'kd_transaksi_obat' => $request->kd_transaksi_obat,
            'tipe_transaksi' => $tipe_transaki,
            'quantity' => $qty,
            'id_detail_obat' => $id_obatGudang
        ]);

        Alert::toast('Data transaksi obat berhasil ditambah', 'success');
        return redirect()->route('admin.kelolaTransaksiObat.index');
    }

    public function show($id)
    {
        $transaksiObat = TransaksiObatModel::with('detailObat')->find($id); // Ambil data tambak dengan relasi gudang
        if (!$transaksiObat) {
            return response()->json(['error' => 'Transaksi obat tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaTransaksiObat.show', compact('transaksiObat'))->render();
        return response()->json(['html' => $view]);
    }

    public function edit(string $id){
        $transaksiObat = TransaksiObatModel::find($id);
        $obatGudang = DetailObatModel::with(['obat', 'gudang'])->get();

        $breadcrumb = (object) [
            'title' => 'Edit Data Transaksi Obat',
            'paragraph' => 'Berikut ini merupakan form edit data transaksi obat yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Obat', 'url' => route('admin.kelolaObat.index')],
                ['label' => 'Kelola Obat ke Gudang', 'url' => route('admin.kelolaObatGudang.index')],
                ['label' => 'Kelola Transaksi Obat', 'url' => route('admin.kelolaTransaksiObat.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaTransaksiObat';

        return view('admin.kelolaTransaksiObat.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'transaksiObat' => $transaksiObat, 'obatGudang' => $obatGudang]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'kd_transaksi_obat' => 'required|string|unique:transaksi_obat,kd_transaksi_obat,'.$id.',id_transaksi_obat',
            'tipe_transaksi' => 'required|string',
            'quantity' => 'required|integer',
            'id_detail_obat' => 'required|integer'
        ]);

        $transaksiObat = TransaksiObatModel::find($id);
        
        $qty_new = $request->quantity;
        $qty_old = $transaksiObat->quantity;
        $tipeTransaksi_new = $request->tipe_transaksi;
        $tipeTransaksi_old = $transaksiObat->tipe_transaksi;
        $idDetailObat_new = $request->id_detail_obat;
        $idDetailObat_old = $transaksiObat->id_detail_obat;
        
        $detailObat_old = DetailObatModel::find($idDetailObat_old);
        $detailObat_new = DetailObatModel::find($idDetailObat_new);

        $stok_old = $detailObat_old->stok_obat;
        $stok_new = $detailObat_new->stok_obat;

        $stokQty_old = $stok_old+$qty_old;
        $totalQty = $qty_new + $qty_old;
        $stokOld_qtyNew = $stok_old + $qty_new;

        if ($idDetailObat_new != $idDetailObat_old) {
            if ($tipeTransaksi_new != $tipeTransaksi_old) {
                if ($tipeTransaksi_new == 'Masuk') {
                    $detailObat_old->update([
                        'stok_obat' => $stok_old + $qty_old,
                    ]);
                    $detailObat_new->update([
                        'stok_obat' => $stok_new + $qty_new,
                    ]);
                }elseif (in_array($tipeTransaksi_new, ['Keluar', 'Rusak', 'Kadaluarsa'])) {
                    if ($tipeTransaksi_old == 'Masuk' && in_array($tipeTransaksi_new, ['Keluar', 'Rusak', 'Kadaluarsa'])) {
                        if ($stok_old < $qty_old){
                            Alert::toast('Data transaksi obat gagal ditambahkan karena stok kurang dari kuantitas lama', 'error');
                            return redirect()->back();
                        }elseif ($stok_old >= $qty_old){
                            if ($stok_new < $qty_new) {
                                Alert::toast('Data transaksi obat gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                                return redirect()->back();
                            }elseif ($stok_new >= $qty_new){
                                $detailObat_old->update([
                                    'stok_obat' => $stok_old - $qty_old,
                                ]);
                                $detailObat_new->update([
                                    'stok_obat' => $stok_new - $qty_new,
                                ]);
                            }
                        }
                    }else if(($tipeTransaksi_old == 'Keluar' && in_array($tipeTransaksi_new, ['Kadaluarsa', 'Rusak'])) || 
                    ($tipeTransaksi_old == 'Kadaluarsa' && in_array($tipeTransaksi_new, ['Keluar', 'Rusak'])) || 
                    ($tipeTransaksi_old == 'Rusak' && in_array($tipeTransaksi_new, ['Keluar', 'Kadaluarsa']))){
                        if ($stok_new < $qty_new) {
                            Alert::toast('Data transaksi obat gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                            return redirect()->back();
                        }elseif ($stok_new >= $qty_new){
                            $detailObat_old->update([
                                'stok_obat' => $stok_old + $qty_old,
                            ]);
                            $detailObat_new->update([
                                'stok_obat' => $stok_new - $qty_new,
                            ]);
                        }
                    }
                }
            }elseif ($tipeTransaksi_new == $tipeTransaksi_old){
                if ($tipeTransaksi_new == 'Masuk') {
                    if ($stok_old < $qty_old) {
                        Alert::toast('Data transaksi obat gagal ditambahkan karena stok kurang dari kuantitas lama', 'error');
                        return redirect()->back();
                    }elseif($stok_old >= $qty_old){
                        $detailObat_old->update([
                            'stok_obat' => $stok_old - $qty_old,
                        ]);
                        $detailObat_new->update([
                            'stok_obat' => $stok_new + $qty_new,
                        ]);
                    }
                }elseif (in_array($tipeTransaksi_new, ['Keluar', 'Rusak', 'Kadaluarsa'])) {
                    if ($stok_new < $qty_new) {
                        Alert::toast('Data transaksi obat gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                        return redirect()->back();
                    }elseif ($stok_new >= $qty_new){
                        $detailObat_old->update([
                            'stok_obat' => $stok_old + $qty_old,
                        ]);
                        $detailObat_new->update([
                            'stok_obat' => $stok_new - $qty_new,
                        ]);
                    }
                }
            }
        }elseif ($idDetailObat_new == $idDetailObat_old){
            if ($tipeTransaksi_new != $tipeTransaksi_old) {
                if ($tipeTransaksi_new == 'Masuk') {
                        $detailObat_new->update([
                            'stok_obat' => $stok_old + $qty_old + $qty_new,
                        ]);
                }elseif (in_array($tipeTransaksi_new, ['Keluar', 'Rusak', 'Kadaluarsa'])) {
                    if ($tipeTransaksi_old == 'Masuk' && in_array($tipeTransaksi_new, ['Keluar', 'Rusak', 'Kadaluarsa'])) {
                        if ($stok_old < $totalQty) {
                            Alert::toast('Data transaksi obat gagal ditambahkan karena stok kurang dari kuantitas baru dan lama', 'error');
                            return redirect()->back();
                        }elseif ($stok_old >= $totalQty){
                            $detailObat_new->update([
                                'stok_obat' => $stok_old - $totalQty,
                            ]);
                        }
                    }elseif (($tipeTransaksi_old == 'Keluar' && in_array($tipeTransaksi_new, ['Kadaluarsa', 'Rusak'])) || 
                    ($tipeTransaksi_old == 'Kadaluarsa' && in_array($tipeTransaksi_new, ['Keluar', 'Rusak'])) || 
                    ($tipeTransaksi_old == 'Rusak' && in_array($tipeTransaksi_new, ['Keluar', 'Kadaluarsa']))) {
                        if ($stokQty_old < $qty_new) {
                            Alert::toast('Data transaksi obat gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                            return redirect()->back();
                        }elseif ($stokQty_old >= $qty_new) {
                            $detailObat_new->update([
                                'stok_obat' => $stokQty_old - $qty_new,
                            ]);
                        }
                    }
                }
            }elseif ($tipeTransaksi_new == $tipeTransaksi_old){
                if ($tipeTransaksi_new == 'Masuk') {
                    if ($stokOld_qtyNew < $qty_old) {
                        Alert::toast('Data transaksi obat gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                        return redirect()->back();
                    }elseif ($stokOld_qtyNew >= $qty_old) {
                        $detailObat_new->update([
                            'stok_obat' =>$stokOld_qtyNew - $qty_old,
                        ]);
                    }
                }elseif (in_array($tipeTransaksi_new, ['Keluar', 'Rusak', 'Kadaluarsa'])) {
                    if ($stokQty_old < $qty_new) {
                        Alert::toast('Data transaksi obat gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                        return redirect()->back();
                    }elseif ($stokQty_old >= $qty_new) {
                        $detailObat_new->update([
                            'stok_obat' => $stokQty_old - $qty_new,
                        ]);
                    }
                }
            }
        }
        $transaksiObat->update([
            'kd_transaksi_obat' => $request->kd_transaksi_obat,
            'tipe_transaksi' => $tipeTransaksi_new,
            'quantity' => $qty_new,
            'id_detail_obat' => $idDetailObat_new,
        ]);
        Alert::toast('Data transaksi obat berhasil diubah', 'success');
        return redirect()->route('admin.kelolaTransaksiObat.index');
    }

    public function destroy($id) {
        $transaksiObat = TransaksiObatModel::find($id);
        if (!$transaksiObat) {
            return response()->json([
                'success' => false,
                'message' => 'Data transaksi obat tidak ditemukan.'
            ], 404);
        }
        try{
            $qty = $transaksiObat->quantity;
            $idDetailObat = $transaksiObat->id_detail_obat;
            $detailObat = DetailObatModel::find($idDetailObat);
            $stok = $detailObat->stok_obat;
            $tipeTransaki = $transaksiObat->tipe_transaksi;
            if ($tipeTransaki == 'Masuk') {
                if($stok < $qty){
                    return response()->json([
                        'success' => false,
                        'message' => 'Data transaksi obat gagal dihapus karena stok kurang.'
                    ]);
                }else{
                    $detailObat->update([
                        'stok_obat' => $stok - $qty,
                    ]);
                }
            }else{
                $detailObat->update([
                    'stok_obat' => $stok + $qty,
                ]);
            }
            $transaksiObat->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data transaksi obat berhasil dihapus.'
            ]);
        }catch(\Illuminate\Database\QueryException $e){
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus transaksi obat: ' . $e->getMessage()
            ], 500);
        }
    }
}
