@extends('layouts.template')
@section('title', 'Edit Data Sampling')
@section('content')
    <div class="card">
        <div class="card-body">
            {{-- @empty($samplings)
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('sampling') }}'"
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
            <form method="POST" action="{{ url('/sampling/' . $samplings->id_sampling) }}" class="form-horizontal" enctype="multipart/form-data"
                id="editSampling">
                @csrf {!! method_field('PUT') !!}
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kd_sampling" class="form-label">Kode Sampling</label>
                            <input type="text" class="form-control @error('kd_sampling') is-invalid @enderror" id="kd_sampling" name="kd_sampling"
                                placeholder="Masukkan kode sampling " value="{{ old('kd_sampling', $samplings->kd_sampling) }}" required autofocus>
                            @if ($errors->has('kd_sampling'))
                                <span class="text-danger">{{ $errors->first('kd_sampling') }}</span>
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
                            <label for="tanggal_cek" class="form-label">Tanggal Cek</label>
                            <input type="date" class="form-control @error('tanggal_cek') is-invalid @enderror" id="tanggal_cek" name="tanggal_cek"
                             value="{{ old('tanggal_cek', $samplings->tanggal_cek) }}" required>
                            @if ($errors->has('tanggal_cek'))
                                <span class="text-danger">{{ $errors->first('tanggal_cek') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="waktu_cek" class="form-label">Waktu Cek</label>
                            <input type="time" class="form-control @error('waktu_cek') is-invalid @enderror" id="waktu_cek" name="waktu_cek"
                             value="{{ old('waktu_cek', $samplings->waktu_cek) }}" required>
                            @if ($errors->has('waktu_cek'))
                                <span class="text-danger">{{ $errors->first('waktu_cek') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="DOC" class="form-label">DOC (hari)</label>
                            <input type="integer" class="form-control @error('DOC') is-invalid @enderror" id="DOC" name="DOC"
                             value="{{ old('DOC', $samplings->DOC) }}" required>
                            @if ($errors->has('DOC'))
                                <span class="text-danger">{{ $errors->first('DOC') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="berat_udang" class="form-label">Berat Udang / Ekor (gr)</label>
                            <input type="integer" class="form-control @error('berat_udang') is-invalid @enderror" id="berat_udang" name="berat_udang"
                             value="{{ old('berat_udang' , $samplings->berat_udang) }}" required>
                            @if ($errors->has('berat_udang'))
                                <span class="text-danger">{{ $errors->first('berat_udang') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="size_udang" class="form-label">Size Udang (cm)</label>
                            <input type="integer" class="form-control @error('size_udang') is-invalid @enderror" id="size_udang" name="size_udang"
                             value="{{ old('size_udang' , $samplings->size_udang) }}" required>
                            @if ($errors->has('size_udang'))
                                <span class="text-danger">{{ $errors->first('size_udang') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="interval_hari" class="form-label">Interval Hari</label>
                            <input type="integer" class="form-control @error('interval_hari') is-invalid @enderror" id="interval_hari" name="interval_hari"
                             value="{{ old('interval_hari' , $samplings->interval_hari) }}" required>
                            @if ($errors->has('interval_hari'))
                                <span class="text-danger">{{ $errors->first('interval_hari') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="harga_udang" class="form-label">Harga Udang (Rp)</label>
                            <input type="integer" class="form-control @error('harga_udang') is-invalid @enderror" id="harga_udang" name="harga_udang"
                             value="{{ old('harga_udang' , $samplings->harga_udang) }}" required>
                            @if ($errors->has('harga_udang'))
                                <span class="text-danger">{{ $errors->first('harga_udang') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="input_fr" class="form-label">Input FR (%)</label>
                            <input type="integer" class="form-control @error('input_fr') is-invalid @enderror" id="input_fr" name="input_fr"
                             value="{{ old('input_fr' , $samplings->input_fr) }}" required>
                            @if ($errors->has('input_fr'))
                                <span class="text-danger">{{ $errors->first('input_fr') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="total_pakan" class="form-label">Total Pakan (kg)</label>
                            <input type="integer" class="form-control @error('total_pakan') is-invalid @enderror" id="total_pakan" name="total_pakan"
                             value="{{ old('total_pakan' , $samplings->total_pakan) }}" required>
                            @if ($errors->has('total_pakan'))
                                <span class="text-danger">{{ $errors->first('total_pakan') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="ADG_udang" class="form-label">ADG udang (otomatis)</label>
                            <input type="integer" class="form-control @error('ADG_udang') is-invalid @enderror" id="ADG_udang" name="ADG_udang"
                             value="{{ old('ADG_udang' , $samplings->ADG_udang) }}" required>
                            @if ($errors->has('ADG_udang'))
                                <span class="text-danger">{{ $errors->first('ADG_udang') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="biomassa" class="form-label">Biomassa (kg)</label>
                            <input type="integer" class="form-control @error('biomassa') is-invalid @enderror" id="biomassa" name="biomassa"
                             value="{{ old('biomassa' , $samplings->biomassa) }}" required>
                            @if ($errors->has('biomassa'))
                                <span class="text-danger">{{ $errors->first('biomassa') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="populasi_ekor" class="form-label">Populasi Ekor</label>
                            <input type="integer" class="form-control @error('populasi_ekor') is-invalid @enderror" id="populasi_ekor" name="populasi_ekor"
                             value="{{ old('populasi_ekor' , $samplings->populasi_ekor) }}" required>
                            @if ($errors->has('populasi_ekor'))
                                <span class="text-danger">{{ $errors->first('populasi_ekor') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                            required>{{ old('catatan' , $samplings->catatan) }}
                            </textarea>
                            @if ($errors->has('catatan'))
                                <span class="text-danger">{{ $errors->first('catatan') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('sampling') }}'"
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
        function calculatePopulasi() {
            let size_udang = parseFloat(document.getElementById('size_udang').value) || 0;
            let biomassa = parseFloat(document.getElementById('biomassa').value) || 0;
            let populasi_ekor = size_udang * biomassa;
            document.getElementById('populasi_ekor').value = populasi_ekor;
        }
    </script>
@endpush
