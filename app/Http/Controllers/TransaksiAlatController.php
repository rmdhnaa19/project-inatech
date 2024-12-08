<?php

namespace App\Http\Controllers;

use App\Models\DetailAlatModel;
use App\Models\TransaksiAlatModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TransaksiAlatController extends Controller
{
    public function index(){
        if (auth()->user()->id_role == 1) {
            $breadcrumb = (object) [
                'title' => 'Kelola Data Transaksi Alat',
                'paragraph' => 'Berikut ini merupakan data transaksi alat yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Kelola Alat', 'url' => route('admin.kelolaAlat.index')],
                    ['label' => 'Kelola Alat ke Gudang', 'url' => route('admin.kelolaAlatGudang.index')],
                    ['label' => 'Kelola Transaksi Alat'],
                ]
            ];
            $activeMenu = 'kelolaTransaksiAlat';
            $alatGudang = DetailAlatModel::all();
            return view('admin.kelolaTransaksiAlat.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'alatGudang' => $alatGudang]);
        }elseif (auth()->user()->id_role == 2) {
            $breadcrumb = (object) [
                'title' => 'Riwayat Transaksi Alat',
                'paragraph' => 'Berikut ini merupakan data transaksi alat yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Riwayat Transaksi Alat'],
                ]
            ];
            $activeMenu = 'transaksiAlat';
            $gudangIds = auth()->user()->detailUser()->pluck('id_gudang');
            $alatGudang = DetailAlatModel::where('id_gudang', $gudangIds)->get();
            return view('adminGudang.transaksiAlat.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'alatGudang' => $alatGudang, 'gudangIds' => $gudangIds]);
        }
    }

    public function list(Request $request)
    {
        if (auth()->user()->id_role == 1) {
            $transaksiAlats = TransaksiAlatModel::with(['detailAlat.gudang', 'detailAlat.alat'])
                ->select('transaksi_alat.*', 'alat.nama as nama_alat', 'gudang.nama as nama_gudang')
                ->join('detail_alat', 'transaksi_alat.id_detail_alat', '=', 'detail_alat.id_detail_alat')
                ->join('alat', 'detail_alat.id_alat', '=', 'alat.id_alat')
                ->join('gudang', 'detail_alat.id_gudang', '=', 'gudang.id_gudang');

            return DataTables::of($transaksiAlats)
                ->addColumn('alat_gudang', function ($transaksi) {
                    return $transaksi->nama_alat . ' - ' . $transaksi->nama_gudang;
                })
                ->addColumn('created_at_formatted', function ($transaksi) {
                    return Carbon::parse($transaksi->created_at)->translatedFormat('l, j F Y');
                })
                ->filterColumn('alat_gudang', function($query, $keyword) {
                    $query->whereRaw("CONCAT(alat.nama, ' - ', gudang.nama) like ?", ["%{$keyword}%"]);
                })
                ->make(true);
        }elseif (auth()->user()->id_role == 2) {
            $gudangIds = auth()->user()->detailUser()->pluck('id_gudang');
            $transaksiAlats = TransaksiAlatModel::with(['detailAlat.gudang', 'detailAlat.alat'])
                ->select('transaksi_alat.*', 'alat.nama as nama_alat', 'gudang.nama as nama_gudang')
                ->join('detail_alat', 'transaksi_alat.id_detail_alat', '=', 'detail_alat.id_detail_alat')
                ->join('alat', 'detail_alat.id_alat', '=', 'alat.id_alat')
                ->join('gudang', 'detail_alat.id_gudang', '=', 'gudang.id_gudang')
                ->whereIn('detail_alat.id_gudang', $gudangIds);;

            return DataTables::of($transaksiAlats)
                ->addColumn('alat_gudang', function ($transaksi) {
                    return $transaksi->nama_alat;
                })
                ->addColumn('created_at_formatted', function ($transaksi) {
                    return Carbon::parse($transaksi->created_at)->translatedFormat('l, j F Y');
                })
                ->filterColumn('alat_gudang', function($query, $keyword) {
                    $query->whereRaw("CONCAT(alat.nama) like ?", ["%{$keyword}%"]);
                })
                ->make(true);
        }
    }

    public function create(Request $request){
        if (auth()->user()->id_role == 1) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Transaksi Alat',
                'paragraph' => 'Berikut ini merupakan form tambah data transaksi alat yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Kelola Alat', 'url' => route('admin.kelolaAlat.index')],
                    ['label' => 'Kelola Alat ke Gudang', 'url' => route('admin.kelolaAlatGudang.index')],
                    ['label' => 'Kelola Transaksi Alat', 'url' => route('admin.kelolaTransaksiAlat.index')],
                    ['label' => 'Tambah'],
                ]
            ];
            $activeMenu = 'kelolaTransaksiAlat';
            $alatGudang = DetailAlatModel::with(['alat', 'gudang'])->get();
            return view('admin.kelolaTransaksiAlat.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'alatGudang' => $alatGudang]);
        }elseif (auth()->user()->id_role == 2) {
            $breadcrumb = (object) [
                'title' => 'Tambah Transaksi Alat',
                'paragraph' => 'Berikut ini merupakan form tambah data transaksi alat yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Tambah Transaksi Alat'],
                ]
            ];
            $activeMenu = 'transaksiAlat';
            $alatGudang = DetailAlatModel::with(['alat', 'gudang'])->get();
            $selectedIdDetailAlat = $request->input('id_detail_alat'); // Ambil ID dari URL
            return view('adminGudang.transaksiAlat.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'alatGudang' => $alatGudang, 'selectedIdDetailAlat' => $selectedIdDetailAlat]);
        }
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kd_transaksi_alat' => 'required|string|unique:transaksi_alat,kd_transaksi_alat',
            'tipe_transaksi' => 'required|string',
            'quantity' => 'required|integer',
            'id_detail_alat' => 'required|integer'
        ]);

        $id_alatGudang = $request->id_detail_alat;
        $qty = $request->quantity;
        $qty_old = DetailAlatModel::find($id_alatGudang)->stok_alat;
        $tipe_transaki = $request->tipe_transaksi;

        if ($tipe_transaki == 'Masuk') {
            DetailAlatModel::find($id_alatGudang)->update([
                'stok_alat' => $qty_old + $qty
            ]);
        }elseif ($tipe_transaki == 'Keluar' || $tipe_transaki == 'Rusak') {
            if ($qty_old < $qty) {
                Alert::toast('Data transaksi keluar gagal ditambahkan karena stok kurang', 'error');
                return redirect()->back();
            }else {
                DetailAlatModel::find($id_alatGudang)->update([
                    'stok_alat' => $qty_old - $qty
                ]);
            }
        }
        TransaksiAlatModel::create([
            'kd_transaksi_alat' => $request->kd_transaksi_alat,
            'tipe_transaksi' => $tipe_transaki,
            'quantity' => $qty,
            'id_detail_alat' => $id_alatGudang
        ]);

        if (auth()->user()->id_role == 1) {
            Alert::toast('Data transaksi alat berhasil ditambah', 'success');
            return redirect()->route('admin.kelolaTransaksiAlat.index');
        }elseif (auth()->user()->id_role == 2) {
            Alert::toast('Data transaksi alat berhasil ditambah', 'success');
            return redirect()->route('user.transaksiAlat.index');
        }
    }

    public function show($id)
    {
        if (auth()->user()->id_role == 1) {
            $transaksiAlat = TransaksiAlatModel::with('detailAlat')->find($id); // Ambil data tambak dengan relasi gudang
            if (!$transaksiAlat) {
                return response()->json(['error' => 'Transaksi alat tidak ditemukan.'], 404);
            }

            // Render view dengan data tambak
            $view = view('admin.kelolaTransaksiAlat.show', compact('transaksiAlat'))->render();
            return response()->json(['html' => $view]);
        }elseif (auth()->user()->id_role == 2) {
            $transaksiAlat = TransaksiAlatModel::with('detailAlat')->find($id); // Ambil data tambak dengan relasi gudang
            if (!$transaksiAlat) {
                return response()->json(['error' => 'Transaksi alat tidak ditemukan.'], 404);
            }

            // Render view dengan data tambak
            $view = view('adminGudang.transaksiAlat.show', compact('transaksiAlat'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function edit(string $id){
        $transaksiAlat = TransaksiAlatModel::find($id);
        $alatGudang = DetailAlatModel::with(['alat', 'gudang'])->get();

        $breadcrumb = (object) [
            'title' => 'Edit Data Transaksi Alat',
            'paragraph' => 'Berikut ini merupakan form edit data transaksi alat yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Alat', 'url' => route('admin.kelolaAlat.index')],
                ['label' => 'Kelola Alat ke Gudang', 'url' => route('admin.kelolaAlatGudang.index')],
                ['label' => 'Kelola Transaksi Alat', 'url' => route('admin.kelolaTransaksiAlat.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaTransaksiAlat';

        return view('admin.kelolaTransaksiAlat.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'transaksiAlat' => $transaksiAlat, 'alatGudang' => $alatGudang]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'kd_transaksi_alat' => 'required|string|unique:transaksi_alat,kd_transaksi_alat,'.$id.',id_transaksi_alat',
            'tipe_transaksi' => 'required|string',
            'quantity' => 'required|integer',
            'id_detail_alat' => 'required|integer'
        ]);

        $transaksiAlat = TransaksiAlatModel::find($id);
        
        $qty_new = $request->quantity;
        $qty_old = $transaksiAlat->quantity;
        $tipeTransaksi_new = $request->tipe_transaksi;
        $tipeTransaksi_old = $transaksiAlat->tipe_transaksi;
        $idDetailAlat_new = $request->id_detail_alat;
        $idDetailAlat_old = $transaksiAlat->id_detail_alat;
        
        $detailAlat_old = DetailAlatModel::find($idDetailAlat_old);
        $detailAlat_new = DetailAlatModel::find($idDetailAlat_new);

        $stok_old = $detailAlat_old->stok_alat;
        $stok_new = $detailAlat_new->stok_alat;

        $stokQty_old = $stok_old+$qty_old;
        $totalQty = $qty_new + $qty_old;
        $stokOld_qtyNew = $stok_old + $qty_new;

        if ($idDetailAlat_new != $idDetailAlat_old) {
            if ($tipeTransaksi_new != $tipeTransaksi_old) {
                if ($tipeTransaksi_new == 'Masuk') {
                    $detailAlat_old->update([
                        'stok_alat' => $stok_old + $qty_old,
                    ]);
                    $detailAlat_new->update([
                        'stok_alat' => $stok_new + $qty_new,
                    ]);
                }elseif (in_array($tipeTransaksi_new, ['Keluar', 'Rusak'])) {
                    if ($tipeTransaksi_old == 'Masuk' && in_array($tipeTransaksi_new, ['Keluar', 'Rusak'])) {
                        if ($stok_old < $qty_old){
                            Alert::toast('Data transaksi alat gagal ditambahkan karena stok kurang dari kuantitas lama', 'error');
                            return redirect()->back();
                        }elseif ($stok_old >= $qty_old){
                            if ($stok_new < $qty_new) {
                                Alert::toast('Data transaksi alat gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                                return redirect()->back();
                            }elseif ($stok_new >= $qty_new){
                                $detailAlat_old->update([
                                    'stok_alat' => $stok_old - $qty_old,
                                ]);
                                $detailAlat_new->update([
                                    'stok_alat' => $stok_new - $qty_new,
                                ]);
                            }
                        }
                    }else if(($tipeTransaksi_old == 'Keluar' && $tipeTransaksi_new == 'Rusak') || 
                    ($tipeTransaksi_old == 'Rusak' && $tipeTransaksi_new == 'Keluar')){
                        if ($stok_new < $qty_new) {
                            Alert::toast('Data transaksi alat gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                            return redirect()->back();
                        }elseif ($stok_new >= $qty_new){
                            $detailAlat_old->update([
                                'stok_alat' => $stok_old + $qty_old,
                            ]);
                            $detailAlat_new->update([
                                'stok_alat' => $stok_new - $qty_new,
                            ]);
                        }
                    }
                }
            }elseif ($tipeTransaksi_new == $tipeTransaksi_old){
                if ($tipeTransaksi_new == 'Masuk') {
                    if ($stok_old < $qty_old) {
                        Alert::toast('Data transaksi alat gagal ditambahkan karena stok kurang dari kuantitas lama', 'error');
                        return redirect()->back();
                    }elseif($stok_old >= $qty_old){
                        $detailAlat_old->update([
                            'stok_alat' => $stok_old - $qty_old,
                        ]);
                        $detailAlat_new->update([
                            'stok_alat' => $stok_new + $qty_new,
                        ]);
                    }
                }elseif (in_array($tipeTransaksi_new, ['Keluar', 'Rusak'])) {
                    if ($stok_new < $qty_new) {
                        Alert::toast('Data transaksi alat gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                        return redirect()->back();
                    }elseif ($stok_new >= $qty_new){
                        $detailAlat_old->update([
                            'stok_alat' => $stok_old + $qty_old,
                        ]);
                        $detailAlat_new->update([
                            'stok_alat' => $stok_new - $qty_new,
                        ]);
                    }
                }
            }
        }elseif ($idDetailAlat_new == $idDetailAlat_old){
            if ($tipeTransaksi_new != $tipeTransaksi_old) {
                if ($tipeTransaksi_new == 'Masuk') {
                        $detailAlat_new->update([
                            'stok_alat' => $stok_old + $qty_old + $qty_new,
                        ]);
                }elseif (in_array($tipeTransaksi_new, ['Keluar', 'Rusak'])) {
                    if ($tipeTransaksi_old == 'Masuk' && in_array($tipeTransaksi_new, ['Keluar', 'Rusak'])) {
                        if ($stok_old < $totalQty) {
                            Alert::toast('Data transaksi alat gagal ditambahkan karena stok kurang dari kuantitas baru dan lama', 'error');
                            return redirect()->back();
                        }elseif ($stok_old >= $totalQty){
                            $detailAlat_new->update([
                                'stok_alat' => $stok_old - $totalQty,
                            ]);
                        }
                    }elseif (($tipeTransaksi_old == 'Keluar' && $tipeTransaksi_new == 'Rusak') || 
                    ($tipeTransaksi_old == 'Rusak' && $tipeTransaksi_new == 'Keluar')) {
                        if ($stokQty_old < $qty_new) {
                            Alert::toast('Data transaksi alat gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                            return redirect()->back();
                        }elseif ($stokQty_old >= $qty_new) {
                            $detailAlat_new->update([
                                'stok_alat' => $stokQty_old - $qty_new,
                            ]);
                        }
                    }
                }
            }elseif ($tipeTransaksi_new == $tipeTransaksi_old){
                if ($tipeTransaksi_new == 'Masuk') {
                    if ($stokOld_qtyNew < $qty_old) {
                        Alert::toast('Data transaksi alat gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                        return redirect()->back();
                    }elseif ($stokOld_qtyNew >= $qty_old) {
                        $detailAlat_new->update([
                            'stok_alat' =>$stokOld_qtyNew - $qty_old,
                        ]);
                    }
                }elseif ($tipeTransaksi_new == 'Keluar' || $tipeTransaksi_new == 'Rusak') {
                    if ($stokQty_old < $qty_new) {
                        Alert::toast('Data transaksi alat gagal ditambahkan karena stok kurang dari kuantitas baru', 'error');
                        return redirect()->back();
                    }elseif ($stokQty_old >= $qty_new) {
                        $detailAlat_new->update([
                            'stok_alat' => $stokQty_old - $qty_new,
                        ]);
                    }
                }
            }
        }
        $transaksiAlat->update([
            'kd_transaksi_alat' => $request->kd_transaksi_alat,
            'tipe_transaksi' => $tipeTransaksi_new,
            'quantity' => $qty_new,
            'id_detail_alat' => $idDetailAlat_new,
        ]);
        Alert::toast('Data transaksi alat berhasil diubah', 'success');
        return redirect()->route('admin.kelolaTransaksiAlat.index');
    }

    public function destroy($id) {
        $transaksiAlat = TransaksiAlatModel::find($id);
        if (!$transaksiAlat) {
            return response()->json([
                'success' => false,
                'message' => 'Data transaksi alat tidak ditemukan.'
            ], 404);
        }
        try{
            $qty = $transaksiAlat->quantity;
            $idDetailAlat = $transaksiAlat->id_detail_alat;
            $detailAlat = DetailAlatModel::find($idDetailAlat);
            $stok = $detailAlat->stok_alat;
            $tipeTransaki = $transaksiAlat->tipe_transaksi;
            if ($tipeTransaki == 'Masuk') {
                if($stok < $qty){
                    return response()->json([
                        'success' => false,
                        'message' => 'Data transaksi alat gagal dihapus karena stok kurang.'
                    ]);
                }else{
                    $detailAlat->update([
                        'stok_alat' => $stok - $qty,
                    ]);
                }
            }else{
                $detailAlat->update([
                    'stok_alat' => $stok + $qty,
                ]);
            }
            $transaksiAlat->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data transaksi alat berhasil dihapus.'
            ]);
        }catch(\Illuminate\Database\QueryException $e){
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus transaksi alat: ' . $e->getMessage()
            ], 500);
        }
    }
}
