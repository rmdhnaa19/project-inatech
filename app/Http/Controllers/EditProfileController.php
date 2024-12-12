<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class EditProfileController extends Controller
{
    public function edit(string $id) {
        $breadcrumb = (object) [
            'title' => 'Edit Profil Pengguna',
            'paragraph' => 'Berikut ini merupakan edit profil pengguna',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Edit Profil Pengguna'],
            ]
        ];
        if (Auth::id() != $id) {
            abort(403, 'Unauthorized action.');
        }
        $activeMenu = '';

        $user = Auth::user();
        $role = RoleModel::all();
        return view('profile.edit', compact('breadcrumb', 'user', 'activeMenu', 'role'));
    }

    public function update(Request $request, string $id){
        $request->validate([
            'username' => 'required|string|unique:user,username,'.$id.',id_user',
            'password' => 'nullable|string|min:8',
            'id_role' => 'required|integer',
            'nama' => 'required|string|unique:user,nama,'.$id.',id_user',
            'no_hp' => 'nullable|string|min:11|max:12',
            'gaji_pokok' => 'required|integer',
            'komisi' => 'nullable|integer',
            'tunjanSgan' => 'nullable|integer',
            'potongan_gaji' => 'nullable|integer',
            'posisi' => 'required|string'
        ]);
        $user = Auth::user();
        $user->update([
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'id_role' => $request->id_role,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'gaji_pokok' => $request->gaji_pokok,
            'komisi' => $request->komisi ?? 0,
            'tunjangan' => $request->tunjangan ?? 0,
            'potongan_gaji' => $request->potongan_gaji ?? 0,
            'posisi' => $request->posisi
        ]);
        Alert::toast('Berhasil mengubah profil pengguna', 'success');
        return redirect()->route('profile.logout-notice');
    }

    public function logoutNotice(){
        return view('profile.logout-notice');
    }
}
