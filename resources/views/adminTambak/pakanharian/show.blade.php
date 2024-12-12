@extends('layouts.template')
@section('title', 'Pakan Harian')
@section('content')

<div class="card">
    <div class="card-body">
    <div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-3">Detail Pakan Harian</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <p><strong>Kode Pakan Harian : </strong> {{ $pakan_harians->kd_pakan_harian }}</p>
            </div>
            <div class="col">
                <p><strong>Fase Kolam : </strong> {{ $pakan_harians->faseKolam->kd_fase_tambak ?? 'Fase tidak ditemukan' }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Tanggal Cek : </strong> {{ $pakan_harians->tanggal_cek }} </p>
            </div>
            <div class="col">
                <p><strong>waktu Cek : </strong> {{ $pakan_harians->waktu_cek }} </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>DOC : </strong> {{ $pakan_harians->DOC }}</p>
            </div>
            <div class="col">
                <p><strong>Berat Udang : </strong> {{ $pakan_harians->berat_udang }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Total Pakan : </strong> {{ $pakan_harians->total_pakan }}</p>
            </div>
            <div class="col">
                <p><strong>Catatan : </strong> {{ $pakan_harians->catatan }} </p>
            </div>
        </div>
        <button type="button" class="btn btn-sm btn-danger"
                onclick="window.location.href='{{ route ('user.pakanharian.index') }}'"
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