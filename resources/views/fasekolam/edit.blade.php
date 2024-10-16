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

                    <!-- Foto fase kolam Saat Ini yang tersimpan di database -->
                    <div class="form-group">
                        <label for="current_foto">Foto Fase Kolam Saat Ini</label>
                        @if($fasekolam->foto)
                            <div class="current-photo-wrapper mt-2">
                                <img id="current-foto" src="{{ asset('storage/' . $fasekolam->foto) }}" class="img-fluid rounded" width="500">
                            </div>
                        @else
                            <p>Belum ada foto.</p>
                        @endif
                    </div>
                </div>

                <!-- Drag and Drop -->
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div class="form-group">
                        <div class="col">
                            <div class="row mb-1">
                                <div class="drop-zone px-5" id="drop-zone">
                                    <div class="text-center" id="drop-zone-preview">
                                        <i class="fa-solid fa-cloud-arrow-up" style="height: 50px; font-size: 50px"></i>
                                        <p>Seret lalu letakkan file di sini</p>
                                    </div>
                                    <input type="file" class="drop-zone__input" id="foto" name="foto">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <span class="text-center">Atau</span>
                            </div>
                            <div class="row">
                                <div class="form-file">
                                    <label class="form-file-label" for="foto">
                                        <span class="form-file-text">Choose file...</span>
                                        <span class="form-file-button">Browse</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('css')
<style>
    .drop-zone {
        width: 100%; 
        height: 200px;
        border: 2px dashed #ddd;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 4px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .drop-zone img {
        max-width: 100%;
        max-height: 100%;
        border-radius: 4px;
        object-fit: cover;
    }

    .drop-zone__input {
        display: none;
    }

    .drop-zone--over {
        background-color: #eef;
        border-color: #cde;
    }

    .current-photo-wrapper img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('js')
<script>
    const dropZone = document.querySelector('.drop-zone');
    const dropZoneInput = document.querySelector('.drop-zone__input');
    const dropZonePreview = document.querySelector('#drop-zone-preview');
    const browseInput = document.querySelector('#foto');
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
        previewFile(files[0]);
    });

    // Handle the file browse
    browseInput.addEventListener('change', function() {
        dropZoneInput.files = browseInput.files; 
        updateFileName(this.files[0].name);
        previewFile(this.files[0]);
    });

    // Update the filename in the label
    function updateFileName(name) {
        fileNameLabel.textContent = name;
    }

    // Preview the uploaded file
    function previewFile(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            dropZonePreview.innerHTML = '';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100%';
            img.style.maxHeight = '100%';
            img.style.objectFit = 'cover';
            dropZonePreview.appendChild(img);
        }
        reader.readAsDataURL(file);
    }
</script>
@endpush
