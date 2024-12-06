@extends('layouts.template')
@section('title', 'Edit Data Penanganan')
@section('content')
    <div class="card">
        <div class="card-body">
            {{-- @empty($penanganans)
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('penanganan') }}'"
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
            <form method="POST" action="{{ url('/penanganan/' . $penanganans->id_penanganan) }}" class="form-horizontal" enctype="multipart/form-data"
                id="editPenanganan">
                @csrf {!! method_field('PUT') !!}
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kd_penanganan" class="form-label">Kode Penanganan</label>
                            <input type="text" class="form-control @error('kd_penanganan') is-invalid @enderror" id="kd_penanganan" name="kd_penanganan"
                                placeholder="Masukkan kode penanganan " value="{{ old('kd_penanganan', $penanganans->kd_penanganan) }}" required autofocus>
                            @if ($errors->has('kd_penanganan'))
                                <span class="text-danger">{{ $errors->first('kd_penanganan') }}</span>
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
                             value="{{ old('tanggal_cek', $penanganans->tanggal_cek) }}" required>
                            @if ($errors->has('tanggal_cek'))
                                <span class="text-danger">{{ $errors->first('tanggal_cek') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="waktu_cek" class="form-label">Waktu Cek</label>
                            <input type="time" class="form-control @error('waktu_cek') is-invalid @enderror" id="waktu_cek" name="waktu_cek"
                             value="{{ old('waktu_cek', $penanganans->waktu_cek) }}" required>
                            @if ($errors->has('waktu_cek'))
                                <span class="text-danger">{{ $errors->first('waktu_cek') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="pemberian_mineral" class="form-label">Pemberian Mineral (Liter)</label>
                            <input type="integer" class="form-control @error('pemberian_mineral') is-invalid @enderror" id="pemberian_mineral" name="pemberian_mineral"
                             value="{{ old('pemberian_mineral', $penanganans->pemberian_mineral) }}" required>
                            @if ($errors->has('pemberian_mineral'))
                                <span class="text-danger">{{ $errors->first('pemberian_mineral') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="pemberian_vitamin" class="form-label">Pemberian Vitamin (Kg)</label>
                            <input type="integer" class="form-control @error('pemberian_vitamin') is-invalid @enderror" id="pemberian_vitamin" name="pemberian_vitamin"
                             value="{{ old('pemberian_vitamin' , $penanganans->pemberian_vitamin) }}" required>
                            @if ($errors->has('pemberian_vitamin'))
                                <span class="text-danger">{{ $errors->first('pemberian_vitamin') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="pemberian_obat" class="form-label">Pemberian Obat (Kg)</label>
                            <input type="integer" class="form-control @error('pemberian_obat') is-invalid @enderror" id="pemberian_obat" name="pemberian_obat"
                             value="{{ old('pemberian_obat' , $penanganans->pemberian_obat) }}" required>
                            @if ($errors->has('pemberian_obat'))
                                <span class="text-danger">{{ $errors->first('pemberian_obat') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="penambahan_air" class="form-label">Penambahan Air (Liter)</label>
                            <input type="integer" class="form-control @error('penambahan_air') is-invalid @enderror" id="penambahan_air" name="penambahan_air"
                             value="{{ old('penambahan_air' , $penanganans->penambahan_air) }}" required>
                            @if ($errors->has('penambahan_air'))
                                <span class="text-danger">{{ $errors->first('penambahan_air') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="pengurangan_air" class="form-label">Pengurangan Air (Liter)</label>
                            <input type="integer" class="form-control @error('pengurangan_air') is-invalid @enderror" id="pengurangan_air" name="pengurangan_air"
                             value="{{ old('pengurangan_air' , $penanganans->pengurangan_air) }}" required>
                            @if ($errors->has('pengurangan_air'))
                                <span class="text-danger">{{ $errors->first('pengurangan_air') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                            required>{{ old('catatan' , $penanganans->catatan) }}
                            </textarea>
                            @if ($errors->has('catatan'))
                                <span class="text-danger">{{ $errors->first('catatan') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('penanganan') }}'"
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
