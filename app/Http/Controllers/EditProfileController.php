<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('profile.edit', compact('breadcrumb', 'user', 'activeMenu'));
    }

    public function update(){
        
    }
}
