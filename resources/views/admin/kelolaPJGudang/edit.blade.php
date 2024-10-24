@extends('layouts.template')
@section('title', 'Edit Penanggung Jawab Gudang')
@section('content')
    <div class="card">
        <div class="card-body">
            @empty($pjGudang)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban white"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                </div>
                <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('kelolaPJGudang') }}'"
                    style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
            @else
                <form method="POST" action="{{ url('/kelolaPJGudang/' . $pjGudang->id_detail_user) }}" class="form-horizontal"
                    enctype="multipart/form-data" id="editPJGudang">
                    @csrf {!! method_field('PUT') !!}
                    <div class="mt-3">
                        <div class="form-group">
                            <label for="kd_detail_user" class="form-label">Kode</label>
                            <input type="text" class="form-control @error('kd_detail_user') is-invalid @enderror"
                                id="kd_detail_user" name="kd_detail_user"
                                value="{{ old('kd_detail_user', $pjGudang->kd_detail_user) }}"
                                placeholder="Masukkan Kode Penanggung Jawab Gudang" required autofocus>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('kd_detail_user'))
                                <span class="text-danger">{{ $errors->first('kd_detail_user') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="id_gudang" class="form-label">Nama Gudang</label>
                            <div class="form-group">
                                <select class="choices form-select @error('id_gudang') is-invalid @enderror" name="id_gudang"
                                    id="id_gudang" required>
                                    <option value="">- Pilih Gudang -</option>
                                    @foreach ($gudang as $item)
                                        <option value="{{ $item->id_gudang }}"
                                            @if ($item->id_gudang == $pjGudang->id_gudang) selected @endif>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                            </div>
                            @if ($errors->has('id_gudang'))
                                <span class="text-danger">{{ $errors->first('id_gudang') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="id_user" class="form-label">Nama Penanggung Jawab</label>
                            <div class="form-group">
                                <select class="choices form-select @error('id_user') is-invalid @enderror" name="id_user"
                                    id="id_user" required>
                                    <option value="">- Pilih Penanggung Jawab -</option>
                                    @foreach ($user as $item)
                                        <option value="{{ $item->id_user }}" @if ($item->id_user == $pjGudang->id_user) selected @endif>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                            </div>
                            @if ($errors->has('id_user'))
                                <span class="text-danger">{{ $errors->first('id_user') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ url('kelolaPJGudang') }}'"
                            style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                        <button type="submit" class="btn btn-primary btn-sm"
                            style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush
