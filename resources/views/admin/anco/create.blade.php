@extends('layouts.template')
@section('title', 'Kelola Anco') 
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('anco') }}" class="form-horizontal" enctype="multipart/form-data"
            id="tambahanco">
            @csrf
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_anco" class="form-label">Kode Anco</label>
                        <input type="text" class="form-control" id="kd_anco" name="kd_anco"
                            placeholder="Masukkan kode anco " value="{{ old('kd_anco') }}" required autofocus>
                        @error('kd_anco')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Kode anco yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                            <label for="fase_tambak" class="form-label">Fase Kolam</label>
                            <div class="form-group">
                                <select class="choices form-select @error('id_fase_tambak') is-invalid @enderror" name="id_fase_tambak"
                                    id="id_fase_tambak">
                                    <option value="{{ old('id_fase_tambak') }}">- Pilih Fase Kolam -</option>
                                    @foreach ($fase_kolam as $item)
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
                        <input type="date" class="form-control" id="tanggal_cek" name="tanggal_cek"
                            placeholder="Masukkan tanggal cek" value="{{ old('tanggal_cek') }}" required>
                        @error('tanggal_cek')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Tanggal cek yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="waktu_cek" class="form-label">Waktu Cek</label>
                        <input type="time" class="form-control" id="waktu_cek" name="waktu_cek"
                            placeholder="Masukkan waktu cek" value="{{ old('waktu_cek') }}" required>
                        @error('waktu_cek')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Waktu cek yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pemberian_pakan" class="form-label">Pemberian Pakan (kg)</label>
                        <input type="string" class="form-control" id="pemberian_pakan" name="pemberian_pakan"
                            placeholder="Masukkan pemberian pakan" value="{{ old('pemberian_pakan') }}" required>
                        @error('waktu_cek')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Pemberian pakan yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jamPemberian_pakan" class="form-label">Jam Pemberian Pakan</label>
                        <input type="time" class="form-control" id="jamPemberian_pakan" name="jamPemberian_pakan"
                            placeholder="Masukkan jam pPemberian pakan" value="{{ old('jamPemberian_pakan') }}" required>
                        @error('jamPemberian_pakan')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Jam pemberian pakan yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="kondisi_pakan" class="form-label">Kondisi Pakan</label>
                        <div class="form-group">
                            <select class="choices form-select @error('kondisi_pakan') is-invalid @enderror" name="kondisi_pakan"
                                id="kondisi_pakan">
                                <option value="{{ old('kondisi_pakan') }}">- Pilih Kondisi Pakan -</option>
                                <option value="Sisa sedikit">Sisa sedikit</option>
                                <option value="Sisa setengah">Sisa setengah</option>
                                <option value="Sisa banyak">Sisa banyak</option>
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
                                <option value="{{ old('kondisi_udang') }}">- Pilih Kondisi Udang -</option>
                                <option value="Udang sakit">Udang sakit</option>
                                <option value="Udang sehat">Udang sehat</option>
                                <option value="Udang mati">Udang mati</option>
                            </select>
                        </div>
                        @if ($errors->has('kondisi_udang'))
                            <span class="text-danger">{{ $errors->first('kondisi_udang') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                            placeholder="Tambahkan catatan"></textarea>
                        @if ($errors->has('catatan'))
                            <span class="text-danger">{{ $errors->first('catatan') }}</span>
                        @endif
                    </div>

                    {{-- Tombol kembali dan simpan --}}
                    <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('anco') }}'"
                        style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                    <button type="submit" class="btn btn-primary btn-sm"
                        style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
                </div>
                </div>

                {{-- Tambahkan foto di sini --}}
                <!-- <div class="col-md-6 d-flex justify-content-center align-items-center">
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
                            <div class="row text-center">
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
                </div> -->
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
</script>
@endpush
