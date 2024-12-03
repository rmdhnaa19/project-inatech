<?php

namespace App\Http\Controllers;

use App\Models\GudangModel;
use App\Models\TambakModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
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
    

    // public function list(Request $request)
    // {
    //     $tambaks = TambakModel::select('id_tambak', 'nama_tambak', 'id_gudang','luas_lahan', 'luas_tambak', 'lokasi_tambak')->with('gudang'); 
    //     return DataTables::of($tambaks)
    //     ->make(true);
    // }

    public function list(Request $request)
    {
        $tambaks = TambakModel::select('id_tambak', 'nama_tambak', 'id_gudang','luas_lahan', 'luas_tambak', 'lokasi_tambak')->with('gudang');  
        if ($request->id_tambak) {
            $tambaks->where('id_tambak', $request->id_tambak);
        }
        return DataTables::of($tambaks)
        ->make(true);
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Tambak',
            'paragraph' => 'Berikut ini merupakan form tambah data tambak yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Tambak', 'url' => route('tambak.index')],
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

        // Jika ada file foto, simpan file tersebut dan tambahkan path ke validatedData
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_tambak', $foto, $namaFoto);
            $validatedData['foto'] = $path;
        } else {
            // Jika tidak ada foto yang diupload, set ke null
            $validatedData['foto'] = null;
        }

        // Simpan data ke database
        TambakModel::create($validatedData);
        Alert::toast('Data Tambak berhasil diubah', 'success');
        return redirect()->route('tambak.index');
    }

    public function show($id)
{
    $tambak = TambakModel::with('gudang')->find($id); 
    if (!$tambak) {
        return response()->json(['error' => 'Tambak tidak ditemukan.'], 404);
    }

    // Render view 
    $view = view('tambak.show', compact('tambak'))->render();
    return response()->json(['html' => $view]);
}


    public function edit($id)
    {
        $tambak = TambakModel::find($id);
        $gudang = GudangModel::all();
        
        if (!$tambak) {
            return redirect()->route('tambak.index')->with('error', 'Tambak tidak ditemukan');
        }
        
        $breadcrumb = (object) [
            'title' => 'Edit Data Tambak',
            'paragraph' => 'Berikut ini merupakan form edit data tambak yang ada di dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Tambak', 'url' => route('tambak.index')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'manajemenTambak';

        return view('tambak.edit', compact('tambak', 'gudang', 'breadcrumb', 'activeMenu'));
        // return view('tambak.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'tambak' => $tambak, 'gudang' => $gudang]);
    }


    public function update(Request $request, string $id) {
    
        $request->validate([
        'nama_tambak' => 'required|string|unique:tambak,nama_tambak,'.$id.',id_tambak',
        'id_gudang' => 'required',
        'luas_lahan' => 'required|numeric',
        'luas_tambak' => 'required|numeric',
        'lokasi_tambak' => 'required|string|max:255',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $tambak = TambakModel::find($id);

    if ($request->file('foto') == '') {
        $tambak->update([
            'nama_tambak' => $request->nama_tambak,
            'id_gudang' => $request->id_gudang,
            'luas_lahan' => $request->luas_lahan,
            'luas_tambak' => $request->luas_tambak,
            'lokasi_tambak' => $request->lokasi_tambak,
    ]);
    }else{
        Storage::disk('public')->delete($request->oldImage);
        $foto = $request->file('foto');
        $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('foto_tambak', $foto, $namaFoto);
        $updateFoto['foto'] = $path;

    $tambak->update([
            'nama_tambak' => $request->nama_tambak,
            'id_gudang' => $request->id_gudang,
            'luas_lahan' => $request->luas_lahan,
            'luas_tambak' => $request->luas_tambak,
            'lokasi_tambak' => $request->lokasi_tambak,
            'foto' => $updateFoto['foto']
        ]);
    }
        Alert::toast('Data Tambak berhasil diubah', 'success');   
        return redirect()->route('tambak.index');
    }


    public function destroy($id) {
        $tambak = TambakModel::find($id);
        if ($tambak->foto) {
            Storage::disk('public')->delete($tambak->foto);
        }
        TambakModel::destroy($id);
        return redirect()->route('tambak.index')->with('success', 'Data Berhasil Dihapus!');
    }
}