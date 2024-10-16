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

                    {{-- ambil nama gudang dari tabel gudang --}}
                    <div class="form-group">
                        <label for="id_gudang" class="form-label">Nama Gudang</label>
                        <div class="form-group">
                            <select class="choices form-select @error('id_gudang') is-invalid @enderror" name="id_gudang"
                                id="id_gudang">
                                <option value="{{ old('id_gudang') }}">- Pilih Nama Gudang -</option>
                                @foreach ($gudang as $item)
                                    <option value="{{ $item->id_gudang }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('id_gudang'))
                            <span class="text-danger">{{ $errors->first('id_gudang') }}</span>
                        @endif
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
                        <label for="lokasi_tambak" class="form-label">Lokasi Tambak</label>
                        <textarea class="form-control" id="lokasi_tambak" name="lokasi_tambak" rows="3" placeholder="Masukkan Lokasi Tambak" required></textarea>
                        @error('lokasi_tambak')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Lokasi tambak yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                </div>


                {{-- tambahkan foto disini --}}
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
                                </div>
                            </div>
                            <div class="row mb-1">
                                <span class="text-center">Atau</span>
                            </div>
                            <div class="row">
                                <div class="form-file">
                                    <input type="file" class="drop-zone__input" id="foto" name="foto">
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
