@extends('layouts.template')
@section('title', 'Fase Kolam')
@section('content')
    <div class="card">
        <div class="card-header">Fase Kolam</div>
        <div class="card-body">
            <table class="table" id="table_faseKolam">
                <thead>
                    <tr class="text-center">
                        <th>KODE FASE KOLAM</th>
                        <th>KODE KOLAM</th>
                        <th>TANGGAL MULAI</th>
                        <th>TANGGAL PANEN</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="faseKolamDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel160">Detail Fase Tambak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <div id="user-detail-content" class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <img id="pjtambak-foto" class="img-fluid rounded mb-3" src="" alt="Foto Pj Tambak"
                                    style="max-width: 100%; height: auto;">
                            </div>
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Kode Fase Kolam:</th>
                                        <td id="faseKolam-kode-fase-kolam"></td>
                                    </tr>
                                    <tr>
                                        <th>Kode Kolam:</th>
                                        <td id="faseKolam-kode-kolam"></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Mulai:</th>
                                        <td id="faseKolam-tanggal-mulai"></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Panen:</th>
                                        <td id="faseKolam-tanggal-panen"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-danger" id="btn-delete-fasekolam">
                        <span>Hapus</span>
                    </button>
                    <button type="button" class="btn btn-warning ml-1" id="edit-fasekolam" data-id="">
                        <span>Edit</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('css')
    @endpush
@endsection

@push('js')
<script>
    $(document).ready(function() {
        let currentfasekolamId = null;

        var datafaseKolam = $('#table_faseKolam').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('fasekolam/list') }}",
                type: "POST",
                data: function(d) {
                    d.id_kolam = $('#id_kolam').val();
                }
            },
            columns: [
                {
                    data: "kd_fase_tambak",
                    render: function(data, type, row) {
                        var url = '{{ route('admin.fasekolam.show', ':id') }}'.replace(':id', row.id_fase_tambak);
                        return `<a href="javascript:void(0);" data-id="${row.id_fase_tambak}" 
                            class="view-user-details" data-url="${url}" data-toggle="modal" 
                            data-target="#faseKolamDetailModal">${data}</a>`;
                    }
                },
                { data: "kolam.kd_kolam" },
                { data: "tanggal_mulai" },
                { data: "tanggal_panen" }
            ],
            language: { search: "" }
        });

        // View details
        $(document).on('click', '.view-user-details', function() {
            var url = $(this).data('url');
            currentfasekolamId = $(this).data('id'); // Set currentfasekolamId
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.html) {
                        $('#user-detail-content').html(response.html);
                        $('#faseKolamDetailModal').modal('show');
                    } else {
                        alert('Gagal memuat detail fase kolam');
                    }
                }
            });
        });

        // Edit button
        $(document).on('click', '#edit-fasekolam', function() {
            var id = currentfasekolamId; // Ambil ID fase kolam saat ini
            if (id) {
                var url = '{{ route("admin.fasekolam.edit", ":id") }}'.replace(':id', id);
                window.location.href = url; // Arahkan ke halaman edit
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'ID fase kolam tidak ditemukan',
                    icon: 'error'
                });
            }
        });

        // Delete button
        $(document).on('click', '#btn-delete-fasekolam', function() {
            if (currentfasekolamId) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data Fase Kolam ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var deleteUrl = '{{ route('admin.fasekolam.destroy', ':id') }}'.replace(':id', currentfasekolamId);
                        $.ajax({
                            url: deleteUrl,
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "_method": "DELETE"
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                        window.location.href = "{{ route('admin.fasekolam.index') }}";
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
            } else {
                Swal.fire('Error!', 'ID fase kolam tidak ditemukan', 'error');
            }
        });

        // Filter and tambah button
        $("#table_faseKolam_filter").append(`
            <select class="form-control" name="id_kolam" id="id_kolam" style="margin-left: 30px; width: 150px;">
                <option value="">- SEMUA -</option>
                @foreach ($kolam as $item)
                    <option value="{{ $item->id_kolam }}">{{ $item->kd_kolam }}</option>
                @endforeach
            </select>
            <button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>
        `);

        $("#btn-tambah").on('click', function() {
            window.location.href = "{{ url('fasekolam/create') }}";
        });

        $('#id_kolam').on('change', function() {
            datafaseKolam.ajax.reload();
        });
    });
</script>

@endpush
