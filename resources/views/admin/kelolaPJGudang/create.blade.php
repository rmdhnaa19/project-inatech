@extends('layouts.template')
@section('title', 'Tambah Penanggung Jawab Gudang')
@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('kelolaPJGudang') }}" class="form-horizontal" enctype="multipart/form-data"
                id="tambahPJGudang">
                @csrf
                <div class="mt-3">
                    <div class="form-group">
                        <label for="kd_detail_user" class="form-label">Kode</label>
                        <input type="text" class="form-control @error('kd_detail_user') is-invalid @enderror"
                            id="kd_detail_user" name="kd_detail_user" placeholder="Masukkan Kode"
                            value="{{ old('kd_detail_user') }}" required autofocus>
                        @if ($errors->has('kd_detail_user'))
                            <span class="text-danger">{{ $errors->first('kd_detail_user') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="id_gudang" class="form-label">Nama Gudang</label>
                        <div class="form-group">
                            <select class="choices form-select @error('id_gudang') is-invalid @enderror" name="id_gudang"
                                id="id_gudang">
                                <option value="">- Pilih Gudang -</option>
                                @foreach ($gudang as $item)
                                    <option value="{{ $item->id_gudang }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('id_gudang'))
                            <span class="text-danger">{{ $errors->first('id_gudang') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="id_user" class="form-label">Nama Penanggung Jawab</label>
                        <div class="form-group">
                            <select class="choices form-select @error('id_user') is-invalid @enderror" name="id_user"
                                id="id_user">
                                <option value="">- Pilih Nama Penanggung Jawab -</option>
                                @foreach ($user as $item)
                                    <option value="{{ $item->id_user }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
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
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
@endpush
