@extends('layouts.template')
@section('title', 'Kematian Udang')
@section('content')
    <div class="card">
        <div class="d-flex justify-content-betwen">
        <div class="card-header">Data Kematian Udang</div>
                <button class="btn btn-primary mt-auto ml-auto mr-2 rounded-10"
                    onclick="window.location.href='{{ route('user.kematianudang.create') }}'">
                            Tambah Data
                </button>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @foreach ($kematianudangs as $detailKematianUdang)
                        <div class="col-md-6 mb-4">
                            <div class="card border border-primary" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-8 d-flex flex-column">
                                       <a href="{{ route('user.kematianudang.show', $detailKematianUdang->id_kematian_udang) }}" class="text-decoration-none text-dark">
                                       <div class="card-body flex-grow-1">
                                            <h5 class="card-title">{{ $detailKematianUdang->kd_kematian_udang }}</h5>
                                            <p class="card-text m-0">Fase Kolam : {{ $detailKematianUdang->faseKolam->kd_fase_tambak }}</p>
                                            <p class="card-text">Catatan : {{ $detailKematianUdang->catatan }} </p>
                                            <p class="card-text">
                                                <small class="text-body-secondary">
                                                    Terakhir Diperbarui :
                                                    {{ \Carbon\Carbon::parse($detailKematianUdang->updated_at)->translatedFormat('l, j F Y') }}
                                                </small>
                                            </p>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                                
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