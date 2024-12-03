<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $kolam->kd_kolam }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                <img src="{{ asset('storage/' . $kolam->foto) }}" alt="Foto Kolam" class="img-fluid"
                    style="width: 100%; height: auto; max-height: 300px; object-fit: cover;">
            </div>
        </div>
        <div class="col-md-7">
            <div style="padding-right: 15px;">
                {{-- <p><strong>Kode Kolam :</strong> {{ $kolam->kd_kolam }}</p> --}}
                <p><strong>Tipe Kolam :</strong> {{ $kolam->tipe_kolam }}</p>
                <p><strong>Nama Tambak :</strong> {{ $kolam->tambak->nama_tambak ?? 'Tambak tidak ditemukan' }}</p>
                <p><strong>Panjang Kolam :</strong> {{ $kolam->panjang_kolam }} m</p>
                <p><strong>Luas Kolam :</strong> {{ $kolam->luas_kolam }} m²</p>
                <p><strong>Kedalaman :</strong> {{ $kolam->kedalaman }} m</p>
            </div>
        </div>
    </div>
</div>
