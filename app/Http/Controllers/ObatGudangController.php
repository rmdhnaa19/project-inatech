<?php

namespace App\Http\Controllers;

use App\Models\DetailObatModel;
use App\Models\GudangModel;
use App\Models\ObatModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ObatGudangController extends Controller
{
    public function index(){
        if (auth()->user()->id_role == 1) {
            $breadcrumb = (object) [
                'title' => 'Kelola Data Obat ke Gudang',
                'paragraph' => 'Berikut ini merupakan data obat ke gudang yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Kelola Obat', 'url' => route('admin.kelolaObat.index')],
                    ['label' => 'Kelola Obat ke Gudang'],
                ]
            ];
            $activeMenu = 'kelolaObatGudang';
            $obatGudang = DetailObatModel::all();
            $gudang = GudangModel::all();
            $obat = ObatModel::all();
            return view('admin.kelolaObatGudang.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'obatGudang' => $obatGudang, 'obat' => $obat, 'gudang' => $gudang]);
        }elseif (auth()->user()->id_role == 2) {
            $breadcrumb = (object) [
                'title' => 'Data Obat',
                'paragraph' => 'Berikut ini merupakan data obat yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Data Obat'],
                ]
            ];
            $activeMenu = 'alatGudang';
            $user = Auth::user();
            $gudangIds = $user->detailUser->pluck('id_gudang'); // Ambil semua id_gudang
            $alatGudang = DetailAlatModel::whereIn('id_gudang', $gudangIds)->get();
            return view('adminGudang.alatGudang.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'alatGudang' => $alatGudang, 'gudangIds' => $gudangIds, 'user' => $user]);
        }
    }

    public function list(Request $request)
    {
        $obatGudangs = DetailObatModel::select('id_detail_obat', 'kd_detail_obat', 'id_obat', 'id_gudang', 'stok_obat')->with(['obat', 'gudang']); 
        if ($request->id_obat) {
            $obatGudangs->where('id_obat', $request->id_obat);
        }
        return DataTables::of($obatGudangs)
        ->make(true);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Obat ke Gudang',
            'paragraph' => 'Berikut ini merupakan form tambah data obat ke gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Obat', 'url' => route('admin.kelolaObat.index')],
                ['label' => 'Kelola Obat ke Gudang', 'url' => route('admin.kelolaObatGudang.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaObatGudang';
        $gudang = GudangModel::all();
        $obat = ObatModel::all();
        $obatGudang = DetailObatModel::all();
        return view('admin.kelolaObatGudang.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'gudang' => $gudang, 'obat' => $obat, 'obatGudang' => $obatGudang]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kd_detail_obat' => 'required|string|unique:detail_obat,kd_detail_obat',
            'id_obat' => [
                'required',
                'exists:obat,id_obat',
                function ($attribute, $value, $fail) use ($request) {
                    // Cek apakah kombinasi id_gudang dan id_obat sudah ada di database
                    $exists = DetailObatModel::where('id_gudang', $request->id_gudang)
                                                ->where('id_obat', $value)
                                                ->exists();
                    if ($exists) {
                        $fail('Data obat yang anda masukkan sudah di dalam gudang tersebut.');
                    }
                },
            ],
            'id_gudang' => 'required|integer',
        ]);

        $validatedData['stok_obat'] = 0;

        // Buat user baru
        DetailObatModel::create($validatedData);
        Alert::toast('Data obat ke gudang berhasil ditambah', 'success');

        // Redirect ke halaman kelola pengguna
        return redirect()->route('admin.kelolaObatGudang.index');
    }

    public function show($id)
    {
        $obatGudang = DetailObatModel::find($id); // Ambil data tambak dengan relasi gudang
        if (!$obatGudang) {
            return response()->json(['error' => 'Data obat ke gudang tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaObatGudang.show', compact('obatGudang'))->render();
        return response()->json(['html' => $view]);
    }


    public function edit(string $id){
        $obatGudang = DetailObatModel::find($id);
        $obat = ObatModel::all();
        $gudang = GudangModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Data Obat ke Gudang',
            'paragraph' => 'Berikut ini merupakan form edit data obat ke gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Obat', 'url' => route('admin.kelolaObat.index')],
                ['label' => 'kelola Obat ke Gudang', 'url' => route('admin.kelolaObatGudang.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaObatGudang';

        return view('admin.kelolaObatGudang.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'obatGudang' => $obatGudang, 'obat' => $obat, 'gudang' => $gudang]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kd_detail_obat' => 'required|string|unique:detail_obat,kd_detail_obat,' . $id . ',id_detail_obat',
            'id_obat' => [
                'required',
                'exists:obat,id_obat',
                function ($attribute, $value, $fail) use ($request, $id) {
                    // Cek apakah kombinasi sudah ada kecuali untuk data yang sedang di-update
                    $exists = DetailObatModel::where('id_gudang', $request->id_gudang)
                                               ->where('id_obat', $value)
                                               ->where('id_detail_obat', '!=', $id)
                                               ->exists();
                    if ($exists) {
                        $fail('Data obat yang ada di dalam gudang tersebut sudah ada.');
                    }
                },
            ],
            'id_gudang' => 'required|integer',
        ]);

        $obatGudang = DetailObatModel::find($id);

        $obatGudang->update([
            'kd_detail_obat' => $request->kd_detail_obat,
            'id_obat' => $request->id_obat,
            'id_gudang' => $request->id_gudang,
        ]);
        Alert::toast('Data obat ke gudang berhasil diubah', 'success');
        return redirect()->route('admin.kelolaObatGudang.index');
    }

    public function destroy($id)
    {
        $obatGudang = DetailObatModel::find($id);
        if (!$obatGudang) {
            return response()->json([
                'success' => false,
                'message' => 'Data obat ke gudang tidak ditemukan.'
            ], 404);
        }
    
        try {
            $obatGudang->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Data obat ke gudang berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus obat ke gudang: ' . $e->getMessage()
            ], 500);
        }
    }
}
