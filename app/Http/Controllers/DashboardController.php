<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPakanModel;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index(Request $request) {
        if (auth()->user()->id_role == 1) {
            $breadcrumb = (object) [
                'title' => 'Dashboard',
                'paragraph' => 'Berikut ini merupakan visualisasi data yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home'],
                ]
            ];
            $activeMenu = 'dashboardAdmin';
            $totalTransaksiPerBulan = TransaksiPakanModel::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

            $labels = $totalTransaksiPerBulan->pluck('bulan')->map(function ($bulan) {
                return date("F", mktime(0, 0, 0, $bulan, 10)); // Mengubah angka bulan menjadi nama bulan
            });
            $data = $totalTransaksiPerBulan->pluck('total');
 
            $totalTransaksiPakanChart = (new LarapexChart)
                ->lineChart()
                ->addData('Total Transaksi', $data->toArray())
                ->setXAxis($labels->toArray());
            return view('admin.dashboard.index', compact('breadcrumb', 'activeMenu', 'totalTransaksiPakanChart', 'totalTransaksiPerBulan'));
        }elseif (auth()->user()->id_role == 2) {
            $breadcrumb = (object) [
                'title' => 'Dashboard',
                'paragraph' => 'Berikut ini merupakan visualisasi data yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home'],
                ]
            ];
            $activeMenu = 'dashboardUserGudang';
            $balanceChart = (new LarapexChart)
                ->lineChart()
                ->addData('Balance', [10, 20, 30, 40, 50])
                ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May']);
    
            $revenueChart = (new LarapexChart)
                ->lineChart()
                ->addData('Revenue', [50, 100, 150, 200, 250])
                ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May']);
    
            $ordersChart = (new LarapexChart)
                ->lineChart()
                ->addData('Orders', [300, 400, 500, 600, 700])
                ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May']);
    
            $salesTodayChart = (new LarapexChart)
                ->lineChart()
                ->addData('Sales Today', [10, 15, 20, 25, 30])
                ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May']);

            return view('adminGudang.dashboard.index', compact('breadcrumb', 'activeMenu', 'balanceChart', 'revenueChart', 'ordersChart', 'salesTodayChart'));
        }elseif (auth()->user()->id_role == 3) {
            $breadcrumb = (object) [
                'title' => 'Dashboard',
                'paragraph' => 'Berikut ini merupakan visualisasi data yang terinput ke dalam sistem',
                'list' => [
                    ['label' => 'Home'],
                ]
            ];
            $activeMenu = 'dashboardUserTambak';

            $balanceChart = (new LarapexChart)
                ->lineChart()
                ->addData('Balance', [10, 20, 30, 40, 50])
                ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May']);
    
            $revenueChart = (new LarapexChart)
                ->lineChart()
                ->addData('Revenue', [50, 100, 150, 200, 250])
                ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May']);
    
            $ordersChart = (new LarapexChart)
                ->lineChart()
                ->addData('Orders', [300, 400, 500, 600, 700])
                ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May']);
    
            $salesTodayChart = (new LarapexChart)
                ->lineChart()
                ->addData('Sales Today', [10, 15, 20, 25, 30])
                ->setXAxis(['Jan', 'Feb', 'Mar', 'Apr', 'May']);
                
            return view('adminTambak.dashboard.index', compact('breadcrumb', 'activeMenu', 'balanceChart', 'revenueChart', 'ordersChart', 'salesTodayChart'));
        }
    }
}
