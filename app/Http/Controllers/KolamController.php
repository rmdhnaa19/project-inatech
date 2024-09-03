<?php

namespace App\Http\Controllers;

use App\Models\KolamModel;
use App\Models\TambakModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KolamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Kolam',
            'paragraph' => 'Berikut ini merupakan data kolam yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('kolam.index')],
                ['label' => 'Manajemen Kolam'],
            ]
        ];
        $activeMenu = 'manajemenKolam';
        $tambak = TambakModel::all();
        return view('kolam.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'tambak' => $tambak]);
    }
    
    public function list(Request $request)
    {
        $kolams = KolamModel::select('id_kolam', 'kd_kolam', 'tipe_kolam','panjang_kolam', 'lebar_kolam', 'luas_kolam', 'kedalaman', 'id_tambak', 'created_at', 'updated_at')->with('tambak'); 
        return DataTables::of($kolams)
        ->make(true);
    }
    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Kolam',
            'paragraph' => 'Berikut ini merupakan form tambah data kolam yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Manajemen Kolam', 'url' => route('kolam.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'manajemenTambak';
        $tambak = TambakModel::all();
        return view('kolam.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'tambak' => $tambak]);
    }
}
