@extends('layouts.template')
@section('title', 'Manajemen Fase Kolam')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('fasekolam') }}" class="form-horizontal" enctype="multipart/form-data"
            id="tambahfaseKolam">
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_kolam" class="form-label">Kode Kolam</label>
                        <input type="text" class="form-control" id="kd_kolam" name="kd_kolam"
                            placeholder="Masukkan Kode Kolam " value="{{ old('kd_kolam') }}" required autofocus>
                        @error('kd_kolam')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Kode kolam  yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                            placeholder="Masukkan tanggal mulai" value="{{ old('tanggal_mulai') }}" required>
                        @error('tanggal_mulai')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Tanggal mulai yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal_panen" class="form-label">Tanggal Panen</label>
                        <input type="date" class="form-control" id="tanggal_panen" name="tanggal_panen"
                            placeholder="Masukkan tanggal panen" value="{{ old('tanggal_panen') }}" required>
                        @error('tanggal_panen')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Tanggal panen yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jumlah_tebar" class="form-label">Jumlah Tebar</label>
                        <input type="text" class="form-control" id="jumlah_tebar" name="jumlah_tebar"
                            placeholder="Masukkan jumlah tebar" value="{{ old('jumlah_tebar') }}" required>
                        @error('jumlah_tebar')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Jumlah tebar yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="densitas" class="form-label">Densitas</label>
                        <input type="text" class="form-control" id="densitas" name="densitas"
                            placeholder="Masukkan densitas" value="{{ old('densitas') }}" required>
                        @error('densitas')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Densitas yang anda masukkan tidak valid
                        </div>
                        @enderror
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
