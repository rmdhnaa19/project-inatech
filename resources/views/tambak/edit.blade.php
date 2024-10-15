@extends('layouts.template')
@section('title', 'Manajemen Tambak')
@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('tambak.update', $tambak->id_tambak) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_tambak">Nama Tambak</label>
                        <input type="text" name="nama_tambak" class="form-control @error('nama_tambak') is-invalid @enderror" value="{{ old('nama_tambak', $tambak->nama_tambak) }}" required>
                        @error('nama_tambak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_gudang">Gudang</label>
                        <select name="id_gudang" class="form-control @error('id_gudang') is-invalid @enderror" required>
                            <option value="">-- Pilih Gudang --</option>
                            @foreach($gudang as $item)
                                <option value="{{ $item->id_gudang }}" {{ old('id_gudang', $tambak->id_gudang) == $item->id_gudang ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_gudang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="luas_lahan">Luas Lahan (m²)</label>
                        <input type="number" name="luas_lahan" class="form-control @error('luas_lahan') is-invalid @enderror" value="{{ old('luas_lahan', $tambak->luas_lahan) }}" required>
                        @error('luas_lahan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="luas_tambak">Luas Tambak (m²)</label>
                        <input type="number" name="luas_tambak" class="form-control @error('luas_tambak') is-invalid @enderror" value="{{ old('luas_tambak', $tambak->luas_tambak) }}" required>
                        @error('luas_tambak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lokasi_tambak">Lokasi Tambak</label>
                        <input type="text" name="lokasi_tambak" class="form-control @error('lokasi_tambak') is-invalid @enderror" value="{{ old('lokasi_tambak', $tambak->lokasi_tambak) }}" required>
                        @error('lokasi_tambak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Foto Tambak Saat Ini yang tersimpan di database -->
                    <div class="form-group">
                        <label for="current_foto">Foto Tambak Saat Ini</label>
                        @if($tambak->foto)
                            <div class="current-photo-wrapper mt-2">
                                <img id="current-foto" src="{{ asset('storage/' . $tambak->foto) }}" class="img-fluid rounded" width="500">
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
                                <div class="drop-zone px-5">
                                    <div class="text-center">
                                        <i class="fa-solid fa-cloud-arrow-up"
                                            style="height: 50px; font-size: 50px"></i>
                                        <p>Seret lalu letakkan file di sini</p>
                                    </div>
                                    <input type="file" class="drop-zone__input" id="foto" name="foto">
                                    <input type="hidden" name="oldImage" value="{{ $tambak->foto }}">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <span class="text-center">Atau</span>
                            </div>
                            <div class="row">
                                <div class="form-file">
                                    <!-- <input type="file" class="form-file-input" id="foto" name="foto"> -->
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
            <div class="d-flex justify-content-between">
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="window.location.href='{{ url('kelolaPengguna') }}'"
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
