<div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $fasekolam->kd_fase_tambak }}</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div style="position: sticky; top: 20px;">
                <img src="{{ asset('storage/' . $fasekolam->foto) }}" alt="Foto Fase Kolam" class="img-fluid"
                    style="max-width: ; height: auto;">
            </div>
        </div>
        <div class="col-md-6">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Kode Fase Kolam:</strong> {{ $fasekolam->kd_fase_tambak }}</p>
                <p><strong>Kode Kolam:</strong> {{ $fasekolam->kolam->kd_kolam ?? 'Kolam tidak ditemukan'}}</p>
                <p><strong>Tanggal Mulai:</strong> {{ $fasekolam->tanggal_mulai }}</p>
                <p><strong>Tanggal Panen:</strong> {{ $fasekolam->tanggal_panen}}</p>
                <p><strong>Jumlah Tebar:</strong> {{ $fasekolam->jumlah_tebar }}</p>
                <p><strong>Densitas:</strong> {{ $fasekolam->densitas}}</p>
            </div>
        </div>
    </div>
</div>