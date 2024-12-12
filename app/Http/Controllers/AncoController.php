<?php

namespace App\Http\Controllers;

use App\Models\AncoModel;
use App\Models\FaseKolamModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class AncoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        if(auth()->user()->id_role == 1){
            $breadcrumb = (object) [
                'title' => 'Kelola Data Anco',
                'paragraph' => 'Berikut ini merupakan data anco yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Anco', 'url' => route('admin.anco.index')],
                    ['label' => 'Anco'],
                ]
            ];
            $activeMenu = 'anco';
            $anco = AncoModel::all();
            $fase_kolam = FaseKolamModel::all();
            return view('admin.anco.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'anco' => $anco]);
        } elseif(auth()->user()->id_role == 3){
            $breadcrumb = (object) [
                'title' => 'Kelola Data Anco',
                'paragraph' => 'Berikut ini merupakan data anco yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Anco'],
                ]
            ];
            $activeMenu = 'anco';
            $anco = AncoModel::all();
            $fase_kolam = FaseKolamModel::all();
            return view('adminTambak.anco.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'anco' => $anco]);
        }
        
    }

    // menampilkan data table    
    public function list(Request $request)
    {
        $ancos = AncoModel::select('id_anco','kd_anco', 'tanggal_cek', 'waktu_cek', 'pemberian_pakan','jamPemberian_pakan','kondisi_pakan', 'kondisi_udang', 'catatan', 'id_fase_tambak', 'created_at', 'updated_at')->with('faseKolam'); 
        return DataTables::of($ancos)
        ->make(true);
    }


    public function create()
    {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Anco',
                'paragraph' => 'Berikut ini merupakan form tambah data anco yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Anco', 'url' => route('admin.anco.index')],
                    ['label' => 'Tambah'],
                ]
            ];
            $activeMenu = 'anco';
            $fase_kolam = FaseKolamModel::all();
            return view('admin.anco.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
    }

public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'kd_anco' => 'required|string|max:255',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'pemberian_pakan' => 'required|string',
        'jamPemberian_pakan' => 'required',
        'kondisi_pakan' => 'required|string',
        'kondisi_udang' => 'required|string',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
    ]);

    // Simpan data ke dalam database
    $anco = new AncoModel();
    $anco->kd_anco = $request->kd_anco;
    $anco->tanggal_cek = $request->tanggal_cek;
    $anco->waktu_cek = $request->waktu_cek;
    $anco->pemberian_pakan = $request->pemberian_pakan;
    $anco->jamPemberian_pakan = $request->jamPemberian_pakan;
    $anco->kondisi_pakan = $request->kondisi_pakan;
    $anco->kondisi_udang = $request->kondisi_udang;
    $anco->catatan = $request->catatan;
    $anco->id_fase_tambak = $request->id_fase_tambak;
    
    $anco->save();

    // Untuk role lainnya (opsional)
    Alert::toast('Data anco berhasil ditambahkan', 'success');
    return redirect()->route('admin.anco.index')->with('success', 'Data kolam berhasil ditambahkan');
}


public function show($id)
{
    $anco = AncoModel::with('faseKolam')->find($id); // Ambil data tambak dengan relasi faseKolam
    if (!$anco) {
        return response()->json(['error' => 'Tambak tidak ditemukan.'], 404);
    }

    // Render view dengan data tambak
    $view = view('admin.anco.show', compact('anco'))->render();
    return response()->json(['html' => $view]);
}

public function edit(string $id){
    $anco = AncoModel::find($id);
    $faseKolam = FaseKolamModel::all();

    $breadcrumb = (object) [
        'title' => 'Edit Data Anco',
        'paragraph' => 'Berikut ini merupakan form edit data anco yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Anco', 'url' => route('admin.anco.index')],
            ['label' => 'Edit'],
        ]
    ];
    $activeMenu = 'anco';

    return view('admin.anco.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'anco' => $anco, 'faseKolam' => $faseKolam]);
}

public function update(Request $request, string $id){
    $request->validate([
        'kd_anco' => 'required|string|max:255',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'pemberian_pakan' => 'required|string',
        'jamPemberian_pakan' => 'required',
        'kondisi_pakan' => 'required|string',
        'kondisi_udang' => 'required|string',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
    ]);

    $anco = AncoModel::findOrFail($id);
    
    $updateData = [
        'kd_anco' => $request->kd_anco,
        'tanggal_cek' => $request->tanggal_cek,
        'waktu_cek' => $request->waktu_cek,
        'pemberian_pakan' => $request->pemberian_pakan,
        'jamPemberian_pakan' => $request->jamPemberian_pakan,
        'kondisi_pakan' => $request->kondisi_pakan,
        'kondisi_udang' => $request->kondisi_udang,
        'catatan' => $request->catatan,
        'id_fase_tambak' => $request->id_fase_tambak,
    ];
    
    $anco->update($updateData);
    return redirect()->route('admin.anco.index');
}

public function destroy($id) {
    $anco = AncoModel::findOrFail($id);
    // // AncoModel::destroy($id);
    // $anco->delete();
    // return redirect()->route('admin.anco.index');
    try {
        $anco->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data anco berhasil dihapus.'
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus anco: ' . $th->getMessage()
        ], 500);
    }
}

// Role adminTambak
public function indexAdminTambak() {
    $breadcrumb = (object) [
        'title' => 'Kelola Data Anco',
        'paragraph' => 'Berikut ini merupakan data anco yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Anco', 'url' => route('user.anco.index')],
            ['label' => 'Anco'],
        ]
    ];
    $activeMenu = 'anco';
    $anco = AncoModel::all();
    $fase_kolam = FaseKolamModel::all();
    return view('adminTambak.anco.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'anco' => $anco]);
}

public function createAdminTambak() {
    $breadcrumb = (object) [
        'title' => 'Tambah Data Anco',
        'paragraph' => 'Berikut ini merupakan form tambah data anco yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Anco', 'url' => route('user.anco.create')],
            ['label' => 'Tambah'],
        ]
    ];
    $activeMenu = 'anco';
    $fase_kolam = FaseKolamModel::all();
    return view('adminTambak.anco.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
}

public function storeAdminTambak(Request $request) {
    // Validasi input
    $request->validate([
        'kd_anco' => 'required|string|max:255',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'pemberian_pakan' => 'required|string',
        'jamPemberian_pakan' => 'required',
        'kondisi_pakan' => 'required|string',
        'kondisi_udang' => 'required|string',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
    ]);
    

    try {
        // Simpan data ke dalam database
        AncoModel::create($request->all());

        // Untuk role lainnya (opsional)
        Alert::toast('Data anco berhasil ditambahkan', 'success');
        return redirect()->route('user.anco.index')->with('success', 'Data anco berhasil ditambahkan');
    } catch (\Throwable $th) {
        return back('user.anco.create')->with('gagal', 'Data anco gagal ditambahkan' . $th->getMessage());
}
}

public function showAdminTambak($id)
{
    $anco = AncoModel::with('faseKolam')->find($id); // Ambil data tambak dengan relasi faseKolam
    if (!$anco) {
        return response()->json(['error' => 'Anco tidak ditemukan.'], 404);
    }
    $breadcrumb = (object) [
        'title' => 'Detail Data Anco',
        'paragraph' => 'Berikut ini merupakan form tambah data anco yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Anco', 'url' => route('user.anco.index')],
            ['label' => 'Anco', 'url' => route('user.anco.show', $id)],
            ['label' => 'Detail'],
        ]
    ];
    $activeMenu = 'anco';
    // Render view dengan data tambak
    return view('adminTambak.anco.show', compact('anco', 'activeMenu', 'breadcrumb'));
    // return response()->json(['html' => $view]);
}

}
