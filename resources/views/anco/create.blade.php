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
                                id="posisi">
                                <option value="{{ old('posisi') }}">- Pilih Kondisi Pakan -</option>
                                <option value="Manager">Sisa sedikit</option>
                                <option value="Teknisi">Sisa setengah</option>
                                <option value="Analis Tambak">Sisa banyak</option>
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
                                id="posisi">
                                <option value="{{ old('posisi') }}">- Pilih Kondisi Udang -</option>
                                <option value="Manager">Udang sakit</option>
                                <option value="Teknisi">Udang sehat</option>
                                <option value="Analis Tambak">Udang mati</option>
                            </select>
                        </div>
                        @if ($errors->has('kondisi_udang'))
                            <span class="text-danger">{{ $errors->first('kondisi_udang') }}</span>
                        @endif
                    </div>

                    {{-- Tombol kembali dan simpan --}}
                    <div class="form-group">
                        <a class="btn btn-sm btn-default" href="{{ url('administrasi') }}">Kembali</a>
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
