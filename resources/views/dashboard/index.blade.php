@extends('layouts.template')
@section('title', 'Dashboard')
@section('content')
    <div class="row mb-2">
        <div class="col-md-6">
            <div class="card" style="height: auto">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class='d-flex justify-content-between'>
                            <h3 class='card-title'>Jumlah Transaksi Pakan per Bulan Tahun {{ $tahunPakan }}</h3>
                            <div class="card-right d-flex align-items-center">
                                <form method="GET" action="{{ route('dashboard.index') }}" class="mb-4">
                                    <select name="tahunPakan" id="tahunPakan" class="form-select" style="width: 200px;"
                                        onchange="this.form.submit()">
                                        @foreach ($yearsPakan as $yearPakan)
                                            <option value="{{ $yearPakan }}"
                                                {{ $tahunPakan == $yearPakan ? 'selected' : '' }}>
                                                {{ $yearPakan }}</option>
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
                            <h3 class='card-title'>Jumlah Transaksi Alat per Bulan Tahun {{ $tahunAlat }}</h3>
                            <div class="card-right d-flex align-items-center">
                                <form method="GET" action="{{ route('dashboard.index') }}" class="mb-4">
                                    <select name="tahunAlat" id="tahunAlat" class="form-select" style="width: 200px;"
                                        onchange="this.form.submit()">
                                        @foreach ($yearsAlat as $yearAlat)
                                            <option value="{{ $yearAlat }}"
                                                {{ $tahunAlat == $yearAlat ? 'selected' : '' }}>
                                                {{ $yearAlat }}</option>
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
                            <h3 class='card-title'>Jumlah Transaksi Obat per Bulan Tahun {{ $tahunObat }}</h3>
                            <div class="card-right d-flex align-items-center">
                                <form method="GET" action="{{ route('dashboard.index') }}" class="mb-4">
                                    <select name="tahunObat" id="tahunObat" class="form-select" style="width: 200px;"
                                        onchange="this.form.submit()">
                                        @foreach ($yearsObat as $yearObat)
                                            <option value="{{ $yearObat }}"
                                                {{ $tahunObat == $yearObat ? 'selected' : '' }}>
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
@endpush
