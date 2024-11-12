<?php

namespace App\Http\Controllers;

use App\Models\DetailPakanModel;
use App\Models\GudangModel;
use App\Models\PakanModel;
use App\Models\TransaksiPakanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
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
        return view('admin.kelolaTransaksiPakan.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'pakanGudang' => $pakanGudang]);
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

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Transaksi Pakan',
            'paragraph' => 'Berikut ini merupakan form tambah data transaksi pakan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaPakan.index')],
                ['label' => 'Kelola Pakan ke Gudang', 'url' => route('admin.kelolaPakanGudang.index')],
                ['label' => 'Kelola Transaksi Pakan', 'url' => route('admin.kelolaTransaksiPakan.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaTransaksiPakan';
        $pakanGudang = DetailPakanModel::with(['pakan', 'gudang'])->get();
        return view('admin.kelolaTransaksiPakan.create', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu, 
            'pakanGudang' => $pakanGudang
        ]);
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kd_transaksi_pakan' => 'required|string|unique:transaksi_pakan,kd_transaksi_pakan',
            'tipe_transaksi' => 'required|string',
            'quantity' => 'required|integer',
            'id_detail_pakan' => 'required|integer'
        ]);

        $id_pakanGudang = $request->id_detail_pakan;
        $qty = $request->quantity;
        $qty_old = DetailPakanModel::find($id_pakanGudang)->stok_pakan;
        $tipe_transaki = $request->tipe_transaksi;

        if ($tipe_transaki == 'Masuk') {
            TransaksiPakanModel::create([
                'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                'tipe_transaksi' => $tipe_transaki,
                'quantity' => $qty,
                'id_detail_pakan' => $id_pakanGudang
            ]);
            DetailPakanModel::find($id_pakanGudang)->update([
                'stok_pakan' => $qty_old + $qty
            ]);
        }elseif ($tipe_transaki == 'Keluar' || $tipe_transaki == 'Kadaluarsa' || $tipe_transaki == 'Rusak') {
            if ($qty_old < $qty) {
                Alert::toast('Data transaksi keluar gagal ditambahkan karena stok kurang', 'error');
                return redirect()->back();
            }else {
                TransaksiPakanModel::create([
                    'kd_transaksi_pakan' => $request->kd_transaksi_pakan,
                    'tipe_transaksi' => $tipe_transaki,
                    'quantity' => $qty,
                    'id_detail_pakan' => $id_pakanGudang
                ]);
                DetailPakanModel::find($id_pakanGudang)->update([
                    'stok_pakan' => $qty_old - $qty
                ]);
            }
        }

        Alert::toast('Data transaksi pakan berhasil ditambah', 'success');

        // Redirect ke halaman kelola pengguna
        return redirect()->route('admin.kelolaTransaksiPakan.index');
    }

    public function show($id)
    {
        $transaksiPakan = TransaksiPakanModel::with('detailPakan')->find($id); // Ambil data tambak dengan relasi gudang
        if (!$transaksiPakan) {
            return response()->json(['error' => 'Transaksi pakan tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaTransaksiPakan.show', compact('transaksiPakan'))->render();
        return response()->json(['html' => $view]);
    }

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
