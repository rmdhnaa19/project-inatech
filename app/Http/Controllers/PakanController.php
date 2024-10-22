<?php

namespace App\Http\Controllers;

use App\Models\PakanModel;
use Illuminate\Http\Request;
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

    // public function show($id)
    // {
    //     $pjGudang = DetailUserModel::with(['gudang', 'user'])->find($id); // Ambil data tambak dengan relasi gudang
    //     if (!$pjGudang) {
    //         return response()->json(['error' => 'Penanggung jawab gudang tidak ditemukan.'], 404);
    //     }

    //     // Render view dengan data tambak
    //     $view = view('admin.kelolaPJGudang.show', compact('pjGudang'))->render();
    //     return response()->json(['html' => $view]);
    // }

    // public function create(){
    //     $breadcrumb = (object) [
    //         'title' => 'Tambah Data Penanggung Jawab Gudang',
    //         'paragraph' => 'Berikut ini merupakan form tambah data penanggung jawab gudang yang terinput ke dalam sistem',
    //         'list' => [
    //             ['label' => 'Home', 'url' => route('dashboard.index')],
    //             ['label' => 'Kelola Pengguna', 'url' => route('admin.kelolaPJGudang.index')],
    //             ['label' => 'Tambah'],
    //         ]
    //     ];
    //     $activeMenu = 'kelolaPJGudang';
    //     $gudang = GudangModel::all();
    //     $user = UserModel::all();
    //     return view('admin.kelolaPJGudang.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'gudang' => $gudang, 'user' => $user]);
    // }

    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $validatedData = $request->validate([
    //         'kd_detail_user' => 'required|string|unique:detail_user,kd_detail_user',
    //         'id_gudang' => 'required|integer',
    //         'id_user' => 'required|integer'
    //     ]);

    //     // Buat user baru
    //     DetailUserModel::create($validatedData);

    //     // Redirect ke halaman kelola pengguna
    //     return redirect()->route('admin.kelolaPJGudang.index')->with('success', 'Data berhasil ditambahkan!');
    // }

    // public function edit(string $id){
    //     $pjGudang = DetailUserModel::find($id);
    //     $gudang = GudangModel::all();
    //     $user = UserModel::all();

    //     $breadcrumb = (object) [
    //         'title' => 'Edit Data Penanggung Jawab Gudang',
    //         'paragraph' => 'Berikut ini merupakan form edit data penanggung jawab gudang yang terinput ke dalam sistem',
    //         'list' => [
    //             ['label' => 'Home', 'url' => route('dashboard.index')],
    //             ['label' => 'Kelola Pengguna', 'url' => route('admin.kelolaPJGudang.index')],
    //             ['label' => 'Edit'],
    //         ]
    //     ];
    //     $activeMenu = 'kelolaPJGudang';

    //     return view('admin.kelolaPJGudang.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'pjGudang' => $pjGudang, 'gudang' => $gudang, 'user' => $user]);
    // }

    // public function update(Request $request, string $id){
    //     $request->validate([
    //         'kd_detail_user' => 'required|string|unique:detail_user,kd_detail_user,'.$id.',id_detail_user',
    //         'id_gudang' => 'required|integer',
    //         'id_user' => 'required|integer',
    //     ]);

    //     $pjGudang = DetailUserModel::find($id);

    //     $pjGudang->update([
    //         'kd_detail_user' => $request->kd_detail_user,
    //         'id_gudang' => $request->id_gudang,
    //         'id_user' => $request->id_user,
    //         ]);

    //     return redirect()->route('admin.kelolaPJGudang.index')->with('success', 'Data Berhasil Diubah!');
    // }

    // public function destroy($id) {
    //     DetailUserModel::destroy($id);
    //     return redirect()->route('admin.kelolaPJGudang.index')->with('success', 'Data Berhasil Dihapus!');
    // }
}
