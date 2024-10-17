<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $user->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto User" class="img-fluid"
                    style="width: auto; height: 30vh;">
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Posisi : </strong> {{ $user->posisi ?? '-' }} </p>
                <p><strong>Username : </strong> {{ $user->username ?? '-' }} </p>
                <p><strong>Role : </strong> {{ $user->role->nama ?? '-' }} </p>
                <p><strong>Nomor HP : </strong> {{ $user->no_hp ?? '-' }} </p>
                <p><strong>Alamat : </strong> {{ $user->alamat ?? '-' }} </p>
                <p><strong>Gaji Pokok : </strong> Rp {{ number_format($user->gaji_pokok, 0, ',', '.') }} </p>
                <p><strong>Komisi : </strong> Rp {{ number_format($user->komisi, 0, ',', '.') ?? '-' }} </p>
                <p><strong>Tunjangan : </strong> Rp {{ number_format($user->tunjangan, 0, ',', '.') ?? '-' }} </p>
                <p><strong>Potongan Gaji : </strong> Rp {{ number_format($user->potongan_gaji, 0, ',', '.') ?? '-' }}
                </p>
            </div>
        </div>
    </div>
</div>
