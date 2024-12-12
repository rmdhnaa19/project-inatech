@extends('layouts.template')
@section('title', 'Sampling')
@section('content')

<div class="card">
    <div class="card-body">
    <div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-3">Detail Sampling</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <p><strong>Kode Sampling : </strong> {{ $samplings->kd_sampling }}</p>
            </div>
            <div class="col">
                <p><strong>Fase Kolam : </strong> {{ $samplings->faseKolam->kd_fase_tambak ?? 'Fase tidak ditemukan' }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Tanggal Cek : </strong> {{ $samplings->tanggal_cek }} </p>
            </div>
            <div class="col">
                <p><strong>Waktu Cek : </strong> {{ $samplings->waktu_cek }} </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>DOC : </strong> {{ $samplings->DOC }}</p>
            </div>
            <div class="col">
                <p><strong>Berat Udang : </strong> {{ $samplings->berat_udang }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Size Udang : </strong> {{ $samplings->size_udang }}</p>
            </div>
            <div class="col">
                <p><strong>Harga Udang : </strong> {{ $samplings->harga_udang }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Interval Hari : </strong> {{ $samplings->interval_hari }}</p>
            </div>
            <div class="col">
                <p><strong>Input FR : </strong> {{ $samplings->input_fr }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Total Pakan : </strong> {{ $samplings->total_pakan }}</p>
            </div>
            <div class="col">
                <p><strong>ADG Udang : </strong> {{ $samplings->ADG_udang }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Biomassa : </strong> {{ $samplings->biomassa }}</p>
            </div>
            <div class="col">
                <p><strong>Populasi Ekor : </strong> {{ $samplings->populasi_ekor }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Catatan : </strong> {{ $samplings->catatan }}</p>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-danger"
                onclick="window.location.href='{{ route ('user.sampling.index') }}'"
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