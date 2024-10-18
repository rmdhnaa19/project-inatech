<div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $gudang->nama }}</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <img src="{{ asset('storage/' . $gudang->gambar) }}" alt="Foto Gudang" class="img-fluid"
                    style="height: auto; width: 500px">
            </div>
            <div class="col-md-7">
                <div class="row">
                    <p><strong>Panjang : </strong> {{ $gudang->panjang }} </p>
                </div>
                <div class="row">
                    <p><strong>Luas : </strong> {{ $gudang->luas }}</p>
                </div>
                <div class="row">
                    <p><strong>Lebar : </strong> {{ $gudang->lebar }}</p>
                </div>
                <div class="row">
                    <p><strong>Alamat : </strong> {{ $gudang->alamat }} </p>
                </div>
            </div>
        </div>
    </div>
</div>
