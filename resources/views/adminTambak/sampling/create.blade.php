@extends('layouts.template')
@section('title', 'Kelola Sampling')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route ('user.sampling.store') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahsampling">
            @csrf
            <div class="row">
                <!-- Left Side Form Fields -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kd_sampling" class="form-label">Kode Sampling</label>
                        <input type="text" class="form-control" id="kd_sampling" name="kd_sampling"
                            placeholder="Masukkan kode sampling" value="{{ old('kd_sampling') }}" required autofocus>
                        @error('kd_sampling')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Kode sampling yang anda masukkan tidak valid
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
                        <label for="DOC" class="form-label">DOC (hari)</label>
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
                        <label for="berat_udang" class="form-label">Berat Udang / Ekor (gr)</label>
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
                        <label for="size_udang" class="form-label">Size Udang (cm)</label>
                        <input type="text" class="form-control" id="size_udang" name="size_udang"  step="0.01" required oninput="calculatePopulasi()"
                            placeholder="Masukkan size udang" value="{{ old('size_udang') }}" required>
                        @error('size_udang')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Size udang yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga_udang" class="form-label">Interval Hari</label>
                        <input type="text" class="form-control" id="interval_hari" name="interval_hari"
                            placeholder="Masukkan interval" value="{{ old('interval_hari') }}" required>
                        @error('interval_hari')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Interval yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga_udang" class="form-label">Harga Udang (Rp)</label>
                        <input type="text" class="form-control" id="harga_udang" name="harga_udang"
                            placeholder="Masukkan harga udang" value="{{ old('harga_udang') }}" required>
                        @error('harga_udang')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Harga udang yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="input_fr" class="form-label">Input FR (%)</label>
                        <input type="text" class="form-control" id="input_fr" name="input_fr"
                            placeholder="Masukkan Input FR" value="{{ old('input_fr') }}" required>
                        @error('input_fr')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Input FR udang yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="total_pakan" class="form-label">Total Pakan (kg)</label>
                        <input type="text" class="form-control" id="total_pakan" name="total_pakan"
                            placeholder="Otomatis dari penjumlahan pakan sebelumnya" value="{{ old('total_pakan') }}" required>
                        @error('total_pakan')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Total pakan yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ADG_udang" class="form-label">ADG udang (otomatis)</label>
                        <input type="text" class="form-control" id="ADG_udang" name="ADG_udang"
                            placeholder="(Berat sekarang - Berat sebelumnya/Interval hari)" value="{{ old('total_pakan') }}" required>
                        @error('ADG_udang')
                        <!-- <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Total pakan yang anda masukkan tidak valid
                        </div> -->
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="biomassa" class="form-label">Biomassa (kg)</label>
                        <input type="text" class="form-control" id="biomassa" name="biomassa"  step="0.01" required oninput="calculatePopulasi()"
                            placeholder="Masukkan biomassa" value="{{ old('biomassa') }}" required>
                        @error('biomassa')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Biomassa yang anda masukkan tidak valid
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                            <label for="populasi_ekor" class="form-label">Populasi Ekor</label>
                            <input type="number" class="form-control @error('populasi_ekor') is-invalid @enderror" id="populasi_ekor"
                                name="populasi_ekor" value="{{ old('populasi_ekor') }}" step="0.01" readonly>
                            <p><small class="text-muted">Hasil Hitung (Biomassa x Size)</small></p>
                            @if ($errors->has('populasi_ekor'))
                                <span class="text-danger">{{ $errors->first('populasi_ekor') }}</span>
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
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ route ('user.sampling.index') }}'"
                            style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                        <button type="submit" class="btn btn-primary btn-sm"
                            style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
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
<script>
        function calculatePopulasi() {
            let size_udang = parseFloat(document.getElementById('size_udang').value) || 0;
            let biomassa = parseFloat(document.getElementById('biomassa').value) || 0;
            let populasi_ekor = size_udang * biomassa;
            document.getElementById('populasi_ekor').value = populasi_ekor;
        }
</script>
@endpush
