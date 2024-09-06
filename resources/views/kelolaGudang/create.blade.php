@extends('layouts.template')
@section('title', 'Kelola Gudang')
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
            <form method="POST" action="{{ url('kelolaGudang') }}" class="form-horizontal" enctype="multipart/form-data"
                id="tambahGudang">
                @csrf
                <div class=" form-group row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" placeholder="Masukkan Nama Gudang" value="{{ old('nama') }}" required
                                autofocus>
                            @if ($errors->has('nama'))
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="panjang" class="form-label">Panjang</label>
                            <input type="number" class="form-control @error('panjang') is-invalid @enderror" id="panjang"
                                name="panjang" placeholder="Masukkan Panjang Gudang" value="{{ old('panjang') }}"
                                step="0.01" required oninput="calculateLuas()">
                            <p><small class="text-muted">Masukkan ukuran dalam meter.</small></p>
                            @if ($errors->has('panjang'))
                                <span class="text-danger">{{ $errors->first('panjang') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="lebar" class="form-label">Lebar</label>
                            <input type="number" class="form-control @error('lebar') is-invalid @enderror" id="lebar"
                                name="lebar" placeholder="Masukkan Lebar Gudang" value="{{ old('lebar') }}"
                                step="0.01" required oninput="calculateLuas()">
                            <p><small class="text-muted">Masukkan ukuran dalam meter.</small></p>
                            @if ($errors->has('lebar'))
                                <span class="text-danger">{{ $errors->first('lebar') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="luas" class="form-label">Luas</label>
                            <input type="number" class="form-control @error('luas') is-invalid @enderror" id="luas"
                                name="luas" value="{{ old('luas') }}" step="0.01" readonly>
                            <p><small class="text-muted">Hasil Hitung dalam meter<sup>2</sup>.</small></p>
                            @if ($errors->has('luas'))
                                <span class="text-danger">{{ $errors->first('lebar') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                placeholder="Masukkan Alamat"></textarea>
                            @if ($errors->has('alamat'))
                                <span class="text-danger">{{ $errors->first('alamat') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <div class="form-group">
                            <div class="col">
                                <div class="row mb-1">
                                    <div class="drop-zone px-5">
                                        <div class="text-center">
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
                        onclick="window.location.href='{{ url('kelolaGudang') }}'"
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
    <script>
        function calculateLuas() {
            let panjang = parseFloat(document.getElementById('panjang').value) || 0;
            let lebar = parseFloat(document.getElementById('lebar').value) || 0;
            let luas = panjang * lebar;
            document.getElementById('luas').value = luas;
        }
    </script>
@endpush
