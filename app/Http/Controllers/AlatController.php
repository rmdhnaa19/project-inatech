<?php

namespace App\Http\Controllers;

use App\Models\AlatModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class AlatController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Alat',
            'paragraph' => 'Berikut ini merupakan data alat yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Alat'],
            ]
        ];
        $activeMenu = 'kelolaAlat';
        $alat = AlatModel::all();
        return view('admin.kelolaAlat.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'alat' => $alat]);
    }

    public function list()
    {
        $alats = AlatModel::select('id_alat', 'nama', 'harga_satuan', 'satuan'); 
        return DataTables::of($alats)
        ->make(true);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Alat',
            'paragraph' => 'Berikut ini merupakan form tambah data alat yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaAlat.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaAlat';
        return view('admin.kelolaAlat.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|unique:alat,nama',
            'harga_satuan' => 'required|integer',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_alat', $foto, $namaFoto);
            $validatedData['foto'] = $path;
        }

        AlatModel::create($validatedData);
        Alert::toast('Data alat berhasil ditambahkan', 'success');

        // Redirect ke halaman kelola pengguna
        return redirect()->route('admin.kelolaAlat.index');
    }

    public function show($id)
    {
        $alat = AlatModel::find($id); // Ambil data tambak dengan relasi gudang
        if (!$alat) {
            return response()->json(['error' => 'Data alat tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaAlat.show', compact('alat'))->render();
        return response()->json(['html' => $view]);
    }

    public function edit(string $id){
        $alat = AlatModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Alat',
            'paragraph' => 'Berikut ini merupakan form edit data alat yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Alat', 'url' => route('admin.kelolaAlat.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaAlat';

        return view('admin.kelolaAlat.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'alat' => $alat]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nama' => 'required|string|unique:alat,nama,'.$id.',id_alat',
            'harga_satuan' => 'required|integer',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $alat = AlatModel::find($id);

        if ($request->oldImage != '') {
            if ($request->file('foto') == '') {
                $alat->update([
                    'nama' => $request->nama,
                    'harga_satuan' => $request->harga_satuan,
                    'satuan' => $request->satuan,
                    'deskripsi' => $request->deskripsi,
                ]);
            }else {
                Storage::disk('public')->delete($request->oldImage);
                $foto = $request->file('foto');
                $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('foto_alat', $foto, $namaFoto);
                $updateFoto['foto'] = $path;
    
                $alat->update([
                    'nama' => $request->nama,
                    'harga_satuan' => $request->harga_satuan,
                    'satuan' => $request->satuan,
                    'deskripsi' => $request->deskripsi,
                    'foto' => $updateFoto['foto']
                ]);
            }
            Alert::toast('Data alat berhasil diubah', 'success');
            return redirect()->route('admin.kelolaAlat.index');
        }else {
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_alat', $foto, $namaFoto);
            $updateFoto['foto'] = $path;
    
            $alat->update([
                'nama' => $request->nama,
                'harga_satuan' => $request->harga_satuan,
                'satuan' => $request->satuan,
                'deskripsi' => $request->deskripsi,
                'foto' => $updateFoto['foto']
            ]);
        }
    }

    public function destroy($id) {
        $check = AlatModel::find($id);
        if (!$check) {
            Alert::toast('Data alat tidak ditemukan', 'error');
            return redirect('/kelolaAlat');
        }
        try{
            $kelolaAlat = AlatModel::find($id);
            if ($kelolaAlat->foto != '') {
                Storage::disk('public')->delete($kelolaAlat->foto);
                AlatModel::destroy($id);
            }else {
                AlatModel::destroy($id);
            }
            Alert::toast('Data alat berhasil dihapus', 'success');
            return redirect('/kelolaAlat');
        }catch(\Illuminate\Database\QueryException $e){
            Alert::toast('Data alat gagal dihapus', 'error');
            return redirect('/kelolaAlat');
        }
    }
}
