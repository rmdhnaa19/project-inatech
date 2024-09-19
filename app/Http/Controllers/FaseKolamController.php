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
        $activeMenu = 'fasekolam';
        $kolam = KolamModel::all();
        return view('fasekolam.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kolam' => $kolam]);
    }
    
    public function list(Request $request)
    {
        $fasekolams = FaseKolamModel::select('id_fase_tambak', 'kd_fase_tambak', 'tanggal_mulai', 'tanggal_panen', 'jumlah_tebar', 'densitas', 'id_kolam', 'created_at', 'updated_at')->with('kolam');  
        if ($request->id_kolam) {
            $fasekolams->where('id_kolam', $request->id_kolam);
        }
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
        $activeMenu = 'fasekolam';
        $kolam = KolamModel::all();
        return view('fasekolam.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kolam' => $kolam]);
}

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kd_fase_tambak' => 'required|string|unique:fase_tambak,kd_fase_tambak',
            'tanggal_mulai' => 'required|date',
            'tanggal_panen' => 'required|date',
            'jumlah_tebar' => 'required|integer',
            'densitas' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'id_kolam' => 'required|string',                 
        ]);

        // Mengelola upload foto jika ada
    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('foto_fase_kolam', 'public'); // Simpan ke storage
        $validatedData['foto'] = $path; // Tambahkan path foto ke validated data
    }

    // Simpan data ke database
    FaseKolamModel::create($validatedData);

    return redirect()->route('fasekolam.index')->with('success', 'Data fase kolam berhasil ditambahkan');
    }

public function show($id)
{
    $fasekolam = FaseKolamModel::with('kolam')->find($id); // Ambil data tambak dengan relasi gudang
    if (!$fasekolam) {
        return response()->json(['error' => ' Fase kolam tidak ditemukan.'], 404);
    }

    // Render view dengan data tambak
    $view = view('fasekolam.show', compact('fasekolam'))->render();
    return response()->json(['html' => $view]);
}
}