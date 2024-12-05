<div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-3">Detail Penanganan</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <p><strong>Kode Penanganan : </strong> {{ $penanganans->kd_penanganan }}</p>
            </div>
            <div class="col">
                <p><strong>Fase Kolam : </strong> {{ $penanganans->faseKolam->kd_fase_tambak ?? 'Fase tidak ditemukan' }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Tanggal Cek : </strong> {{ $penanganans->tanggal_cek }} </p>
            </div>
            <div class="col">
                <p><strong>Waktu Cek : </strong> {{ $penanganans->waktu_cek }} </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Pemberian Mineral : </strong> {{ $penanganans->pemberian_mineral }}</p>
            </div>
            <div class="col">
                <p><strong>Pemberian Vitamin : </strong> {{ $penanganans->pemberian_vitamin }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Pemberian Obat : </strong> {{ $penanganans->pemberian_obat }}</p>
            </div>
            <div class="col">
                <p><strong>Penambahan Air : </strong> {{ $penanganans->penambahan_air }}</p>
            </div>
        </div>
        <div class="row">
        <div class="col">
                <p><strong>Pengurangan Air : </strong> {{ $penanganans->pengurangan_air }}</p>
            </div>
            <div class="col">
                <p><strong>Catatan : </strong> {{ $penanganans->catatan }}</p>
            </div>
        </div>
    </div>
</div>
