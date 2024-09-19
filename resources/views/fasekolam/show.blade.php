<div class="text-center mb-3">
    <h4>Detail Fase Kolam</h4>
    <img src="{{ asset('storage/' . $fasekolam->foto) }}" alt="Foto Fase Kolam" class="img-fluid mb-3" style="max-height: 200px;">
</div>
<div class="text-left">
    <p><strong>Kode Fase Kolam:</strong> {{ $fasekolam->kd_fase_tambak }}</p>
    <p><strong>Kode Kolam:</strong> {{ $fasekolam->kolam->kd_kolam ?? 'Kolam tidak ditemukan'}}</p>
    <p><strong>Tanggal Mulai:</strong> {{ $fasekolam->tanggal_mulai }}</p>
    <p><strong>Tanggal Panen:</strong> {{ $fasekolam->tanggal_panen}}</p>
    <p><strong>Jumlah Tebar:</strong> {{ $fasekolam->jumlah_tebar }}</p>
    <p><strong>Densitas:</strong> {{ $fasekolam->densitas}}</p>
</div>
