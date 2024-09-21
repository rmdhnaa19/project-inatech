<div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-3">Detail Pengguna</h4>
        <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto User" class="img-fluid"
            style="max-height: 200px; width: auto;">
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <p><strong>Nama : </strong> {{ $user->nama }}</p>
            </div>
            <div class="col">
                <p><strong>Role : </strong> {{ $user->role->nama ?? 'Gudang tidak ditemukan' }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Username : </strong> {{ $user->username }} m²</p>
            </div>
            <div class="col">
                <p><strong>Nomor HP : </strong> {{ $user->no_hp }} m²</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Alamat : </strong> {{ $user->alamat }}</p>
            </div>
            <div class="col">
                <p><strong>Gaji Pokok : </strong> {{ $user->gaji_pokok }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Komisi : </strong> {{ $user->komisi }}</p>
            </div>
            <div class="col">
                <p><strong>Tunjangan : </strong> {{ $user->tunjangan }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p><strong>Tunjangan : </strong> {{ $user->tunjangan }}</p>
            </div>
            <div class="col">
                <p><strong>Posisi : </strong> {{ $user->posisi }}</p>
            </div>
        </div>
    </div>
</div>
