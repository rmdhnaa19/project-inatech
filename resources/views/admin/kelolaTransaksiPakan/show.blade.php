<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">Transaksi {{ $transaksiPakan->detailPakan->pakan->nama }} -
            {{ $transaksiPakan->detailPakan->gudang->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                @if ($transaksiPakan->detailPakan->pakan->foto != '')
                    <img src="{{ asset('storage/' . $transaksiPakan->detailPakan->pakan->foto) }}" alt="Foto Pakan"
                        class="img-fluid" style="width: auto; height: 30vh;">
                @else
                    <img src="{{ asset('storage/asset_web/No Image Available.png') }}" alt="Foto Pakan"
                        class="img-fluid" style="width: auto; height: 30vh;">
                @endif
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Kode : </strong> {{ $transaksiPakan->kd_transaksi_pakan ?? '-' }} </p>
                <p><strong>Nama Pakan : </strong> {{ $transaksiPakan->detailPakan->pakan->nama ?? '-' }} </p>
                <p><strong>Nama Gudang : </strong> {{ $transaksiPakan->detailPakan->gudang->nama ?? '-' }} </p>
                <p><strong>Tipe Transaksi : </strong> {{ $transaksiPakan->tipe_transaksi ?? '-' }} </p>
                <p><strong>Kuantitas : </strong> {{ number_format($transaksiPakan->quantity, 0, ',', '.') }}
                    {{ $transaksiPakan->detailPakan->pakan->satuan }}</p>
            </div>
        </div>
    </div>
</div>
