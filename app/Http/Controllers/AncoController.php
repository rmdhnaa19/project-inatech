<?php

namespace App\Http\Controllers;

use App\Models\AncoModel;
use App\Models\FaseKolamModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AncoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Anco',
            'paragraph' => 'Berikut ini merupakan data anco yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('anco.index')],
                ['label' => 'Anco'],
            ]
        ];
        $activeMenu = 'anco';
        $fase_kolam = FaseKolamModel::all();
        return view('anco.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
    }

    // menampilkan data table    
    public function list(Request $request)
    {
        $ancos = AncoModel::select('id_anco','kd_anco', 'tanggal_cek', 'waktu_cek', 'pemberian_pakan','jamPemberian_pakan','kondisi_pakan', 'kondisi_udang', 'catatan', 'id_fase_tambak', 'created_at', 'updated_at')->with('fase_tambak'); 
        return DataTables::of($ancos)
        ->make(true);
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Anco',
            'paragraph' => 'Berikut ini merupakan form tambah data anco yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Anco', 'url' => route('anco.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'anco';
    $fase_kolam = FaseKolamModel::all();
    return view('anco.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
}
}


