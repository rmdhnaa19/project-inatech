<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $obat->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                @if ($obat->foto != '')
                    <img src="{{ asset('storage/' . $obat->foto) }}" alt="Foto Alat" class="img-fluid"
                        style="width: auto; height: 30vh;">
                @else
                    <img src="{{ asset('storage/asset_web/No Image Available.png') }}" alt="Foto Alat" class="img-fluid"
                        style="width: auto; height: 30vh;">
                @endif
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Harga Satuan : </strong> Rp {{ number_format($obat->harga_satuan, 0, ',', '.') }} </p>
                <p><strong>Satuan : </strong> {{ $obat->satuan ?? '-' }} </p>
                <p><strong>Deskripsi : </strong> {{ $obat->deskripsi ?? '-' }} </p>
            </div>
        </div>
    </div>
</div>
