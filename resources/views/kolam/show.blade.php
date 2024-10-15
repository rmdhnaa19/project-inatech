<div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-3">Detail Kolam</h4>
        <img src="{{ asset('storage/' . $kolam->foto) }}" alt="Foto Kolam" class="img-fluid"
            style="max-height: 200px; width: auto;">
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <p><strong>Kode Kolam: </strong> {{ $kolam->kd_kolam }}</p>
            </div>
            <div class="col">
                <p><strong>Tipe Kolam : </strong> {{ $kolam->tipe_kolam }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Nama Tambak: </strong> {{ $kolam->tambak->nama_tambak ?? 'Tambak tidak ditemukan' }} m²</p>
            </div>
            <div class="col">
                <p><strong>Panjang Kolam: </strong> {{ $kolam->panjang_kolam }} m</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Lebar Kolam: </strong> {{ $kolam->lebar_kolam }} m</p>
            </div>
            <div class="col">
                <p><strong>Luas Kolam: </strong> {{ $kolam->luas_kolam }} m²</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Kedalaman: </strong> {{ $kolam->kedalaman}} m</p>
            </div>
        </div>
    </div>
</div>




{{-- <div class="text-center mb-3">
    <h4>Detail Kolam</h4>
    <img src="{{ asset('storage/' . $kolam->foto) }}" alt="Foto Kolam" class="img-fluid mb-3" style="max-height: 200px;">
    </div>
    <div class="text-left">
    <p><strong>Kode Kolam:</strong> {{ $kolam->kd_kolam }}</p>
    <p><strong>Tipe Kolam:</strong> {{ $kolam->tipe_kolam }}</p>
    <p><strong>Nama Tambak:</strong> {{ $kolam->tambak->nama_tambak ?? 'Tambak tidak ditemukan' }}</p>
    <p><strong>Panjang Kolam:</strong> {{ $kolam->panjang_kolam }} m</p>
    <p><strong>Lebar Kolam:</strong> {{ $kolam->lebar_kolam }} m</p>
    <p><strong>Luas Kolam:</strong> {{ $kolam->luas_kolam }} m²</p>
    <p><strong>Kedalaman:</strong> {{ $kolam->kedalaman}} m</p>
</div> --}}