<?php

namespace App\Http\Controllers;

use App\Models\KematianUdangModel;
use App\Models\FaseKolamModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KematianUdangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Kematian Udang',
            'paragraph' => 'Berikut ini merupakan data kematian udang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('kematianudang.index')],
                ['label' => 'kematianUdang'],
            ]
        ];
        $activeMenu = 'kematianudang';
        $fase_kolam = FaseKolamModel::all();
        return view('kematianudang.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
    }

    // menampilkan data table    
    public function list(Request $request)
    {
        $kematian_udangs = KematianUdangModel::select('id_kematian_udang', 'kd_kematian_udang', 'size_udang', 'berat_udang', 'catatan','gambar', 'id_fase_tambak', 'created_at', 'updated_at')->with('fase_tambak'); 
        return DataTables::of($kematian_udangs)
        ->make(true);
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Kematian Udang',
            'paragraph' => 'Berikut ini merupakan form tambah data kematian udang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'kematianUdang', 'url' => route('kematianudang.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'kematianUdang';
    $fase_kolam = FaseKolamModel::all();
    return view('kematianudang.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
}
}


