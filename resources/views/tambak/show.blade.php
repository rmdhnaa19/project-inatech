{{-- <div class="container">
    <h5>{{ $tambak->nama_tambak }}</h5>
</div> --}}

<div>
    <h5>Detail Tambak</h5>
    <p><strong>Nama Tambak:</strong> {{ $tambak->nama_tambak }}</p>
    <p><strong>Nama Gudang:</strong> {{ $tambak->gudang->nama }}</p>
    <p><strong>Luas Lahan:</strong> {{ $tambak->luas_lahan }}</p>
    <p><strong>Luas Tambak:</strong> {{ $tambak->luas_tambak }}</p>
    <p><strong>Lokasi Tambak:</strong> {{ $tambak->lokasi_tambak }}</p>
    @if($tambak->foto)
        <p><strong>Foto:</strong></p>
        <img src="{{ asset('storage/' . $tambak->foto) }}" alt="Foto Tambak" class="img-fluid">
    @endif
</div>

