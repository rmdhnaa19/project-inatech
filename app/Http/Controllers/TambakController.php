<?php

namespace App\Http\Controllers;
use App\Models\GudangModel;
use App\Models\TambakModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TambakController extends Controller
{
   
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Tambak',
            'paragraph' => 'Berikut ini merupakan data tambak yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('tambak.index')],
                ['label' => 'Manajemen Tambak'],
            ]
        ];
        $activeMenu = 'manajemenTambak';
        return view('tambak.index',['breadcrumb' =>$breadcrumb,'activeMenu' => $activeMenu]);
    }
    

    public function list(Request $request)
    {
        $tambaks = TambakModel::select('id_tambak', 'nama_tambak', 'id_gudang','luas_lahan', 'luas_tambak', 'lokasi_tambak')->with('gudang'); 
        return DataTables::of($tambaks)
        ->make(true);
    }


    public function create(){
    $breadcrumb = (object) [
        'title' => 'Tambah Data Tambak',
        'paragraph' => 'Berikut ini merupakan form tambah data tambak yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Kelola Pengguna', 'url' => route('tambak.index')],
            ['label' => 'Tambah'],
        ]
    ];
    $activeMenu = 'manajemenTambak';
        $tambak = TambakModel::all();
        $gudang= GudangModel::all();
        return view('tambak.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'gudang' => $gudang, 'tambak' => $tambak]);
}


    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'nama_tambak' => 'required|string|unique:tambak,nama_tambak',
            'id_gudang' => 'required|integer',
            'luas_lahan' => 'required|integer',
            'luas_tambak' => 'required|integer',
            'lokasi_tambak' => 'required|string',            
        ]);

        // Mengelola upload foto jika ada
    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('foto_tambak', 'public'); // Simpan ke storage
        $validatedData['foto'] = $path; // Tambahkan path foto ke validated data
    }
    // Simpan data ke database
    TambakModel::create($validatedData);
    return redirect()->route('tambak.index')->with('success', 'Data tambak berhasil ditambahkan');
}


//     public function show(string $id)
// {
//     $tambak = TambakModel::find($id);
//     if (!$tambak) {
//         return response()->json(['error' => 'Tambak tidak ditemukan.'], 404);
//     }

//     $view = view('tambak.show', compact('tambak'))->render();
//     return response()->json(['html' => $view]);
//     }
// }

public function show($id)
{
    $tambak = TambakModel::with('gudang')->find($id); // Ambil data tambak dengan relasi gudang
    if (!$tambak) {
        return response()->json(['error' => 'Tambak tidak ditemukan.'], 404);
    }

    // Render view dengan data tambak
    $view = view('tambak.show', compact('tambak'))->render();
    return response()->json(['html' => $view]);
}
}
