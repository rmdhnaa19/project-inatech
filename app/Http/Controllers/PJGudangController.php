<?php

namespace App\Http\Controllers;

use App\Models\DetailUserModel;
use App\Models\GudangModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PJGudangController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Kelola Data Penanggung Jawab Gudang',
            'paragraph' => 'Berikut ini merupakan data penaggung jawab gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Gudang', 'url' => route('admin.kelolaGudang.index')],
                ['label' => 'Kelola Penanggung Jawab Gudang'],
            ]
        ];
        $activeMenu = 'kelolaPJGudang';
        $pjGudang = DetailUserModel::all();
        $gudang = GudangModel::all();
        $user = UserModel::all();
        return view('admin.kelolaPJGudang.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'user' => $user, 'pjGudang' => $pjGudang, 'gudang' => $gudang]);
    }

    public function list(Request $request)
    {
        $pjGudangs = DetailUserModel::select('id_detail_user', 'kd_detail_user', 'id_gudang', 'id_user')->with(['gudang', 'user']); 
        if ($request->id_gudang) {
            $pjGudangs->where('id_gudang', $request->id_gudang);
        }
        return DataTables::of($pjGudangs)
        ->make(true);
    }

    public function show($id)
    {
        $pjGudang = DetailUserModel::with(['gudang', 'user'])->find($id); // Ambil data tambak dengan relasi gudang
        if (!$pjGudang) {
            return response()->json(['error' => 'Penanggung jawab gudang tidak ditemukan.'], 404);
        }

        // Render view dengan data tambak
        $view = view('admin.kelolaPJGudang.show', compact('pjGudang'))->render();
        return response()->json(['html' => $view]);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Penanggung Jawab Gudang',
            'paragraph' => 'Berikut ini merupakan form tambah data penanggung jawab gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Gudang', 'url' => route('admin.kelolaGudang.index')],
                ['label' => 'Kelola Penanggung Jawab Gudang', 'url' => route('admin.kelolaPJGudang.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kelolaPJGudang';
        $usedGudangId = DetailUserModel::pluck('id_gudang')->toArray();
        $gudang = GudangModel::whereNotIn('id_gudang', $usedGudangId)
                ->get();

        $usedUserId = DetailUserModel::pluck('id_user')->toArray();
        $user = UserModel::where('id_role', 2)
                ->whereNotIn('id_user', $usedUserId)
                ->get();
        return view('admin.kelolaPJGudang.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'gudang' => $gudang, 'user' => $user]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'kd_detail_user' => 'required|string|unique:detail_user,kd_detail_user',
            'id_gudang' => 'required|integer',
            'id_user' => [
                'required',
                'exists:user,id_user',
                function ($attribute, $value, $fail) use ($request) {
                    if (DetailUserModel::where('id_gudang', $request->id_gudang)
                                    ->where('id_user', $value)
                                    ->exists()) {
                        $fail('Data penanggung jawab yang ada di dalam gudang tersebut sudah ada.');
                    }
                },
            ],
        ]);

        DetailUserModel::create($validatedData);
        Alert::toast('Data penanggung jawab berhasil ditambah', 'success');
        return redirect()->route('admin.kelolaPJGudang.index');
    }

    public function edit(string $id){
        $pjGudang = DetailUserModel::find($id);

        $usedGudangId = DetailUserModel::pluck('id_gudang')->toArray();
        $gudang = GudangModel::whereNotIn('id_gudang', $usedGudangId)
                ->get();

        $usedUserId = DetailUserModel::pluck('id_user')->toArray();
        $user = UserModel::where('id_role', 2)
                ->whereNotIn('id_user', $usedUserId)
                ->get();

        $breadcrumb = (object) [
            'title' => 'Edit Data Penanggung Jawab Gudang',
            'paragraph' => 'Berikut ini merupakan form edit data penanggung jawab gudang yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Gudang', 'url' => route('admin.kelolaGudang.index')],
                ['label' => 'Kelola Penanggung Jawab Gudang', 'url' => route('admin.kelolaPJGudang.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kelolaPJGudang';

        return view('admin.kelolaPJGudang.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'pjGudang' => $pjGudang, 'gudang' => $gudang, 'user' => $user]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'kd_detail_user' => 'required|string|unique:detail_user,kd_detail_user,'.$id.',id_detail_user',
            'id_gudang' => 'required|integer',
            'id_user' => [
                'required',
                'exists:user,id_user',
                function ($attribute, $value, $fail) use ($request, $id) {
                    // Cek apakah kombinasi sudah ada kecuali untuk data yang sedang di-update
                    $exists = DetailUserModel::where('id_gudang', $request->id_gudang)
                                                ->where('id_user', $value)
                                                ->where('id_detail_user', '!=', $id)
                                                ->exists();
                    if ($exists) {
                        $fail('Data penanggung jawab yang ada di dalam gudang tersebut sudah ada.');
                    }
                },
            ],
        ]);

        $pjGudang = DetailUserModel::find($id);

        $pjGudang->update([
            'kd_detail_user' => $request->kd_detail_user,
            'id_gudang' => $request->id_gudang,
            'id_user' => $request->id_user,
        ]);
        
        Alert::toast('Data penanggung jawab berhasil diubah', 'success');
        return redirect()->route('admin.kelolaPJGudang.index');
    }

    public function destroy($id) {
        $check = DetailUserModel::find($id);
        if (!$check) {
            Alert::toast('Data penanggung jawab tidak ditemukan', 'error');
            return redirect('/kelolaPJGudang');
        }
        try{
            DetailUserModel::destroy($id);
            Alert::toast('Data penanggung jawab berhasil dihapus', 'success');
            return redirect('/kelolaPJGudang');
        }catch(\Illuminate\Database\QueryException $e){
            Alert::toast('Data penanggung jawab gagal dihapus', 'error');
            return redirect('/kelolaPJGudang');
        }
    }
}
