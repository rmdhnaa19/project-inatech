<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Pengguna',
            'paragraph' => 'Berikut ini merupakan data pengguna yang terinput ke dalam sistem',
            'list' => ['Home', 'Kelola Pengguna']
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
            'list' => ['Home', 'Kelola Pengguna', 'Tambah']
        ];
        $activeMenu = 'kelolaPengguna';
        $role = RoleModel::all();
        return view('kelolaPengguna.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'role' => $role]);
    }
}
