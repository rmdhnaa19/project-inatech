<div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-3">Detail Gudang</h4>
        <img src="{{ asset('storage/' . $gudang->gambar) }}" alt="Foto Gudang" class="img-fluid"
            style="max-height: 200px; width: auto;">
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <p><strong>Nama : </strong> {{ $gudang->nama }}</p>
            </div>
            <div class="col">
                <p><strong>Luas : </strong> {{ $gudang->luas }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Panjang : </strong> {{ $gudang->panjang }} </p>
            </div>
            <div class="col">
                <p><strong>Alamat : </strong> {{ $gudang->alamat }} </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Lebar : </strong> {{ $gudang->lebar }}</p>
            </div>
        </div>
    </div>
</div>
