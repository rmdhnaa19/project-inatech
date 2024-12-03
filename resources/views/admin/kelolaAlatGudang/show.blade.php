<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $alatGudang->alat->nama }} di {{ $alatGudang->gudang->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                <img src="{{ asset('storage/' . $alatGudang->alat->foto) }}" alt="Foto Alat" class="img-fluid"
                    style="width: auto; height: 30vh;">
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Kode : </strong> {{ $alatGudang->kd_detail_alat ?? '-' }} </p>
                <p><strong>Nama Alat : </strong> {{ $alatGudang->alat->nama ?? '-' }} </p>
                <p><strong>Nama Gudang : </strong> {{ $alatGudang->gudang->nama ?? '-' }} </p>
                <p><strong>Stok Alat : </strong> {{ number_format($alatGudang->stok_alat, 0, ',', '.') }} </p>
            </div>
        </div>
    </div>
</div>
