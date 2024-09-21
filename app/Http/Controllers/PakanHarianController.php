<?php

namespace App\Http\Controllers;

use App\Models\DetailPakanModel;
use App\Models\PakanHarianModel;
use App\Models\FaseKolamModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PakanHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Pakan Harian',
            'paragraph' => 'Berikut ini merupakan data pakan harian yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('pakanharian.index')],
                ['label' => 'pakanHarian'],
            ]
        ];
        $activeMenu = 'pakanHarian';
        $fase_kolam = FaseKolamModel::all();
        $detail_pakan = DetailPakanModel::all();
        return view('pakanharian.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'detail_pakan' => $detail_pakan]);
    }

    // menampilkan data table    
    public function list(Request $request)
    {
        $pakan_harians = PakanHarianModel::select('id_pakan_harian', 'kd_pakan_harian', 'tanggal_cek', 'waktu_cek', 'DOC','berat_udang','total_pakan', 'catatan', 'id_fase_tambak','id_detail_pakan', 'created_at', 'updated_at')->with('faseKolam', 'detailPakan'); 
        return DataTables::of($pakan_harians)
        ->make(true);
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Pakan Harian',
            'paragraph' => 'Berikut ini merupakan form tambah data pakan harian yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'pakanHarian', 'url' => route('pakanharian.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'pakanHarian';
    $fase_kolam = FaseKolamModel::all();
    $detail_pakan = DetailPakanModel::all();
    return view('pakanharian.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'detail_pakan' => $detail_pakan]);
}

public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'kd_pakan_harian' => 'required|string|max:255|unique:pakan_harian,kd_pakan_harian',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'DOC' => 'required|integer',
        'berat_udang' => 'required|integer',
        'total_pakan' => 'required|integer',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
        // 'id_detail_pakan' => 'required',
    ]);

    // Simpan data ke dalam database
    $pakan_harians = new PakanHarianModel();
    $pakan_harians->kd_pakan_harian = $request->kd_pakan_harian;
    $pakan_harians->tanggal_cek = $request->tanggal_cek;
    $pakan_harians->waktu_cek = $request->waktu_cek;
    $pakan_harians->DOC = $request->DOC;
    $pakan_harians->berat_udang = $request->berat_udang;
    $pakan_harians->total_pakan = $request->total_pakan;
    $pakan_harians->catatan = $request->catatan;
    $pakan_harians->id_fase_tambak = $request->id_fase_tambak;
    // $pakan_harians->id_detail_pakan = $request->id_detail_pakan;
    

    $pakan_harians->save();

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('pakanharian.index')->with('success', 'Data pakan harian berhasil ditambahkan');
}

}


