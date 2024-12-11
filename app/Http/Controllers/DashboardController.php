<?php

namespace App\Http\Controllers;

use App\Models\TransaksiAlatModel;
use App\Models\TransaksiObatModel;
use App\Models\TransaksiPakanModel;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        if (auth()->user()->id_role == 1) {
            $allMonths = collect(range(1, 12))->mapWithKeys(function ($bulan) {
                return [$bulan => date("F", mktime(0, 0, 0, $bulan, 10))];
            });
            
            // Total Transaksi Pakan Per Bulan
            $tahunPakan = $request->input('tahunPakan', date('Y'));
            $totalTransaksiPakanPerBulan = TransaksiPakanModel::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )->whereYear('created_at', $tahunPakan)->groupBy('bulan')->orderBy('bulan')->get()->pluck('total', 'bulan');
            $labelTransaksiPakan = $allMonths->values();
            $dataTransaksiPakan = $allMonths->keys()->map(function ($bulan) use ($totalTransaksiPakanPerBulan) {
                return $totalTransaksiPakanPerBulan->get($bulan, 0); // Default 0 jika tidak ada transaksi di bulan tersebut
            });
            $totalTransaksiPakanChart = (new LarapexChart)
                ->lineChart()
                ->addData('Total Transaksi', $dataTransaksiPakan->toArray())
                ->setHeight(300)
                ->setXAxis($labelTransaksiPakan->toArray());
            $yearsPakan = TransaksiPakanModel::selectRaw('YEAR(created_at) as tahunPakan')->distinct()->pluck('tahunPakan');

            // Total Transaksi Alat Per Bulan
            $tahunAlat = $request->input('tahunAlat', date('Y'));
            $totalTransaksiAlatPerBulan = TransaksiAlatModel::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )->whereYear('created_at', $tahunAlat)->groupBy('bulan')->orderBy('bulan')->get()->pluck('total', 'bulan');
            $labelTransaksiAlat = $allMonths->values();
            $dataTransaksiAlat = $allMonths->keys()->map(function ($bulan) use ($totalTransaksiAlatPerBulan) {
                return $totalTransaksiAlatPerBulan->get($bulan, 0); // Default 0 jika tidak ada transaksi di bulan tersebut
            });
            $totalTransaksiAlatChart = (new LarapexChart)
                ->barChart()
                ->addData('Total Transaksi', $dataTransaksiAlat->toArray())
                ->setHeight(300)
                ->setXAxis($labelTransaksiAlat->toArray());
            $yearsAlat = TransaksiAlatModel::selectRaw('YEAR(created_at) as tahunAlat')->distinct()->pluck('tahunAlat');

            // Total Transaksi Alat Per Bulan
            $tahunObat = $request->input('tahunObat', date('Y'));
            $totalTransaksiObatPerBulan = TransaksiObatModel::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )->whereYear('created_at', $tahunObat)->groupBy('bulan')->orderBy('bulan')->get()->pluck('total', 'bulan');
            $labelTransaksiObat = $allMonths->values();
            $dataTransaksiObat = $allMonths->keys()->map(function ($bulan) use ($totalTransaksiObatPerBulan) {
                return $totalTransaksiObatPerBulan->get($bulan, 0); // Default 0 jika tidak ada transaksi di bulan tersebut
            });
            $totalTransaksiObatChart = (new LarapexChart)
                ->lineChart()
                ->addData('Total Transaksi', $dataTransaksiObat->toArray())
                ->setHeight(300)
                ->setXAxis($labelTransaksiObat->toArray());
            $yearsObat = TransaksiObatModel::selectRaw('YEAR(created_at) as tahunObat')->distinct()->pluck('tahunObat');

            return view('dashboard.index', compact(
                'breadcrumb', 
                'activeMenu', 
                'totalTransaksiPakanChart', 'totalTransaksiPakanPerBulan', 'yearsPakan', 'tahunPakan', 
                'totalTransaksiAlatChart', 'totalTransaksiAlatPerBulan', 'yearsAlat', 'tahunAlat',
                'totalTransaksiObatChart', 'totalTransaksiObatPerBulan', 'yearsObat', 'tahunObat'
            ));
        }elseif (auth()->user()->id_role == 2) {
            
        }
    }
}
