<?php

namespace App\Http\Controllers;
use App\Models\KolamModel;
use App\Models\TambakModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class KolamController extends Controller
{
    
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Kolam',
            'paragraph' => 'Berikut ini merupakan data kolam yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.kolam.index')],
                ['label' => 'Manajemen Kolam'],
            ]
        ];
        $activeMenu = 'manajemenKolam';
        $tambak = TambakModel::all();
        return view('admin.kolam.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'tambak' => $tambak]);
    }


    public function list(Request $request)
    {
        $kolams = KolamModel::select('id_kolam', 'kd_kolam', 'tipe_kolam', 'panjang_kolam', 'lebar_kolam', 'luas_kolam', 'kedalaman', 'id_tambak', 'created_at', 'updated_at')->with('tambak'); 
        if ($request->id_tambak) {
            $kolams->where('id_tambak', $request->id_tambak);
        }
        return DataTables::of($kolams)->make(true);
    }


    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Data Kolam',
            'paragraph' => 'Berikut ini merupakan form tambah data kolam yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Manajemen Kolam', 'url' => route('admin.kolam.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'manajemenTambak';
        $tambak = TambakModel::all();
        Alert::toast('Data Kolam berhasil ditambahkan', 'success');
        return view('admin.kolam.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'tambak' => $tambak]);
    }


    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'tipe_kolam' => 'required|in:kotak,bundar',
            'kd_kolam' => 'required|string|unique:kolam,kd_kolam',
            'panjang_kolam' => 'required|integer',
            'lebar_kolam' => 'nullable|integer',
            'luas_kolam' => 'required|integer',
            'kedalaman' => 'required|integer',
            'id_tambak' => 'required|integer',
        ]);

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('foto_kolam', 'public'); // Menyimpan ke storage
            $validatedData['foto'] = $path; // Menambahkan path foto ke validated data
        }

        // Menyimpan data ke database
        KolamModel::create($validatedData);
        return redirect()->route('admin.kolam.index')->with('success', 'Data kolam berhasil ditambahkan');
    }

    public function show($id)
    {
        $kolam = KolamModel::with('tambak')->find($id);
        if (!$kolam) {
            return response()->json(['error' => 'Kolam tidak ditemukan.'], 404);
        }
        $view = view('admin.kolam.show', compact('kolam'))->render();
        return response()->json(['html' => $view]);
    }


    public function edit($id)
    {
        $kolam = KolamModel::find($id);
        $tambak = TambakModel::all();

        if (!$kolam) {
            return redirect()->route('admin.kolam.index')->with('error', 'Kolam tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Data Kolam',
            'paragraph' => 'Berikut ini merupakan form edit data kolam yang ada di dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Kolam', 'url' => route('admin.kolam.index')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'manajemenKolam';

        return view('admin.kolam.edit', compact('kolam', 'tambak', 'breadcrumb', 'activeMenu'));
    }


    public function update(Request $request, string $id) {
    
        $request->validate([
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'tipe_kolam' => 'required|in:kotak,bundar',
            'kd_kolam' => 'required|string|unique:kolam,kd_kolam,' . $id . ',id_kolam',
            'panjang_kolam' => 'required|integer',
            'lebar_kolam' => 'nullable|integer',
            'luas_kolam' => 'required|integer',
            'kedalaman' => 'required|integer',
            'id_tambak' => 'required|integer',
    ]);

    $kolam = KolamModel::find($id);
    
    if ($request->file('foto') == '') {
        $kolam->update([
            'tipe_kolam' => $request->tipe_kolam,
            'kd_kolam' => $request->kd_kolam,
            'panjang_kolam' => $request->panjang_kolam,
            'lebar_kolam' => $request->lebar_kolam,
            'luas_kolam' => $request->luas_kolam,
            'kedalaman' => $request->kedalaman,
            'id_tambak' => $request->id_tambak,
    ]);
    }else{
        Storage::disk('public')->delete($request->oldImage);
        $foto = $request->file('foto');
        $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('foto_kolam', $foto, $namaFoto);
        $updateFoto['foto'] = $path;

    $kolam->update([
            'tipe_kolam' => $request->tipe_kolam,
            'kd_kolam' => $request->kd_kolam,
            'panjang_kolam' => $request->panjang_kolam,
            'lebar_kolam' => $request->lebar_kolam,
            'luas_kolam' => $request->luas_kolam,
            'kedalaman' => $request->kedalaman,
            'id_tambak' => $request->id_tambak,
            'foto' => $updateFoto['foto']
            ]);
        }
            Alert::toast('Data Kolam berhasil diubah', 'success');   
            return redirect()->route('admin.tambak.index');
        }
    } 