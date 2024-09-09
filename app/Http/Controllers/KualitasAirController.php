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
        $activeMenu = 'kualitasir';
        $fase_kolam = FaseKolamModel::all();
        return view('kualitasair.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
    }

    // menampilkan data table    
    public function list(Request $request)
    {
        $kualitasairs = KualitasAirModel::select('id_kualitas_air', 'kd_kualitas_air', 'tanggal_cek', 'waktu_cek', 'pH','salinitas','DO', 'suhu', 'kejernihan_air', 'warna_air', 'catatan','id_fase_tambak', 'created_at', 'updated_at')->with('fase_tambak'); 
        return DataTables::of($kualitasairs)
        ->make(true);
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Kualitas Air',
            'paragraph' => 'Berikut ini merupakan form tambah data kualitas air yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Anco', 'url' => route('kualitasair.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'kualitasAir';
    $fase_kolam = FaseKolamModel::all();
    return view('kualitasair.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
}

}


