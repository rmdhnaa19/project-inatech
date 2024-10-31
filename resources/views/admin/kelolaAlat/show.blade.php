<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $alat->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                <img src="{{ asset('storage/' . $alat->foto) }}" alt="Foto Alat" class="img-fluid"
                    style="width: auto; height: 30vh;">
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Harga Satuan : </strong> Rp {{ number_format($alat->harga_satuan, 0, ',', '.') }} </p>
                <p><strong>Satuan : </strong> {{ $alat->satuan ?? '-' }} </p>
                <p><strong>Deskripsi : </strong> {{ $alat->deskripsi ?? '-' }} </p>
            </div>
        </div>
    </div>
</div>
