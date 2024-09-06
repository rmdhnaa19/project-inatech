@extends('layouts.template')
@section('title', 'Kelola Sampling')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('sampling') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahsampling">
            @csrf
            <div class="row">
                <!-- Left Side Form Fields -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_sampling" class="form-label">Kode Sampling</label>
                        <input type="text" class="form-control" id="kd_sampling" name="kd_sampling"
                            placeholder="Masukkan kode sampling" value="{{ old('kd_sampling') }}" required autofocus>
                        @error('kd_sampling')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Kode sampling yang anda masukkan tidak valid
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
                        <label for="DOC" class="form-label">DOC</label>
                        <input type="text" class="form-control" id="DOC" name="DOC"
                            placeholder="Masukkan DOC" value="{{ old('DOC') }}" required>
                        @error('DOC')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            DOC yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="berat_udang" class="form-label">Berat Udang</label>
                        <input type="text" class="form-control" id="berat_udang" name="berat_udang"
                            placeholder="Masukkan berat udang" value="{{ old('berat_udang') }}" required>
                        @error('berat_udang')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Berat udang yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="size_udang" class="form-label">Size Udang</label>
                        <input type="text" class="form-control" id="size_udang" name="size_udang"
                            placeholder="Masukkan size udang" value="{{ old('size_udang') }}" required>
                        @error('size_udang')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Size udang yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga_udang" class="form-label">Harga Udang</label>
                        <input type="text" class="form-control" id="harga_udang" name="harga_udang"
                            placeholder="Masukkan harga udang" value="{{ old('harga_udang') }}" required>
                        @error('harga_udang')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Harga udang yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="biomassa" class="form-label">Biomassa</label>
                        <input type="text" class="form-control" id="biomassa" name="biomassa"
                            placeholder="Masukkan biomassa" value="{{ old('biomassa') }}" required>
                        @error('biomassa')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Biomassa yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="populasi_ekor" class="form-label">Populasi Ekor</label>
                        <input type="text" class="form-control" id="populasi_ekor" name="populasi_ekor"
                            placeholder="Masukkan populasi ekor" value="{{ old('populasi_ekor') }}" required>
                        @error('populasi_ekor')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Populasi ekor anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>

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
