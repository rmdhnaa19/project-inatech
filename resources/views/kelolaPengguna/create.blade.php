@extends('layouts.template')
@section('title', 'Kelola Pengguna')
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
            <form method="POST" action="{{ url('kelolaPengguna') }}" class="form-horizontal" enctype="multipart/form-data"
                id="tambahPengguna">
                @csrf
                <div class=" form-group row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" placeholder="Masukkan Username" value="{{ old('username') }}"
                                required autofocus>
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Masukkan Password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="toggle-password"
                                        style="cursor: pointer; padding: 0.7rem 0.6rem;">
                                        <i class="fa fa-eye" id="eye-icon"></i>
                                    </span>
                                </div>
                            </div>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="posisi" class="form-label">Role</label>
                            <div class="form-group">
                                <select class="choices form-select @error('id_role') is-invalid @enderror" name="id_role"
                                    id="id_role">
                                    <option value="">- Pilih Role -</option>
                                    @foreach ($role as $item)
                                        <option value="{{ $item->id_role }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('id_role'))
                                <span class="text-danger">{{ $errors->first('id_role') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" placeholder="Masukkan Nama" value="{{ old('nama') }}" required>
                            @if ($errors->has('nama'))
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="no_hp" class="form-label">Nomor Handphone</label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                                name="no_hp" placeholder="Masukkan No Hp" value="{{ old('no_hp') }}" required>
                            @if ($errors->has('no_hp'))
                                <span class="text-danger">{{ $errors->first('no_hp') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                placeholder="Masukkan Alamat">{{ old('alamat') }}</textarea>
                            @if ($errors->has('alamat'))
                                <span class="text-danger">{{ $errors->first('alamat') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                            <input type="number" class="form-control @error('gaji_pokok') is-invalid @enderror"
                                id="gaji_pokok" name="gaji_pokok" placeholder="Masukkan Gaji Pokok"
                                value="{{ old('gaji_pokok') }}" required>
                            @if ($errors->has('gaji_pokok'))
                                <span class="text-danger">{{ $errors->first('gaji_pokok') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="komisi" class="form-label">Komisi</label>
                            <input type="number" class="form-control @error('komisi') is-invalid @enderror" id="komisi"
                                name="komisi" placeholder="Masukkan Komisi" value="{{ old('komisi') }}">
                            @if ($errors->has('komisi'))
                                <span class="text-danger">{{ $errors->first('komisi') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="tunjangan" class="form-label">Tunjangan</label>
                            <input type="number" class="form-control @error('tunjangan') is-invalid @enderror"
                                id="tunjangan" name="tunjangan" placeholder="Masukkan Tunjangan"
                                value="{{ old('tunjangan') }}">
                            @if ($errors->has('tunjangan'))
                                <span class="text-danger">{{ $errors->first('tunjangan') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="potongan_gaji" class="form-label">Potongan Gaji</label>
                            <input type="number" class="form-control @error('potongan_gaji') is-invalid @enderror"
                                id="potongan_gaji" name="potongan_gaji" placeholder="Masukkan Potongan Gaji"
                                value="{{ old('potongan_gaji') }}">
                            @if ($errors->has('potongan_gaji'))
                                <span class="text-danger">{{ $errors->first('potongan_gaji') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="posisi" class="form-label">Posisi</label>
                            <div class="form-group">
                                <select class="choices form-select @error('posisi') is-invalid @enderror" name="posisi"
                                    id="posisi">
                                    <option value="">- Pilih Posisi -</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Teknisi">Teknisi</option>
                                    <option value="Analis Tambak">Analis Tambak</option>
                                    <option value="Pemilik Tambak">Pemilik Tambak</option>
                                </select>
                            </div>
                            @if ($errors->has('posisi'))
                                <span class="text-danger">{{ $errors->first('posisi') }}</span>
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
                                            <i class="fa-solid fa-cloud-arrow-up"
                                                style="height: 50px; font-size: 50px"></i>
                                            <p>Seret lalu letakkan file di sini</p>
                                        </div>
                                        <input type="file" class="drop-zone__input" id="foto" name="foto"
                                            hidden>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <span class="text-center">Atau</span>
                                </div>
                                <div class="row mb-5">
                                    <div class="form-file">
                                        <label class="form-file-label" for="foto">
                                            <span class="form-file-text">Choose file...</span>
                                            <span class="form-file-button">Browse</span>
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
        $(document).ready(function() {
            // Pilih elemen-elemen yang dibutuhkan
            const dropZone = document.querySelector('.drop-zone');
            const dropZoneInput = document.querySelector('.drop-zone__input');
            const browseInput = document.querySelector('#foto');
            const fileNameLabel = document.querySelector('.form-file-text');

            // Fungsi untuk menangani file yang dipilih
            // function handleFile(file) {
            //     if (file) {
            //         updateFileName(files[0].name);
            //         previewImage(files[0]);
            //         uploadFile(files[0]);
            //     }
            // }

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
                    // handleFile(files[0]);
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
        })
    </script>
    {{-- <script>
        const dropZone = document.querySelector('.drop-zone');
        const dropZoneInput = document.querySelector('.drop-zone__input');
        const browseInput = document.querySelector('#foto');
        const fileNameLabel = document.querySelector('.form-file-text');

        function handleFile(file) {
            if (file) {
                updateFileName(file.name);
                previewImage(file);
                uploadFile(file);
            }
        }

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
            if (files.length > 0) {
                dropZoneInput.files = files;
                handleFile(files[0]);
            }
        });

        // Handle the file browse
        browseInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                dropZoneInput.files = this.files; // Sync files with drop zone
                handleFile(this.files[0]);
            }
        });

        // Update the filename in the label
        function updateFileName(name) {
            fileNameLabel.textContent = name;
        }

        // Preview image
        function previewImage(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create an image element
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'preview-image';
                img.style.maxWidth = '100%';
                img.style.maxHeight = '100%';
                img.style.objectFit = 'contain';

                // Clear the drop zone and append the image
                dropZone.innerHTML = '';
                dropZone.appendChild(img);

                // Change drop zone style
                dropZone.style.padding = '0';
                dropZone.style.border = 'none';
            }
            reader.readAsDataURL(file);
        }

        // Placeholder for uploadFile function
        function uploadFile(file) {
            // Implement file upload logic here
            console.log('Uploading file:', file.name);
        }

        // Function to reset the drop zone
        function resetDropZone() {
            dropZone.innerHTML = `
                <div class="text-center">
                <i class="fa-solid fa-cloud-arrow-up" style="height: 50px; font-size: 50px"></i>
                <p>Seret lalu letakkan file di sini</p>
                </div>`;
            dropZone.style.padding = ''; // Reset to default
            dropZone.style.border = ''; // Reset to default
            fileNameLabel.textContent = 'Choose file...';
        }

        // Add click event to preview image to allow changing the image
        dropZone.addEventListener('click', () => {
            if (dropZone.querySelector('.preview-image')) {
                if (confirm('Do you want to change the image?')) {
                    resetDropZone();
                    browseInput.click();
                }
            }
        });
    </script> --}}
@endpush
