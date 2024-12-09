<?php

namespace App\Http\Controllers;

use App\Models\AlatModel;
use App\Models\DetailAlatModel;
use App\Models\GudangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class AlatGudangController extends Controller
{
    public function index(){
        if (auth()->user()->id_role == 1) {
            $breadcrumb = (object) [
                'title' => 'Kelola Data Alat ke Gudang',
                'paragraph' => 'Berikut ini merupakan data alat ke gudang yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Kelola Alat', 'url' => route('admin.kelolaAlat.index')],
                    ['label' => 'Kelola Alat ke Gudang'],
                ]
            ];
            $activeMenu = 'kelolaAlatGudang';
            $alatGudang = DetailAlatModel::all();
            $gudang = GudangModel::all();
            $alat = AlatModel::all();
            return view('admin.kelolaAlatGudang.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'alatGudang' => $alatGudang, 'alat' => $alat, 'gudang' => $gudang]);
        }elseif (auth()->user()->id_role == 2) {
            $breadcrumb = (object) [
                'title' => 'Kelola Data Alat ke Gudang',
                'paragraph' => 'Berikut ini merupakan data alat ke gudang yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home', 'url' => route('dashboard.index')],
                    ['label' => 'Data Alat'],
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
        $alatGudangs = DetailAlatModel::select('id_detail_alat', 'kd_detail_alat', 'id_alat', 'id_gudang', 'stok_alat')->with(['alat', 'gudang']); 
        if ($request->id_alat) {
            $alatGudangs->where('id_alat', $request->id_alat);
        }
        return DataTables::of($alatGudangs)
        ->make(true);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Alat ke Gudang',
            'paragraph' => 'Berikut ini merupakan form tambah data alat ke gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Alat', 'url' => route('admin.kelolaAlat.index')],
                ['label' => 'Kelola Alat ke Gudang', 'url' => route('admin.kelolaAlatGudang.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaAlatGudang';
        $gudang = GudangModel::all();
        $alat = AlatModel::all();
        $alatGudang = DetailAlatModel::all();
        return view('admin.kelolaAlatGudang.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'gudang' => $gudang, 'alat' => $alat, 'alatGudang' => $alatGudang]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kd_detail_alat' => 'required|string|unique:detail_alat,kd_detail_alat',
            'id_alat' => [
                'required',
                'exists:alat,id_alat',
                function ($attribute, $value, $fail) use ($request) {
                    // Cek apakah kombinasi id_gudang dan id_alat sudah ada di database
                    $exists = DetailAlatModel::where('id_gudang', $request->id_gudang)
                                                ->where('id_alat', $value)
                                                ->exists();
                    if ($exists) {
                        $fail('Data alat yang anda masukkan sudah di dalam gudang tersebut.');
                    }
                },
            ],
            'id_gudang' => 'required|integer',
        ]);

        $validatedData['stok_alat'] = 0;

        // Buat user baru
        DetailAlatModel::create($validatedData);
        Alert::toast('Data alat ke gudang berhasil ditambah', 'success');

        // Redirect ke halaman kelola pengguna
        return redirect()->route('admin.kelolaAlatGudang.index');
    }

    public function show($id)
    {
        $alatGudang = DetailAlatModel::find($id); // Ambil data tambak dengan relasi gudang
        if (!$alatGudang) {
            return response()->json(['error' => 'Data alat ke gudang tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaAlatGudang.show', compact('alatGudang'))->render();
        return response()->json(['html' => $view]);
    }


    public function edit(string $id){
        $alatGudang = DetailAlatModel::find($id);
        $alat = AlatModel::all();
        $gudang = GudangModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Data Alat ke Gudang',
            'paragraph' => 'Berikut ini merupakan form edit data alat ke gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Alat', 'url' => route('admin.kelolaAlat.index')],
                ['label' => 'kelola Alat ke Gudang', 'url' => route('admin.kelolaAlatGudang.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaAlatGudang';

        return view('admin.kelolaAlatGudang.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'alatGudang' => $alatGudang, 'alat' => $alat, 'gudang' => $gudang]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kd_detail_alat' => 'required|string|unique:detail_alat,kd_detail_alat,' . $id . ',id_detail_alat',
            'id_alat' => [
                'required',
                'exists:alat,id_alat',
                function ($attribute, $value, $fail) use ($request, $id) {
                    // Cek apakah kombinasi sudah ada kecuali untuk data yang sedang di-update
                    $exists = DetailAlatModel::where('id_gudang', $request->id_gudang)
                                               ->where('id_alat', $value)
                                               ->where('id_detail_alat', '!=', $id)
                                               ->exists();
                    if ($exists) {
                        $fail('Data alat yang ada di dalam gudang tersebut sudah ada.');
                    }
                },
            ],
            'id_gudang' => 'required|integer',
        ]);

        $alatGudang = DetailAlatModel::find($id);

        $alatGudang->update([
            'kd_detail_alat' => $request->kd_detail_alat,
            'id_alat' => $request->id_alat,
            'id_gudang' => $request->id_gudang,
        ]);
        Alert::toast('Data alat ke gudang berhasil diubah', 'success');
        return redirect()->route('admin.kelolaAlatGudang.index');
    }

    public function destroy($id)
    {
        $alatGudang = DetailAlatModel::find($id);
        if (!$alatGudang) {
            return response()->json([
                'success' => false,
                'message' => 'Data alat ke gudang tidak ditemukan.'
            ], 404);
        }
    
        try {
            $alatGudang->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Data alat ke gudang berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus alat ke gudang: ' . $e->getMessage()
            ], 500);
        }
    }
}
