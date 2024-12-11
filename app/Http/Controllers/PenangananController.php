<?php

namespace App\Http\Controllers;

use App\Models\PenangananModel;
use App\Models\FaseKolamModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class PenangananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->id_role == 1){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Penanganan',
            'paragraph' => 'Berikut ini merupakan data penanganan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'penanganan', 'url' => route('admin.penanganan.index')],
                ['label' => 'penanganan'],
            ]
        ];
        $activeMenu = 'penanganan';
        $fase_kolam = FaseKolamModel::all();
        return view('admin.penanganan.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
    } elseif(auth()->user()->id_role == 3){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Penanganan',
            'paragraph' => 'Berikut ini merupakan data penanganan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'penanganan'],
            ]
        ];
        $activeMenu = 'penanganan';
        $penanganans = PenangananModel::all();
        $fase_kolam = FaseKolamModel::all();
        return view('adminTambak.penanganan.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'penanganans' => $penanganans]);
    }
}

    // menampilkan data table    
    public function list(Request $request)
    {
        $penanganans = PenangananModel::select('id_penanganan', 'kd_penanganan', 'tanggal_cek', 'waktu_cek', 'pemberian_mineral','pemberian_vitamin','pemberian_obat', 'penambahan_air', 'pengurangan_air', 'catatan','id_fase_tambak', 'created_at', 'updated_at')->with('faseKolam'); 
        return DataTables::of($penanganans)
        ->make(true);
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Penanganan',
            'paragraph' => 'Berikut ini merupakan form tambah data penanganan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'penanganan', 'url' => route('admin.penanganan.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'penanganan';
    $fase_kolam = FaseKolamModel::all();
    return view('admin.penanganan.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
}

public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'kd_penanganan' => 'required|string|max:255',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'pemberian_mineral' => 'required|integer',
        'pemberian_vitamin' => 'required|integer',
        'pemberian_obat' => 'required|integer',
        'penambahan_air' => 'required|integer',
        'pengurangan_air' => 'required|integer',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
    ]);

    // Simpan data ke dalam database
    $penanganans = new PenangananModel();
    $penanganans->kd_penanganan = $request->kd_penanganan;
    $penanganans->tanggal_cek = $request->tanggal_cek;
    $penanganans->waktu_cek = $request->waktu_cek;
    $penanganans->pemberian_mineral = $request->pemberian_mineral;
    $penanganans->pemberian_vitamin = $request->pemberian_vitamin;
    $penanganans->pemberian_obat = $request->pemberian_obat;
    $penanganans->penambahan_air = $request->penambahan_air;
    $penanganans->pengurangan_air = $request->pengurangan_air;
    $penanganans->catatan = $request->catatan;
    $penanganans->id_fase_tambak = $request->id_fase_tambak;

    $penanganans->save();

    Alert::toast('Data penanganan berhasil ditambahkan', 'success');

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('admin.penanganan.index')->with('success', 'Data penanganan berhasil ditambahkan');
}

public function show($id)
{
    $penanganans = PenangananModel::with('faseKolam')->find($id); // Ambil data tambak dengan relasi fase
    if (!$penanganans) {
        return response()->json(['error' => 'Penanganan tidak ditemukan.'], 404);
    }

    // Render view dengan data tambak
    $view = view('admin.penanganan.show', compact('penanganans'))->render();
    return response()->json(['html' => $view]);
}

public function edit(string $id){
    $penanganans = PenangananModel::find($id);
    $faseKolam = FaseKolamModel::all();

    $breadcrumb = (object) [
        'title' => 'Edit Data Penanganan',
        'paragraph' => 'Berikut ini merupakan form edit data Penanganan yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Penanganan', 'url' => route('admin.penanganan.index')],
            ['label' => 'Edit'],
        ]
    ];
    $activeMenu = 'penanganan';

    return view('admin.penanganan.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'penanganans' => $penanganans, 'faseKolam' => $faseKolam]);
}

public function update(Request $request, string $id){
    $request->validate([
        'kd_penanganan' => 'required|string|max:255',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'pemberian_mineral' => 'required|integer',
        'pemberian_vitamin' => 'required|integer',
        'pemberian_obat' => 'required|integer',
        'penambahan_air' => 'required|integer',
        'pengurangan_air' => 'required|integer',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
    ]);

    $penanganans = PenangananModel::findOrFail($id);
    
    $updateData = [
        'kd_penanganan' => $request->kd_penanganan,
        'tanggal_cek' => $request->tanggal_cek,
        'waktu_cek' => $request->waktu_cek,
        'pemberian_mineral' => $request->pemberian_mineral,
        'pemberian_vitamin' => $request->pemberian_vitamin,
        'pemberian_obat' => $request->pemberian_obat,
        'penambahan_air' => $request->penambahan_air,
        'pengurangan_air' => $request->pengurangan_air,
        'catatan' => $request->catatan,
        'id_fase_tambak' => $request->id_fase_tambak, 
    ];
    
    $penanganans->update($updateData);
    return redirect()->route('admin.penanganan.index');
}

public function destroy($id) {
    $penanganans = PenangananModel::findOrFail($id);
    // AncoModel::destroy($id);
    // $penanganans->delete();
    // return redirect()->route('penanganan.index');
    try {
        $penanganans->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data penanganan berhasil dihapus.'
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus penanganan: ' . $th->getMessage()
        ], 500);
    }
}

// Role adminTambak
public function indexAdminTambak() {
    $breadcrumb = (object) [
        'title' => 'Kelola Data Penanganan',
        'paragraph' => 'Berikut ini merupakan data penanganan yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Penanganan', 'url' => route('user.penanganan.index')],
            ['label' => 'Penanganan'],
        ]
    ];
    $activeMenu = 'penanganan';
    $penanganans = PenangananModel::all();
    $fase_kolam = FaseKolamModel::all();
    return view('adminTambak.penanganan.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'penanganans' => $penanganans]);
}

public function createAdminTambak() {
    $breadcrumb = (object) [
        'title' => 'Tambah Data Penanganan',
        'paragraph' => 'Berikut ini merupakan form tambah data penanganan yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Penanganan', 'url' => route('user.penanganan.create')],
            ['label' => 'Tambah'],
        ]
    ];
    $activeMenu = 'penanganan';
    $fase_kolam = FaseKolamModel::all();
    return view('adminTambak.penanganan.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
}

public function storeAdminTambak(Request $request) {
    // Validasi input
    $request->validate([
        'kd_penanganan' => 'required|string|max:255',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'pemberian_mineral' => 'required|integer',
        'pemberian_vitamin' => 'required|integer',
        'pemberian_obat' => 'required|integer',
        'penambahan_air' => 'required|integer',
        'pengurangan_air' => 'required|integer',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
    ]);
    

    try {
        // Simpan data ke dalam database
        PenangananModel::create($request->all());

        // Untuk role lainnya (opsional)
        Alert::toast('Data penanganan berhasil ditambahkan', 'success');
        return redirect()->route('user.penanganan.index')->with('success', 'Data penanganan berhasil ditambahkan');
    } catch (\Throwable $th) {
        return back('user.penanganan.create')->with('gagal', 'Data penanganan gagal ditambahkan' . $th->getMessage());
}
}

public function showAdminTambak($id)
{
    $penanganans = PenangananModel::with('faseKolam')->find($id); // Ambil data tambak dengan relasi faseKolam
    if (!$penanganans) {
        return response()->json(['error' => 'Penanganan tidak ditemukan.'], 404);
    }
    $breadcrumb = (object) [
        'title' => 'Detail Data Penanganan',
        'paragraph' => 'Berikut ini merupakan form tambah data penanganan yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Penanganan', 'url' => route('user.penanganan.index')],
            ['label' => 'Penanganan', 'url' => route('user.penanganan.show', $id)],
            ['label' => 'Detail'],
        ]
    ];
    $activeMenu = 'penanganan';
    // Render view dengan data tambak
    return view('adminTambak.penanganan.show', compact('penanganans', 'activeMenu', 'breadcrumb'));
    // return response()->json(['html' => $view]);
}

}