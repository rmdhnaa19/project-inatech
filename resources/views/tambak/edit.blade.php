@extends('layouts.template')
@section('title', 'Manajemen Tambak')
@section('content')
<div class="card">
    <div class="card-body">
        
        <form method="POST" action="{{ url('/tambak/' . $tambak->id_tambak) }}" class="form-horizontal"
            enctype="multipart/form-data" id="edittambak">
            @csrf {!! method_field('PUT') !!}
            <div class=" form-group row">
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
                                            value="{{ $tambak->foto }}">
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