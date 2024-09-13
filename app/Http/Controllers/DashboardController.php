<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'paragraph' => 'Berikut ini merupakan visualisasi data yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home'],
            ]
        ];
        $activeMenu = 'dashboard';
        return view('dashboard.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
