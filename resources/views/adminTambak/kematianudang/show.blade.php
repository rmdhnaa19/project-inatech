@extends('layouts.template')
@section('title', 'Anco')
@section('content')

<div class="card">
    <div class="card-body">
    <div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-3">Detail Kematian Udang</h4>
        <img src="{{ asset('storage/' . $kematianudangs->gambar) }}" alt="gambar" class="img-fluid"
            style="max-height: 200px; width: auto;">
    </div>
    <div class="container">
        <!-- <div class="row">
            <div class="col">
                <p><strong>Gambar : </strong> {{ $kematianudangs->gambar }}</p>
            </div>
        </div> -->
        <div class="row">
            <div class="col">
                <p><strong>Kode Kematian Udang : </strong> {{ $kematianudangs->kd_kematian_udang }}</p>
            </div>
            <div class="col">
                <p><strong>Fase Kolam : </strong> {{ $kematianudangs->faseKolam->kd_fase_tambak ?? 'Fase tidak ditemukan' }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Size Udang : </strong> {{ $kematianudangs->size_udang }} </p>
            </div>
            <div class="col">
                <p><strong>Berat Udang : </strong> {{ $kematianudangs->berat_udang }} </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Catatan : </strong> {{ $kematianudangs->catatan }}</p>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-danger"
                onclick="window.location.href='{{ route ('user.kematianudang.index') }}'"
                style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali
        </button>
    </div>
</div>

    </div>
</div>

@endsection
@push('css')
@endpush
@push('js')
@endpush