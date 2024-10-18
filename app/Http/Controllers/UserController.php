<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
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

        // Jika ada file foto, simpan file tersebut dan tambahkan path ke validatedData
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_user', $foto, $namaFoto);
            $validatedData['foto'] = $path;
        }
        
        // Jika komisi, tunjangan, atau potongan gaji kosong, isi dengan nilai 0
        $validatedData['potongan_gaji'] = $request->potongan_gaji ?? 0;
        $validatedData['komisi'] = $request->komisi ?? 0;
        $validatedData['tunjangan'] = $request->tunjangan ?? 0;
        

        // Enkripsi password
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Buat user baru
        UserModel::create($validatedData);

        // Redirect ke halaman kelola pengguna
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
        $role = RoleModel::all();

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

        return view('kelolaPengguna.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'user' => $user, 'role' => $role]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'username' => 'required|string|unique:user,username,'.$id.',id_user',
            'password' => 'nullable|string|min:8',
            'id_role' => 'required|integer',
            'nama' => 'required|string|unique:user,nama,'.$id.',id_user',
            'no_hp' => 'required|string|min:11|max:12',
            'alamat' => 'nullable|string',
            'gaji_pokok' => 'required|integer',
            'komisi' => 'nullable|integer',
            'tunjangan' => 'nullable|integer',
            'potongan_gaji' => 'nullable|integer',
            'posisi' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->file('foto') != '') {
            # code...
        }
        
        $updateData = [
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'id_role' => $request->id_role,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'gaji_pokok' => $request->gaji_pokok,
            'komisi' => $request->komisi ?? 0,
            'tunjangan' => $request->tunjangan ?? 0,
            'potongan_gaji' => $request->potongan_gaji ?? 0,
            'posisi' => $request->posisi
        ];
        
        if ($request->filled('foto')) {
            Storage::delete($request->oldImage);
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_user', $foto, $namaFoto);
            $updateData['foto'] = $path;
        }

        UserModel::find($id)->update($updateData);
        
        return redirect()->route('kelolaPengguna.index');
    }

    public function destroy($id) {
        $user = UserModel::findOrFail($id);
        Storage::delete($user->foto);
        UserModel::destroy($id);
        return redirect()->route('kelolaPengguna.index');
    }
}