@extends('layouts.template')
@section('title', 'Manajemen Pj Tambak')
@section('content')
<div class="card">
    <div class="card-body">
        {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
        <form action="{{ route('admin.pjTambak.update', $pjtambak->id_user_tambak) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Left Side Form Fields -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_user_tambak">Kode Pj Tambak</label>
                        <input type="text" name="kd_user_tambak" class="form-control @error('kd_user_tambak') is-invalid @enderror" value="{{ old('kd_user_tambak', $pjtambak->kd_user_tambak) }}" required>
                        @error('kd_user_tambak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <div class="form-group">
                        <label for="id_user">Nama Pj Tambak</label>
                        <select name="id_user" class="form-control @error('id_user') is-invalid @enderror" required>
                            <option value="">-- Pilih Nama Pj Tambak --</option>
                            @foreach($user as $item) 
                                <option value="{{ $item->id_user }}" {{ old('id_user', $pjtambak->id_user) == $item->id_user ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>                        
                        @error('id_user')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_tambak">Nama Tambak</label>
                        <select name="id_tambak" class="form-control @error('id_tambak') is-invalid @enderror" required>
                            <option value="">-- Pilih Nama Tambak --</option>
                            @foreach($tambak as $item) <!-- Iterate over the $tambak collection -->
                                <option value="{{ $item->id_tambak }}" {{ old('id_tambak', $pjtambak->id_tambak) == $item->id_tambak ? 'selected' : '' }}>
                                    {{ $item->nama_tambak }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_tambak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>                   
                </div>

            <!-- Centered Submit Button -->
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
