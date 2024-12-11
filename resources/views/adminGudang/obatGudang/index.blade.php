@extends('layouts.template')
@section('title', 'Data Obat')
@section('content')
    <div class="card">
        <div class="card-header">Data Obat</div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @foreach ($obatGudang as $detailObat)
                        @php
                            $totalHarga = $detailObat->stok_obat * $detailObat->obat->harga_satuan;
                        @endphp
                        <div class="col-md-6 mb-4">
                            <div class="card border border-primary" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/' . $detailObat->obat->foto) }}" alt="Foto Obat"
                                            class="img-fluid mx-2 my-2 border" style="width: auto; height: 30vh;">
                                    </div>
                                    <div class="col-md-8 d-flex flex-column">
                                        <div class="card-body flex-grow-1">
                                            <h5 class="card-title">{{ $detailObat->obat->nama }}</h5>
                                            <p class="card-text m-0">Gudang : {{ $detailObat->gudang->nama }}</p>
                                            <p class="card-text m-0">Harga : Rp
                                                {{ number_format($detailObat->obat->harga_satuan, 0, ',', '.') }} per
                                                {{ $detailObat->obat->satuan }}
                                            </p>
                                            <p class="card-text m-0">Sisa stok :
                                                {{ number_format($detailObat->stok_obat, 0, ',', '.') }}
                                            </p>
                                            <p class="card-text">Total Harga :
                                                Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                            </p>
                                            <p class="card-text">
                                                <small class="text-body-secondary">
                                                    Terakhir Diperbarui :
                                                    {{ \Carbon\Carbon::parse($detailObat->updated_at)->translatedFormat('l, j F Y') }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary mt-auto rounded-0"
                                    onclick="window.location.href='{{ route('user.transaksiObat.create', ['id_detail_obat' => $detailObat->id_detail_obat]) }}'">
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
