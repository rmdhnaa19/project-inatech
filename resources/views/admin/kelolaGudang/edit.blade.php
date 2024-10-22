@extends('layouts.template')
@section('title', 'Edit Gudang')
@section('content')
    <div class="card">
        <div class="card-body">
            @empty($gudang)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                </div>
                <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('kelolaGudang') }}'"
                    style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
            @else
                <form method="POST" action="{{ url('/kelolaGudang/' . $gudang->id_gudang) }}" class="form-horizontal"
                    enctype="multipart/form-data" id="editGudang">
                    @csrf {!! method_field('PUT') !!}
                    <div class=" form-group row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                    name="nama" value="{{ old('nama', $gudang->nama) }}" required autofocus>
                                @if ($errors->has('nama'))
                                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="panjang" class="form-label">Panjang</label>
                                        <input type="number" class="form-control @error('panjang') is-invalid @enderror"
                                            id="panjang" name="panjang" value="{{ old('panjang', $gudang->panjang) }}"
                                            step="0.01" oninput="calculateLuas()" required>
                                        <p><small class="text-muted">Masukkan ukuran dalam meter.</small></p>
                                        @if ($errors->has('panjang'))
                                            <span class="text-danger">{{ $errors->first('panjang') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lebar" class="form-label">Lebar</label>
                                        <input type="number" class="form-control @error('lebar') is-invalid @enderror"
                                            id="lebar" name="lebar" value="{{ old('lebar', $gudang->lebar) }}"
                                            step="0.01" oninput="calculateLuas()" required>
                                        @if ($errors->has('lebar'))
                                            <span class="text-danger">{{ $errors->first('lebar') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="luas" class="form-label">Luas</label>
                                <input type="number" class="form-control @error('luas') is-invalid @enderror" id="luas"
                                    name="luas" value="{{ old('luas', $gudang->luas) }}" step="0.01" readonly>
                                <p><small class="text-muted">Hasil Hitung dalam meter<sup>2</sup>.</small></p>
                                @if ($errors->has('luas'))
                                    <span class="text-danger">{{ $errors->first('luas') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat', $gudang->alamat) }}</textarea>
                                @if ($errors->has('alamat'))
                                    <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center align-items-center">
                            <div class="form-group">
                                <div class="col">
                                    <div class="row mb-3">
                                        <div class="drop-zone"
                                            style="width: 300px; height: 300px; border: 2px dashed #ccc; border-radius: 5px; display: flex; justify-content: center; align-items: center; cursor: pointer;">
                                            <div class="text-center">
                                                <i class="fa-solid fa-cloud-arrow-up" style="height: 50px; font-size: 50px"></i>
                                                <p class="mt-2">Seret lalu letakkan file di sini</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <span class="text-center">Atau</span>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="form-file">
                                            <label class="form-file-label" for="gambar">
                                                <span class="form-file-text">Abaikan jika tidak mengganti</span>
                                                <span class="form-file-button">Browse</span>
                                                <input type="hidden" id="oldImage" name="oldImage"
                                                    value="{{ $gudang->gambar }}">
                                                <input type="file" class="drop-zone__input" id="gambar" name="gambar">
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
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ url('kelolaGudang') }}'"
                            style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                        <button type="submit" class="btn btn-primary btn-sm"
                            style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
                    </div>
                </form>
            @endempty
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
        const browseInput = document.querySelector('#gambar');
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
    <script>
        function calculateLuas() {
            let panjang = parseFloat(document.getElementById('panjang').value) || 0;
            let lebar = parseFloat(document.getElementById('lebar').value) || 0;
            let luas = panjang * lebar;
            document.getElementById('luas').value = luas;
        }
    </script>
@endpush
