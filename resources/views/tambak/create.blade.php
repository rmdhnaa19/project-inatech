@extends('layouts.template')
@section('title', 'Manajemen Tambak')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('tambak') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahtambak">
            @csrf
            <div class="row">
                <!-- Left Side Form Fields -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_tambak" class="form-label">Nama Tambak</label>
                        <input type="text" class="form-control" id="nama_tambak" name="nama_tambak"
                            placeholder="Masukkan nama tambak" value="{{ old('nama_tambak') }}" required autofocus>
                        @error('nama_tambak')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Nama tambak yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_gudang" class="form-label">Nama Gudang</label>
                        <select class="choices form-select" name="nama_gudang" id="nama_gudang">
                            <option value="G1TK">Gudang 1 Tambak Kraksaan</option>
                            <option value="G2TK">Gudang 2 Tambak Kraksaan</option>
                            <option value="G1TG">Gudang 1 Tambak Gending</option>
                            <option value="G2TG">Gudang 2 Tambak Gending</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat"></textarea>
                        @error('no_hp')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Alamat yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="luas_lahan" class="form-label">Luas Lahan</label>
                        <input type="text" class="form-control" id="luas_lahan" name="luas_lahan"
                            placeholder="Masukkan luas lahan" value="{{ old('luas_lahan') }}" required>
                        @error('luas_lahan')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Luas lahan yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="luas_tambak" class="form-label">Luas Tambak</label>
                        <input type="text" class="form-control" id="luas_tambak" name="luas_tambak"
                            placeholder="Masukkan luas tambak" value="{{ old('luas_tambak') }}" required>
                        @error('luas_tambak')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Luas tambak yang anda masukkan tidak valid
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
