@extends('layouts.template')
@section('title', 'Kelola Kematian Udang')
@section('content')
<div class="card">
    <div class="card-body">
     @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <form method="POST" action="{{ url('kematianUdang') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahkematianudang">
            @csrf
            <div class="row">
                <!-- Left Side Form Fields -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_kematian_udang" class="form-label">Kode Kematian Udang</label>
                        <input type="text" class="form-control" id="kd_kematian_udang" name="kd_kematian_udang"
                            placeholder="Masukkan kode kematian udang" value="{{ old('kematian_udang') }}" required autofocus>
                        @error('kd_kematian_udang')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Kode kematian udang yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                            <label for="fase_tambak" class="form-label">Fase Kolam</label>
                            <div class="form-group">
                                <select class="choices form-select @error('id_fase_tambak') is-invalid @enderror" name="id_fase_tambak"
                                    id="id_fase_tambak">
                                    <option value="{{ old('id_fase_tambak') }}">- Pilih Fase Kolam -</option>
                                    @foreach ($fase_kolam as $item)
                                        <option value="{{ $item->id_fase_tambak }}">{{ $item->kd_fase_tambak }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('id_fase_tambak'))
                                <span class="text-danger">{{ $errors->first('id_fase_tambak') }}</span>
                            @endif
                    </div>
                    <div class="form-group">
                        <label for="size_udang" class="form-label">Size Udang (cm)</label>
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
                        <label for="berat_udang" class="form-label">Berat Udang (gr)</label>
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
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                            placeholder="Tambahkan catatan"></textarea>
                        @if ($errors->has('catatan'))
                            <span class="text-danger">{{ $errors->first('catatan') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('kematianUdang') }}'"
                        style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                        <button type="submit" class="btn btn-warning btn-sm">Simpan</button>
                    </div>
                </div>

                {{-- Tambahkan foto di sini --}}
                    <!-- <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <div class="form-group">
                            <div class="col">
                                <div class="row mb-1">
                                    <div class="drop-zone px-5">
                                        <div class="text-center">
                                            <i class="fa-solid fa-cloud-arrow-up"
                                                style="height: 50px; font-size: 50px"></i>
                                            <p>Seret lalu letakkan file di sini</p>
                                        </div>
                                        <input type="file" class="drop-zone__input" id="gambar" name="gambar">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <span class="text-center">Atau</span>
                                </div>
                                <div class="row">
                                    <div class="form-file"> -->
                                        <!-- <input type="file" class="form-file-input" id="foto" name="foto"> -->
                                        <!-- <label class="form-file-label" for="gambar">
                                            <span class="form-file-text">Choose file...</span>
                                            <span class="form-file-button">Browse</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-md-6 d-flex justify-content-center align-items-center mt-3">
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
                                            <span class="form-file-text">Choose file...</span>
                                            <span class="form-file-button">Browse</span>
                                            <input type="file" class="drop-zone__input" id="gambar"
                                                name="gambar">
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('gambar'))
                                    <div class="row alert alert-danger">
                                        <span class="text-center">{{ $errors->first('gambar') }}</span>
                                    </div>
                                @endif
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
        // Pilih elemen-elemen yang dibutuhkan
        const dropZone = document.querySelector('.drop-zone');
        const dropZoneInput = document.querySelector('.drop-zone__input');
        const browseInput = document.querySelector('#gambar');
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
