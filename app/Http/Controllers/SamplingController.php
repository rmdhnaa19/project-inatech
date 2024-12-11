<?php

namespace App\Http\Controllers;

use App\Models\SamplingModel;
use App\Models\FaseKolamModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class SamplingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->id_role == 1){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Sampling',
            'paragraph' => 'Berikut ini merupakan data sampling yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'sampling', 'url' => route('admin.sampling.index')],
                ['label' => 'sampling'],
            ]
        ];
        $activeMenu = 'sampling';
        $fase_kolam = FaseKolamModel::all();
        return view('admin.sampling.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
    } elseif(auth()->user()->id_role == 3){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Sampling',
            'paragraph' => 'Berikut ini merupakan data sampling yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'sampling'],
            ]
        ];
        $activeMenu = 'sampling';
        $samplings = SamplingModel::all();
        $fase_kolam = FaseKolamModel::all();
        return view('adminTambak.sampling.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam, 'samplings' => $samplings]);
    }
}

    // menampilkan data table    
    public function list(Request $request)
    {
        $samplings = SamplingModel::select('id_sampling', 'kd_sampling', 'tanggal_cek', 'waktu_cek', 'DOC','berat_udang','size_udang', 'interval_hari', 'harga_udang', 'input_fr', 'total_pakan', 'ADG_udang', 'biomassa', 'populasi_ekor', 'catatan','id_fase_tambak', 'created_at', 'updated_at')->with('faseKolam'); 
        return DataTables::of($samplings)
        ->make(true);
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Sampling',
            'paragraph' => 'Berikut ini merupakan form tambah data sampling yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Sampling', 'url' => route('admin.sampling.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'sampling';
    $fase_kolam = FaseKolamModel::all();
    return view('admin.sampling.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'fase_kolam' => $fase_kolam]);
}

public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'kd_sampling' => 'required|string|max:255|unique:sampling,kd_sampling',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'DOC' => 'required|integer',
        'berat_udang' => 'required|integer',
        'size_udang' => 'required|integer',
        'interval_hari' => 'required|integer',
        'harga_udang' => 'required|integer',
        'input_fr' => 'required|integer',
        'total_pakan' => 'required|integer',
        'ADG_udang' => 'required|integer',
        'biomassa' => 'required|integer',
        'populasi_ekor' => 'required|integer',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
        
    ]);

    // Simpan data ke dalam database
    $samplings = new SamplingModel();
    $samplings->kd_sampling = $request->kd_sampling;
    $samplings->tanggal_cek = $request->tanggal_cek;
    $samplings->waktu_cek = $request->waktu_cek;
    $samplings->DOC = $request->DOC;
    $samplings->berat_udang = $request->berat_udang;
    $samplings->size_udang = $request->size_udang;
    $samplings->harga_udang = $request->harga_udang;
    $samplings->interval_hari = $request->interval_hari;
    $samplings->input_fr = $request->input_fr;
    $samplings->total_pakan = $request->total_pakan;
    $samplings->ADG_udang = $request->ADG_udang;
    $samplings->biomassa = $request->biomassa;
    $samplings->populasi_ekor = $request->populasi_ekor;
    $samplings->catatan = $request->catatan;
    $samplings->id_fase_tambak = $request->id_fase_tambak;

    $samplings->save();

    Alert::toast('Data sampling berhasil ditambahkan', 'success');

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('admin.sampling.index')->with('success', 'Data sampling berhasil ditambahkan');
}

public function show($id)
{
    $samplings = SamplingModel::with('faseKolam')->find($id); // Ambil data tambak dengan relasi fase
    if (!$samplings) {
        return response()->json(['error' => 'Sampling tidak ditemukan.'], 404);
    }

    // Render view dengan data tambak
    $view = view('admin.sampling.show', compact('samplings'))->render();
    return response()->json(['html' => $view]);
}

public function edit(string $id){
    $samplings = SamplingModel::find($id);
    $faseKolam = FaseKolamModel::all();

    $breadcrumb = (object) [
        'title' => 'Edit Data Sampling',
        'paragraph' => 'Berikut ini merupakan form edit data Sampling yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Sampling', 'url' => route('admin.sampling.index')],
            ['label' => 'Edit'],
        ]
    ];
    $activeMenu = 'sampling';

    return view('admin.sampling.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'samplings' => $samplings, 'faseKolam' => $faseKolam]);
}

public function update(Request $request, string $id){
    $request->validate([
        'kd_sampling' => 'required|string|max:255|unique:sampling,kd_sampling',
        'tanggal_cek' => 'required|date',
        'waktu_cek' => 'required',
        'DOC' => 'required|integer',
        'berat_udang' => 'required|integer',
        'size_udang' => 'required|integer',
        'interval_hari' => 'required|integer',
        'harga_udang' => 'required|integer',
        'input_fr' => 'required|integer',
        'total_pakan' => 'required|integer',
        'ADG_udang' => 'required|integer',
        'biomassa' => 'required|integer',
        'populasi_ekor' => 'required|integer',
        'catatan' => 'required|string',
        'id_fase_tambak' => 'required',
    ]);

    $samplings = SamplingModel::findOrFail($id);
    
    $updateData = [
        'kd_sampling' => $request->kd_sampling,
        'tanggal_cek' => $request->tanggal_cek,
        'waktu_cek' => $request->waktu_cek,
        'DOC' => $request->DOC,
        'berat_udang' => $request->berat_udang,
        'size_udang' => $request->size_udang,
        'interval_hari' => $request->interval_hari,
        'harga_udang' => $request->harga_udang,
        'input_fr' => $request->input_fr,
        'total_pakan' => $request->total_pakan,
        'ADG_udang' => $request->ADG_udang,
        'biomassa' => $request->biomassa,
        'populasi_ekor' => $request->populasi_ekor,
        'catatan' => $request->catatan,
        'id_fase_tambak' => $request->id_fase_tambak,
    ];
    
    $samplings->update($updateData);
    return redirect()->route('admin.sampling.index');
}

public function destroy($id) {
    $samplings = SamplingModel::findOrFail($id);
    // AncoModel::destroy($id);
    // $samplings->delete();
    // return redirect()->route('sampling.index');
    try {
        $samplings->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data sampling berhasil dihapus.'
        ]);
    } catch (\Throwable $th) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus sampling: ' . $th->getMessage()
        ], 500);
    }
}

}