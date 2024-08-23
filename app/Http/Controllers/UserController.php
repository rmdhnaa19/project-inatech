<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Pengguna',
            'paragraph' => 'Berikut ini merupakan data pengguna yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pengguna'],
            ]
        ];
        $activeMenu = 'kelolaPengguna';
        $role = RoleModel::all();
        return view('kelolaPengguna.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'role' => $role]);
    }

    public function list(Request $request)
    {
        $users = UserModel::select('id_user', 'nama', 'no_hp', 'posisi', 'id_role')->with('role'); 
        return DataTables::of($users)
        ->make(true);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Pengguna',
            'paragraph' => 'Berikut ini merupakan form tambah data pengguna yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pengguna', 'url' => route('kelolaPengguna.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaPengguna';
        $role = RoleModel::all();
        return view('kelolaPengguna.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'role' => $role]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'username' => 'required|string|min:5|unique:user,username',
            'password' => 'required|string|min:8',
            'id_role' => 'required|integer',
            'nama' => 'required|string|min:5|unique:user,nama',
            'no_hp' => 'required|string|max:12',
            'alamat' => 'required|string',
            'gaji_pokok' => 'required|integer',
            'komisi' => 'nullable|integer',
            'tunjangan' => 'nullable|integer',
            'potongan_gaji' => 'nullable|integer',
            'posisi' => 'required|string',
            'foto' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        dd($request->validate());

        if($request->file('foto')){
            $upFoto['foto'] = $request->file('foto')->store('foto_user');
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
            'foto' => $upFoto['foto'],
        ]);
        // Alert::toast('Data administrasi berhasil ditambahkan', 'success');
        return redirect(route('kelolaPengguna.index'));
    }
}
