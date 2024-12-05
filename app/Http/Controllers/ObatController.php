<?php

namespace App\Http\Controllers;

use App\Models\ObatModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ObatController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Obat',
            'paragraph' => 'Berikut ini merupakan data obat yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Obat'],
            ]
        ];
        $activeMenu = 'kelolaObat';
        $obat = ObatModel::all();
        return view('admin.kelolaObat.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'obat' => $obat]);
    }

    public function list()
    {
        $obats = ObatModel::select('id_obat', 'nama', 'harga_satuan', 'satuan'); 
        return DataTables::of($obats)
        ->make(true);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Obat',
            'paragraph' => 'Berikut ini merupakan form tambah data obat yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaObat.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaObat';
        return view('admin.kelolaObat.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|unique:obat,nama',
            'harga_satuan' => 'required|integer',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_obat', $foto, $namaFoto);
            $validatedData['foto'] = $path;
        }

        ObatModel::create($validatedData);
        Alert::toast('Data obat berhasil ditambahkan', 'success');

        // Redirect ke halaman kelola pengguna
        return redirect()->route('admin.kelolaObat.index');
    }

    public function show($id)
    {
        $obat = ObatModel::find($id); // Ambil data tambak dengan relasi gudang
        if (!$obat) {
            return response()->json(['error' => 'Data obat tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaObat.show', compact('obat'))->render();
        return response()->json(['html' => $view]);
    }

    public function edit(string $id){
        $obat = ObatModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Obat',
            'paragraph' => 'Berikut ini merupakan form edit data obat yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Obat', 'url' => route('admin.kelolaObat.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaObat';

        return view('admin.kelolaObat.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'obat' => $obat]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nama' => 'required|string|unique:obat,nama,'.$id.',id_obat',
            'harga_satuan' => 'required|integer',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $obat = ObatModel::find($id);

        if($request->oldImage != ''){
            if ($request->file('foto') == '') {
                $obat->update([
                    'nama' => $request->nama,
                    'harga_satuan' => $request->harga_satuan,
                    'satuan' => $request->satuan,
                    'deskripsi' => $request->deskripsi,
                ]);
            }else {
                Storage::disk('public')->delete($request->oldImage);
                $foto = $request->file('foto');
                $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('foto_obat', $foto, $namaFoto);
                $updateFoto['foto'] = $path;
    
                $obat->update([
                    'nama' => $request->nama,
                    'harga_satuan' => $request->harga_satuan,
                    'satuan' => $request->satuan,
                    'deskripsi' => $request->deskripsi,
                    'foto' => $updateFoto['foto']
                ]);
            }
        }else{
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_obat', $foto, $namaFoto);
            $updateFoto['foto'] = $path;

            $obat->update([
                'nama' => $request->nama,
                'harga_satuan' => $request->harga_satuan,
                'satuan' => $request->satuan,
                'deskripsi' => $request->deskripsi,
                'foto' => $updateFoto['foto']
            ]);
        }
        Alert::toast('Data obat berhasil diubah', 'success');
        return redirect()->route('admin.kelolaObat.index');
    }

    public function destroy($id)
    {
        $obat = ObatModel::find($id);
        if (!$obat) {
            return response()->json([
                'success' => false,
                'message' => 'Data obat tidak ditemukan.'
            ], 404);
        }
    
        try {
            if ($obat->foto) {
                Storage::disk('public')->delete($obat->foto);
            }
            $obat->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Data obat berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data obat: ' . $e->getMessage()
            ], 500);
        }
    }
}
