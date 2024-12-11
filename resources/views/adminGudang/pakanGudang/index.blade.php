@extends('layouts.template')
@section('title', 'Data Pakan')
@section('content')
    <div class="card">
        <div class="card-header">Data Pakan</div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @foreach ($pakanGudang as $detailPakan)
                        @php
                            $totalHarga = $detailPakan->stok_pakan * $detailPakan->pakan->harga_satuan;
                        @endphp
                        <div class="col-md-6 mb-4">
                            <div class="card border border-primary" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/' . $detailPakan->pakan->foto) }}" alt="Foto Pakan"
                                            class="img-fluid mx-2 my-2 border" style="width: auto; height: 30vh;">
                                    </div>
                                    <div class="col-md-8 d-flex flex-column">
                                        <div class="card-body flex-grow-1">
                                            <h5 class="card-title">{{ $detailPakan->pakan->nama }}</h5>
                                            <p class="card-text m-0">Gudang : {{ $detailPakan->gudang->nama }}</p>
                                            <p class="card-text m-0">Harga : Rp
                                                {{ number_format($detailPakan->pakan->harga_satuan, 0, ',', '.') }} per
                                                {{ $detailPakan->pakan->satuan }}
                                            </p>
                                            <p class="card-text m-0">Sisa stok :
                                                {{ number_format($detailPakan->stok_pakan, 0, ',', '.') }}
                                            </p>
                                            <p class="card-text">Total Harga :
                                                Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                            </p>
                                            <p class="card-text">
                                                <small class="text-body-secondary">
                                                    Terakhir Diperbarui :
                                                    {{ \Carbon\Carbon::parse($detailPakan->updated_at)->translatedFormat('l, j F Y') }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary mt-auto rounded-0"
                                    onclick="window.location.href='{{ route('user.transaksiPakan.create', ['id_detail_pakan' => $detailPakan->id_detail_pakan]) }}'">
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
