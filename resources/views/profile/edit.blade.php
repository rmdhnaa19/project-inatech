@extends('layouts.template')
@section('title', 'Edit Profil Pengguna')
@section('content')
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            @empty($user)
                                <div class="alert alert-danger alert-dismissible">
                                    <h5><i class="icon fas fa-ban white"></i> Kesalahan!</h5> Data yang Anda cari tidak
                                    ditemukan.
                                </div>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="window.location.href='{{ route('dashboard.index') }}'"
                                    style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                            @else
                                <h5 class="text-center my-3">Foto Profil</h5>
                                <div class="d-flex justify-content-center align-items-center profile-picture-container mb-4"
                                    style="position: relative; display: inline-block;">
                                    <!-- Foto Profil -->
                                    @if ($user->foto != '')
                                        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil"
                                            style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('storage/asset_web/No Image Profile.png') }}" alt="Foto Pengguna"
                                            class="img-fluid" style="width: auto; height: 30vh; object-fit: cover">
                                    @endif
                                </div>
                                <form class="form" method="POST" action="{{ url('/profile/' . $user->id_user) }}"
                                    enctype="multipart/form-data" id="editProfile">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text"
                                                    class="form-control @error('username') is-invalid @enderror" id="username"
                                                    name="username" value="{{ old('username', $user->username) }}"
                                                    placeholder="Masukkan Username Pengguna" required autofocus>
                                                <p><small class="text-muted">Wajib Diisi!</small></p>
                                                @if ($errors->has('username'))
                                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        id="password" name="password"
                                                        placeholder="Abaikan (Jangan Diisi) Jika Tidak Ingin Mengganti Password">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="toggle-password"
                                                            style="cursor: pointer; padding: 0.7rem 0.6rem;">
                                                            <i class="fa fa-eye" id="eye-icon"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <p><small class="text-muted">Boleh Dikosongi.</small></p>
                                                @if ($errors->has('password'))
                                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                    id="nama" name="nama" value="{{ old('nama', $user->nama) }}"
                                                    placeholder="Masukkan Nama Pengguna" required>
                                                <p><small class="text-muted">Wajib Diisi!</small></p>
                                                @if ($errors->has('nama'))
                                                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="no_hp" class="form-label">Nomor Handphone</label>
                                                <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                                    id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                                                    placeholder="Masukkan Nomor Hp Pengguna">
                                                <p><small class="text-muted">Boleh Dikosongi.</small></p>
                                                @if ($errors->has('no_hp'))
                                                    <span class="text-danger">{{ $errors->first('no_hp') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="window.location.href='{{ url('/dashboard') }}'"
                                                style="background-color: #DC3545; border-color: #DC3545"
                                                id="btn-kembali">Kembali</button>
                                            <button type="submit" class="btn btn-primary btn-sm"
                                                style="background-color: #007BFF; border-color: #007BFF"
                                                id="btn-simpan">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            @endempty
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('css')
    <style>
        .profile-picture-container:hover .overlay {
            display: flex;
        }
    </style>
@endpush
@push('js')
    <script>
        document.getElementById('toggle-password').addEventListener('click', function(e) {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
@endpush
