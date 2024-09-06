<?php

namespace App\Http\Controllers;

use App\Models\KualitasAirModel;
use App\Models\FaseKolamModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KualitasAirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Kualitas Air',
            'paragraph' => 'Berikut ini merupakan data kualitas air yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('kualitasair.index')],
                ['label' => 'kualitasAir'],
            ]
        ];
        $activeMenu = 'kualitasair';
        $fase_kolam = FaseKolamModel::all();
        return view('kualitasair.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
    }

    // menampilkan data table    
    public function list(Request $request)
    {
        $kualitasairs = KualitasAirModel::select('id_kualitas_air', 'kd_kualitas_air', 'tanggal_cek', 'waktu_cek', 'pH','salinitas','DO', 'suhu', 'kejernihan_air', 'warna_air', 'catatan','id_fase_tambak', 'created_at', 'updated_at')->with('faseKolam'); 
        return DataTables::of($kualitasairs)
        ->make(true);
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Kualitas Air',
            'paragraph' => 'Berikut ini merupakan form tambah data kualitas air yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kualitas Air', 'url' => route('kualitasair.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'kualitasAir';
    $fase_kolam = FaseKolamModel::all();
    return view('kualitasair.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
}

public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'kd_kualitas_air' => 'required|string|max:255|unique:kualitas_air,kd_kualitas_air',
        'tanggal_cek' => 'required|date',
        'pH' => 'required|integer',
        'kejernihan_air' => 'required|string',
        'warna_air' => 'required|string',
        // 'id_fase_tambak' => 'required|exists:fase_kolam,id_fase_tambak',
        // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

        // Simpan data ke dalam database
        $kualitasairs = new KualitasAirModel();
        $kualitasairs->kd_kualitas_air = $request->kd_kualitas_air;
        $kualitasairs->tanggal_cek = $request->tanggal_cek;
        $kualitasairs->pH = $request->pH;
        $kualitasairs->kejernihan_air = $request->kejernihan_air;
        $kualitasairs->warna_air = $request->warna_air;
        // $kualitasairs->id_fase_tambak = $request->id_fase_tambak;

    // Simpan file image jika ada//
    // if ($request->hasFile('image')) {
    //     $file = $request->file('image');
    //     $filename = time() . '_' . $file->getClientOriginalName();
    //     $file->move(public_path('uploads/anco'), $filename);
    //     $kualitasairs->image = $filename;
    // }

    $kualitasairs->save();

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('kualitasair.index');
}

}


