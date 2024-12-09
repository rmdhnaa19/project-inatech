@extends('layouts.template')
@section('title', 'Data Kolam')
@section('content')
    <div class="card">
        <div class="card-header">Data Kolam</div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    @foreach ($kolam as $kolams)
                        <div class="col-md-6 mb-4">
                            <div class="card border border-primary" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="{{ asset('storage/' . $kolams->foto) }}" alt="Foto Kolam"
                                            class="img-fluid mx-2 my-2 border" style="width: auto; height: 30vh;">
                                    </div>
                                    <div class="col-md-8 d-flex flex-column">
                                        <div class="card-body flex-grow-1">
                                            <h5 class="card-title">{{ $kolams->kd_kolam }}</h5>
                                            <p class="card-text m-0">{{ $kolams->tipe_kolam }}</p>
                                            <p class="card-text m-0">
                                                {{ number_format($kolams->panjang_kolam, 0, ',', '.') }}
                                            </p>
                                            <p class="card-text m-0">
                                                {{ number_format($kolams->lebar_kolam, 0, ',', '.') }}
                                            </p>
                                            <p class="card-text m-0">
                                                {{ number_format($kolams->luas_kolam, 0, ',', '.') }}
                                            </p>
                                            <p class="card-text m-0">
                                                {{ number_format($kolams->kedalaman, 0, ',', '.') }}
                                            </p>
                                            <p class="card-text">
                                                <small class="text-body-secondary">
                                                    Last updated
                                                    {{ \Carbon\Carbon::parse($kolams->updated_at)->translatedFormat('l, j F Y') }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary mt-auto rounded-0"
                                    onclick="window.location.href='{{ route('user.fasekolam.create', ['id_kolam' => $kolams->id_kolam]) }}'">
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
