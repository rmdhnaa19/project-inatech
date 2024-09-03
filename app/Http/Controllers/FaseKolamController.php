<?php

namespace App\Http\Controllers;

use App\Models\FaseKolamModel;
use App\Models\KolamModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaseKolamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Fase Kolam',
            'paragraph' => 'Berikut ini merupakan data fase kolam yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('fasekolam.index')],
                ['label' => 'Manajemen Fase Kolam'],
            ]
        ];
        $activeMenu = 'faseKolam';
        $kolam = KolamModel::all();
        return view('fasekolam.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kolam' => $kolam]);
    }
    
    public function list(Request $request)
    {
        $fasekolams = FaseKolamModel::select('id_fase_tambak', 'kd_fase_tambak', 'tanggal_mulai', 'tanggal_panen', 'jumlah_tebar', 'densitas', 'id_kolam', 'created_at', 'updated_at')->with('kolam');  
        return DataTables::of($fasekolams)
        ->make(true);
    }
    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Fase Kolam',
            'paragraph' => 'Berikut ini merupakan form tambah data fase kolam yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Manajemen Fase Kolam', 'url' => route('fasekolam.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'faseKolam';
        $kolam = KolamModel::all();
        return view('fasekolam.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kolam' => $kolam]);
}
}