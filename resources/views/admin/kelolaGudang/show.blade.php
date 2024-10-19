<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $gudang->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                <img src="{{ asset('storage/' . $gudang->gambar) }}" alt="Foto Gudang" class="img-fluid"
                    style="width: auto; height: 30vh;">
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Panjang : </strong> {{ $gudang->panjang ?? '-' }} </p>
                <p><strong>Lebar : </strong> {{ $gudang->lebar ?? '-' }} </p>
                <p><strong>Luas : </strong> {{ $gudang->luas ?? '-' }} </p>
                <p><strong>Alamat : </strong> {{ $gudang->alamat ?? '-' }} </p>
                </p>
            </div>
        </div>
    </div>
</div>
