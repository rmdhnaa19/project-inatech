<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $user =  UserModel::all();
        return view('kelolaPengguna.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'role' => $role, 'user' => $user]);
    }

    public function list(Request $request)
    {
        $users = UserModel::select('id_user', 'nama', 'no_hp', 'posisi', 'id_role')->with('role'); 
        if ($request->id_role) {
            $users->where('id_role', $request->id_role);
        }
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
        return view('kelolaPengguna.create', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu, 
            'role' => $role
        ]);
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
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

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_user', 'public');
            $validatedData['foto'] = $path; // Tambahkan path foto ke validated data
        }

        if ($request->komisi == null) {
            $validatedData['komisi'] = 0;
        }

        if ($request->tunjangan == null) {
            $validatedData['tunjangan'] = 0;
        }

        if ($request->potongan_gaji == null) {
            $validatedData['potongan_gaji'] = 0;
        }


        $validatedData['password'] = bcrypt($validatedData['password']);
        UserModel::create($validatedData);
        // Alert::toast('Data administrasi berhasil ditambahkan', 'success');
        return redirect()->route('kelolaPengguna.index');
    }

    public function show($id)
    {
        $user = UserModel::with('role')->find($id); // Ambil data tambak dengan relasi gudang
        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('kelolaPengguna.show', compact('user'))->render();
        return response()->json(['html' => $view]);
    }

    public function edit(string $id){
        $user = UserModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Pengguna',
            'paragraph' => 'Berikut ini merupakan form edit data pengguna yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pengguna', 'url' => route('kelolaPengguna.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaPengguna';

        return view('kelolaPengguna.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'user' => $user]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'username' => 'required|string|unique:user,username,'.$id.',id_user',
            'password' => 'required|string|min:8',
            'id_role' => 'required|integer',
            'nama' => 'required|string|unique:user,nama,'.$id.',id_user',
            'no_hp' => 'required|string|min:11|max:12',
            'alamat' => 'required|string',
            'gaji_pokok' => 'required|integer',
            'komisi' => 'nullable|integer',
            'tunjangan' => 'nullable|integer',
            'potongan_gaji' => 'nullable|integer',
            'posisi' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if ($request->file('foto') != "") {
            Storage::delete($request->oldImage);

            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('foto_user', 'public');
            }

            if ($request->komisi == "") {
                UserModel::find($id)->update([
                    'komisi' => 0
                ]);
            }else{
                UserModel::find($id)->update([
                    'komisi' => $request->komisi
                ]);
            }
    
            if ($request->tunjangan == "") {
                UserModel::find($id)->update([
                    'tunjangan' => 0
                ]);
            }else{
                UserModel::find($id)->update([
                    'tunjangan' => $request->tunjangan
                ]);
            }
    
            if ($request->potongan_gaji == "") {
                UserModel::find($id)->update([
                    'potongan_gaji' => 0
                ]);
            }else{
                UserModel::find($id)->update([
                    'potongan_gaji' => $request->potongan_gaji
                ]);
            }
            
            UserModel::find($id)->update([
                'username' => $request->username,
                'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                'id_role' => $request->id_role,
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'gaji_pokok' => $request->gaji_pokok,
                'posisi' => $request->posisi,
                'foto' => $path['foto'],
            ]);

        }else{
            if ($request->komisi == "") {
                UserModel::find($id)->update([
                    'komisi' => 0
                ]);
            }else{
                UserModel::find($id)->update([
                    'komisi' => $request->komisi
                ]);
            }
    
            if ($request->tunjangan == "") {
                UserModel::find($id)->update([
                    'tunjangan' => 0
                ]);
            }else{
                UserModel::find($id)->update([
                    'tunjangan' => $request->tunjangan
                ]);
            }
    
            if ($request->potongan_gaji == "") {
                UserModel::find($id)->update([
                    'potongan_gaji' => 0
                ]);
            }else{
                UserModel::find($id)->update([
                    'potongan_gaji' => $request->potongan_gaji
                ]);
            }

            UserModel::find($id)->update([
                'username' => $request->username,
                'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                'id_role' => $request->id_role,
                'nama' => $request->nama,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'gaji_pokok' => $request->gaji_pokok,
                'posisi' => $request->posisi,
            ]);
        }
        return redirect()->route('kelolaPengguna.index');
    }

    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if(!$check){
            // Alert::toast('Data administrasi tidak ditemukan', 'error');
            return redirect()->route('kelolaPengguna.index');
        }
        try{
            UserModel::destroy($id);
            // Alert::toast('Data administrasi berhasil dihapus', 'success');
            return redirect()->route('kelolaPengguna.index');
        }catch(\Illuminate\Database\QueryException $e){
            // Alert::toast('Data administrasi gagal dihapus', 'error');
            return redirect()->route('kelolaPengguna.index');
        }
    }
}