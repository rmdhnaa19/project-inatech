@extends('layouts.template')
@section('title', 'Tambah Transaksi Pakan')
@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('transaksiPakan') }}" class="form-horizontal" enctype="multipart/form-data"
                id="tambahTransaksiPakan">
                @csrf
                <div class=" form-group row">
                    <div class="form-group">
                        <label for="kd_transaksi_pakan" class="form-label">Kode Transaksi</label>
                        <input type="text" class="form-control @error('kd_transaksi_pakan') is-invalid @enderror"
                            id="kd_transaksi_pakan" name="kd_transaksi_pakan" placeholder="Masukkan Kode Transaksi Pakan"
                            value="{{ old('kd_transaksi_pakan') }}" required autofocus>
                        <p><small class="text-muted">Wajib Diisi!</small></p>
                        @if ($errors->has('kd_transaksi_pakan'))
                            <span class="text-danger">{{ $errors->first('kd_transaksi_pakan') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="tipe_transaksi" class="form-label">Tipe Transaksi</label>
                        <div class="form-group">
                            <select class="choices form-select @error('tipe_transaksi') is-invalid @enderror"
                                name="tipe_transaksi" id="tipe_transaksi" required>
                                <option value="">- Pilih Tipe Transaksi -</option>
                                <option value="Masuk">Masuk</option>
                                <option value="Keluar">Keluar</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Kadaluarsa">Kadaluarsa</option>
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
                            name="quantity" placeholder="Masukkan Kuantitas Pakan" value="{{ old('quantity') }}" required>
                        <p><small class="text-muted">Wajib Diisi!</small></p>
                        @if ($errors->has('quantity'))
                            <span class="text-danger">{{ $errors->first('quantity') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="id_detail_pakan" class="form-label">Nama Pakan</label>
                        <div class="form-group">
                            <select class="choices form-select @error('id_detail_pakan') is-invalid @enderror"
                                name="id_detail_pakan" id="id_detail_pakan" disabled required>
                                <option value="">- Pilih Nama Pakan -</option>
                                @foreach ($pakanGudang as $item)
                                    <option value="{{ $item->id_detail_pakan }}"
                                        @if (old('id_detail_pakan', $selectedIdDetailPakan) == $item->id_detail_pakan) selected @endif>
                                        {{ $item->pakan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                        </div>
                        <input type="hidden" name="id_detail_pakan" id="id_detail_pakan"
                            value="{{ old('id_detail_pakan', $selectedIdDetailPakan) }}">
                        @if ($errors->has('id_detail_pakan'))
                            <span class="text-danger">{{ $errors->first('id_detail_pakan') }}</span>
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('pakanGudang') }}'"
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
