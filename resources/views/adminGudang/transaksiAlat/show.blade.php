<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">Transaksi {{ $transaksiAlat->detailAlat->alat->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                @if ($transaksiAlat->detailAlat->alat->foto != '')
                    <img src="{{ asset('storage/' . $transaksiAlat->detailAlat->alat->foto) }}" alt="Foto Alat"
                        class="img-fluid" style="width: auto; height: 30vh;">
                @else
                    <img src="{{ asset('storage/asset_web/No Image Available.png') }}" alt="Foto Alat" class="img-fluid"
                        style="width: auto; height: 30vh;">
                @endif
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Kode : </strong> {{ $transaksiAlat->kd_transaksi_alat ?? '-' }} </p>
                <p><strong>Nama Alat : </strong> {{ $transaksiAlat->detailAlat->alat->nama ?? '-' }} </p>
                <p><strong>Nama Gudang : </strong> {{ $transaksiAlat->detailAlat->gudang->nama ?? '-' }} </p>
                <p><strong>Tipe Transaksi : </strong> {{ $transaksiAlat->tipe_transaksi ?? '-' }} </p>
                <p><strong>Kuantitas : </strong> {{ number_format($transaksiAlat->quantity, 0, ',', '.') }}
                    {{ $transaksiAlat->detailAlat->alat->satuan }}</p>
                <p><strong>Tanggal :
                    </strong>{{ \Carbon\Carbon::parse($transaksiAlat->created_at)->translatedFormat('l, j F Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
