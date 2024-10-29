<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $pakanGudang->pakan->nama }} di {{ $pakanGudang->gudang->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                <img src="{{ asset('storage/' . $pakanGudang->pakan->foto) }}" alt="Foto Pakan" class="img-fluid"
                    style="width: auto; height: 30vh;">
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Kode : </strong> {{ $pakanGudang->kd_detail_pakan ?? '-' }} </p>
                <p><strong>Nama Pakan : </strong> {{ $pakanGudang->pakan->nama ?? '-' }} </p>
                <p><strong>Nama Gudang : </strong> {{ $pakanGudang->gudang->nama ?? '-' }} </p>
                <p><strong>Stok Pakan : </strong> {{ number_format($pakanGudang->stok_pakan, 0, ',', '.') }} </p>
            </div>
        </div>
    </div>
</div>
