<?php

namespace App\Http\Controllers;

use App\Models\DetailPakanModel;
use App\Models\PakanHarianModel;
use App\Models\FaseKolamModel;
use App\Models\PakanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class PakanHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->id_role == 1){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Pakan Harian',
            'paragraph' => 'Berikut ini merupakan data pakan harian yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'pakanHarian', 'url' => route('admin.pakanharian.index')],
                ['label' => 'pakanHarian'],
            ]
        ];
        $activeMenu = 'pakanHarian';
        $fase_kolam = FaseKolamModel::all();
        $detail_pakan = DetailPakanModel::all();
        return view('admin.pakanharian.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'detail_pakan' => $detail_pakan]);
    } elseif(auth()->user()->id_role == 3){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Pakan Harian',
            'paragraph' => 'Berikut ini merupakan data pakan harian yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'pakanHarian'],
            ]
        ];
        $activeMenu = 'pakanHarian';
        $pakan_harians = PakanHarianModel::all();
        $fase_kolam = FaseKolamModel::all();
        return view('adminTambak.pakanharian.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'pakan_harians' => $pakan_harians]);
    }
}

    // menampilkan data table    
    public function list(Request $request)
    {
        $pakan_harians = PakanHarianModel::select('id_pakan_harian', 'kd_pakan_harian', 'tanggal_cek', 'waktu_cek', 'DOC','berat_udang','total_pakan', 'catatan', 'id_fase_tambak','id_detail_pakan', 'created_at', 'updated_at')->with('faseKolam', 'detailPakan'); 
        return DataTables::of($pakan_harians)
        ->make(true);
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Pakan Harian',
            'paragraph' => 'Berikut ini merupakan form tambah data pakan harian yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'pakanHarian', 'url' => route('admin.pakanharian.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'pakanHarian';
    $fase_kolam = FaseKolamModel::all();
    $detail_pakan = DetailPakanModel::all();
    return view('admin.pakanharian.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'detail_pakan' => $detail_pakan]);
}

public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'kd_pakan_harian' => 'required|string|max:255',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'DOC' => 'required|integer',
        'berat_udang' => 'required|integer',
        'total_pakan' => 'required|integer',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
        // 'id_detail_pakan' => 'required',
    ]);

    // Simpan data ke dalam database
    $pakan_harians = new PakanHarianModel();
    $pakan_harians->kd_pakan_harian = $request->kd_pakan_harian;
    $pakan_harians->tanggal_cek = $request->tanggal_cek;
    $pakan_harians->waktu_cek = $request->waktu_cek;
    $pakan_harians->DOC = $request->DOC;
    $pakan_harians->berat_udang = $request->berat_udang;
    $pakan_harians->total_pakan = $request->total_pakan;
    $pakan_harians->catatan = $request->catatan;
    $pakan_harians->id_fase_tambak = $request->id_fase_tambak;
    // $pakan_harians->id_detail_pakan = $request->id_detail_pakan;
    

    $pakan_harians->save();

    Alert::toast('Data pakan harian berhasil ditambahkan', 'success');

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('admin.pakanharian.index')->with('success', 'Data pakan harian berhasil ditambahkan');
}

public function show($id)
{
    $pakan_harians = PakanHarianModel::with('faseKolam')->find($id); // Ambil data tambak dengan relasi fase
    if (!$pakan_harians) {
        return response()->json(['error' => 'Pakan Harian tidak ditemukan.'], 404);
    }

    // Render view dengan data tambak
    $view = view('admin.pakanharian.show', compact('pakan_harians'))->render();
    return response()->json(['html' => $view]);
}

public function edit(string $id){
    $pakan_harians = PakanHarianModel::find($id);
    $faseKolam = FaseKolamModel::all();

    $breadcrumb = (object) [
        'title' => 'Edit Data Pakan Harian',
        'paragraph' => 'Berikut ini merupakan form edit data Pakan Harian yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'pakanHarian', 'url' => route('admin.pakanharian.index')],
            ['label' => 'Edit'],
        ]
    ];
    $activeMenu = 'pakanHarian';

    return view('admin.pakanharian.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'pakan_harians' => $pakan_harians, 'faseKolam' => $faseKolam]);
}

public function update(Request $request, string $id){
    $request->validate([
        'kd_pakan_harian' => 'required|string|max:255',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'DOC' => 'required|integer',
        'berat_udang' => 'required|integer',
        'total_pakan' => 'required|integer',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
        // 'id_detail_pakan' => 'required',
    ]);

    $pakan_harians = PakanHarianModel::findOrFail($id);
    
    $updateData = [
        'kd_pakan_harian' => $request->kd_pakan_harian,
        'tanggal_cek' => $request->tanggal_cek,
        'waktu_cek' => $request->waktu_cek,
        'DOC' => $request->DOC,
        'berat_udang' => $request->berat_udang,
        'total_pakan' => $request->total_pakan,
        'catatan' => $request->catatan,
        'id_fase_tambak' => $request->id_fase_tambak,
        // 'id_detail_pakan' => $request->id_detail_pakan,
    ];
    
    $pakan_harians->update($updateData);
    return redirect()->route('admin.pakanharian.index');
}

public function destroy($id) {
    $pakan_harians = PakanHarianModel::findOrFail($id);
    // AncoModel::destroy($id);
    // $pakan_harians->delete();
    // return redirect()->route('pakanharian.index');
    try {
        $pakan_harians->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data pakan harian berhasil dihapus.'
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus pakan harian: ' . $th->getMessage()
        ], 500);
    }
}

// Role adminTambak
public function indexAdminTambak() {
    $breadcrumb = (object) [
        'title' => 'Kelola Data Pakan Harian',
        'paragraph' => 'Berikut ini merupakan data pakan harian yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'pakanHarian', 'url' => route('user.pakanharian.index')],
            ['label' => 'pakanHarian'],
        ]
    ];
    $activeMenu = 'pakanHarian';
    $pakan_harians = PakanHarianModel::all();
    $fase_kolam = FaseKolamModel::all();
    return view('adminTambak.pakanharian.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'pakan_harians' => $pakan_harians]);
}

public function createAdminTambak() {
    $breadcrumb = (object) [
        'title' => 'Tambah Data Pakan Harian',
        'paragraph' => 'Berikut ini merupakan form tambah data pakan harian yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'pakanHarian', 'url' => route('user.pakanharian.create')],
            ['label' => 'Tambah'],
        ]
    ];
    $activeMenu = 'pakanHarian';
    $fase_kolam = FaseKolamModel::all();
    return view('adminTambak.pakanharian.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
}

public function storeAdminTambak(Request $request) {
    // Validasi input
    $request->validate([
        'kd_pakan_harian' => 'required|string|max:255',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'DOC' => 'required|integer',
        'berat_udang' => 'required|integer',
        'total_pakan' => 'required|integer',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
    ]);
    

    try {
        // Simpan data ke dalam database
        PakanHarianModel::create($request->all());

        // Untuk role lainnya (opsional)
        Alert::toast('Data pakan harian berhasil ditambahkan', 'success');
        return redirect()->route('user.pakanharian.index')->with('success', 'Data pakan harian berhasil ditambahkan');
    } catch (\Throwable $th) {
        return back('user.ppakanharian.create')->with('gagal', 'Data pakan harian gagal ditambahkan' . $th->getMessage());
}
}

public function showAdminTambak($id)
{
    $pakan_harians = PakanHarianModel::with('faseKolam')->find($id); // Ambil data tambak dengan relasi faseKolam
    if (!$pakan_harians) {
        return response()->json(['error' => 'Pakan Harian tidak ditemukan.'], 404);
    }
    $breadcrumb = (object) [
        'title' => 'Detail Data Pakan Harian',
        'paragraph' => 'Berikut ini merupakan form tambah data pakan harian yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'pakanHarian', 'url' => route('user.pakanharian.index')],
            ['label' => 'pakanHarian', 'url' => route('user.pakanharian.show', $id)],
            ['label' => 'Detail'],
        ]
    ];
    $activeMenu = 'pakanHarian';
    // Render view dengan data tambak
    return view('adminTambak.pakanharian.show', compact('pakan_harians', 'activeMenu', 'breadcrumb'));
    // return response()->json(['html' => $view]);
}

}