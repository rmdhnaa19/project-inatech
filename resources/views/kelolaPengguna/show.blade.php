{{-- <div class="container">
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
                <p><strong>Username : </strong> {{ $user->username }} </p>
            </div>
            <div class="col">
                <p><strong>Nomor HP : </strong> {{ $user->no_hp }} </p>
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
</div> --}}

<div class="container">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $user->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div style="position: sticky; top: 20px;">
                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto User" class="img-fluid"
                    style="max-width: ; height: auto;">
            </div>
        </div>
        <div class="col-md-6">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Posisi : </strong> {{ $user->posisi ?? '-' }} </p>
                <p><strong>Username : </strong> {{ $user->username ?? '-' }} </p>
                <p><strong>Role : </strong> {{ $user->role->nama ?? '-' }} </p>
                <p><strong>Nomor HP : </strong> {{ $user->no_hp ?? '-' }} </p>
                <p><strong>Alamat : </strong> {{ $user->alamat ?? '-' }} </p>
                <p><strong>Gaji Pokok : </strong> Rp {{ $user->gaji_pokok ?? '-' }} </p>
                <p><strong>Komisi : </strong> Rp {{ $user->komisi ?? '-' }} </p>
                <p><strong>Tunjangan : </strong> Rp {{ $user->tunjangan ?? '-' }} </p>
                <p><strong>Potongan Gaji : </strong> Rp {{ $user->potongan_gaji ?? '-' }} </p>
            </div>
        </div>
    </div>
</div>
