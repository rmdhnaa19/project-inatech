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
        $pakan_harians = PakanHarianModel::select('id_pakan_harian', 'kd_pakan_harian', 'tanggal_cek', 'waktu_cek', 'DOC','berat_udang','total_pakan', 'catatan', 'id_fase_tambak','id_detail_pakan', 'created_at', 'updated_at')->with('fase_tambak', 'detail_pakan'); 
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
}


