<?php

namespace App\Http\Controllers;

use App\Models\DetailPakanModel;
use App\Models\GudangModel;
use App\Models\PakanModel;
use App\Models\TransaksiPakanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransaksiPakanController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Transaksi Pakan',
            'paragraph' => 'Berikut ini merupakan data transaksi pakan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaPakan.index')],
                ['label' => 'Kelola Pakan ke Gudang', 'url' => route('admin.kelolaPakanGudang.index')],
                ['label' => 'Kelola Transaksi Pakan'],
            ]
        ];
        $activeMenu = 'kelolaTransaksiPakan';
        $pakanGudang = DetailPakanModel::all();
        $transaksiPakan =  TransaksiPakanModel::all();
        $gudang = GudangModel::all();
        $pakan = PakanModel::all();
        return view('admin.kelolaTransaksiPakan.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'pakanGudang' => $pakanGudang, 'transaksiPakan' => $transaksiPakan, 'gudang' => $gudang, 'pakan' => $pakan]);
    }

    public function list(Request $request)
    {
        $transaksiPakans = TransaksiPakanModel::with(['detailPakan.gudang', 'detailPakan.pakan'])
            ->select('id_transaksi_pakan', 'kd_transaksi_pakan', 'tipe_transaksi', 'quantity', 'id_detail_pakan');

        return DataTables::of($transaksiPakans)
            ->addColumn('pakan_gudang', function ($transaksi) {
                return $transaksi->detailPakan->pakan->nama . ' - ' . $transaksi->detailPakan->gudang->nama;
            })
            ->make(true);
    }

    // public function create(){
    //     $breadcrumb = (object) [
    //         'title' => 'Tambah Data Pengguna',
    //         'paragraph' => 'Berikut ini merupakan form tambah data pengguna yang terinput ke dalam sistem',
    //         'list' => [
    //             ['label' => 'Home', 'url' => route('dashboard.index')],
    //             ['label' => 'Kelola Pengguna', 'url' => route('admin.kelolaPengguna.index')],
    //             ['label' => 'Tambah'],
    //         ]
    //     ];
    //     $activeMenu = 'kelolaPengguna';
    //     $role = RoleModel::all();
    //     return view('admin.kelolaPengguna.create', [
    //         'breadcrumb' => $breadcrumb, 
    //         'activeMenu' => $activeMenu, 
    //         'role' => $role
    //     ]);
    // }
    
    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $validatedData = $request->validate([
    //         'username' => 'required|string|unique:user,username',
    //         'password' => 'required|string|min:8',
    //         'id_role' => 'required|integer',
    //         'nama' => 'required|string|unique:user,nama',
    //         'no_hp' => 'nullable|string|min:11|max:12',
    //         'alamat' => 'nullable|string',
    //         'gaji_pokok' => 'required|integer',
    //         'komisi' => 'nullable|integer',
    //         'tunjangan' => 'nullable|integer',
    //         'potongan_gaji' => 'nullable|integer',
    //         'posisi' => 'required|string',
    //         'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     // Jika ada file foto, simpan file tersebut dan tambahkan path ke validatedData
    //     if ($request->hasFile('foto')) {
    //         $foto = $request->file('foto');
    //         $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
    //         $path = Storage::disk('public')->putFileAs('foto_user', $foto, $namaFoto);
    //         $validatedData['foto'] = $path;
    //     }
        
    //     // Jika komisi, tunjangan, atau potongan gaji kosong, isi dengan nilai 0
    //     $validatedData['potongan_gaji'] = $request->potongan_gaji ?? 0;
    //     $validatedData['komisi'] = $request->komisi ?? 0;
    //     $validatedData['tunjangan'] = $request->tunjangan ?? 0;
        

    //     // Enkripsi password
    //     $validatedData['password'] = bcrypt($validatedData['password']);

    //     // Buat user baru
    //     UserModel::create($validatedData);

    //     Alert::toast('Data pengguna berhasil ditambah', 'success');

    //     // Redirect ke halaman kelola pengguna
    //     return redirect()->route('admin.kelolaPengguna.index');
    // }

    // public function show($id)
    // {
    //     $user = UserModel::with('role')->find($id); // Ambil data tambak dengan relasi gudang
    //     if (!$user) {
    //         return response()->json(['error' => 'User tidak ditemukan.'], 404);
    //     }

    //     // Render view dengan data tambak
    //     $view = view('admin.kelolaPengguna.show', compact('user'))->render();
    //     return response()->json(['html' => $view]);
    // }

    // public function edit(string $id){
    //     $user = UserModel::find($id);
    //     $role = RoleModel::all();

    //     $breadcrumb = (object) [
    //         'title' => 'Edit Data Pengguna',
    //         'paragraph' => 'Berikut ini merupakan form edit data pengguna yang terinput ke dalam sistem',
    //         'list' => [
    //             ['label' => 'Home', 'url' => route('dashboard.index')],
    //             ['label' => 'Kelola Pengguna', 'url' => route('admin.kelolaPengguna.index')],
    //             ['label' => 'Edit'],
    //         ]
    //     ];
    //     $activeMenu = 'kelolaPengguna';

    //     return view('admin.kelolaPengguna.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'user' => $user, 'role' => $role]);
    // }

    // public function update(Request $request, string $id){
    //     $request->validate([
    //         'username' => 'required|string|unique:user,username,'.$id.',id_user',
    //         'password' => 'nullable|string|min:8',
    //         'id_role' => 'required|integer',
    //         'nama' => 'required|string|unique:user,nama,'.$id.',id_user',
    //         'no_hp' => 'nullable|string|min:11|max:12',
    //         'alamat' => 'nullable|string',
    //         'gaji_pokok' => 'required|integer',
    //         'komisi' => 'nullable|integer',
    //         'tunjangan' => 'nullable|integer',
    //         'potongan_gaji' => 'nullable|integer',
    //         'posisi' => 'required|string',
    //         'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);

    //     $user = UserModel::find($id);

    //     if ($request->oldImage != '') {
    //         if ($request->file('foto') == '') {
    //             $user->update([
    //                 'username' => $request->username,
    //                 'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
    //                 'id_role' => $request->id_role,
    //                 'nama' => $request->nama,
    //                 'no_hp' => $request->no_hp,
    //                 'alamat' => $request->alamat,
    //                 'gaji_pokok' => $request->gaji_pokok,
    //                 'komisi' => $request->komisi ?? 0,
    //                 'tunjangan' => $request->tunjangan ?? 0,
    //                 'potongan_gaji' => $request->potongan_gaji ?? 0,
    //                 'posisi' => $request->posisi,
    //             ]);
    //         }else{
    //             Storage::disk('public')->delete($request->oldImage);
    //             $foto = $request->file('foto');
    //             $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
    //             $path = Storage::disk('public')->putFileAs('foto_user', $foto, $namaFoto);
    //             $updateFoto['foto'] = $path;
                
    //             $user->update([
    //                 'username' => $request->username,
    //                 'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
    //                 'id_role' => $request->id_role,
    //                 'nama' => $request->nama,
    //                 'no_hp' => $request->no_hp,
    //                 'alamat' => $request->alamat,
    //                 'gaji_pokok' => $request->gaji_pokok,
    //                 'komisi' => $request->komisi ?? 0,
    //                 'tunjangan' => $request->tunjangan ?? 0,
    //                 'potongan_gaji' => $request->potongan_gaji ?? 0,
    //                 'posisi' => $request->posisi,
    //                 'foto' => $updateFoto['foto']
    //             ]);
    //         }
    //     } else {
    //         $foto = $request->file('foto');
    //         $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
    //         $path = Storage::disk('public')->putFileAs('foto_user', $foto, $namaFoto);
    //         $updateFoto['foto'] = $path;
                
    //         $user->update([
    //             'username' => $request->username,
    //             'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
    //             'id_role' => $request->id_role,
    //             'nama' => $request->nama,
    //             'no_hp' => $request->no_hp,
    //             'alamat' => $request->alamat,
    //             'gaji_pokok' => $request->gaji_pokok,
    //             'komisi' => $request->komisi ?? 0,
    //             'tunjangan' => $request->tunjangan ?? 0,
    //             'potongan_gaji' => $request->potongan_gaji ?? 0,
    //             'posisi' => $request->posisi,
    //             'foto' => $updateFoto['foto']
    //         ]);
    //     }
    //     Alert::toast('Data pengguna berhasil diubah', 'success');
    //     return redirect()->route('admin.kelolaPengguna.index');
    // }

    // public function destroy($id) {
    //     $check = UserModel::find($id);
    //     if (!$check) {
    //         Alert::toast('Data pengguna tidak ditemukan', 'error');
    //         return redirect('/kelolaPengguna');
    //     }
    //     try{
    //         $kelolaPengguna = UserModel::find($id);
    //         if ($kelolaPengguna->foto != '') {
    //             Storage::disk('public')->delete($kelolaPengguna->foto);
    //             UserModel::destroy($id);
    //         } else {
    //             UserModel::destroy($id);
    //         }
    //         Alert::toast('Data pengguna berhasil dihapus', 'success');
    //         return redirect('/kelolaPengguna');
    //     }catch(\Illuminate\Database\QueryException $e){
    //         Alert::toast('Data pengguna gagal dihapus', 'error');
    //         return redirect('/kelolaPengguna');
    //     }
    // }
}
