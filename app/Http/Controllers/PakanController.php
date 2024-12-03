<?php

namespace App\Http\Controllers;

use App\Models\PakanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PakanController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Pakan',
            'paragraph' => 'Berikut ini merupakan data pakan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan'],
            ]
        ];
        $activeMenu = 'kelolaPakan';
        $pakan = PakanModel::all();
        return view('admin.kelolaPakan.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'pakan' => $pakan]);
    }

    public function list()
    {
        $pakans = PakanModel::select('id_pakan', 'nama', 'harga_satuan', 'satuan'); 
        return DataTables::of($pakans)
        ->make(true);
    }

    public function show($id)
    {
        $pakan = PakanModel::find($id); // Ambil data tambak dengan relasi gudang
        if (!$pakan) {
            return response()->json(['error' => 'Data pakan tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaPakan.show', compact('pakan'))->render();
        return response()->json(['html' => $view]);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Pakan',
            'paragraph' => 'Berikut ini merupakan form tambah data pakan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaPakan.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaPakan';
        return view('admin.kelolaPakan.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|unique:pakan,nama',
            'harga_satuan' => 'required|integer',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_pakan', $foto, $namaFoto);
            $validatedData['foto'] = $path;
        }

        // Buat user baru
        PakanModel::create($validatedData);
        Alert::toast('Data pakan berhasil ditambahkan', 'success');

        // Redirect ke halaman kelola pengguna
        return redirect()->route('admin.kelolaPakan.index');
    }

    public function edit(string $id){
        $pakan = PakanModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Pakan',
            'paragraph' => 'Berikut ini merupakan form edit data pakan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaPakan.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaPakan';

        return view('admin.kelolaPakan.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'pakan' => $pakan]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nama' => 'required|string|unique:pakan,nama,'.$id.',id_pakan',
            'harga_satuan' => 'required|integer',
            'satuan' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $pakan = PakanModel::find($id);

        if ($request->oldImage != '') {
            if ($request->file('foto') == '') {
                $pakan->update([
                    'nama' => $request->nama,
                    'harga_satuan' => $request->harga_satuan,
                    'satuan' => $request->satuan,
                    'deskripsi' => $request->deskripsi,
                ]);
            }else {
                Storage::disk('public')->delete($request->oldImage);
                $foto = $request->file('foto');
                $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('foto_pakan', $foto, $namaFoto);
                $updateFoto['foto'] = $path;
    
                $pakan->update([
                    'nama' => $request->nama,
                    'harga_satuan' => $request->harga_satuan,
                    'satuan' => $request->satuan,
                    'deskripsi' => $request->deskripsi,
                    'foto' => $updateFoto['foto']
                ]);
            }
        } else {
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_pakan', $foto, $namaFoto);
            $updateFoto['foto'] = $path;

            $pakan->update([
                'nama' => $request->nama,
                'harga_satuan' => $request->harga_satuan,
                'satuan' => $request->satuan,
                'deskripsi' => $request->deskripsi,
                'foto' => $updateFoto['foto']
            ]);
        }
        Alert::toast('Data pakan berhasil diubah', 'success');
        return redirect()->route('admin.kelolaPakan.index');
    }

    public function destroy($id) {
        $check = PakanModel::find($id);
        if (!$check) {
            Alert::toast('Data pakan tidak ditemukan', 'error');
            return redirect('/kelolaPakan');
        }
        try{
            $kelolaPakan = PakanModel::find($id);
            if ($kelolaPakan->foto != '') {
                Storage::disk('public')->delete($kelolaPakan->foto);
                PakanModel::destroy($id);
            } else {
                PakanModel::destroy($id);
            }
            Alert::toast('Data pakan berhasil dihapus', 'success');
            return redirect('/kelolaPakan');
        }catch(\Illuminate\Database\QueryException $e){
            Alert::toast('Data pakan gagal dihapus', 'error');
            return redirect('/kelolaPakan');
        }
    }
}
