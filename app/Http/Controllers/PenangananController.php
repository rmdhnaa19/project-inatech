<?php

namespace App\Http\Controllers;

use App\Models\PenangananModel;
use App\Models\FaseKolamModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PenangananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Penanganan',
            'paragraph' => 'Berikut ini merupakan data penanganan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('penanganan.index')],
                ['label' => 'penanganan'],
            ]
        ];
        $activeMenu = 'penanganan';
        $fase_kolam = FaseKolamModel::all();
        return view('penanganan.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
    }

    // menampilkan data table    
    public function list(Request $request)
    {
        $penanganans = PenangananModel::select('id_penanganan', 'kd_penanganan', 'tanggal_cek', 'waktu_cek', 'pemberian_mineral','pemberian_vitamin','pemberian_obat', 'penambahan_air', 'pengurangan_air', 'catatan','id_fase_tambak', 'created_at', 'updated_at')->with('fase_tambak'); 
        return DataTables::of($penanganans)
        ->make(true);
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Penanganan',
            'paragraph' => 'Berikut ini merupakan form tambah data penanganan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'penanganan', 'url' => route('penanganan.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'penanganan';
    $fase_kolam = FaseKolamModel::all();
    return view('penanganan.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
}
}


