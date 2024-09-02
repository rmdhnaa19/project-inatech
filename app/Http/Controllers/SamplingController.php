<?php

namespace App\Http\Controllers;

use App\Models\SamplingModel;
use App\Models\FaseKolamModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SamplingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Sampling',
            'paragraph' => 'Berikut ini merupakan data sampling yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('sampling.index')],
                ['label' => 'sampling'],
            ]
        ];
        $activeMenu = 'sampling';
        $fase_kolam = FaseKolamModel::all();
        return view('sampling.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
    }

    // menampilkan data table    
    public function list(Request $request)
    {
        $samplings = SamplingModel::select('id_sampling', 'kd_sampling', 'tanggal_cek', 'waktu_cek', 'DOC','berat_udang','size_udang', 'interval_hari', 'harga_udang', 'input_fr', 'total_pakan', 'ADG_udang', 'biomassa', 'populasi_ekor', 'catatan','id_fase_tambak', 'created_at', 'updated_at')->with('fase_tambak'); 
        return DataTables::of($samplings)
        ->make(true);
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Sampling',
            'paragraph' => 'Berikut ini merupakan form tambah data sampling yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Sampling', 'url' => route('sampling.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'sampling';
    $fase_kolam = FaseKolamModel::all();
    return view('sampling.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
}
}


