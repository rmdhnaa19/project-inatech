@extends('layouts.template')
@section('title', 'Kelola Pengguna')
@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('kelolaPengguna') }}" class="form-horizontal" enctype="multipart/form-data"
                id="tambahPengguna">
                @csrf
                <div class=" form-group row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Masukkan Username" value="{{ old('username') }}" required autofocus>
                            @error('username')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    Username yang anda masukkan tidak valid
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Masukkan Password" required>
                            @error('password')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    Password yang anda masukkan tidak valid
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="posisi" class="form-label">Role</label>
                            <div class="form-group">
                                <select class="choices form-select" name="id_role" id="id_role">
                                    <option value="{{ old('id_role') }}">- Pilih Role -</option>
                                    @foreach ($role as $item)
                                        <option value="{{ $item->id_role }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('id_role')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    Role yang anda masukkan tidak valid
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan Nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    Nama yang anda masukkan tidak valid
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp" class="form-label">Nomor Handphone</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                placeholder="Masukkan No Hp" value="{{ old('no_hp') }}" required>
                            @error('no_hp')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    No Hp yang anda masukkan tidak valid
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat"></textarea>
                            @error('no_hp')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    Alamat yang anda masukkan tidak valid
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="gaji_pokok" class="form-label">Gaji Pokok</label>
                            <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok"
                                placeholder="Masukkan Gaji Pokok" value="{{ old('gaji_pokok') }}" required>
                            @error('gaji_pokok')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    Gaji Pokok yang anda masukkan tidak valid
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="komisi" class="form-label">Komisi</label>
                            <input type="number" class="form-control" id="komisi" name="komisi"
                                placeholder="Masukkan Komisi" value="{{ old('komisi') }}" required>
                            @error('komisi')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    Komisi yang anda masukkan tidak valid
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tunjangan" class="form-label">Tunjangan</label>
                            <input type="number" class="form-control" id="tunjangan" name="tunjangan"
                                placeholder="Masukkan Tunjangan" value="{{ old('tunjangan') }}" required>
                            @error('tunjangan')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    Tunjangan yang anda masukkan tidak valid
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="potongan_gaji" class="form-label">Potongan Gaji</label>
                            <input type="number" class="form-control" id="potongan_gaji" name="potongan_gaji"
                                placeholder="Masukkan Potongan Gaji" value="{{ old('potongan_gaji') }}" required>
                            @error('potongan_gaji')
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    Potongan gaji yang anda masukkan tidak valid
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="posisi" class="form-label">Posisi</label>
                            <div class="form-group">
                                <select class="choices form-select" name="posisi" id="posisi">
                                    <option value="{{ old('posisi') }}">- Pilih Posisi -</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Teknisi">Teknisi</option>
                                    <option value="Analis Tambak">Analis Tambak</option>
                                    <option value="Pemilik Tambak">Pemilik Tambak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <div class="form-group">
                            <div class="col">
                                <img class="img-preview img-fluid mb-2 col-sm-2">
                                <div class="row mb-1">
                                    <div class="drop-zone">
                                        <div class="col">
                                            <div class="text-center row">
                                                <i class="fa-solid fa-cloud-arrow-up"
                                                    style="height: 50px; font-size: 50px"></i>
                                            </div>
                                            <div class="row">
                                                <span class="drop-zone__prompt text-center">Seret lalu letakkan file di
                                                    sini</span>
                                            </div>
                                        </div>
                                        <input type="file" name="image" class="drop-zone__input" id="foto"
                                            name="foto" onchange="previewImage()" required>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <span class="text-center">Atau</span>
                                </div>
                                <div class="row">
                                    <div class="form-file">
                                        <input type="file" class="form-file-input" id="foto" name="foto"
                                            onchange="previewImage()" required>
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
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('kelolaPengguna') }}'"
                        style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                    <button type="submit" class="btn btn-primary btn-sm"
                        style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    @endsection
    @push('css')
    @endpush
    @push('js')
        <script>
            function previewImage() {
                const foto = document.querySelector('#foto');
                const imgPreview = document.querySelector('.img-preview');
                imgPreview.style.display = 'block';
                const oFReader = new FileReader();
                oFReader.readAsDataURL(foto.files[0]);

                oFReader.onload = function(oFREvent) {
                    imgPreview.src = oFREvent.target.result;
                }
            }
        </script>
    @endpush
