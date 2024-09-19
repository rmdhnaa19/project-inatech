    <div class="text-center mb-3">
        <h4 class="mb-3">Detail Tambak</h4>
        <img src="{{ asset('storage/' . $tambak->foto) }}" alt="Foto Tambak" class="img-fluid" style="max-height: 200px; width: auto;">
    </div>
    <div class="text-left">
    <p><strong>Nama Tambak:</strong> {{ $tambak->nama_tambak }}</p>
    <p><strong>Nama Gudang:</strong> {{ $tambak->gudang->nama ?? 'Gudang tidak ditemukan' }}</p>
    <p><strong>Luas Lahan:</strong> {{ $tambak->luas_lahan }} m²</p>
    <p><strong>Luas Tambak:</strong> {{ $tambak->luas_tambak }} m²</p>
    <p><strong>Lokasi Tambak:</strong> {{ $tambak->lokasi_tambak }}</p>
</div>



