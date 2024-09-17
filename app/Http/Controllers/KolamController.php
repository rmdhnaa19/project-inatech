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
        if ($request->id_tambak) {
            $kolams->where('id_tambak', $request->id_tambak);
        }
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


    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'tipe_kolam' => 'required|in:kotak,bundar',
            'kd_kolam' => 'required|string|unique:kolam,kd_kolam',
            'panjang_kolam' => 'required|integer',
            'lebar_kolam' => 'nullable|integer',
            'luas_kolam' => 'required|integer',
            'kedalaman' => 'required|integer',
            'id_tambak' => 'required|integer',

        ]);

        // Mengelola upload foto jika ada
    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('foto_kolam', 'public'); // Simpan ke storage
        $validatedData['foto'] = $path; // Tambahkan path foto ke validated data
    }

    // Simpan data ke database
    KolamModel::create($validatedData);
    return redirect()->route('kolam.index')->with('success', 'Data tambak berhasil ditambahkan');
}

    public function show(string $id){
        $kolam = KolamModel::find($id); // Pastikan $id diisi dengan nilai yang valid
        if (!$kolam) {
            return redirect()->route('kolam.index')->with('error', 'Kolam tidak ditemukan.');
        }
        return view('kolam.show', compact('kolam'));
    }
}
