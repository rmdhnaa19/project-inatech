@extends('layouts.template')
@section('title', 'Edit Kolam')
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
            <form action="{{ url('/kolam/' . $kolam->id_kolam) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Left Side Form Inputs -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kd_kolam">Kode Kolam</label>
                            <input type="text" name="kd_kolam" id="kd_kolam"
                                class="form-control @error('kd_kolam') is-invalid @enderror"
                                value="{{ old('kd_kolam', $kolam->kd_kolam) }}" required>
                            @error('kd_kolam')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tipe_kolam" class="form-label">Tipe Kolam</label>
                            <select class="form-select" name="tipe_kolam" id="tipe_kolam" required>
                                <option value="" disabled>Pilih Tipe Kolam</option>
                                <option value="kotak" {{ old('tipe_kolam', $kolam->tipe_kolam) == 'kotak' ? 'selected' : '' }}>Kotak</option>
                                <option value="bundar" {{ old('tipe_kolam', $kolam->tipe_kolam) == 'bundar' ? 'selected' : '' }}>Bundar</option>
                            </select>
                        </div>

                        <div id="kolom-tambahan">
                            <!-- Dynamic form fields will be injected here -->
                        </div>
                        
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const tipeKolamSelect = document.getElementById('tipe_kolam');
                                const kolomTambahanDiv = document.getElementById('kolom-tambahan');
                                let panjangInput, lebarInput, luasKolamInput;
                        
                                // Load the initial form based on the current kolam type
                                const initialTipeKolam = "{{ old('tipe_kolam', $kolam->tipe_kolam) }}";
                                loadFormFields(initialTipeKolam);
                        
                                // Helper function to calculate circular area
                                function calculateCircularArea(diameter) {
                                    const radius = diameter / 2;
                                    return Math.PI * Math.pow(radius, 2);
                                }
                        
                                // Helper function to calculate rectangular area
                                function calculateRectangularArea(panjang, lebar) {
                                    return panjang * lebar;
                                }
                        
                                // Automatically calculate area for circular pools
                                function hitungLuasKolamCircular() {
                                    const panjang = parseFloat(panjangInput.value) || 0;
                                    luasKolamInput.value = Math.round(calculateCircularArea(panjang)); // Rounded to nearest integer
                                }
                        
                                // Automatically calculate area for rectangular pools
                                function hitungLuasKolamRectangular() {
                                    const panjang = parseFloat(panjangInput.value) || 0;
                                    const lebar = parseFloat(lebarInput.value) || 0;
                                    luasKolamInput.value = Math.round(calculateRectangularArea(panjang, lebar)); // Rounded to nearest integer
                                }
                        
                                // Function to load the appropriate form fields based on the kolam type
                                function loadFormFields(tipeKolam) {
                                    kolomTambahanDiv.innerHTML = ''; // Clear previous inputs
                        
                                    if (tipeKolam === 'kotak') {
                                        kolomTambahanDiv.innerHTML = `
                                        <div class="form-group">
                                            <label for="id_tambak" class="form-label">Nama Tambak</label>
                                            <select class="choices form-select" name="id_tambak" id="id_tambak">
                                                <option value="">- Pilih Nama Tambak -</option>
                                                @foreach ($tambak as $item)
                                                    <option value="{{ $item->id_tambak }}" {{ old('id_tambak', $kolam->id_tambak) == $item->id_tambak ? 'selected' : '' }}>{{ $item->nama_tambak }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                            <div class="form-group">
                                                <label for="panjang_kolam" class="form-label">Panjang Kolam (m)</label>
                                                <input type="number" class="form-control" id="panjang_kolam" name="panjang_kolam" value="{{ old('panjang_kolam', $kolam->panjang_kolam) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="lebar_kolam" class="form-label">Lebar Kolam (m)</label>
                                                <input type="number" class="form-control" id="lebar_kolam" name="lebar_kolam" value="{{ old('lebar_kolam', $kolam->lebar_kolam) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="luas_kolam" class="form-label">Luas Kolam (m²)</label>
                                                <input type="number" class="form-control" id="luas_kolam" name="luas_kolam" value="{{ old('luas_kolam', $kolam->luas_kolam) }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="kedalaman" class="form-label">Kedalaman (m)</label>
                                                <input type="number" class="form-control" id="kedalaman" name="kedalaman" value="{{ old('kedalaman', $kolam->kedalaman) }}" required>
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
                                                <label for="diameter_kolam" class="form-label">Diameter Kolam (m)</label>
                                                <input type="number" class="form-control" id="panjang_kolam" name="panjang_kolam" value="{{ old('panjang_kolam', $kolam->panjang_kolam) }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="luas_kolam" class="form-label">Luas Kolam (m²)</label>
                                                <input type="number" class="form-control" id="luas_kolam" name="luas_kolam" value="{{ old('luas_kolam', $kolam->luas_kolam) }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="kedalaman" class="form-label">Kedalaman (m)</label>
                                                <input type="number" class="form-control" id="kedalaman" name="kedalaman" value="{{ old('kedalaman', $kolam->kedalaman) }}" required>
                                            </div>`;
                        
                                        panjangInput = document.getElementById('panjang_kolam'); // Using the panjang field for diameter
                                        luasKolamInput = document.getElementById('luas_kolam');
                        
                                        if (panjangInput) {
                                            panjangInput.addEventListener('input', hitungLuasKolamCircular);
                                        }
                                    }
                                }
                        
                                // Listen for changes on the 'tipe_kolam' select field
                                tipeKolamSelect.addEventListener('change', function () {
                                    const tipeKolam = this.value;
                                    loadFormFields(tipeKolam);
                                });
                            });
                        </script>                            
                    </div>                       

                <!-- Right Side Drag and Drop -->
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div class="form-group">
                        <div class="col">
                            <div class="row mb-1">
                                <div class="drop-zone px-5" id="drop-zone">
                                    <div class="text-center" id="drop-zone-preview">
                                        @if($kolam->foto)
                                            <img src="{{ asset('storage/'.$kolam->foto) }}" class="img-fluid" alt="Foto Kolam" style="max-width: 100%;">
                                        @else
                                            <i class="fa-solid fa-cloud-arrow-up" style="height: 50px; font-size: 50px"></i>
                                            <p>Seret lalu letakkan file di sini</p>
                                        @endif
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

            <!-- Centered Submit Button -->
            <div class="row">
                <div class="col d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@push('css')
<style>
    .drop-zone {
        width: 100%; 
        height: 200px;
        border: 2px dashed #ddd;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 4px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .drop-zone img {
        max-width: 100%;
        max-height: 100%;
        border-radius: 4px;
        object-fit: cover;
    }

    .drop-zone__input {
        display: none;
    }

    .drop-zone--over {
        background-color: #eef;
        border-color: #cde;
    }

    .current-photo-wrapper img {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('js')
<script>
    const dropZone = document.querySelector('.drop-zone');
    const dropZoneInput = document.querySelector('.drop-zone__input');
    const dropZonePreview = document.querySelector('#drop-zone-preview');
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
        previewFile(files[0]);
    });

    // Handle the file browse
    browseInput.addEventListener('change', function() {
        dropZoneInput.files = browseInput.files; 
        updateFileName(this.files[0].name);
        previewFile(this.files[0]);
    });

    // Update the filename in the label
    function updateFileName(name) {
        fileNameLabel.textContent = name;
    }

    // Preview the uploaded file
    function previewFile(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            dropZonePreview.innerHTML = '';
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '100%';
            img.style.maxHeight = '100%';
            img.style.objectFit = 'cover';
            dropZonePreview.appendChild(img);
        }
        reader.readAsDataURL(file);
    }
</script>
@endpush

