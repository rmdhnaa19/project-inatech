@extends('layouts.template')
@section('title', 'Kelola Pakan Harian')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('pakanHarian') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahpakanharian">
            @csrf
            <div class="row">
                <!-- Left Side Form Fields -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_pakan_harian" class="form-label">Kode Pakan Harian</label>
                        <input type="text" class="form-control" id="kd_pakan_harian" name="kd_pakan_harian"
                            placeholder="Masukkan kode pakan harian" value="{{ old('pakan_harian') }}" required autofocus>
                        @error('kd_pakan_harian')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Kode pakan harian yang anda masukkan tidak valid
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
                        <label for="DOC" class="form-label">DOC</label>
                        <input type="text" class="form-control" id="DOC" name="DOC"
                            placeholder="Masukkan DOC" value="{{ old('DOC') }}" required>
                        @error('DOC')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            DOC yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="berat_udang" class="form-label">Berat Udang</label>
                        <input type="text" class="form-control" id="berat_udang" name="berat_udang"
                            placeholder="Masukkan berat udang" value="{{ old('berat_udang') }}" required>
                        @error('berat_udang')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Berat udang yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="total_pakan" class="form-label">Total Pakan</label>
                        <input type="text" class="form-control" id="total_pakan" name="total_pakan"
                            placeholder="Masukkan total pakan" value="{{ old('total_pakan') }}" required>
                        @error('total_pakan')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Total pakan yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3"
                            placeholder="Tambahkan catatan"></textarea>
                        @if ($errors->has('catatan'))
                            <span class="text-danger">{{ $errors->first('catatan') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('pakanharian') }}'"
                        style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                        <button type="submit" class="btn btn-warning btn-sm">Simpan</button>
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
