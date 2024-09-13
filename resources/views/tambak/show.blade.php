{{-- <div class="container">
    <h5>{{ $tambak->nama_tambak }}</h5>
</div> --}}



<div class="container">
    <div class="text-center">
        <!-- Display foto -->
        @if($tambak->foto)
            <img src="{{ asset('storage/' . $tambak->foto) }}" alt="Foto Tambak" class="img-thumbnail" style="max-width: 100%; height: auto;">
        @else
            <p>No photo available</p>
        @endif
    </div>
    <div class="mt-3">
        <h5>Nama Tambak: {{ $tambak->nama_tambak }}</h5>
        <p><strong>ID Gudang:</strong> {{ $tambak->id_gudang }}</p>
        <p><strong>Luas Lahan:</strong> {{ $tambak->luas_lahan }} m²</p>
        <p><strong>Luas Tambak:</strong> {{ $tambak->luas_tambak }} m²</p>
        <p><strong>Lokasi Tambak:</strong> {{ $tambak->lokasi_tambak }}</p>
    </div>
</div>
