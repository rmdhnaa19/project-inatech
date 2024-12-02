@extends('layouts.template')
@section('title', 'Kelola Transaksi Pakan')
@section('content')
    <div class="card">
        <div class="card-header">Data Transaksi Pakan</div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @foreach ($pakanGudang as $detailPakan)
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
                                            <p class="card-text m-0">{{ $detailPakan->pakan->deskripsi }}</p>
                                            <p class="card-text m-0">Rp
                                                {{ number_format($detailPakan->pakan->harga_satuan, 0, ',', '.') }} per
                                                {{ $detailPakan->pakan->satuan }}
                                            </p>
                                            <p class="card-text">Sisa stok
                                                {{ number_format($detailPakan->stok_pakan, 0, ',', '.') }}
                                            </p>
                                            <p class="card-text">
                                                <small class="text-body-secondary">
                                                    Last updated
                                                    {{ \Carbon\Carbon::parse($detailPakan->updated_at)->translatedFormat('l, j F Y') }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary mt-auto rounded-0"
                                    onclick="window.location.href='{{ route('user.TransaksiPakan.create', ['id_detail_pakan' => $detailPakan->id_detail_pakan]) }}'">
                                    Tambah
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
