@extends('layouts.template')
@section('title', 'Edit Transaksi Alat')
@section('content')
    <div class="card">
        <div class="card-body">
            @empty($transaksiAlat)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban white"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                </div>
                <button type="button" class="btn btn-sm btn-danger"
                    onclick="window.location.href='{{ url('kelolaTransaksiAlat') }}'"
                    style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
            @else
                <form method="POST" action="{{ url('/kelolaTransaksiAlat/' . $transaksiAlat->id_transaksi_alat) }}"
                    class="form-horizontal" enctype="multipart/form-data" id="editTransaksiAlat">
                    @csrf {!! method_field('PUT') !!}
                    <div class=" form-group row">
                        <div class="form-group">
                            <label for="kd_transaksi_alat" class="form-label">Kode</label>
                            <input type="text" class="form-control @error('kd_transaksi_alat') is-invalid @enderror"
                                id="kd_transaksi_alat" name="kd_transaksi_alat"
                                value="{{ old('kd_transaksi_alat', $transaksiAlat->kd_transaksi_alat) }}"
                                placeholder="Masukkan Kode Transaksi Alat" required autofocus>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('kd_transaksi_alat'))
                                <span class="text-danger">{{ $errors->first('kd_transaksi_alat') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="tipe_transaksi" class="form-label">Tipe Transaksi</label>
                            <div class="form-group">
                                <select class="choices form-select @error('tipe_transaksi') is-invalid @enderror"
                                    name="tipe_transaksi" id="tipe_transaksi" required>
                                    <option value="">- Pilih Tipe Transaksi -</option>
                                    <option value="Masuk"
                                        {{ old('tipe_transaksi', $transaksiAlat->tipe_transaksi) == 'Masuk' ? 'selected' : '' }}>
                                        Masuk
                                    </option>
                                    <option value="Keluar"
                                        {{ old('tipe_transaksi', $transaksiAlat->tipe_transaksi) == 'Keluar' ? 'selected' : '' }}>
                                        Keluar
                                    </option>
                                    <option value="Rusak"
                                        {{ old('tipe_transaksi', $transaksiAlat->tipe_transaksi) == 'Rusak' ? 'selected' : '' }}>
                                        Rusak
                                    </option>
                                </select>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                            </div>
                            @if ($errors->has('tipe_transaksi'))
                                <span class="text-danger">{{ $errors->first('tipe_transaksi') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="quantity" class="form-label">Kuantitas</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                                name="quantity" value="{{ old('quantity', $transaksiAlat->quantity) }}"
                                placeholder="Masukkan Kuantitas Alat" required>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('quantity'))
                                <span class="text-danger">{{ $errors->first('quantity') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="id_detail_alat" class="form-label">Alat & Gudang</label>
                            <div class="form-group">
                                <select class="choices form-select @error('id_detail_alat') is-invalid @enderror"
                                    name="id_detail_alat" id="id_detail_alat" required>
                                    <option value="">- Pilih Alat & Gudang -</option>
                                    @foreach ($alatGudang as $item)
                                        <option value="{{ $item->id_detail_alat }}"
                                            @if ($item->id_detail_alat == $transaksiAlat->id_detail_alat) selected @endif>
                                            {{ $item->alat->nama }} - {{ $item->gudang->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                            </div>
                            @if ($errors->has('id_detail_alat'))
                                <span class="text-danger">{{ $errors->first('id_detail_alat') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ url('kelolaTransaksiAlat') }}'"
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
