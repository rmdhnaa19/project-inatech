<?php

namespace App\Http\Controllers;

use App\Models\KematianUdangModel;
use App\Models\FaseKolamModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class KematianUdangController extends Controller
{
    public function index()
    {
        if(auth()->user()->id_role == 1){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Kematian Udang',
            'paragraph' => 'Berikut ini merupakan data kematian udang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'kematianUdang', 'url' => route('admin.kematianudang.index')],
                ['label' => 'kematianUdang'],
            ]
        ];
        $activeMenu = 'kematianudang';
        $fase_kolam = FaseKolamModel::all();
        return view('admin.kematianudang.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
    } elseif(auth()->user()->id_role == 3){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Kematian Udang',
            'paragraph' => 'Berikut ini merupakan data kematian udang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'kematianUdang'],
            ]
        ];
        $activeMenu = 'kematianudang';
        $kematianudangs = KematianUdangModel::all();
        $fase_kolam = FaseKolamModel::all();
        return view('adminTambak.kematianudang.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'kematianudangs' => $kematianudangs]);
    }
}

    // menampilkan data table    
    public function list(Request $request)
    {
        $kematianudangs = KematianUdangModel::select('id_kematian_udang', 'kd_kematian_udang', 'size_udang', 'berat_udang', 'catatan','gambar', 'id_fase_tambak', 'created_at', 'updated_at')->with('faseKolam'); 
        return DataTables::of($kematianudangs)
        ->make(true);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Kematian Udang',
            'paragraph' => 'Berikut ini merupakan form tambah data kematian udang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'kematianUdang', 'url' => route('admin.kematianudang.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'kematianUdang';
    $fase_kolam = FaseKolamModel::all();
    return view('admin.kematianudang.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
}

public function store(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'kd_kematian_udang' => 'required|string|max:255|unique:kematian_udang,kd_kematian_udang',
        'size_udang' => 'required|integer',
        'berat_udang' => 'required|integer',
        'catatan' => 'required|string',
        'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        'id_fase_tambak' => 'required',
    ]);

     // Simpan file image jika ada
    // if ($request->hasFile('gambar')) {
    //     $path = $request->file('gambar')->store('foto_kematianudang', 'public');
    //     $validatedData['gambar'] = $path;// Tambahkan path foto ke validated data
    // } 
    
    if ($request->hasFile('gambar')) {
        $gambar = $request->file('gambar');
        $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('gambar_kematianudang', $gambar, $namaGambar);
        $validatedData['Gambar'] = $path; // Tambahkan path foto ke validated data
    }

    KematianUdangModel::create($validatedData);
    Alert::toast('Data kematian udang berhasil ditambahkan', 'success');
    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('admin.kematianudang.index')->with('success', 'Data kematian udang berhasil ditambahkan');
}


public function show($id)
{
    $kematianudangs = KematianUdangModel::with('faseKolam')->find($id); // Ambil data tambak dengan relasi fase
    if (!$kematianudangs) {
        return response()->json(['error' => 'Kematian udang tidak ditemukan.'], 404);
    }

    // Render view dengan data tambak
    $view = view('admin.kematianudang.show', compact('kematianudangs'))->render();
    return response()->json(['html' => $view]);
}

public function edit(string $id){
    $kematianudangs = KematianUdangModel::find($id);
    $faseKolam = FaseKolamModel::all();
 
    $breadcrumb = (object) [
        'title' => 'Edit Data Kematian Udang',
        'paragraph' => 'Berikut ini merupakan form edit data Kematian Udang yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'kematianUdang', 'url' => route('admin.kematianudang.index')],
            ['label' => 'Edit'],
        ]
    ];
    $activeMenu = 'kematianUdang';

    return view('admin.kematianudang.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'kematianudangs' => $kematianudangs, 'faseKolam' => $faseKolam]);
}

public function update(Request $request, string $id){
    $request->validate([
        'kd_kematian_udang' => 'required|string|max:255|unique:kematian_udang,kd_kematian_udang',
        'size_udang' => 'required|integer',
        'berat_udang' => 'required|integer',
        'catatan' => 'required|string',
        'gambar' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        'id_fase_tambak' => 'required',
    ]);

    $kematianudangs = KematianUdangModel::findOrFail($id);
    
    if ($request->oldImage != '') {
        if ($request->file('gambar') == '') {
            $kematianudangs->update([
                'kd_kematian_udang' => $request->kd_kematian_udang,
                'size_udang' => $request->size_udang,
                'berat_udang' => $request->berat_udang,
                'catatan' => $request->catatan,
                'gambar' => $request->gambar,
                'id_fase_tambak' => $request->id_fase_tambak,
            ]);
        }else{
            Storage::disk('public')->delete($request->oldImage);
            $gambar = $request->file('gambar');
            $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('gambar_kematianudang', $gambar, $namaGambar);
            $updateGambar['gambar'] = $path;
            
            $kematianudangs->update([
                'kd_kematian_udang' => $request->kd_kematian_udang,
                'size_udang' => $request->size_udang,
                'berat_udang' => $request->berat_udang,
                'catatan' => $request->catatan,
                'gambar' => $updateGambar['gambar'],
                'id_fase_tambak' => $request->id_fase_tambak,
            ]);
        }
    } else {
        $gambar = $request->file('gambar');
        $namaGambar = time() . '.' . $gambar->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('gambar_kematianudang', $gambar, $namaGambar);
        $updateGambar['gambar'] = $path;
        
        $kematianudangs->update([
            'kd_kematian_udang' => $request->kd_kematian_udang,
            'size_udang' => $request->size_udang,
            'berat_udang' => $request->berat_udang,
            'catatan' => $request->catatan,
            'gambar' => $updateGambar['gambar'],
            'id_fase_tambak' => $request->id_fase_tambak,
        ]);
    }
    Alert::toast('Data kematian udang berhasil diubah', 'success');
    return redirect()->route('admin.kematianudang.index');
}



public function destroy($id) {
    $kematianudangs = KematianUdangModel::find($id);
        if (!$kematianudangs) {
            return response()->json([
                'success' => false,
                'message' => 'Data kematian udang tidak ditemukan.'
            ], 404);
        }
    
        try {
            if ($kematianudangs->gambar) {
                Storage::disk('public')->delete($kematianudangs->gambar);
            }
            $kematianudangs->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Data kematian udang berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kematian udang: ' . $e->getMessage()
            ], 500); 
        }
}
}