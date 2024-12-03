@extends('layouts.template')
@section('title', 'Fase Kolam')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('fasekolam.update', $fasekolam->id_fase_tambak) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_fase_tambak">Kode Fase Kolam</label>
                        <input type="text" name="kd_fase_tambak" id="kd_fase_tambak"
                            class="form-control @error('kd_fase_tambak') is-invalid @enderror"
                            value="{{ old('kd_fase_tambak', $fasekolam->kd_fase_tambak) }}" required>
                        @error('kd_fase_kolam')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_kolam">Kode Kolam</label>
                        <select name="id_kolam" class="form-control @error('id_kolam') is-invalid @enderror" required>
                            <option value="">-- Pilih Kode Kolam --</option>
                            @foreach($kolam as $item) <!-- Kolam harus benar-benar diiterasi -->
                                <option value="{{ $item->id_kolam }}" {{ old('id_kolam', $fasekolam ? $fasekolam->id_kolam : '') == $item->id_kolam ? 'selected' : '' }}>
                                    {{ $item->kd_kolam }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kolam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $fasekolam->tanggal_mulai) }}" required>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tanggal_panen">Tanggal Panen</label>
                        <input type="date" name="tanggal_panen" class="form-control @error('tanggal_panen') is-invalid @enderror" value="{{ old('tanggal_panen', $fasekolam->tanggal_panen) }}" required>
                        @error('tanggal_panen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jumlah_tebar">Jumlah Tebar</label>
                        <input type="number" name="jumlah_tebar" class="form-control @error('jumlah_tebar') is-invalid @enderror" value="{{ old('jumlah_tebar', $fasekolam->jumlah_tebar) }}" required>
                        @error('jumlah_tebar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="densitas">Densitas</label>
                        <input type="number" name="densitas" class="form-control @error('densitas') is-invalid @enderror" value="{{ old('densitas', $fasekolam->densitas) }}" required>
                        @error('densitas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Right Side Drag and Drop -->
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div class="form-group">
                        <div class="col">
                            <div class="row mb-3">
                                <div class="drop-zone"
                                    style="width: 300px; height: 300px; border: 2px dashed #ccc; border-radius: 5px; display: flex; justify-content: center; align-items: center; cursor: pointer;">
                                    <div class="text-center">
                                        <i class="fa-solid fa-cloud-arrow-up"
                                            style="height: 50px; font-size: 50px"></i>
                                        <p class="mt-2">Seret lalu letakkan file di sini</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <span class="text-center">Atau</span>
                            </div>
                            <div class="row mb-5">
                                <div class="form-file">
                                    <label class="form-file-label" for="foto">
                                        <span class="form-file-text">Abaikan jika tidak mengganti</span>
                                        <span class="form-file-button">Browse</span>
                                        <input type="hidden" id="oldImage" name="oldImage"
                                            value="{{ $fasekolam->foto }}">
                                        <input type="file" class="drop-zone__input" id="foto"
                                            name="foto">
                                    </label>
                                </div>
                            </div>
                            @if ($errors->has('foto'))
                                <div class="row alert alert-danger">
                                    <span class="text-center">{{ $errors->first('foto') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
@push('css')
@endpush
@push('js')
<script>
    // Pilih elemen-elemen yang dibutuhkan
    const dropZone = document.querySelector('.drop-zone');
    const dropZoneInput = document.querySelector('.drop-zone__input');
    const browseInput = document.querySelector('#foto');
    const fileNameLabel = document.querySelector('.form-file-text');

    // Fungsi untuk menangani event dragover
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('drop-zone--over');
    });

    // Fungsi untuk menangani event dragleave
    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('drop-zone--over');
    });

    // Fungsi untuk menangani event drop
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('drop-zone--over');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            dropZoneInput.files = files;
            updateFileName(files[0].name);
            previewImage(files[0]);
            uploadFile(files[0]);
        }
    });

    // Fungsi untuk menangani event change pada input file
    browseInput.addEventListener('change', function() {
        if (this.files.length > 0) {
            dropZoneInput.files = this.files; // Sync files dengan drop zone
            updateFileName(this.files[0].name);
            previewImage(this.files[0]);
            uploadFile(this.files[0]);
        }
    });

    // Fungsi untuk mengupdate nama file pada label
    function updateFileName(name) {
        fileNameLabel.textContent = name;
    }

    // Fungsi untuk preview gambar
    function previewImage(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Buat elemen gambar
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'preview-image';
            img.style.maxWidth = '100%';
            img.style.maxHeight = '100%';
            img.style.objectFit = 'contain';

            // Hapus isi drop zone dan tambahkan gambar
            dropZone.innerHTML = '';
            dropZone.appendChild(img);

            // Ubah style drop zone
            dropZone.style.padding = '0';
            dropZone.style.border = 'none';
        }
        reader.readAsDataURL(file);
    }

    // Fungsi placeholder untuk upload file
    function uploadFile(file) {
        // Implementasi logika upload file di sini
        console.log('Mengupload file:', file.name);
    }

    // Fungsi untuk reset drop zone
    function resetDropZone() {
        dropZone.innerHTML = `
            <div class="text-center">
            <i class="fa-solid fa-cloud-arrow-up" style="height: 50px; font-size: 50px"></i>
            <p>Seret lalu letakkan file di sini</p>
            </div>`;
        dropZone.style.padding = ''; // Reset ke default
        dropZone.style.border = ''; // Reset ke default
        fileNameLabel.textContent = 'Pilih file...';
    }

    // Tambahkan event click pada preview gambar untuk mengganti gambar
    dropZone.addEventListener('click', () => {
        if (dropZone.querySelector('.preview-image')) {
            if (confirm('Apakah Anda ingin mengganti gambar?')) {
                resetDropZone();
                browseInput.click();
            }
        }
    });
</script>
@endpush