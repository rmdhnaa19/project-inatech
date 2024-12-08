@extends('layouts.template')
@section('title', 'Data Obat')
@section('content')
    <div class="card">
        <div class="card-header">Data Obat</div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @foreach ($alatGudang as $detailAlat)
                        <div class="col-md-6 mb-4">
                            <div class="card border border-primary" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/' . $detailAlat->alat->foto) }}" alt="Foto Alat"
                                            class="img-fluid mx-2 my-2 border" style="width: auto; height: 30vh;">
                                    </div>
                                    <div class="col-md-8 d-flex flex-column">
                                        <div class="card-body flex-grow-1">
                                            <h5 class="card-title">{{ $detailAlat->alat->nama }}</h5>
                                            <p class="card-text m-0">Deskripsi : {{ $detailAlat->alat->deskripsi }}</p>
                                            <p class="card-text m-0">Harga : Rp
                                                {{ number_format($detailAlat->alat->harga_satuan, 0, ',', '.') }} per
                                                {{ $detailAlat->alat->satuan }}
                                            </p>
                                            <p class="card-text">Sisa stok :
                                                {{ number_format($detailAlat->stok_alat, 0, ',', '.') }}
                                            </p>
                                            <p class="card-text">
                                                <small class="text-body-secondary">
                                                    Terakhir Diperbarui :
                                                    {{ \Carbon\Carbon::parse($detailAlat->updated_at)->translatedFormat('l, j F Y') }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary mt-auto rounded-0"
                                    onclick="window.location.href='{{ route('user.transaksiAlat.create', ['id_detail_alat' => $detailAlat->id_detail_alat]) }}'">
                                    Tambah Transaksi
                                </button>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush
@extends('layouts.template')
@section('title', 'Transaksi Alat')
@section('content')
    <div class="card">
        <div class="card-header">Data Alat</div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @foreach ($alatGudang as $detailAlat)
                        <div class="col-md-6 mb-4">
                            <div class="card border border-primary" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/' . $detailAlat->alat->foto) }}" alt="Foto Alat"
                                            class="img-fluid mx-2 my-2 border" style="width: auto; height: 30vh;">
                                    </div>
                                    <div class="col-md-8 d-flex flex-column">
                                        <div class="card-body flex-grow-1">
                                            <h5 class="card-title">{{ $detailAlat->alat->nama }}</h5>
                                            <p class="card-text m-0">Deskripsi : {{ $detailAlat->alat->deskripsi }}</p>
                                            <p class="card-text m-0">Harga : Rp
                                                {{ number_format($detailAlat->alat->harga_satuan, 0, ',', '.') }} per
                                                {{ $detailAlat->alat->satuan }}
                                            </p>
                                            <p class="card-text">Sisa stok :
                                                {{ number_format($detailAlat->stok_alat, 0, ',', '.') }}
                                            </p>
                                            <p class="card-text">
                                                <small class="text-body-secondary">
                                                    Terakhir Diperbarui :
                                                    {{ \Carbon\Carbon::parse($detailAlat->updated_at)->translatedFormat('l, j F Y') }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary mt-auto rounded-0"
                                    onclick="window.location.href='{{ route('user.transaksiAlat.create', ['id_detail_alat' => $detailAlat->id_detail_alat]) }}'">
                                    Tambah Transaksi
                                </button>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush
