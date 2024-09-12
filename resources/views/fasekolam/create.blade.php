@extends('layouts.template')
@section('title', 'Manajemen Fase Kolam')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('fasekolam') }}" class="form-horizontal" enctype="multipart/form-data"
            id="tambahfaseKolam">
            @csrf
            <div class="form-group row">
                <!-- Kolom kiri, berisi form input teks -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_fase_tambak" class="form-label">Kode Fase Kolam</label>
                        <input type="text" class="form-control" id="kd_fase_tambak" name="kd_fase_tambak"
                            placeholder="Masukkan Fase Kode Kolam " value="{{ old('kd_fase_tambak') }}" required autofocus>
                        @error('kd_fase_tambak')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Kode fase kolam yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_kolam" class="form-label">Pilih Kode Kolam</label>
                        <div class="form-group">
                            <select class="choices form-select @error('id_kolam') is-invalid @enderror" name="id_kolam"
                                id="id_user">
                                <option value="{{ old('id_kolam') }}">- Pilih Kode Kolam -</option>
                                @foreach ($kolam as $item)
                                    <option value="{{ $item->id_kolam }}">{{ $item->kd_kolam }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('id_kolam'))
                            <span class="text-danger">{{ $errors->first('id_kolam') }}</span>
                        @endif
                    </div>   

                    <div class="form-group">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                            placeholder="Masukkan tanggal mulai" value="{{ old('tanggal_mulai') }}" required>
                        @error('tanggal_mulai')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Tanggal mulai yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tanggal_panen" class="form-label">Tanggal Panen</label>
                        <input type="date" class="form-control" id="tanggal_panen" name="tanggal_panen"
                            placeholder="Masukkan tanggal panen" value="{{ old('tanggal_panen') }}" required>
                        @error('tanggal_panen')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Tanggal panen yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jumlah_tebar" class="form-label">Jumlah Tebar</label>
                        <input type="text" class="form-control" id="jumlah_tebar" name="jumlah_tebar"
                            placeholder="Masukkan jumlah tebar" value="{{ old('jumlah_tebar') }}" required>
                        @error('jumlah_tebar')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Jumlah tebar yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="densitas" class="form-label">Densitas</label>
                        <input type="text" class="form-control" id="densitas" name="densitas"
                            placeholder="Masukkan densitas" value="{{ old('densitas') }}" required>
                        @error('densitas')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Densitas yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Kolom kanan, berisi area seret gambar -->
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
            
            <!-- Tombol kembali dan simpan -->
            <div class="d-flex justify-content-between mt-5">
                <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('kolam') }}'" style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                <button type="submit" class="btn btn-primary btn-sm" style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
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
    });

    // Handle the file browse
    browseInput.addEventListener('change', function() {
        dropZoneInput.files = browseInput.files; // Sync files with drop zone
        updateFileName(this.files[0].name);
    });

    // Update the filename in the label
    dropZoneInput.addEventListener('change', function() {
        if (dropZoneInput.files.length > 0) {
            updateFileName(dropZoneInput.files[0].name);
        }
    });

    function updateFileName(name) {
        fileNameLabel.textContent = name;
    }
</script>
@endpush
