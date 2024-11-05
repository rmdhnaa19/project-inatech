@extends('layouts.template')
@section('title', 'Tambah Alat ke Gudang')
@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('kelolaAlatGudang') }}" class="form-horizontal" enctype="multipart/form-data"
                id="tambahAlatGudang">
                @csrf
                <div class=" form-group container-fluid mt-3">
                    <div class="form-group">
                        <label for="kd_detail_alat" class="form-label">Kode</label>
                        <input type="text" class="form-control @error('kd_detail_alat') is-invalid @enderror"
                            id="kd_detail_alat" name="kd_detail_alat" placeholder="Masukkan Kode Alat ke Gudang"
                            value="{{ old('kd_detail_alat') }}" required autofocus>
                        <p><small class="text-muted">Wajib Diisi!</small></p>
                        @if ($errors->has('kd_detail_alat'))
                            <span class="text-danger">{{ $errors->first('kd_detail_alat') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="id_alat" class="form-label">Nama Alat</label>
                        <div class="form-group">
                            <select class="choices form-select @error('id_alat') is-invalid @enderror" name="id_alat"
                                id="id_alat" required>
                                <option value="">- Pilih Alat -</option>
                                @foreach ($alat as $item)
                                    <option value="{{ $item->id_alat }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                        </div>
                        @if ($errors->has('id_alat'))
                            <span class="text-danger">{{ $errors->first('id_alat') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="id_gudang" class="form-label">Nama Gudang</label>
                        <div class="form-group">
                            <select class="choices form-select @error('id_gudang') is-invalid @enderror" name="id_gudang"
                                id="id_gudang" required>
                                <option value="">- Pilih Gudang -</option>
                                @foreach ($gudang as $item)
                                    <option value="{{ $item->id_gudang }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                        </div>
                        @if ($errors->has('id_gudang'))
                            <span class="text-danger">{{ $errors->first('id_gudang') }}</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('kelolaAlatGudang') }}'"
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
@endpush
