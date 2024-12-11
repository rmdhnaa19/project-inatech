<?php

namespace App\Http\Controllers;

use App\Models\FaseKolamModel;
use App\Models\KolamModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class FaseKolamController extends Controller
{
    public function index()
    {
    if (auth()->user()->id_role == 1) {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Fase Kolam',
            'paragraph' => 'Berikut ini merupakan data fase kolam yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.fasekolam.index')],
                ['label' => 'Manajemen Fase Kolam'],
            ]
        ];
        $activeMenu = 'fasekolam';
        $kolam = KolamModel::all();
        return view('admin.fasekolam.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kolam' => $kolam]);
    }elseif (auth()->user()->id_role == 3) {
        $breadcrumb = (object) [
            'title' => 'Data Fase Kolam',
            'paragraph' => 'Berikut ini merupakan data fase kolam yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('user.fasekolam.index')],
                ['label' => 'Data Fase Kolam'],
            ]
        ];
        $activeMenu = 'fasekolam';
        $user = Auth::user();
        $tambakIds = $user->userTambak->pluck('id_tambak'); // Ambil semua id_tambak
        $kolam = KolamModel::whereIn('id_tambak', $tambakIds)->get();
        return view('adminTambak.fasekolam.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kolam' => $kolam, 'user' => $user, 'tambakIds' => $tambakIds]);
    }
}
    

    public function list(Request $request)
    {
        if (auth()->user()->id_role == 1) {
            $fasekolams = FaseKolamModel::select('id_fase_tambak', 'kd_fase_tambak', 'tanggal_mulai', 'tanggal_panen', 'jumlah_tebar', 'densitas', 'id_kolam', 'created_at', 'updated_at')->with('kolam');  
            if ($request->id_kolam) {
                $fasekolams->where('id_kolam', $request->id_kolam);
            }
            return DataTables::of($fasekolams)
            ->make(true);
        }elseif (auth()->user()->id_role == 3) {
            $user = Auth::user();
$tambakIds = $user->userTambak->pluck('id_tambak'); // Ambil ID tambak milik user

// Query fase kolam berdasarkan id_tambak milik user yang sedang login
$fasekolams = FaseKolamModel::select('id_fase_tambak', 'kd_fase_tambak', 'tanggal_mulai', 'tanggal_panen', 'jumlah_tebar', 'densitas', 'id_kolam', 'created_at', 'updated_at')
    ->with(['kolam' => function($query) use ($tambakIds) {
        // Hanya muat kolam yang memiliki id_tambak yang sesuai dengan milik user
        $query->whereIn('id_tambak', $tambakIds);
    }])
    ->whereIn('id_kolam', function($query) use ($tambakIds) {
        // Pastikan hanya ambil fase kolam yang terkait dengan id_tambak milik user
        $query->select('id_kolam')->from('kolam')->whereIn('id_tambak', $tambakIds);
    })
    ->get();

            if ($request->id_kolam) {
                $fasekolams->where('id_kolam', $request->id_kolam);
            }
            return DataTables::of($fasekolams)
            ->make(true);
        }
    }


    public function create(Request $request){
        if (auth()->user()->id_role == 1) {
        $breadcrumb = (object) [
            'title' => 'Tambah Data Fase Kolam',
            'paragraph' => 'Berikut ini merupakan form tambah data fase kolam yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Manajemen Fase Kolam', 'url' => route('admin.fasekolam.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'fasekolam';
        $kolam = KolamModel::all();
        return view('admin.fasekolam.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kolam' => $kolam]);

    }elseif (auth()->user()->id_role == 3) {
        $breadcrumb = (object) [
            'title' => 'Tambah Data Fase Kolam',
            'paragraph' => 'Berikut ini merupakan form tambah data fase kolam yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'fasekolam';
        $user = Auth::user();
        $kolam = KolamModel::with(['tambak'])->get();
        $selectedIdkolam = $request->input('id_kolam'); // Ambil ID dari URL
        return view('adminTambak.faseKolam.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kolam' => $kolam, 'selectedIdkolam' => $selectedIdkolam]);
    }
    }

    public function store(Request $request)
    {
            $validatedData = $request->validate([
            'kd_fase_tambak' => 'required|string|unique:fase_tambak,kd_fase_tambak',
            'tanggal_mulai' => 'required|date',
            'tanggal_panen' => 'required|date',
            'jumlah_tebar' => 'required|integer',
            'densitas' => 'required|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
            'id_kolam' => 'required|string',                 
        ]);

    if ($request->hasFile('foto')) {
        $path = $request->file('foto')->store('foto_fase_kolam', 'public'); 
        $validatedData['foto'] = $path;
    }

    // Simpan data ke database
    FaseKolamModel::create($validatedData);
    if (auth()->user()->id_role == 1) {
        Alert::toast('Data Fase Kolam berhasil ditambahkan', 'success'); 
        return redirect()->route('admin.fasekolam.index')->with('success', 'Data fase kolam berhasil ditambahkan');
    }elseif (auth()->user()->id_role == 3) {
        Alert::toast('Data Fase Kolam berhasil ditambahkan', 'success'); 
        return redirect()->route('user.fasekolam.index')->with('success', 'Data fase kolam berhasil ditambahkan');
    }
    }


    public function show($id)
    {
        if (auth()->user()->id_role == 1) {
            $fasekolam = FaseKolamModel::with('kolam')->find($id); // Ambil data fase kolam dengan relasi kolam
            if (!$fasekolam) {
                return response()->json(['error' => ' Fase kolam tidak ditemukan.'], 404);
            }
            // Render view dengan data 
            $view = view('admin.fasekolam.show', compact('fasekolam'))->render();
            return response()->json(['html' => $view]);
        }elseif (auth()->user()->id_role == 3) {
            $fasekolam = FaseKolamModel::with('kolam')->find($id); // Ambil data fase kolam dengan relasi kolam
            if (!$fasekolam) {
                return response()->json(['error' => ' Fase kolam tidak ditemukan.'], 404);
            }
            // Render view dengan data 
            $view = view('adminTambak.fasekolam.show', compact('fasekolam'))->render();
            return response()->json(['html' => $view]);
        }
    }


    public function edit($id)
    {
        $fasekolam = FaseKolamModel::find($id);
        $kolam = KolamModel::all();
        
        if (!$fasekolam) {
        return redirect()->route('admin.fasekolam.index')->with('error', 'Fase Kolam tidak ditemukan');
    }
    
    $breadcrumb = (object) [
        'title' => 'Edit Data Fase Kolam',
        'paragraph' => 'Berikut ini merupakan form edit data fase kolam yang ada di dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Kelola Fase Kolam', 'url' => route('admin.fasekolam.index')],
            ['label' => 'Edit'],
        ]
    ];

    $activeMenu = 'fasekolam';
    return view('admin.fasekolam.edit', compact('fasekolam', 'kolam', 'breadcrumb', 'activeMenu'));
    }


    public function update(Request $request, string $id) {
    
    $request->validate([
        'kd_fase_tambak' => 'required|string|unique:fase_tambak,kd_fase_tambak,' . $id . ',id_fase_tambak',
        'tanggal_mulai' => 'required|string',
        'tanggal_panen' => 'required|string',
        'jumlah_tebar' => 'required|integer',
        'densitas' => 'required|integer',
        'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        'id_kolam' => 'required|integer',
    ]);

    $fasekolam = FaseKolamModel::find($id);

    if ($request->file('foto') == '') {
        $fasekolam->update([
            'kd_fase_tambak' => $request->kd_fase_tambak,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_panen' => $request->tanggal_panen,
            'jumlah_tebar' => $request->jumlah_tebar,
            'densitas' => $request->densitas,
            'id_kolam' => $request->id_kolam,
    ]);
    }else{
        Storage::disk('public')->delete($request->oldImage);
        $foto = $request->file('foto');
        $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
        $path = Storage::disk('public')->putFileAs('foto_fasekolam', $foto, $namaFoto);
        $updateFoto['foto'] = $path;

    $fasekolam->update([
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_panen' => $request->tanggal_panen,
            'jumlah_tebar' => $request->jumlah_tebar,
            'densitas' => $request->densitas,
            'id_kolam' => $request->id_kolam,
            'foto' => $updateFoto['foto']
        ]);
    }
        Alert::toast('Data Fase Kolam berhasil diubah', 'success');   
        return redirect()->route('admin.fasekolam.index');
    }

    public function destroy($id)
    {
        $fasekolam = FaseKolamModel::find($id);
        if (!$fasekolam) {
            return response()->json([
                'success' => false,
                'message' => 'Data fase kolam tidak ditemukan.'
            ], 404);
        }
    
        try {
            if ($fasekolam->gambar) {
                Storage::disk('public')->delete($fasekolam->gambar);
            }
            $fasekolam->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Data fase kolam berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus fase kolam: ' . $e->getMessage()
            ], 500);
        }
    }
}    

