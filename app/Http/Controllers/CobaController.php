<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CobaController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Wisang ASU',
            'paragraph' => 'ini paragraf',
            'list' => ['Home', 'Welcome']
        ];
        $activeMenu = 'coba';
        return view('welcome',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu]);
    }
    
}
