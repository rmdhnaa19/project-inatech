@extends('layouts.template')
@section('title', 'Edit Data Anco')
@section('content')
    <div class="card">
        <div class="card-body">
            {{-- @empty($anco)
                    <div class="alert alert-danger alert-dismissible">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                    </div>
                    <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('anco') }}'"
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
            <form method="POST" action="{{ url('/anco/' . $anco->id_anco) }}" class="form-horizontal" enctype="multipart/form-data"
                id="editAnco">
                @csrf {!! method_field('PUT') !!}
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kd_anco" class="form-label">Kode Anco</label>
                            <input type="text" class="form-control @error('kd_anco') is-invalid @enderror" id="kd_anco" name="kd_anco"
                                placeholder="Masukkan kode anco " value="{{ old('kd_anco', $anco->kd_anco) }}" required autofocus>
                            @if ($errors->has('kd_anco'))
                                <span class="text-danger">{{ $errors->first('kd_anco') }}</span>
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
                             value="{{ old('tanggal_cek', $anco->tanggal_cek) }}" required>
                            @if ($errors->has('tanggal_cek'))
                                <span class="text-danger">{{ $errors->first('tanggal_cek') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="waktu_cek" class="form-label">Waktu Cek</label>
                            <input type="time" class="form-control @error('waktu_cek') is-invalid @enderror" id="waktu_cek" name="waktu_cek"
                             value="{{ old('waktu_cek', $anco->waktu_cek) }}" required>
                            @if ($errors->has('waktu_cek'))
                                <span class="text-danger">{{ $errors->first('waktu_cek') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="pemberian_pakan" class="form-label">Pemberian Pakan (kg)</label>
                            <input type="string" class="form-control @error('pemberian_pakan') is-invalid @enderror" id="pemberian_pakan" name="pemberian_pakan"
                             value="{{ old('pemberian_pakan', $anco->pemberian_pakan) }}" required>
                            @if ($errors->has('pemberian_pakan'))
                                <span class="text-danger">{{ $errors->first('pemberian_pakan') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="jamPemberian_pakan" class="form-label">Jam Pemberian Pakan</label>
                            <input type="time" class="form-control @error('jamPemberian_pakan') is-invalid @enderror" id="jamPemberian_pakan" name="jamPemberian_pakan"
                             value="{{ old('jamPemberian_pakan' , $anco->jamPemberian_pakan) }}" required>
                            @if ($errors->has('jamPemberian_pakan'))
                                <span class="text-danger">{{ $errors->first('jamPemberian_pakan') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="kondisi_pakan" class="form-label">Kondisi Pakan</label>
                            <div class="form-group">
                                <select class="choices form-select @error('kondisi_pakan') is-invalid @enderror" name="kondisi_pakan"
                                    id="kondisi_pakan">
                                    <option value="">- Pilih Kondisi Pakan -</option>
                                    <option value="Sisa sedikit" 
                                        {{ old('kondisi_pakan' , $anco->kondisi_pakan) == 'Sisa sedikit' ? 'selected' : '' }}>Sisa sedikit
                                    </option>
                                    <option value="Sisa setengah"
                                        {{ old('kondisi_pakan' , $anco->kondisi_pakan) == 'Sisa setengah' ? 'selected' : '' }}>Sisa setengah
                                    </option>
                                    <option value="Sisa banyak" 
                                        {{ old('kondisi_pakan' , $anco->kondisi_pakan) == 'Sisa banyak' ? 'selected' : '' }}>Sisa banyak
                                    </option>
                                </select>
                            </div>
                            @if ($errors->has('kondisi_pakan')) 
                                <span class="text-danger">{{ $errors->first('kondisi_pakan') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="kondisi_udang" class="form-label">Kondisi Udang</label>
                            <div class="form-group">
                                <select class="choices form-select @error('kondisi_udang') is-invalid @enderror" name="kondisi_udang"
                                    id="kondisi_udang">
                                    <option value="">- Pilih Kondisi Udang -</option>
                                    <option value="Udang sakit"
                                        {{ old('kondisi_udang' , $anco->kondisi_udang) == 'Udang sakit' ? 'selected' : '' }}>Udang sakit
                                    </option>
                                    <option value="Udang sehat"
                                        {{ old('kondisi_udang' , $anco->kondisi_udang) == 'Udang sehat' ? 'selected' : '' }}>Udang sehat
                                    </option>
                                    <option value="Udang mati"
                                        {{ old('kondisi_udang' , $anco->kondisi_udang) == 'Udang mati' ? 'selected' : '' }}>Udang mati
                                    </option>
                                </select>
                            </div>
                            @if ($errors->has('kondisi_udang'))
                                <span class="text-danger">{{ $errors->first('kondisi_udang') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                            required>{{ old('catatan' , $anco->catatan) }}
                            </textarea>
                            @if ($errors->has('catatan'))
                                <span class="text-danger">{{ $errors->first('catatan') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('anco') }}'"
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
@endpush
