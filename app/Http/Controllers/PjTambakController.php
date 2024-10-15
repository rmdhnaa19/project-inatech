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
                ['label' => 'Home', 'url' => route('pjTambak.index')],
                ['label' => 'Penanggung Jawab Tambak'],
            ]
        ];
        $activeMenu = 'pjTambak';
        $tambak = TambakModel::all();
        $user = UserModel::all();
        return view('pjTambak.index', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu, 
            'tambak' => $tambak, 
            'user' => $user
        ]);
    }
    
    public function list(Request $request)
    {
        $pjtambaks = PjTambakModel::with('user', 'tambak')
            ->select('id_user_tambak', 'kd_user_tambak', 'id_user', 'id_tambak', 'created_at', 'updated_at');

        return DataTables::of($pjtambaks)
            ->addColumn('user_nama', function ($pjtambak) {
                return $pjtambak->user->nama; // Mengakses nama user dari relasi
            })
            ->addColumn('tambak_nama', function ($pjtambak) {
                return $pjtambak->tambak->nama_tambak; // Mengakses nama tambak dari relasi
            })
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Penanggung Jawab Tambak',
            'paragraph' => 'Berikut ini merupakan form tambah penanggung jawab tambak yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Penanggung Jawab Tambak', 'url' => route('pjTambak.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'pjTambak';
        $tambak = TambakModel::all();
        $user = UserModel::all();
        
        return view('pjTambak.create', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu, 
            'tambak' => $tambak, 
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([            
            'kd_user_tambak' => 'required|string|unique:pj_tambak,kd_user_tambak',
            'id_user' => 'required|integer',
            'id_tambak' => 'required|integer',
        ]);

        // Simpan data ke database
        PjTambakModel::create($validatedData);

        return redirect()->route('pjTambak.index')->with('success', 'Data user tambak berhasil ditambahkan');
    }

    public function show($id)
    {
        $pjtambak = PjTambakModel::with('user', 'tambak')->find($id); 
        if (!$pjtambak) {
            return response()->json(['error' => 'Pj Tambak tidak ditemukan.'], 404);
        }
        
        $view = view('pjtambak.show', compact('pjtambak'))->render();
        return response()->json(['html' => $view]);
    }

    public function edit($id)
    {
        $pjtambak = PjTambakModel::find($id);
        $user = UserModel::all();
        $tambak = TambakModel::all();
        
        if (!$pjtambak) {
            return redirect()->route('pjTambak.index')->with('error', 'Pj Tambak tidak ditemukan');
        }
        
        $breadcrumb = (object) [
            'title' => 'Edit Data Pj Tambak',
            'paragraph' => 'Berikut ini merupakan form edit data penanggung jawab tambak yang ada di dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pj Tambak', 'url' => route('pjTambak.index')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'manajemenpjTambak';

        return view('pjTambak.edit', compact('pjtambak', 'tambak', 'user', 'breadcrumb', 'activeMenu'));
    }

    public function update(Request $request, $id)
    {
        $pjtambak = PjTambakModel::find($id);

        if (!$pjtambak) {
            return redirect()->route('pjTambak.index')->with('error', 'Pj Tambak tidak ditemukan');
        }

        // Validasi input
        $validatedData = $request->validate([
            'kd_user_tambak' => 'required|string|unique:pj_tambak,kd_user_tambak,' . $id . ',id_user_tambak',
            'id_user' => 'required|integer',
            'id_tambak' => 'required|integer',
        ]);

        // Update data tambak
        $pjtambak->update($validatedData);

        return redirect()->route('pjTambak.index')->with('success', 'Data pj tambak berhasil diubah');
    }
}