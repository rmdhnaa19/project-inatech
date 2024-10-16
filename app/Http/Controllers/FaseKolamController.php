<?php

namespace App\Http\Controllers;

use App\Models\FaseKolamModel;
use App\Models\KolamModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class FaseKolamController extends Controller
{
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
            $validatedData = $request->validate([
            'kd_fase_tambak' => 'required|string|unique:fase_tambak,kd_fase_tambak',
            'tanggal_mulai' => 'required|date',
            'tanggal_panen' => 'required|date',
            'jumlah_tebar' => 'required|integer',
            'densitas' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'id_kolam' => 'required|string',                 
        ]);

    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('foto_fase_kolam', 'public'); 
        $validatedData['foto'] = $path;
    }

    // Simpan data ke database
    FaseKolamModel::create($validatedData);

    return redirect()->route('fasekolam.index')->with('success', 'Data fase kolam berhasil ditambahkan');
    }


    public function show($id)
    {
        $fasekolam = FaseKolamModel::with('kolam')->find($id); // Ambil data fase kolam dengan relasi kolam
        if (!$fasekolam) {
            return response()->json(['error' => ' Fase kolam tidak ditemukan.'], 404);
    }

    // Render view dengan data 
    $view = view('fasekolam.show', compact('fasekolam'))->render();
    return response()->json(['html' => $view]);
    }


    public function edit($id)
    {
        $fasekolam = FaseKolamModel::find($id);
        $kolam = KolamModel::all();
        
        if (!$fasekolam) {
        return redirect()->route('fasekolam.index')->with('error', 'Fase Kolam tidak ditemukan');
    }
    
    $breadcrumb = (object) [
        'title' => 'Edit Data Fase Kolam',
        'paragraph' => 'Berikut ini merupakan form edit data fase kolam yang ada di dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Kelola Fase Kolam', 'url' => route('fasekolam.index')],
            ['label' => 'Edit'],
        ]
    ];

    $activeMenu = 'fasekolam';
    return view('fasekolam.edit', compact('fasekolam', 'kolam', 'breadcrumb', 'activeMenu'));
    }


    public function update(Request $request, $id)
    {
        $fasekolam = FaseKolamModel::find($id);

        if (!$fasekolam) {
            return redirect()->route('fasekolam.index')->with('error', 'Fase kolam tidak ditemukan');
    }

    // Validasi input
        $validatedData = $request->validate([
        'tanggal_mulai' => 'required|string',
        'tanggal_panen' => 'required|string',
        'jumlah_tebar' => 'required|integer',
        'densitas' => 'required|integer',
        'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        'id_kolam' => 'required|integer',
    ]);

    // Mengelola upload foto jika ada
    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('foto_fasekolam', 'public');
        $validatedData['foto'] = $path;
    }

    // Update data fase kolam
    $fasekolam->update($validatedData);

    return redirect()->route('fasekolam.index')->with('success', 'Data fase kolam berhasil diubah');
    }


    public function destroy($id) {
        $fasekolam = FaseKolamModel::findOrFail($id);
        Storage::delete($fasekolam->foto);
        FaseKolamModel::destroy($id);
        return response()->redirect()->route('fasekolam.index');
    }
}
