<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">Transaksi {{ $transaksiObat->detailObat->obat->nama }} -
            {{ $transaksiObat->detailObat->gudang->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                @if ($transaksiObat->detailObat->obat->foto != '')
                    <img src="{{ asset('storage/' . $transaksiObat->detailObat->obat->foto) }}" alt="Foto Obat"
                        class="img-fluid" style="width: auto; height: 30vh;">
                @else
                    <img src="{{ asset('storage/asset_web/No Image Available.png') }}" alt="Foto Obat"
                        class="img-fluid" style="width: auto; height: 30vh;">
                @endif
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Kode : </strong> {{ $transaksiObat->kd_transaksi_obat ?? '-' }} </p>
                <p><strong>Nama Obat : </strong> {{ $transaksiObat->detailObat->obat->nama ?? '-' }} </p>
                <p><strong>Nama Gudang : </strong> {{ $transaksiObat->detailObat->gudang->nama ?? '-' }} </p>
                <p><strong>Tipe Transaksi : </strong> {{ $transaksiObat->tipe_transaksi ?? '-' }} </p>
                <p><strong>Kuantitas : </strong> {{ number_format($transaksiObat->quantity, 0, ',', '.') }}
                    {{ $transaksiObat->detailObat->obat->satuan }}</p>
                <p><strong>Tanggal :
                    </strong>{{ \Carbon\Carbon::parse($transaksiObat->created_at)->translatedFormat('l, j F Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
