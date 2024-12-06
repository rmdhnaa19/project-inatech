@extends('layouts.template')
@section('title', 'Edit Data Kualitas Air')
@section('content')
    <div class="card">
        <div class="card-body">
            {{-- @empty($kualitasairs)
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('kualitasair') }}'"
                        style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                @else --}}
                {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif --}}
            <form method="POST" action="{{ url('/kualitasair/' . $kualitasairs->id_kualitas_air) }}" class="form-horizontal" enctype="multipart/form-data"
                id="editKualitasAir">
                @csrf {!! method_field('PUT') !!}
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kd_kualitas_air" class="form-label">Kode Kualitas Air</label>
                            <input type="text" class="form-control @error('kd_kualitas_air') is-invalid @enderror" id="kd_kualitas_air" name="kd_kualitas_air"
                                placeholder="Masukkan kode kualitas air " value="{{ old('kd_kualitas_air', $kualitasairs->kd_kualitas_air) }}" required autofocus>
                            @if ($errors->has('kd_kualitas_air'))
                                <span class="text-danger">{{ $errors->first('kd_kualitas_air') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                                <label for="fase_tambak" class="form-label">Fase Kolam</label>
                                <div class="form-group">
                                    <select class="choices form-select @error('id_fase_tambak') is-invalid @enderror" name="id_fase_tambak"
                                        id="id_fase_tambak">
                                        <option value="{{ old('id_fase_tambak') }}">- Pilih Fase Kolam -</option>
                                        @foreach ($faseKolam as $item)
                                            <option value="{{ $item->id_fase_tambak }}">{{ $item->kd_fase_tambak }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('id_fase_tambak'))
                                    <span class="text-danger">{{ $errors->first('id_fase_tambak') }}</span>
                                @endif
                        </div>
                        <div class="form-group">
                            <label for="tanggal_cek" class="form-label">Tanggal Cek</label>
                            <input type="date" class="form-control @error('tanggal_cek') is-invalid @enderror" id="tanggal_cek" name="tanggal_cek"
                             value="{{ old('tanggal_cek', $kualitasairs->tanggal_cek) }}" required>
                            @if ($errors->has('tanggal_cek'))
                                <span class="text-danger">{{ $errors->first('tanggal_cek') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="waktu_cek" class="form-label">Waktu Cek</label>
                            <input type="time" class="form-control @error('waktu_cek') is-invalid @enderror" id="waktu_cek" name="waktu_cek"
                             value="{{ old('waktu_cek', $kualitasairs->waktu_cek) }}" required>
                            @if ($errors->has('waktu_cek'))
                                <span class="text-danger">{{ $errors->first('waktu_cek') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="pH" class="form-label">pH</label>
                            <input type="integer" class="form-control @error('pH') is-invalid @enderror" id="pH" name="pH"
                             value="{{ old('pH', $kualitasairs->pH) }}" required>
                            @if ($errors->has('pH'))
                                <span class="text-danger">{{ $errors->first('pH') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="salinitas" class="form-label">Salinitas</label>
                            <input type="integer" class="form-control @error('salinitas') is-invalid @enderror" id="salinitas" name="salinitas"
                             value="{{ old('salinitas' , $kualitasairs->salinitas) }}" required>
                            @if ($errors->has('salinitas'))
                                <span class="text-danger">{{ $errors->first('salinitas') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="DO" class="form-label">DO</label>
                            <input type="integer" class="form-control @error('DO') is-invalid @enderror" id="DO" name="DO"
                             value="{{ old('DO' , $kualitasairs->DO) }}" required>
                            @if ($errors->has('DO'))
                                <span class="text-danger">{{ $errors->first('DO') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="suhu" class="form-label">Suhu</label>
                            <input type="integer" class="form-control @error('suhu') is-invalid @enderror" id="suhu" name="suhu"
                             value="{{ old('suhu' , $kualitasairs->suhu) }}" required>
                            @if ($errors->has('suhu'))
                                <span class="text-danger">{{ $errors->first('suhu') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                        <label for="kejernihan_air" class="form-label">Kejernihan Air</label>
                        <div class="form-group">
                            <select class="choices form-select @error('kejernihan_air') is-invalid @enderror" name="kejernihan_air"
                                id="kejernihan_air">
                                <option value="">- Pilih Kejernihan Air-</option>
                                <option value="Jernih"
                                {{ old('kejernihan_air' , $kualitasairs->kejernihan_air) == 'Jernih' ? 'selected' : '' }}>Jernih
                                </option>
                                <option value="Keruh"
                                {{ old('kejernihan_air' , $kualitasairs->kejernihan_air) == 'Keruh' ? 'selected' : '' }}>Keruh
                                </option>
                            </select>
                        </div>
                        @if ($errors->has('kejernihan_air'))
                            <span class="text-danger">{{ $errors->first('kejernihan_air') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="warna_air" class="form-label">Warna Air</label>
                        <div class="form-group">
                            <select class="choices form-select @error('warna_air') is-invalid @enderror" name="warna_air"
                                id="warna_air">
                                <option value="">- Pilih Warna Air -</option>
                                <option value="Coklat Muda"
                                {{ old('warna_air' , $kualitasairs->warna_air) == 'Coklat Muda' ? 'selected' : '' }}>Coklat Muda
                                </option>
                                <option value="Coklat Tua"
                                {{ old('warna_air' , $kualitasairs->warna_air) == 'Coklat Tua' ? 'selected' : '' }}>Coklat Tua
                                </option>
                                <option value="Hijau Muda"
                                {{ old('warna_air' , $kualitasairs->warna_air) == 'Hijau Muda' ? 'selected' : '' }}>Hijau Muda
                                </option>
                                <option value="Hijau Kecoklatan"
                                {{ old('warna_air' , $kualitasairs->warna_air) == 'Hijau Kecoklatan' ? 'selected' : '' }}>Hijau Kecoklatan
                                </option>
                            </select>
                        </div>
                        @if ($errors->has('warna_air'))
                            <span class="text-danger">{{ $errors->first('warna_air') }}</span>
                        @endif
                    </div>
                        <div class="form-group">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                            required>{{ old('catatan' , $kualitasairs->catatan) }}
                            </textarea>
                            @if ($errors->has('catatan'))
                                <span class="text-danger">{{ $errors->first('catatan') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('kualitasair') }}'"
                        style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                    <button type="submit" class="btn btn-primary btn-sm"
                        style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
<script>
        const dropZone = document.querySelector('.drop-zone');
        const dropZoneInput = document.querySelector('.drop-zone__input');
        const fileNameLabel = document.querySelector('.form-file-text');
 
        // Handle the file drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drop-zone--over');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('drop-zone--over');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drop-zone--over');
            const files = e.dataTransfer.files;
            dropZoneInput.files = files;
            updateFileName(files[0].name);
            uploadFile(files[0]);
        });

        // Handle the file browse
        browseInput.addEventListener('change', function() {
            dropZoneInput.files = browseInput.files; // Sync files with drop zone
            updateFileName(this.files[0].name);
            uploadFile(this.files[0]);
        });

        // Update the filename in the label
        dropZoneInput.addEventListener('change', function() {
            if (dropZoneInput.files.length > 0) {
                updateFileName(dropZoneInput.files[0].name);
                uploadFile(dropZoneInput.files[0]); // Upload file to server
            }
        });

        function updateFileName(name) {
            fileNameLabel.textContent = name;
        }
    </script>
@endpush
