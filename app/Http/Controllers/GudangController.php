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
        $activeMenu = 'kelolaPengguna';
        $role = RoleModel::all();
        return view('kelolaPengguna.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'role' => $role]);
    }

    public function store(Request $request)
    {
        // Inisialisasi variabel $upGambar dengan nilai default
        $upGambar = ['foto' => null];
        
        // dd($request->all());
        $request->validate([
            'username' => 'required|string|unique:user,username',
            'password' => 'required|string|min:8',
            'id_role' => 'required|integer',
            'nama' => 'required|string|unique:user,nama',
            'no_hp' => 'required|string|min:11|max:12',
            'alamat' => 'required|string',
            'gaji_pokok' => 'required|integer',
            'komisi' => 'nullable|integer',
            'tunjangan' => 'nullable|integer',
            'potongan_gaji' => 'nullable|integer',
            'posisi' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        // dd($request->validate());

        if($request->file('foto')){
            $upGambar['foto'] = $request->file('foto')->store('foto_user');
        }

        UserModel::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'id_role' => $request->id_role,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'gaji_pokok' => $request->gaji_pokok,
            'komisi' => $request->komisi,
            'tunjangan' => $request->tunjangan,
            'potongan_gaji' => $request->potongan_gaji,
            'posisi' => $request->posisi,
            'foto' => $upGambar['foto'],
        ]);
        // Alert::toast('Data administrasi berhasil ditambahkan', 'success');
        return redirect(route('kelolaPengguna.index'));
    }
}
