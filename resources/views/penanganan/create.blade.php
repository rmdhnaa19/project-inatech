@extends('layouts.template')
@section('title', 'Kelola Penanganan')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('penanganan') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahpenanganan">
            @csrf
            <div class="row">
                <!-- Left Side Form Fields -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_penanganan" class="form-label">Kode Penanganan</label>
                        <input type="text" class="form-control" id="kd_penanganan" name="kd_penanganan"
                            placeholder="Masukkan penanganan" value="{{ old('kd_penanganan') }}" required autofocus>
                        @error('kd_penanganan')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Kode penanganan yang anda masukkan tidak valid
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
                        <label for="pemberian_mineral" class="form-label">Pemberian Mineral (Liter)</label>
                        <input type="text" class="form-control" id="pemberian_mineral" name="pemberian_mineral"
                            placeholder="Masukkan pemberian mineral" value="{{ old('pemberian_mineral') }}" required>
                        @error('pemberian_mineral')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Pemberian mineral yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pemberian_vitamin" class="form-label">Pemberian Vitamin (Kg)</label>
                        <input type="text" class="form-control" id="pemberian_vitamin" name="pemberian_vitamin"
                            placeholder="Masukkan pemberian vitamin" value="{{ old('pemberian_mineral') }}" required>
                        @error('pemberian_vitamin')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Pemberian vitamin yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pemberian_obat" class="form-label">Pemberian Obat (Kg)</label>
                        <input type="text" class="form-control" id="pemberian_obat" name="pemberian_obat"
                            placeholder="Masukkan pemberian obat" value="{{ old('pemberian_obat') }}" required>
                        @error('pemberian_obat')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Pemberian obat yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="penambahan_air" class="form-label">Penambahan Air (cm)</label>
                        <input type="text" class="form-control" id="penambahan_air" name="penambahan_air"
                            placeholder="Masukkan penambahan air" value="{{ old('penambahan_air') }}" required>
                        @error('penambahan_air')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Penambahan air yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pengurangan_air" class="form-label">Pengurangan Air (cm)</label>
                        <input type="text" class="form-control" id="pengurangan_air" name="pengurangan_air"
                            placeholder="Masukkan pengurangan air" value="{{ old('pengurangan_air') }}" required>
                        @error('pengurangan_air')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Pengurangan air yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <a class="btn btn-sm btn-default" href="{{ url('administrasi') }}">Kembali</a>
                        <button type="submit" class="btn btn-warning btn-sm">Simpan</button>
                    </div>
                </div>

                {{-- Tambahkan foto di sini --}}
                <!-- <div class="col-md-6 d-flex justify-content-center align-items-center">
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
                </div> -->
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
