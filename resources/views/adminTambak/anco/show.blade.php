@extends('layouts.template')
@section('title', 'Anco')
@section('content')

<div class="card">
    <div class="card-body">
    <div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-3">Detail Anco</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <p><strong>Kode Anco : </strong> {{ $anco->kd_anco }}</p>
            </div>
            <div class="col">
                <p><strong>Fase Kolam : </strong> {{ $anco->faseKolam->kd_fase_tambak ?? 'Fase tidak ditemukan' }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Tanggal Cek : </strong> {{ $anco->tanggal_cek }} </p>
            </div>
            <div class="col">
                <p><strong>waktu Cek : </strong> {{ $anco->waktu_cek }} </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Pemberian Pakan : </strong> {{ $anco->pemberian_pakan }}</p>
            </div>
            <div class="col">
                <p><strong>Jam Pemberian Pakan : </strong> {{ $anco->jamPemberian_pakan }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Kondisi Pakan : </strong> {{ $anco->kondisi_pakan }}</p>
            </div>
            <div class="col">
                <p><strong>Kondisi Udang : </strong> {{ $anco->kondisi_udang }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Catatan : </strong> {{ $anco->catatan }}</p>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-danger"
                onclick="window.location.href='{{ route ('user.anco.index') }}'"
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