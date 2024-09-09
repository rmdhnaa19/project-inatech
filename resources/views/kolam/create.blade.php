@extends('layouts.template')
@section('title', 'Manajemen Kolam')
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
        <form method="POST" action="{{ url('kolam') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahKolam">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipe_kolam" class="form-label">Tipe Kolam</label>
                        <select class="choices form-select" name="tipe_kolam" id="tipe_kolam" required>
                            <option value="" disabled selected>Pilih Tipe Kolam</option>
                            <option value="kotak" {{ old('tipe_kolam') == 'kotak' ? 'selected' : '' }}>Kotak</option>
                            <option value="bundar" {{ old('tipe_kolam') == 'bundar' ? 'selected' : '' }}>Bundar</option>
                        </select>
                    </div>

                    <div id="kolom-tambahan">
                        <!-- Dinamically added fields will appear here -->
                    </div>

                    <!-- Script for dynamically changing form fields and calculations -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const tipeKolamSelect = document.getElementById('tipe_kolam');
    const kolomTambahanDiv = document.getElementById('kolom-tambahan');
    let panjangInput, lebarInput, diameterInput, luasKolamInput;

    function calculateCircularArea(diameter) {
        const radius = diameter / 2;
        return Math.PI * Math.pow(radius, 2);
    }

    function calculateRectangularArea(panjang, lebar) {
        return panjang * lebar;
    }

    function hitungLuasKolamCircular() {
        const diameter = parseFloat(diameterInput.value) || 0;
        luasKolamInput.value = Math.round(calculateCircularArea(diameter)); // Pembulatan ke integer
    }

    function hitungLuasKolamRectangular() {
        const panjang = parseFloat(panjangInput.value) || 0;
        const lebar = parseFloat(lebarInput.value) || 0;
        luasKolamInput.value = Math.round(calculateRectangularArea(panjang, lebar)); // Pembulatan ke integer
    }

                            tipeKolamSelect.addEventListener('change', function () {
                                const tipeKolam = this.value;
                                kolomTambahanDiv.innerHTML = '';

                                if (tipeKolam === 'kotak') {
                                    kolomTambahanDiv.innerHTML = `
                                        <div class="form-group">
                                            <label for="kd_kolam" class="form-label">Kode Kolam</label>
                                            <input type="text" class="form-control" id="kd_kolam" name="kd_kolam" placeholder="Masukkan Kode Kolam" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_tambak" class="form-label">Nama Tambak</label>
                                            <select class="choices form-select" name="id_tambak" id="id_tambak">
                                                <option value="">- Pilih Nama Tambak -</option>
                                                @foreach ($tambak as $item)
                                                    <option value="{{ $item->id_tambak }}" {{ old('id_tambak') == $item->id_tambak ? 'selected' : '' }}>{{ $item->nama_tambak }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="panjang_kolam" class="form-label">Panjang Kolam (m)</label>
                                            <input type="number" class="form-control" id="panjang_kolam" name="panjang_kolam" placeholder="Masukkan Panjang Kolam" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="lebar_kolam" class="form-label">Lebar Kolam (m)</label>
                                            <input type="number" class="form-control" id="lebar_kolam" name="lebar_kolam" placeholder="Masukkan Lebar Kolam" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="luas_kolam" class="form-label">Luas Kolam (m²)</label>
                                            <input type="number" class="form-control" id="luas_kolam" name="luas_kolam" placeholder="Luas Kolam Otomatis Terhitung" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="kedalaman" class="form-label">Kedalaman (m)</label>
                                            <input type="number" class="form-control" id="kedalaman" name="kedalaman" placeholder="Masukkan Kedalaman" required>
                                        </div>`;
                                    
                                    panjangInput = document.getElementById('panjang_kolam');
                                    lebarInput = document.getElementById('lebar_kolam');
                                    luasKolamInput = document.getElementById('luas_kolam');

                                    if (panjangInput && lebarInput) {
                                        panjangInput.addEventListener('input', hitungLuasKolamRectangular);
                                        lebarInput.addEventListener('input', hitungLuasKolamRectangular);
                                    }

                                } else if (tipeKolam === 'bundar') {
                                    kolomTambahanDiv.innerHTML = `
                                        <div class="form-group">
                                            <label for="kd_kolam" class="form-label">Kode Kolam</label>
                                            <input type="text" class="form-control" id="kd_kolam" name="kd_kolam" placeholder="Masukkan Kode Kolam" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="id_tambak" class="form-label">Nama Tambak</label>
                                            <select class="choices form-select" name="id_tambak" id="id_tambak">
                                                <option value="">- Pilih Nama Tambak -</option>
                                                @foreach ($tambak as $item)
                                                    <option value="{{ $item->id_tambak }}" {{ old('id_tambak') == $item->id_tambak ? 'selected' : '' }}>{{ $item->nama_tambak }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="panjang_kolam" class="form-label">Diameter Kolam (m)</label>
                                            <input type="number" class="form-control" id="panjang_kolam" name="panjang_kolam" placeholder="Masukkan Diameter Kolam" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="luas_kolam" class="form-label">Luas Kolam (m²)</label>
                                            <input type="number" class="form-control" id="luas_kolam" name="luas_kolam" placeholder="Luas Kolam Otomatis Terhitung" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="kedalaman" class="form-label">Kedalaman (m)</label>
                                            <input type="number" class="form-control" id="kedalaman" name="kedalaman" placeholder="Masukkan Kedalaman" required>
                                        </div>`;
                                    
                                    diameterInput = document.getElementById('panjang_kolam');
                                    luasKolamInput = document.getElementById('luas_kolam');

                                    if (diameterInput) {
                                        diameterInput.addEventListener('input', hitungLuasKolamCircular);
                                    }
                                }
                            });
                        });
                    </script>
                </div>

                {{-- Tambahkan foto di sini --}}
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
