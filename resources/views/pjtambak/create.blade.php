@extends('layouts.template')
@section('title', 'Manajemen Tambak')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('pjTambak') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahpjtambak">
            @csrf
            <div class="row">
                <!-- Left Side Form Fields -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_user_tambak" class="form-label">KODE PJ TAMBAK</label>
                        <input type="text" class="form-control" id="kd_user_tambak" name="kd_user_tambak"
                            placeholder="Masukkan kode penanggung jawab tambak" value="{{ old('kd_user_tambak') }}" required autofocus>
                        @error('kd_user_tambak')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Kode user tambak yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_user" class="form-label">Nama PJ Tambak</label>
                        <div class="form-group">
                            <select class="choices form-select @error('id_user') is-invalid @enderror" name="id_user"
                                id="id_user">
                                <option value="{{ old('id_user') }}">- Pilih Nama PJ Tambak -</option>
                                @foreach ($user as $item)
                                    <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('id_user'))
                            <span class="text-danger">{{ $errors->first('id_user') }}</span>
                        @endif
                    </div>   
                    
                    <div class="form-group">
                        <label for="id_tambak" class="form-label">Nama Tambak</label>
                        <div class="form-group">
                            <select class="choices form-select @error('id_tambak') is-invalid @enderror" name="id_tambak"
                                id="id_tambak">
                                <option value="{{ old('id_tambak') }}">- Pilih Nama Tambak -</option>
                                @foreach ($tambak as $item)
                                    <option value="{{ $item->id_tambak }}">{{ $item->nama_tambak }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('id_tambak'))
                            <span class="text-danger">{{ $errors->first('id_tambak') }}</span>
                        @endif
                    </div>                  
                </div> <!-- Akhir div col-md-6 -->
                
                {{-- Bagian kanan dengan form foto --}}
                {{-- <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div class="form-group">
                        <div class="col">
                            <div class="row mb-3">
                                <div class="drop-zone">
                                    <div class="text-center">
                                        <i class="fa-solid fa-cloud-arrow-up" style="font-size: 50px"></i>
                                        <div class="drop-zone__prompt">Seret dan jatuhkan file di sini</div>
                                    </div>
                                    <input type="file" name="image" class="drop-zone__input" required>
                                </div>
                            </div>
                            <div class="row text-center">
                                <span>Atau</span>
                            </div>
                            <div class="row">
                                <div class="form-file">
                                    <input type="file" class="form-file-input" id="customFile">
                                    <label class="form-file-label" for="customFile">
                                        <span class="form-file-text">Pilih file...</span>
                                        <span class="form-file-button">Browse</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- Akhir div col-md-6 -->
            </div> <!-- Akhir div row --> --}}

            {{-- Pindahkan tombol ke luar grid row --}}
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="window.location.href='{{ url('tambak') }}'"
                    style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                <button type="submit" class="btn btn-primary btn-sm"
                    style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
