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
        $kematianudangs = KematianUdangModel::select('id_kematian_udang', 'kd_kematian_udang', 'size_udang', 'berat_udang', 'catatan','gambar', 'id_fase_tambak', 'created_at', 'updated_at')->with('faseKolam'); 
        return DataTables::of($kematianudangs)
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

public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'kd_kematian_udang' => 'required|string|max:255|unique:kematian_udang,kd_kematian_udang',
        'size_udang' => 'required|integer',
        'berat_udang' => 'required|integer',
        'catatan' => 'required|string',
        // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Simpan data ke dalam database
    $kematianudangs = new KematianUdangModel();
    $kematianudangs->kd_kematian_udang = $request->kd_kematian_udang;
    $kematianudangs->size_udang = $request->size_udang;
    $kematianudangs->berat_udang = $request->berat_udang;
    $kematianudangs->catatan = $request->catatan;
   

    // // Simpan file image jika ada
    // if ($request->hasFile('image')) {
    //     $file = $request->file('image');
    //     $filename = time() . '_' . $file->getClientOriginalName();
    //     $file->move(public_path('uploads/kematianUdang'), $filename);
    //     $kematianudangs->image = $filename;
    // }

    $kematianudangs->save();

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('kematianudang.index')->with('success', 'Data kematian udang berhasil ditambahkan');
}


}


