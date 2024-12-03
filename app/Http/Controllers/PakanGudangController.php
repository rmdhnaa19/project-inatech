<?php

namespace App\Http\Controllers;

use App\Models\DetailPakanModel;
use App\Models\GudangModel;
use App\Models\PakanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PakanGudangController extends Controller
{
    public function index(){
        if (auth()->user()->id_role == 1) {
            $breadcrumb = (object) [
                'title' => 'Kelola Data Pakan ke Gudang',
                'paragraph' => 'Berikut ini merupakan data pakan ke gudang yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaPakan.index')],
                    ['label' => 'Kelola Pakan ke Gudang'],
                ]
            ];
            $activeMenu = 'kelolaPakanGudang';
            $pakanGudang = DetailPakanModel::all();
            $gudang = GudangModel::all();
            $pakan = PakanModel::all();
            return view('admin.kelolaPakanGudang.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'pakanGudang' => $pakanGudang, 'pakan' => $pakan, 'gudang' => $gudang]);
        }elseif (auth()->user()->id_role == 2) {
            $breadcrumb = (object) [
                'title' => 'Data Pakan',
                'paragraph' => 'Berikut ini merupakan data pakan yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Kelola Pakan']
                ]
            ];
            $activeMenu = 'pakanGudang';
            $user = Auth::user();
            $gudangIds = $user->detailUser->pluck('id_gudang'); // Ambil semua id_gudang
            $pakanGudang = DetailPakanModel::whereIn('id_gudang', $gudangIds)->get();
            return view('adminGudang.pakanGudang.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'pakanGudang' => $pakanGudang, 'user' => $user, 'gudangIds' => $gudangIds]);
        }
        
    }

    public function list(Request $request)
    {
        $pakanGudangs = DetailPakanModel::select('id_detail_pakan', 'kd_detail_pakan', 'id_pakan', 'id_gudang', 'stok_pakan')->with(['pakan', 'gudang']); 
        if ($request->id_pakan) {
            $pakanGudangs->where('id_pakan', $request->id_pakan);
        }
        return DataTables::of($pakanGudangs)
        ->make(true);
    }

    public function show($id)
    {
        $pakanGudang = DetailPakanModel::find($id); // Ambil data tambak dengan relasi gudang
        if (!$pakanGudang) {
            return response()->json(['error' => 'Data pakan ke gudang tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaPakanGudang.show', compact('pakanGudang'))->render();
        return response()->json(['html' => $view]);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Pakan ke Gudang',
            'paragraph' => 'Berikut ini merupakan form tambah data pakan ke gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaPakan.index')],
                ['label' => 'Kelola Pakan ke Gudang', 'url' => route('admin.kelolaPakanGudang.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaPakanGudang';
        $gudang = GudangModel::all();
        $pakan = PakanModel::all();
        $pakanGudang = DetailPakanModel::all();
        return view('admin.kelolaPakanGudang.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'gudang' => $gudang, 'pakan' => $pakan, 'pakanGudang' => $pakanGudang]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kd_detail_pakan' => 'required|string|unique:detail_pakan,kd_detail_pakan',
            'id_pakan' => [
                'required',
                'exists:pakan,id_pakan',
                function ($attribute, $value, $fail) use ($request) {
                    // Cek apakah kombinasi id_gudang dan id_pakan sudah ada di database
                    $exists = DetailPakanModel::where('id_gudang', $request->id_gudang)
                                                ->where('id_pakan', $value)
                                                ->exists();
                    if ($exists) {
                        $fail('Data pakan yang anda masukkan sudah di dalam gudang tersebut.');
                    }
                },
            ],
            'id_gudang' => 'required|integer',
        ]);

        $validatedData['stok_pakan'] = 0;

        // Buat user baru
        DetailPakanModel::create($validatedData);
        Alert::toast('Data pakan ke gudang berhasil ditambah', 'success');

        // Redirect ke halaman kelola pengguna
        return redirect()->route('admin.kelolaPakanGudang.index');
    }

    public function edit(string $id){
        $pakanGudang = DetailPakanModel::find($id);
        $pakan = PakanModel::all();
        $gudang = GudangModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Data Pakan ke Gudang',
            'paragraph' => 'Berikut ini merupakan form edit data pakan ke gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Pakan', 'url' => route('admin.kelolaPakan.index')],
                ['label' => 'kelola Pakan ke Gudang', 'url' => route('admin.kelolaPakanGudang.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaPakanGudang';

        return view('admin.kelolaPakanGudang.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'pakanGudang' => $pakanGudang, 'pakan' => $pakan, 'gudang' => $gudang]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kd_detail_pakan' => 'required|string|unique:detail_pakan,kd_detail_pakan,' . $id . ',id_detail_pakan',
            'id_pakan' => [
                'required',
                'exists:pakan,id_pakan',
                function ($attribute, $value, $fail) use ($request, $id) {
                    // Cek apakah kombinasi sudah ada kecuali untuk data yang sedang di-update
                    $exists = DetailPakanModel::where('id_gudang', $request->id_gudang)
                                               ->where('id_pakan', $value)
                                               ->where('id_detail_pakan', '!=', $id)
                                               ->exists();
                    if ($exists) {
                        $fail('Data pakan yang ada di dalam gudang tersebut sudah ada.');
                    }
                },
            ],
            'id_gudang' => 'required|integer',
        ]);

        $pakanGudang = DetailPakanModel::find($id);

        $pakanGudang->update([
            'kd_detail_pakan' => $request->kd_detail_pakan,
            'id_pakan' => $request->id_pakan,
            'id_gudang' => $request->id_gudang,
        ]);
        Alert::toast('Data pakan ke gudang berhasil diubah', 'success');
        return redirect()->route('admin.kelolaPakanGudang.index');
    }

    public function destroy($id) {
        $check = DetailPakanModel::find($id);
        if (!$check) {
            Alert::toast('Data pakan ke gudang tidak ditemukan', 'error');
            return redirect('/kelolaPakanGudang');
        }
        try{
            DetailPakanModel::destroy($id);
            Alert::toast('Data pakan ke gudang berhasil dihapus', 'success');
            return redirect('/kelolaPakanGudang');
        }catch(\Illuminate\Database\QueryException $e){
            Alert::toast('Data pakan ke gudang gagal dihapus', 'error');
            return redirect('/kelolaPakanGudang');
        }
    }
}
