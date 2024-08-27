@extends('layouts.template')
@section('title', 'Manajemen Kolam')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('kolam') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahKolam">
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipe_kolam" class="form-label">Tipe Kolam</label>
                        <div class="form-group">
                            <select class="choices form-select" name="tipe_kolam" id="tipe_kolam" required>
                                <option value="" disabled selected>Pilih Tipe Kolam</option>
                                <option value="kotak" {{ old('tipe_kolam') == 'kotak' ? 'selected' : '' }}>Kotak</option>
                                <option value="bundar" {{ old('tipe_kolam') == 'bundar' ? 'selected' : '' }}>Bundar</option>
                            </select>
                        </div>
                    </div>

                    {{-- Kolom tambahan berdasarkan tipe kolam --}}
                    <div id="kolom-tambahan">
                        {{-- Kolom ini akan diisi berdasarkan pilihan tipe kolam --}}
                    </div>

                    {{-- Tombol kembali dan simpan --}}
                    <div class="form-group d-flex justify-content-start mt-3">
                        <a class="btn btn-sm btn-default mr-2" href="{{ url('administrasi') }}">Kembali</a>
                        <button type="submit" class="btn btn-warning btn-sm">Simpan</button>
                    </div>
                </div>

                {{-- Tambahkan foto di sini --}}
                <div class="col-md-6 d-flex justify-content-center align-items-center">
                    <div class="form-group">
                        <div class="col">
                            <div class="row mb-3">
                                <div class="drop-zone">
                                    <div class="text-center">
                                        <i class="fa-solid fa-cloud-arrow-up" style="font-size: 50px"></i>
                                        <div class="drop-zone__prompt">Seret dan jatuhkan file di sini</div>
                                    </div>
                                    <input type="file" name="image" class="drop-zone__input" required>
                                </div>
                            </div>
                            <div class="row text-center mb-2">
                                <span>Atau</span>
                            </div>
                            <div class="row">
                                <div class="form-file">
                                    <input type="file" class="form-file-input" id="customFile">
                                    <label class="form-file-label" for="customFile">
                                        <span class="form-file-text">Pilih file...</span>
                                        <span class="form-file-button">Browse</span>
                                    </label>
                                </div>
                            </div>
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
    document.addEventListener('DOMContentLoaded', function () {
        const tipeKolamSelect = document.getElementById('tipe_kolam');
        const kolomTambahanDiv = document.getElementById('kolom-tambahan');

        tipeKolamSelect.addEventListener('change', function () {
            const tipeKolam = this.value;
            kolomTambahanDiv.innerHTML = ''; // Bersihkan kolom tambahan setiap kali tipe kolam berubah

            if (tipeKolam === 'kotak') {
                kolomTambahanDiv.innerHTML = `
                    <div class="form-group">
                        <label for="kode_kolam" class="form-label">Kode Kolam</label>
                        <input type="text" class="form-control" id="kode_kolam" name="kode_kolam" placeholder="Masukkan Kode Kolam" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_tambak" class="form-label">Nama Tambak</label>
                        <select class="choices form-select" name="nama_tambak" id="nama_tambak" required>
                            <option value="" disabled selected>Pilih Nama Tambak</option>
                            <option value="gending">Tambak Gending</option>
                            <option value="kraksaan">Tambak Kraksaan</option>
                            // {{-- Tambahkan opsi nama tambak di sini --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="panjang" class="form-label">Panjang Kolam (m)</label>
                        <input type="number" class="form-control" id="panjang" name="panjang" placeholder="Masukkan Panjang Kolam" required>
                    </div>
                    <div class="form-group">
                        <label for="lebar" class="form-label">Lebar Kolam (m)</label>
                        <input type="number" class="form-control" id="lebar" name="lebar" placeholder="Masukkan Lebar Kolam" required>
                    </div>
                    <div class="form-group">
                        <label for="luas_kolam" class="form-label">Luas Kolam (m²)</label>
                        <input type="number" class="form-control" id="luas_kolam" name="luas_kolam" placeholder="Luas Kolam Otomatis Terhitung" readonly>
                    </div>
                    <div class="form-group">
                        <label for="kedalaman" class="form-label">Kedalaman (m)</label>
                        <input type="number" class="form-control" id="kedalaman" name="kedalaman" placeholder="Masukkan Kedalaman" required>
                    </div>
                `;

                const panjangInput = document.getElementById('panjang');
                const lebarInput = document.getElementById('lebar');
                const luasKolamInput = document.getElementById('luas_kolam');

                panjangInput.addEventListener('input', hitungLuasKolam);
                lebarInput.addEventListener('input', hitungLuasKolam);

                function hitungLuasKolam() {
                    const panjang = parseFloat(panjangInput.value) || 0;
                    const lebar = parseFloat(lebarInput.value) || 0;
                    luasKolamInput.value = panjang * lebar;
                }

            } else if (tipeKolam === 'bundar') {
                kolomTambahanDiv.innerHTML = `
                    <div class="form-group">
                        <label for="kode_kolam" class="form-label">Kode Kolam</label>
                        <input type="text" class="form-control" id="kode_kolam" name="kode_kolam" placeholder="Masukkan Kode Kolam" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_tambak" class="form-label">Nama Tambak</label>
                        <select class="choices form-select" name="nama_tambak" id="nama_tambak" required>
                            <option value="" disabled selected>Pilih Nama Tambak</option>
                            <option value="" disabled selected>Pilih Nama Tambak</option>
                            <option value="gending">Tambak Gending</option>
                            <option value="kraksaan">Tambak Kraksaan</option>
                            // {{-- Tambahkan opsi nama tambak di sini --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="diameter" class="form-label">Diameter Kolam (m)</label>
                        <input type="number" class="form-control" id="diameter" name="diameter" placeholder="Masukkan Diameter Kolam" required>
                    </div>
                    <div class="form-group">
                        <label for="luas_kolam" class="form-label">Luas Kolam (m²)</label>
                        <input type="number" class="form-control" id="luas_kolam" name="luas_kolam" placeholder="Luas Kolam Otomatis Terhitung" readonly>
                    </div>
                    <div class="form-group">
                        <label for="kedalaman" class="form-label">Kedalaman (m)</label>
                        <input type="number" class="form-control" id="kedalaman" name="kedalaman" placeholder="Masukkan Kedalaman" required>
                    </div>
                `;

                const diameterInput = document.getElementById('diameter');
                const luasKolamInput = document.getElementById('luas_kolam');

                diameterInput.addEventListener('input', hitungLuasKolam);

                function hitungLuasKolam() {
                    const diameter = parseFloat(diameterInput.value) || 0;
                    const radius = diameter / 2;
                    luasKolamInput.value = Math.PI * Math.pow(radius, 2);
                }
            }
        });

        document.querySelectorAll('.drop-zone__input').forEach((inputElement) => {
            const dropZoneElement = inputElement.closest('.drop-zone');

            dropZoneElement.addEventListener('click', (e) => {
                inputElement.click();
            });

            inputElement.addEventListener('change', (e) => {
                if (inputElement.files.length) {
                    updateThumbnail(dropZoneElement, inputElement.files[0]);
                }
            });

            dropZoneElement.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZoneElement.classList.add('drop-zone--over');
            });

            ['dragleave', 'dragend'].forEach((type) => {
                dropZoneElement.addEventListener(type, (e) => {
                    dropZoneElement.classList.remove('drop-zone--over');
                });
            });

            dropZoneElement.addEventListener('drop', (e) => {
                e.preventDefault();

                if (e.dataTransfer.files.length) {
                    inputElement.files = e.dataTransfer.files;
                    updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                }

                dropZoneElement.classList.remove('drop-zone--over');
            });
        });

        function updateThumbnail(dropZoneElement, file) {
            let thumbnailElement = dropZoneElement.querySelector('.drop-zone__thumb');

            // Remove the prompt
            if (dropZoneElement.querySelector('.drop-zone__prompt')) {
                dropZoneElement.querySelector('.drop-zone__prompt').remove();
            }

            // First time - there is no thumbnail element, so let's create it
            if (!thumbnailElement) {
                thumbnailElement = document.createElement('div');
                thumbnailElement.classList.add('drop-zone__thumb');
                dropZoneElement.appendChild(thumbnailElement);
            }

            thumbnailElement.dataset.label = file.name;

            // Show thumbnail for image files
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.readAsDataURL(file);
                reader.onload = () => {
                    thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
                };
            } else {
                thumbnailElement.style.backgroundImage = null;
            }
        }
    });
</script>
@endpush
