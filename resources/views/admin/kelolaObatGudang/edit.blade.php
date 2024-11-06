@extends('layouts.template')
@section('title', 'Edit Obat ke Gudang')
@section('content')
    <div class="card">
        <div class="card-body">
            @empty($obatGudang)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban white"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                </div>
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="window.location.href='{{ url('kelolaObatGudang') }}'"
                    style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
            @else
                <form method="POST" action="{{ url('/kelolaObatGudang/' . $obatGudang->id_detail_obat) }}"
                    class="form-horizontal" enctype="multipart/form-data" id="editObatGudang">
                    @csrf {!! method_field('PUT') !!}
                    <div class="container-fluid mt-3">
                        <div class="form-group">
                            <label for="kd_detail_obat" class="form-label">Kode</label>
                            <input type="text" class="form-control @error('kd_detail_obat') is-invalid @enderror"
                                id="kd_detail_obat" name="kd_detail_obat"
                                value="{{ old('kd_detail_obat', $obatGudang->kd_detail_obat) }}"
                                placeholder="Masukkan Kode Obat ke Gudang" required autofocus>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('kd_detail_obat'))
                                <span class="text-danger">{{ $errors->first('kd_detail_obat') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="id_obat" class="form-label">Nama Obat</label>
                            <div class="form-group">
                                <select class="choices form-select @error('id_obat') is-invalid @enderror" name="id_obat"
                                    id="id_obat" required>
                                    <option value="">- Pilih Obat -</option>
                                    @foreach ($obat as $item)
                                        <option value="{{ $item->id_obat }}" @if ($item->id_obat == $obatGudang->id_obat) selected @endif>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                            </div>
                            @if ($errors->has('id_obat'))
                                <span class="text-danger">{{ $errors->first('id_obat') }}</span>
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
                                            @if ($item->id_gudang == $obatGudang->id_gudang) selected @endif>
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
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ url('kelolaObatGudang') }}'"
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
