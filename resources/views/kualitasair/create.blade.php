@extends('layouts.template')
@section('title', 'Kelola Kualitas Air')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('kualitasAir') }}" class="form-horizontal" enctype="multipart/form-data"
            id="tambahkualitasair">
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_kulitas_air" class="form-label">Kode Kualitas Air</label>
                        <input type="text" class="form-control" id="kd_anco" name="kd_kualitas_air"
                            placeholder="Masukkan kode kualitas air" value="{{ old('kd_kualitas_air') }}" required autofocus>
                        @error('kd_kualitas_air')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Kode kualitas air yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_cek" class="form-label">Tanggal Cek</label>
                        <input type="date" class="form-control" id="tanggal_cek" name="tanggal_cek"
                            placeholder="Masukkan tanggal cek" value="{{ old('tanggal_cek') }}" required>
                        @error('tanggal_cek')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Tanggal cek yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pH" class="form-label">pH Air</label>
                        <input type="text" class="form-control" id="pH" name="pH"
                            placeholder="Masukkan pH air" value="{{ old('pH') }}" required>
                        @error('pH')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            pH air yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kejernihan_air" class="form-label">Kejernihan Air</label>
                        <div class="form-group">
                            <select class="choices form-select @error('kejernihan_air') is-invalid @enderror" name="kejernihan_air"
                                id="kejernihan_air">
                                <option value="{{ old('warna_air') }}">- Pilih Kejernihan Air-</option>
                                <option value="Jernih">Jernih</option>
                                <option value="Jernih">Keruh</option>
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
                                <option value="{{ old('warna_air') }}">- Pilih Warna Air -</option>
                                <option value="Coklat Muda">Coklat Muda</option>
                                <option value="Coklat Tua">Coklat Tua</option>
                                <option value="Hijau Muda">Hijau Muda</option>
                                <option value="Hijau Kecoklatan">Hijau Kecoklatan</option>
                            </select>
                        </div>
                        @if ($errors->has('warna_air'))
                            <span class="text-danger">{{ $errors->first('warna_air') }}</span>
                        @endif
                    </div>

                    {{-- Tombol kembali dan simpan --}}
                    <div class="form-group">
                        <a class="btn btn-sm btn-default" href="{{ url('administrasi') }}">Kembali</a>
                        <button type="submit" class="btn btn-warning btn-sm">Simpan</button>
                    </div>
                </div>

                {{-- Tambahkan foto di sini --}}
                <div class="col-md-6 d-flex justify-content-center align-items-center">
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
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
{{-- Tambahkan CSS khusus di sini jika diperlukan --}}
@endpush

@push('js')
<script>
    document.querySelectorAll('.drop-zone__input').forEach((inputElement) => {
        const dropZoneElement = inputElement.closest('.drop-zone');

        dropZoneElement.addEventListener('click', (e) => {
            inputElement.click();
        });

        inputElement.addEventListener('change', (e) => {
            if (inputElement.files.length) {
                updateThumbnail(dropZoneElement, inputElement.files[0]);
            }
        });

        dropZoneElement.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZoneElement.classList.add('drop-zone--over');
        });

        ['dragleave', 'dragend'].forEach((type) => {
            dropZoneElement.addEventListener(type, (e) => {
                dropZoneElement.classList.remove('drop-zone--over');
            });
        });

        dropZoneElement.addEventListener('drop', (e) => {
            e.preventDefault();

            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
            }

            dropZoneElement.classList.remove('drop-zone--over');
        });
    });

    function updateThumbnail(dropZoneElement, file) {
        let thumbnailElement = dropZoneElement.querySelector('.drop-zone__thumb');

        // Remove the prompt
        if (dropZoneElement.querySelector('.drop-zone__prompt')) {
            dropZoneElement.querySelector('.drop-zone__prompt').remove();
        }

        // First time - there is no thumbnail element, so let's create it
        if (!thumbnailElement) {
            thumbnailElement = document.createElement('div');
            thumbnailElement.classList.add('drop-zone__thumb');
            dropZoneElement.appendChild(thumbnailElement);
        }

        thumbnailElement.dataset.label = file.name;

        // Show thumbnail for image files
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = () => {
                thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
            };
        } else {
            thumbnailElement.style.backgroundImage = null;
        }
    }
</script>
@endpush
