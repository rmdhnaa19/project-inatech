@extends('layouts.template')
@section('title', 'Edit Obat')
@section('content')
    <div class="card">
        <div class="card-body">
            @empty($obat)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban white"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                </div>
                <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('kelolaObat') }}'"
                    style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
            @else
                <form method="POST" action="{{ url('/kelolaObat/' . $obat->id_obat) }}" class="form-horizontal"
                    enctype="multipart/form-data" id="editObat">
                    @csrf {!! method_field('PUT') !!}
                    <div class=" form-group row">
                        <div class="col-md-6 mt-3">
                            <div class="form-group">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                    name="nama" value="{{ old('nama', $obat->nama) }}" placeholder="Masukkan Nama Obat"
                                    required autofocus>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                                @if ($errors->has('nama'))
                                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="harga_satuan" class="form-label">Harga Satuan</label>
                                <input type="number" class="form-control @error('harga_satuan') is-invalid @enderror"
                                    id="harga_satuan" name="harga_satuan" value="{{ old('harga_satuan', $obat->harga_satuan) }}"
                                    placeholder="Masukkan Harga Satuan Obat" required>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                                @if ($errors->has('harga_satuan'))
                                    <span class="text-danger">{{ $errors->first('harga_satuan') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="satuan" class="form-label">Satuan</label>
                                <div class="form-group">
                                    <select class="choices form-select @error('satuan') is-invalid @enderror" name="satuan"
                                        id="satuan" required>
                                        <option value="">- Pilih Satuan -</option>
                                        <option value="Gram" {{ old('satuan', $obat->satuan) == 'Gram' ? 'selected' : '' }}>
                                            Gram</option>
                                        <option value="Kg" {{ old('satuan', $obat->satuan) == 'Kg' ? 'selected' : '' }}>
                                            Kg</option>
                                        <option value="Liter" {{ old('satuan', $obat->satuan) == 'Liter' ? 'selected' : '' }}>
                                            Liter
                                        </option>
                                        <option value="Ml" {{ old('satuan', $obat->satuan) == 'Ml' ? 'selected' : '' }}>
                                            Ml</option>
                                        <option value="Pcs" {{ old('satuan', $obat->satuan) == 'Pcs' ? 'selected' : '' }}>
                                            Pcs</option>
                                        <option value="Sachet"
                                            {{ old('satuan', $obat->satuan) == 'Sachet' ? 'selected' : '' }}>
                                            Sachet</option>
                                    </select>
                                    <p><small class="text-muted">Wajib Diisi!</small></p>
                                </div>
                                @if ($errors->has('satuan'))
                                    <span class="text-danger">{{ $errors->first('satuan') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $obat->deskripsi) }}</textarea>
                                <p><small class="text-muted">Boleh Dikosongi.</small></p>
                                @if ($errors->has('deskripsi'))
                                    <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-center align-items-center mt-3">
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
                                            <label class="form-file-label" for="foto">
                                                <span class="form-file-text">Abaikan jika tidak mengganti</span>
                                                <span class="form-file-button">Browse</span>
                                                <input type="hidden" id="oldImage" name="oldImage"
                                                    value="{{ $obat->foto }}">
                                                <input type="file" class="drop-zone__input" id="foto" name="foto">
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
                            onclick="window.location.href='{{ url('kelolaObat') }}'"
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
