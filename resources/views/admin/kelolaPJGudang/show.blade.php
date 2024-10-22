<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">Penanggung Jawab {{ $pjGudang->gudang->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                <img src="{{ asset('storage/' . $pjGudang->user->foto) }}" alt="Foto User" class="img-fluid"
                    style="width: auto; height: 30vh;">
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Kode : </strong> {{ $pjGudang->kd_detail_user ?? '-' }} </p>
                <p><strong>Nama Gudang : </strong> {{ $pjGudang->gudang->nama ?? '-' }} </p>
                <p><strong>Nama Penanggung Jawab Gudang : </strong> {{ $pjGudang->user->nama ?? '-' }} </p>
            </div>
        </div>
    </div>
</div>
