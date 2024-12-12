@extends('layouts.template')
@section('title', 'Sampling')
@section('content')
    <div class="card">
        <div class="d-flex justify-content-betwen">
        <div class="card-header">Data Sampling</div>
                <button class="btn btn-primary mt-auto ml-auto mr-2 rounded-10"
                    onclick="window.location.href='{{ route('user.sampling.create') }}'">
                            Tambah Data
                </button>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @foreach ($samplings as $detailSampling)
                        <div class="col-md-6 mb-4">
                            <div class="card border border-primary" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-8 d-flex flex-column">
                                       <a href="{{ route('user.sampling.show', $detailSampling->id_sampling) }}" class="text-decoration-none text-dark">
                                       <div class="card-body flex-grow-1">
                                            <h5 class="card-title">{{ $detailSampling->kd_sampling }}</h5>
                                            <p class="card-text m-0">Fase Kolam : {{ $detailSampling->faseKolam->kd_fase_tambak }}</p>
                                            <p class="card-text">Catatan : {{ $detailSampling->catatan }} </p>
                                            <p class="card-text">
                                                <small class="text-body-secondary">
                                                    Terakhir Diperbarui :
                                                    {{ \Carbon\Carbon::parse($detailSampling->updated_at)->translatedFormat('l, j F Y') }}
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