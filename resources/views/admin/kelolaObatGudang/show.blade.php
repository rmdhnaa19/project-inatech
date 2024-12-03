<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $obatGudang->obat->nama }} di {{ $obatGudang->gudang->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                <img src="{{ asset('storage/' . $obatGudang->obat->foto) }}" alt="Foto Obat" class="img-fluid"
                    style="width: auto; height: 30vh;">
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Kode : </strong> {{ $obatGudang->kd_detail_obat ?? '-' }} </p>
                <p><strong>Nama Obat : </strong> {{ $obatGudang->obat->nama ?? '-' }} </p>
                <p><strong>Nama Gudang : </strong> {{ $obatGudang->gudang->nama ?? '-' }} </p>
                <p><strong>Stok Obat : </strong> {{ number_format($obatGudang->stok_obat, 0, ',', '.') }} </p>
            </div>
        </div>
    </div>
</div>
