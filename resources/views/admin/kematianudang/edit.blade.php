@extends('layouts.template')
@section('title', 'Kelola Kematian Udang')
@section('content')
<div class="card">
    <div class="card-body">
        {{-- @empty($kematianudangs)
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('kematianUdang') }}'"
                        style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                @else --}}
                {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif --}}
        <form method="POST" action="{{ url('/kematianUdang/' . $kematianudangs->id_kematian_udang) }}" class="form-horizontal" enctype="multipart/form-data" 
            id="editKematianUdang">
            @csrf
            <div class="row">
                <!-- Left Side Form Fields -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_kematian_udang" class="form-label">Kode Kematian Udang</label>
                            <input type="text" class="form-control @error('kd_kematian_udang') is-invalid @enderror" id="kd_kematian_udang" name="kd_kematian_udang"
                                value="{{ old('kd_kematian_udang', $kematianudangs->kd_kematian_udang) }}" required autofocus>
                            @if ($errors->has('kd_kematian_udang'))
                                <span class="text-danger">{{ $errors->first('kd_kematian_udang') }}</span>
                            @endif
                    </div>

                    <div class="form-group">
                        <label for="fase_tambak" class="form-label">Fase Kolam</label>
                            <div class="form-group">
                                <select class="choices form-select @error('id_fase_tambak') is-invalid @enderror" name="id_fase_tambak"
                                    id="id_fase_tambak">
                                    <option value="{{ old('id_fase_tambak') }}">- Pilih Fase Kolam -</option>
                                    @foreach ($faseKolam as $item)
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
                            <input type="text" class="form-control @error('size_udang') is-invalid @enderror" id="size_udang" name="size_udang"
                            value="{{ old('size_udang' , $kematianudangs->size_udang) }}" required>
                            @if ($errors->has('size_udang'))
                                <span class="text-danger">{{ $errors->first('size_udang') }}</span>
                            @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="berat_udang" class="form-label">Berat Udang (gr)</label>
                            <input type="text" class="form-control @error('berat_udang') is-invalid @enderror" id="berat_udang" name="berat_udang"
                            value="{{ old('berat_udang' , $kematianudangs->berat_udang) }}" required>
                            @if ($errors->has('berat_udang'))
                                <span class="text-danger">{{ $errors->first('berat_udang') }}</span>
                            @endif
                    </div>
                
                    <div class="form-group">
                        <label for="catatan" class="form-label">Catatan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                                required>{{ old('catatan' , $kematianudangs->catatan) }}
                                </textarea>
                                @if ($errors->has('catatan'))
                                    <span class="text-danger">{{ $errors->first('catatan') }}</span>
                                @endif
                    </div>
                </div>
                
                {{-- Tambahkan foto di sini --}}
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
                                        <input type="file" class="drop-zone__input" id="gambar" name="gambar" value="{{ old('gambar' , $kematianudangs->gambar) }}">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <span class="text-center">Atau</span>
                                </div>
                                <div class="row">
                                    <div class="form-file">
                                        <!-- <input type="file" class="form-file-input" id="foto" name="foto"> -->
                                        <label class="form-file-label" for="gambar">
                                            <span class="form-file-text">Choose file...</span>
                                            <span class="form-file-button">Browse</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('kematianUdang') }}'"
                        style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                    <button type="submit" class="btn btn-primary btn-sm"
                        style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
                    </div>
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
    </script>
@endpush