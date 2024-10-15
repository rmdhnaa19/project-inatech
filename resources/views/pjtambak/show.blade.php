<div>
    <p><strong>Kode PJ Tambak:</strong> {{ $pjtambak->kd_user_tambak }}</p>
    <p><strong>Nama PJ Tambak:</strong> {{ $pjtambak->user->nama ?? 'Nama PJ Tambak tidak ditemukan' }}</p>
    <p><strong>Nama Tambak:</strong> {{ $pjtambak->tambak->nama_tambak ?? 'Tambak tidak ditemukan' }}</p>
</div>


{{-- <div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $pjtambak->kd_user_tambak }}</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div style="position: sticky; top: 20px;">
                <img src="{{ asset('storage/' . $tambak->foto) }}" alt="Foto Tambak" class="img-fluid"
                    style="max-width: ; height: auto;">
            </div>
        </div>
        <div class="col-md-6">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Kode PJ Tambak : </strong> {{ $pjtambak->kd_user_tambak }} </p>
                <p><strong>Nama PJ Tambak : </strong> {{ $pjtambak->user->nama ?? 'Nama PJ Tambak tidak ditemukan' }} </p>
                <p><strong>Nama Tambak : </strong> {{ $pjtambak->tambak->nama_tambak ?? 'Tambak tidak ditemukan' }} m²</p>
            </div>
        </div>
    </div>
</div> --}}


{{-- <div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-3">Detail Penanggung Jawab</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <p><strong>Kode PJ Tambak: </strong> {{ $pjtambak->kd_user_tambak }}</p>
            </div>
            <div class="col">
                <p><strong>Nama PJ Tambak : </strong> {{ $pjtambak->user->nama ?? 'PJ Tambak tidak ditemukan' }}</p>
            </div>
            <div class="col">
                <p><strong>Nama Tambak : </strong> {{ $pjtambak->tambak->nama_tambak ?? 'Tambak tidak ditemukan' }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Luas Lahan : </strong> {{ $tambak->luas_lahan}} m²</p>
            </div>
            <div class="col">
                <p><strong>Luas Tambak : </strong> {{ $tambak->luas_tambak }} m²</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Lokasi Tambak: </strong> {{ $tambak->lokasi_tambak }}</p>
            </div>
        </div>
    </div>
</div>
 --}}
