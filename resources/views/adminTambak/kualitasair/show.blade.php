@extends('layouts.template')
@section('title', 'Kualitas Air')
@section('content')

<div class="card">
    <div class="card-body">
    <div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-3">Detail Kualitas Air</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <p><strong>Kode Kualitas Air : </strong> {{ $kualitasairs->kd_kualitas_air }}</p>
            </div>
            <div class="col">
                <p><strong>Fase Kolam : </strong> {{ $kualitasairs->faseKolam->kd_fase_tambak ?? 'Fase tidak ditemukan' }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Tanggal Cek : </strong> {{ $kualitasairs->tanggal_cek }} </p>
            </div>
            <div class="col">
                <p><strong>waktu Cek : </strong> {{ $kualitasairs->waktu_cek }} </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>pH : </strong> {{ $kualitasairs->pH }}</p>
            </div>
            <div class="col">
                <p><strong>Salinitas : </strong> {{ $kualitasairs->salinitas }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>DO : </strong> {{ $kualitasairs->DO }}</p>
            </div>
            <div class="col">
                <p><strong>Suhu : </strong> {{ $kualitasairs->suhu }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Kejernihan Air : </strong> {{ $kualitasairs->kejernihan_air }}</p>
            </div>
            <div class="col">
                <p><strong>Warna Air : </strong> {{ $kualitasairs->warna_air }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Catatan : </strong> {{ $kualitasairs->catatan }}</p>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-danger"
                onclick="window.location.href='{{ route ('user.kualitasair.index') }}'"
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