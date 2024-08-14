<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Manajemen User',
            'paragraph' => 'Berikut ini merupakan data user yang terinput ke dalam sistem',
            'list' => ['Home', 'Manajemen User']
        ];
        $activeMenu = 'manajemenUser';
        return view('manajemenUser.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
