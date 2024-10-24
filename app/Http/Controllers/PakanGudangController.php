<?php

namespace App\Http\Controllers;

use App\Models\DetailPakanModel;
use App\Models\GudangModel;
use App\Models\PakanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PakanGudangController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Pakan ke Gudang',
            'paragraph' => 'Berikut ini merupakan data pakan ke gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'kelola Pakan', 'url' => route('admin.kelolaPakan.index')],
                ['label' => 'Kelola Pakan ke Gudang'],
            ]
        ];
        $activeMenu = 'kelolaPakanGudang';
        $pakanGudang = DetailPakanModel::all();
        $gudang = GudangModel::all();
        $pakan = PakanModel::all();
        return view('admin.kelolaPakanGudang.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'pakanGudang' => $pakanGudang, 'pakan' => $pakan, 'gudang' => $gudang]);
    }

    public function list(Request $request)
    {
        $pakanGudangs = DetailPakanModel::select('id_detail_pakan', 'kd_detail_pakan', 'id_pakan', 'id_gudang', 'stok_pakan')->with(['pakan', 'gudang']); 
        if ($request->id_pakan) {
            $pakanGudangs->where('id_pakan', $request->id_pakan);
        }
        return DataTables::of($pakanGudangs)
        ->make(true);
    }

    public function show($id)
    {
        $pakanGudang = DetailPakanModel::find($id); // Ambil data tambak dengan relasi gudang
        if (!$pakanGudang) {
            return response()->json(['error' => 'Data pakan ke gudang tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaPakanGudang.show', compact('pakanGudang'))->render();
        return response()->json(['html' => $view]);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Pakan ke Gudang',
            'paragraph' => 'Berikut ini merupakan form tambah data pakan ke gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaPakan.index')],
                ['label' => 'kelola Pakan', 'url' => route('admin.kelolaPakanGudang.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaPakanGudang';
        $gudang = GudangModel::all();
        $pakan = PakanModel::all();
        return view('admin.kelolaPakanGudang.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'gudang' => $gudang, 'pakan' => $pakan]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kd_detail_pakan' => 'required|string|unique:detail_pakan,kd_detail_pakan',
            'id_pakan' => 'required|integer',
            'id_gudang' => 'required|integer',
        ]);

        $validatedData['stok_pakan'] = 0;

        // Buat user baru
        DetailPakanModel::create($validatedData);

        // Redirect ke halaman kelola pengguna
        return redirect()->route('admin.kelolaPakanGudang.index')->with('success', 'Data berhasil ditambahkan!');
    }

    // public function edit(string $id){
    //     $pakan = PakanModel::find($id);

    //     $breadcrumb = (object) [
    //         'title' => 'Edit Data Pakan',
    //         'paragraph' => 'Berikut ini merupakan form edit data pakan yang terinput ke dalam sistem',
    //         'list' => [
    //             ['label' => 'Home', 'url' => route('dashboard.index')],
    //             ['label' => 'Kelola Pengguna', 'url' => route('admin.kelolaPakan.index')],
    //             ['label' => 'Edit'],
    //         ]
    //     ];
    //     $activeMenu = 'kelolaPakan';

    //     return view('admin.kelolaPakan.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'pakan' => $pakan]);
    // }

    // public function update(Request $request, string $id){
    //     $request->validate([
    //         'nama' => 'required|string|unique:pakan,nama,'.$id.',id_pakan',
    //         'harga_satuan' => 'required|integer',
    //         'satuan' => 'required|string|max:50',
    //         'deskripsi' => 'required|string',
    //         'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048'
    //     ]);

    //     $pakan = PakanModel::find($id);

    //     if ($request->file('foto') == '') {
    //         $pakan->update([
    //             'nama' => $request->nama,
    //             'harga_satuan' => $request->harga_satuan,
    //             'satuan' => $request->satuan,
    //             'deskripsi' => $request->deskripsi,
    //         ]);
    //     }else {
    //         Storage::disk('public')->delete($request->oldImage);
    //         $foto = $request->file('foto');
    //         $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
    //         $path = Storage::disk('public')->putFileAs('foto_pakan', $foto, $namaFoto);
    //         $updateFoto['foto'] = $path;

    //         $pakan->update([
    //             'nama' => $request->nama,
    //             'harga_satuan' => $request->harga_satuan,
    //             'satuan' => $request->satuan,
    //             'deskripsi' => $request->deskripsi,
    //             'foto' => $updateFoto['foto']
    //         ]);
    //     }
    //     return redirect()->route('admin.kelolaPakan.index')->with('success', 'Data Berhasil Diubah!');
    // }

    // public function destroy($id) {
    //     PakanModel::destroy($id);
    //     return redirect()->route('admin.kelolaPakan.index')->with('success', 'Data Berhasil Dihapus!');
    // }
}
