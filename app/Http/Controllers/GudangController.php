<?php

namespace App\Http\Controllers;

use App\Models\GudangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class GudangController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Gudang',
            'paragraph' => 'Berikut ini merupakan data gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Gudang'],
            ]
        ];
        $activeMenu = 'kelolaGudang';
        return view('admin.kelolaGudang.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $gudangs = GudangModel::select('id_gudang', 'nama', 'alamat', 'luas'); 
        return DataTables::of($gudangs)
        ->make(true);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Gudang',
            'paragraph' => 'Berikut ini merupakan form tambah data gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Gudang', 'url' => route('admin.kelolaGudang.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaGudang';
        return view('admin.kelolaGudang.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|unique:gudang,nama',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'luas' => 'required|numeric',
            'alamat' => 'nullable|string',
            'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('foto_gudang', 'public'); // Simpan ke storage
            $validatedData['gambar'] = $path; // Tambahkan path foto ke validated data
        }
        GudangModel::create($validatedData);
        // Alert::toast('Data administrasi berhasil ditambahkan', 'success');
        return redirect()->route('admin.kelolaGudang.index');
    }

    public function show($id)
    {
        $gudang = GudangModel::find($id); // Ambil data tambak dengan relasi gudang
        if (!$gudang) {
            return response()->json(['error' => 'Gudang tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaGudang.show', compact('gudang'))->render();
        return response()->json(['html' => $view]);
    }

    public function edit(string $id){
        $gudang = GudangModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Gudang',
            'paragraph' => 'Berikut ini merupakan form edit data gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Gudang', 'url' => route('admin.kelolaGudang.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaGudang';

        return view('admin.kelolaGudang.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'gudang' => $gudang]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nama' => 'required|string|unique:gudang,nama,'.$id.',id_gudang',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'luas' => 'required|numeric',
            'alamat' => 'nullable|string',
            'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gudang = GudangModel::find($id);


        if ($request->file('gambar') == '') {
            $gudang->update([
                'nama' => $request->nama,
                'panjang' => $request->panjang,
                'lebar' => $request->lebar,
                'luas' => $request->luas,
                'alamat' => $request->alamat,
            ]);
        }else{
            Storage::disk('public')->delete($request->oldImage);
            $gambar = $request->file('gambar');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_gudang', $gambar, $namaGambar);
            $updateGambar['gambar'] = $path;
            
            $gudang->update([
                'nama' => $request->nama,
                'panjang' => $request->panjang,
                'lebar' => $request->lebar,
                'luas' => $request->luas,
                'alamat' => $request->alamat,
                'gambar' => $updateGambar['gambar']
            ]);
        }
        return redirect()->route('admin.kelolaGudang.index')->with('success', 'Data Berhasil Diubah!');
    }

    public function destroy($id) {
        $gudang = GudangModel::find($id);
        if ($gudang) {
            if ($gudang->gambar) {
                Storage::disk('public')->delete($gudang->gambar);
            }
            $gudang->delete();
            return response()->json(['success' => true, 'message' => 'Data Berhasil Dihapus!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gudang tidak ditemukan'], 404);
        }
    }
}
