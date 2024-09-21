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
        $ancos = AncoModel::select('id_anco','kd_anco', 'tanggal_cek', 'waktu_cek', 'pemberian_pakan','jamPemberian_pakan','kondisi_pakan', 'kondisi_udang', 'catatan', 'id_fase_tambak', 'created_at', 'updated_at')->with('faseKolam'); 
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

public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'kd_anco' => 'required|string|max:255|unique:anco,kd_anco',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'pemberian_pakan' => 'required|string',
        'jamPemberian_pakan' => 'required',
        'kondisi_pakan' => 'required|string',
        'kondisi_udang' => 'required|string',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
        // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Simpan data ke dalam database
    $anco = new AncoModel();
    $anco->kd_anco = $request->kd_anco;
    $anco->tanggal_cek = $request->tanggal_cek;
    $anco->waktu_cek = $request->waktu_cek;
    $anco->pemberian_pakan = $request->pemberian_pakan;
    $anco->jamPemberian_pakan = $request->jamPemberian_pakan;
    $anco->kondisi_pakan = $request->kondisi_pakan;
    $anco->kondisi_udang = $request->kondisi_udang;
    $anco->catatan = $request->catatan;
    $anco->id_fase_tambak = $request->id_fase_tambak;

    // Simpan file image jika ada
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/anco'), $filename);
        $anco->image = $filename;
    }

    $anco->save();

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('anco.index')->with('success', 'Data anco berhasil ditambahkan');
}
}


