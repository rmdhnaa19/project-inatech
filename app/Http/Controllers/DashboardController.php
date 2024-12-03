<?php

namespace App\Http\Controllers;

use App\Models\DetailPakanModel;
use App\Models\GudangModel;
use Illuminate\Http\Request;

class DashboardController extends Controller {
    public function index(Request $request) {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'paragraph' => 'Berikut ini merupakan visualisasi data yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home'],
            ]
        ];
        $activeMenu = 'dashboard';

        $pakanGudang = DetailPakanModel::select(
            'id_pakan',
            'id_gudang',
            'stok_pakan'
        )->get();

        // Format data untuk ApexCharts
        $chartData = [
            'categories' => $pakanGudang->map(fn($d) => "{$d->id_pakan} - {$d->id_gudang}"),
            'data' => $pakanGudang->pluck('stok_pakan'),
        ];

        // Kirim data ke view
        return view('dashboard.index', compact('breadcrumb', 'activeMenu', 'pakanGudang', 'chartData'));
    }
}
