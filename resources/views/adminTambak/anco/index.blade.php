@extends('layouts.template')
@section('title', 'Anco')
@section('content')
    <div class="card">
        <div class="card-header">Data Anco</div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @foreach ($anco as $detailAnco)
                        <div class="col-md-6 mb-4">
                            <div class="card border border-primary" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-8 d-flex flex-column">
                                        <div class="card-body flex-grow-1">
                                            <h5 class="card-title">{{ $detailAnco->kd_anco }}</h5>
                                            <p class="card-text m-0">Catatan : {{ $detailAnco->catatan }}</p>
                                            <p class="card-text">
                                                <small class="text-body-secondary">
                                                    Last updated
                                                    {{ \Carbon\Carbon::parse($detailAnco->updated_at)->translatedFormat('l, j F Y') }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary mt-auto rounded-0"
                                    onclick="window.location.href=''">
                                    Detail
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
