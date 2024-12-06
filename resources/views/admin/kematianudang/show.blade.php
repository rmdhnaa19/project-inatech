<div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-3">Detail Kematian Udang</h4>
        <img src="{{ asset('storage/' . $kematianudangs->gambar) }}" alt="gambar" class="img-fluid"
            style="max-height: 200px; width: auto;">
    </div>
    <div class="container">
        <!-- <div class="row">
            <div class="col">
                <p><strong>Gambar : </strong> {{ $kematianudangs->gambar }}</p>
            </div>
        </div> -->
        <div class="row">
            <div class="col">
                <p><strong>Kode Kematian Udang : </strong> {{ $kematianudangs->kd_kematian_udang }}</p>
            </div>
            <div class="col">
                <p><strong>Fase Kolam : </strong> {{ $kematianudangs->faseKolam->kd_fase_tambak ?? 'Fase tidak ditemukan' }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Size Udang : </strong> {{ $kematianudangs->size_udang }} </p>
            </div>
            <div class="col">
                <p><strong>Berat Udang : </strong> {{ $kematianudangs->berat_udang }} </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Catatan : </strong> {{ $kematianudangs->catatan }}</p>
            </div>
        </div>
    </div>
</div>
