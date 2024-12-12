@extends('layouts.template')
@section('title', 'Dashboard')
@section('content')
    <div class="row mb-2">
        <div class="col-md-4">
            <div class="card" style="height: auto;">
                <div class="card-body">
                    <h5 class="card-title">
                        Jumlah Transaksi Pakan Sesuai Tipe Transaksi
                    </h5>
                    <div class="card-body">
                        {!! $totalTransaksiPakanByTipeChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="height: auto;">
                <div class="card-body">
                    <h5 class="card-title">
                        Jumlah Transaksi Alat Sesuai Tipe Transaksi
                    </h5>
                    <div class="card-body">
                        {!! $totalTransaksiAlatByTipeChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card" style="height: auto">
                <div class="card-body">
                    <h5 class="card-title">
                        Jumlah Transaksi Obat Sesuai Tipe Transaksi
                    </h5>
                    <div class="card-body">
                        {!! $totalTransaksiObatByTipeChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row gy-3">
                <div class="col-6">
                    <div class="card m-0" style="height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title m-0">
                                <x-svg-icon icon="user" /> Total Pengguna
                            </h5>
                            <div class="card-body p-0 d-flex justify-content-center align-items-center">
                                <h1 style="font-size: 90px; font-weight: 900">{{ $totalPengguna }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card m-0" style="height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title m-0">
                                <x-svg-icon icon="gudang" /> Total Gudang
                            </h5>
                            <div class="card-body p-0 d-flex justify-content-center align-items-center">
                                <h1 style="font-size: 90px; font-weight: 900">{{ $totalGudang }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card m-0" style="height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title m-0">
                                <x-svg-icon icon="tambak" /> Total Tambak
                            </h5>
                            <div class="card-body p-0 d-flex justify-content-center align-items-center">
                                <h1 style="font-size: 90px; font-weight: 900">{{ $totalTambak }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card m-0" style="height: 200px;">
                        <div class="card-body">
                            <h5 class="card-title m-0">
                                <x-svg-icon icon="tambak" /> Total Kolam
                            </h5>
                            <div class="card-body p-0 d-flex justify-content-center align-items-center">
                                <h1 style="font-size: 90px; font-weight: 900">{{ $totalKolam }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" style="height: auto">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class='d-flex justify-content-between'>
                            <h5 class='card-title'>Jumlah Transaksi Pakan per Bulan</h5>
                            <div class="card-right d-flex align-items-center">
                                <form method="GET" action="{{ route('dashboard.index') }}" class="mb-4">
                                    <select name="tahunPakan" id="tahunPakan" class="form-select" style="width: 200px;"
                                        onchange="this.form.submit()">
                                        <option value="">- Semua Tahun -</option>
                                        @foreach ($yearsPakan as $yearPakan)
                                            <option value="{{ $yearPakan }}"
                                                {{ $yearPakan == session('tahunPakan') ? 'selected' : '' }}>
                                                {{ $yearPakan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div>
                            {!! $totalTransaksiPakanChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" style="height: auto">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class='d-flex justify-content-between'>
                            <h5 class='card-title'>Jumlah Transaksi Alat per Bulan</h5>
                            <div class="card-right d-flex align-items-center">
                                <form method="GET" action="{{ route('dashboard.index') }}" class="mb-4">
                                    <select name="tahunAlat" id="tahunAlat" class="form-select" style="width: 200px;"
                                        onchange="this.form.submit()">
                                        <option value="">- Semua Tahun -</option>
                                        @foreach ($yearsAlat as $yearAlat)
                                            <option value="{{ $yearAlat }}"
                                                {{ session('tahunAlat') == $yearAlat ? 'selected' : '' }}>
                                                {{ $yearAlat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div>
                            {!! $totalTransaksiAlatChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card" style="height: auto">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class='d-flex justify-content-between'>
                            <h5 class='card-title'>Jumlah Transaksi Obat per Bulan</h5>
                            <div class="card-right d-flex align-items-center">
                                <form method="GET" action="{{ route('dashboard.index') }}" class="mb-4">
                                    <select name="tahunObat" id="tahunObat" class="form-select" style="width: 200px;"
                                        onchange="this.form.submit()">
                                        <option value="">- Semua Tahun -</option>
                                        @foreach ($yearsObat as $yearObat)
                                            <option value="{{ $yearObat }}"
                                                {{ session('tahunObat') == $yearObat ? 'selected' : '' }}>
                                                {{ $yearObat }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div>
                            {!! $totalTransaksiObatChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {{ $totalTransaksiPakanChart->script() }}
    {{ $totalTransaksiAlatChart->script() }}
    {{ $totalTransaksiObatChart->script() }}
    {{ $totalTransaksiPakanByTipeChart->script() }}
    {{ $totalTransaksiAlatByTipeChart->script() }}
    {{ $totalTransaksiObatByTipeChart->script() }}
@endpush
