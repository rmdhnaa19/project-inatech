<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\TambakModel;
use App\Models\PjTambakModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PjTambakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Penanggung Jawab Tambak',
            'paragraph' => 'Berikut ini merupakan Penanggung Jawab yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('pjtambak.index')],
                ['label' => 'Penanggung Jawab Tambak'],
            ]
        ];
        $activeMenu = 'pjTambak';
        $tambak = TambakModel::all();
        $user = UserModel::all();
        return view('pjtambak.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'tambak' => $tambak, 'user' => $user]);
    }
    
    public function list(Request $request)
    {
        $pjtambaks = PjTambakModel::select('id_user_tambak', 'kd_user_tambak', 'id_user','id_tambak', 'created_at', 'updated_at')->with('tambak'); 
        return DataTables::of($pjtambaks)
        ->make(true);
    }
    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Penanggung Jawab Tambak',
            'paragraph' => 'Berikut ini merupakan form tambah penanggung jawab tambak yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Penanggung Jawab Tambak', 'url' => route('pjtambak.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'pjTambak';
            $tambak = TambakModel::all();
            $user = UserModel::all();
            return view('pjtambak.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'tambak' => $tambak, 'user' => $user]);
    }
    }