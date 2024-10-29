@extends('layouts.template')
@section('title', 'Tambah Pakan ke Gudang')
@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('kelolaPakanGudang') }}" class="form-horizontal" enctype="multipart/form-data"
                id="tambahPakanGudang">
                @csrf
                <div class=" form-group container-fluid mt-3">
                    <div class="form-group">
                        <label for="kd_detail_pakan" class="form-label">Kode</label>
                        <input type="text" class="form-control @error('kd_detail_pakan') is-invalid @enderror"
                            id="kd_detail_pakan" name="kd_detail_pakan" placeholder="Masukkan Kode Pakan ke Gudang"
                            value="{{ old('kd_detail_pakan') }}" required autofocus>
                        <p><small class="text-muted">Wajib Diisi!</small></p>
                        @if ($errors->has('kd_detail_pakan'))
                            <span class="text-danger">{{ $errors->first('kd_detail_pakan') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="id_pakan" class="form-label">Nama Pakan</label>
                        <div class="form-group">
                            <select class="choices form-select @error('id_pakan') is-invalid @enderror" name="id_pakan"
                                id="id_pakan" required>
                                <option value="">- Pilih Pakan -</option>
                                @foreach ($pakan as $item)
                                    <option value="{{ $item->id_pakan }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                        </div>
                        @if ($errors->has('id_pakan'))
                            <span class="text-danger">{{ $errors->first('id_pakan') }}</span>
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
                        onclick="window.location.href='{{ url('kelolaPakanGudang') }}'"
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
