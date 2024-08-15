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
            'title' => 'Kelola Pengguna',
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
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi  
                $btn = '<a href="'.url('/kelolaPengguna/' . $user->id_user).'" class="btn btn-info btn-sm" id="btn-detail"><i class="fa-solid fa-circle-info"></i>&nbsp;&nbsp;Detail</a> '; 
                $btn .= '<a href="'.url('/kelolaPengguna/' . $user->id_user . '/edit').'" class="btn btn-warning btn-sm" style="color: white" id="btn-edit"><i class="fa-solid fa-pen-to-square"></i>&nbsp;&nbsp;Edit</a> '; 
                $btn .= '<form class="d-inline-block" id="btn-hapus" method="POST" action="'. url('/kelolaPengguna/'.$user->id_user).'">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');"><i class="fa-solid fa-trash-can"></i>&nbsp;&nbsp;Hapus</button></form>'; 
            return $btn; 
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
        ->make(true);
    }
}
