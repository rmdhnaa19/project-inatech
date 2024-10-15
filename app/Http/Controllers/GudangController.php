<?php

namespace App\Http\Controllers;

use App\Models\GudangModel;
use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
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
        return view('kelolaGudang.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu]);
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
                ['label' => 'Kelola Gudang', 'url' => route('kelolaGudang.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaGudang';
        return view('kelolaGudang.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|unique:gudang,nama',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'luas' => 'required|numeric',
            'alamat' => 'required|string',
            'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('foto_gudang', 'public'); // Simpan ke storage
            $validatedData['gambar'] = $path; // Tambahkan path foto ke validated data
        }
        GudangModel::create($validatedData);
        // Alert::toast('Data administrasi berhasil ditambahkan', 'success');
        return redirect()->route('kelolaGudang.index');
    }

    public function show($id)
    {
        $gudang = GudangModel::find($id); // Ambil data tambak dengan relasi gudang
        if (!$gudang) {
            return response()->json(['error' => 'Gudang tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('kelolaGudang.show', compact('gudang'))->render();
        return response()->json(['html' => $view]);
    }
}
