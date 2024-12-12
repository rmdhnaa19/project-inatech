<?php

namespace App\Http\Controllers;

use App\Models\GudangModel;
use App\Models\KolamModel;
use App\Models\TambakModel;
use App\Models\TransaksiAlatModel;
use App\Models\TransaksiObatModel;
use App\Models\TransaksiPakanModel;
use App\Models\UserModel;
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

        $allMonths = collect([
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ]);

        // Transaksi Pakan by Tipe Transaksi
        $dataTransaksiPakanByTipe = TransaksiPakanModel::select(
            'tipe_transaksi',
            DB::raw('COUNT(*) as total')
        )->groupBy('tipe_transaksi')
        ->get();
        $labelsTransaksiPakanByTipe = $dataTransaksiPakanByTipe->pluck('tipe_transaksi')->toArray();
        $datasTransaksiPakanByTipe = $dataTransaksiPakanByTipe->pluck('total')->toArray();
        $totalTransaksiPakanByTipeChart = (new LarapexChart)
            ->pieChart()
            ->addData($datasTransaksiPakanByTipe)
            ->setLabels($labelsTransaksiPakanByTipe)
            ->setHeight(200)
            ->setWidth(300);

        // Transaksi Alat by Tipe Transaksi
        $dataTransaksiAlatByTipe = TransaksiAlatModel::select(
            'tipe_transaksi',
            DB::raw('COUNT(*) as total')
        )->groupBy('tipe_transaksi')
        ->get();
        $labelsTransaksiAlatByTipe = $dataTransaksiAlatByTipe->pluck('tipe_transaksi')->toArray();
        $datasTransaksiAlatByTipe = $dataTransaksiAlatByTipe->pluck('total')->toArray();
        $totalTransaksiAlatByTipeChart = (new LarapexChart)
            ->pieChart()
            ->addData($datasTransaksiAlatByTipe)
            ->setLabels($labelsTransaksiAlatByTipe)
            ->setHeight(200)
            ->setWidth(275);

        // Transaksi Obat by Tipe Transaksi
        $dataTransaksiObatByTipe = TransaksiObatModel::select(
            'tipe_transaksi',
            DB::raw('COUNT(*) as total')
        )->groupBy('tipe_transaksi')
        ->get();
        $labelsTransaksiObatByTipe = $dataTransaksiObatByTipe->pluck('tipe_transaksi')->toArray();
        $datasTransaksiObatByTipe = $dataTransaksiObatByTipe->pluck('total')->toArray();
        $totalTransaksiObatByTipeChart = (new LarapexChart)
            ->pieChart()
            ->addData($datasTransaksiObatByTipe)
            ->setLabels($labelsTransaksiObatByTipe)
            ->setHeight(200)
            ->setWidth(300);

        // Total Pengguna, Gudang, Tambak, Kolam
        $totalPengguna = UserModel::count();
        $totalGudang = GudangModel::count();
        $totalTambak = TambakModel::count();
        $totalKolam = KolamModel::count();
            
        // Total Transaksi Pakan Per Bulan
        $tahunPakan = $request->input('tahunPakan', session('tahunPakan', null));
        session(['tahunPakan' => $tahunPakan]);
        $totalTransaksiPakanPerBulan = TransaksiPakanModel::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )->when($tahunPakan, function ($query, $tahunPakan) {
            if ($tahunPakan !== null) {
                return $query->whereYear('created_at', $tahunPakan);
            }
            return $query;
        })->groupBy('bulan')->orderBy('bulan')->get()->pluck('total', 'bulan');
        $labelTransaksiPakan = $allMonths->values();
        $dataTransaksiPakan = $allMonths->keys()->map(function ($bulan) use ($totalTransaksiPakanPerBulan) {
            return $totalTransaksiPakanPerBulan->get($bulan, 0);
        });
        $totalTransaksiPakanChart = (new LarapexChart)
            ->lineChart()
            ->addData('Total Transaksi', $dataTransaksiPakan->toArray())
            ->setHeight(300)
            ->setXAxis($labelTransaksiPakan->toArray());
        $yearsPakan = TransaksiPakanModel::selectRaw('YEAR(created_at) as tahunPakan')->distinct()->pluck('tahunPakan');

        // Total Transaksi Alat Per Bulan
        $tahunAlat = $request->input('tahunAlat', session('tahunAlat', null));
        session(['tahunAlat' => $tahunAlat]);
        $totalTransaksiAlatPerBulan = TransaksiAlatModel::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )->when($tahunAlat, function ($query, $tahunAlat){
            if ($tahunAlat !== null) {
                return $query->whereYear('created_at', $tahunAlat);
            }
            return $query;
        })->groupBy('bulan')->orderBy('bulan')->get()->pluck('total', 'bulan');
        $labelTransaksiAlat = $allMonths->values();
        $dataTransaksiAlat = $allMonths->keys()->map(function ($bulan) use ($totalTransaksiAlatPerBulan) {
            return $totalTransaksiAlatPerBulan->get($bulan, 0);
        });
        $totalTransaksiAlatChart = (new LarapexChart)
            ->lineChart()
            ->addData('Total Transaksi', $dataTransaksiAlat->toArray())
            ->setHeight(300)
            ->setXAxis($labelTransaksiAlat->toArray());
        $yearsAlat = TransaksiAlatModel::selectRaw('YEAR(created_at) as tahunAlat')->distinct()->pluck('tahunAlat');

        // Total Transaksi Alat Per Bulan
        $tahunObat = $request->input('tahunObat', session('tahunObat', null));
        session(['tahunObat' => $tahunObat]);
        $totalTransaksiObatPerBulan = TransaksiObatModel::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )->when($tahunObat, function ($query, $tahunObat){
            if ($tahunObat !== null) {
                return $query->whereYear('created_at', $tahunObat);
            }
            return $query;
        })->groupBy('bulan')->orderBy('bulan')->get()->pluck('total', 'bulan');
        $labelTransaksiObat = $allMonths->values();
        $dataTransaksiObat = $allMonths->keys()->map(function ($bulan) use ($totalTransaksiObatPerBulan) {
            return $totalTransaksiObatPerBulan->get($bulan, 0); 
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
            'totalTransaksiPakanByTipeChart',
            'totalTransaksiAlatByTipeChart',
            'totalTransaksiObatByTipeChart',
            'totalTransaksiPakanChart', 'totalTransaksiPakanPerBulan', 'yearsPakan', 'tahunPakan', 
            'totalTransaksiAlatChart', 'totalTransaksiAlatPerBulan', 'yearsAlat', 'tahunAlat',
            'totalTransaksiObatChart', 'totalTransaksiObatPerBulan', 'yearsObat', 'tahunObat',
            'totalPengguna', 'totalGudang', 'totalTambak', 'totalKolam',
        ));
    }
}
