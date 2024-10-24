<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $pakan->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                <img src="{{ asset('storage/' . $pakan->foto) }}" alt="Foto Pakan" class="img-fluid"
                    style="width: auto; height: 30vh;">
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Harga Satuan : </strong> Rp {{ number_format($pakan->harga_satuan, 0, ',', '.') }} </p>
                <p><strong>Satuan Berat : </strong> {{ $pakan->satuan ?? '-' }} </p>
                <p><strong>Deskripsi : </strong> {{ $pakan->deskripsi ?? '-' }} </p>
            </div>
        </div>
    </div>
</div>
