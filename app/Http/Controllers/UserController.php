<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
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
        return view('admin.kelolaPengguna.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'role' => $role, 'user' => $user]);
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
                ['label' => 'Kelola Pengguna', 'url' => route('admin.kelolaPengguna.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaPengguna';
        $role = RoleModel::all();
        return view('admin.kelolaPengguna.create', [
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
            'no_hp' => 'nullable|string|min:11|max:12',
            'alamat' => 'nullable|string',
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

        Alert::toast('Data pengguna berhasil ditambah', 'success');

        // Redirect ke halaman kelola pengguna
        return redirect()->route('admin.kelolaPengguna.index');
    }

    public function show($id)
    {
        $user = UserModel::with('role')->find($id); // Ambil data tambak dengan relasi gudang
        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaPengguna.show', compact('user'))->render();
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
                ['label' => 'Kelola Pengguna', 'url' => route('admin.kelolaPengguna.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaPengguna';

        return view('admin.kelolaPengguna.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'user' => $user, 'role' => $role]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'username' => 'required|string|unique:user,username,'.$id.',id_user',
            'password' => 'nullable|string|min:8',
            'id_role' => 'required|integer',
            'nama' => 'required|string|unique:user,nama,'.$id.',id_user',
            'no_hp' => 'nullable|string|min:11|max:12',
            'alamat' => 'nullable|string',
            'gaji_pokok' => 'required|integer',
            'komisi' => 'nullable|integer',
            'tunjangan' => 'nullable|integer',
            'potongan_gaji' => 'nullable|integer',
            'posisi' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = UserModel::find($id);

        if ($request->oldImage != '') {
            if ($request->file('foto') == '') {
                $user->update([
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
                    'posisi' => $request->posisi,
                ]);
            }else{
                Storage::disk('public')->delete($request->oldImage);
                $foto = $request->file('foto');
                $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('foto_user', $foto, $namaFoto);
                $updateFoto['foto'] = $path;
                
                $user->update([
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
                    'posisi' => $request->posisi,
                    'foto' => $updateFoto['foto']
                ]);
            }
        } else {
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_user', $foto, $namaFoto);
            $updateFoto['foto'] = $path;
                
            $user->update([
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
                'posisi' => $request->posisi,
                'foto' => $updateFoto['foto']
            ]);
        }
        Alert::toast('Data pengguna berhasil diubah', 'success');
        return redirect()->route('admin.kelolaPengguna.index');
    }

    public function destroy($id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengguna tidak ditemukan.'
            ], 404);
        }
    
        try {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Data pengguna berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data pengguna dikarenakan data masih tersambung ke data lain.'
            ], 500);
        }
    }
}