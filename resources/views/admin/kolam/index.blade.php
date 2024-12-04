@extends('layouts.template')
@section('title', 'Kolam')
@section('content')
    <div class="card">
        <div class="card-header">Manajemen Kolam</div>
        <div class="card-body">
            <table class="table" id="table_manajemenKolam">
                <thead>
                    <tr class="text-center">
                        <th>KODE KOLAM</th>
                        <th>TIPE KOLAM</th>
                        <th>NAMA TAMBAK</th>
                        <th>LUAS KOLAM</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade text-left" id="kolamDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
            <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title white" id="myModalLabel160">Detail Kolam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div id="user-detail-content" class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="kolam-foto" class="img-fluid rounded mb-3" src="" alt="Foto Kolam" style="max-width: 100%; height: auto;">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Kode Kolam:</th>
                                    <td id="kolam-kode"></td>
                                </tr>
                                <tr>
                                    <th>Tipe Kolam:</th>
                                    <td id="kolam-tipe"></td>
                                </tr>
                                <tr>
                                    <th>Nama Tambak:</th>
                                    <td id="tambak-nama"></td>
                                </tr>
                                    <th>Luas Kolam:</th>
                                    <td id="kolam-luas-kolam"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                <button type="button" class="btn btn-danger" id="btn-delete-kolam">Hapus</button>
                <button type="button" class="btn btn-primary" id="btn-edit-kolam">Edit</button>
            </div>     
        </div>
    </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
    $(document).ready(function() {
        var currentKolamId = null; // Variabel global untuk menyimpan ID kolam saat ini

        var dataManajemenKolam = $('#table_manajemenKolam').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('kolam/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.id_tambak = $('#id_tambak').val();
                },
                "error": function(xhr, error, thrown) {
                    console.error('Error fetching data: ', thrown);
                }
            },
            columns: [
                {
                    data: "kd_kolam",
                    render: function(data, type, row) {
                        var url = '{{ route('admin.kolam.show', ':id') }}';
                        url = url.replace(':id', row.id_kolam);
                        return '<a href="javascript:void(0);" data-id="' + row.id_kolam +
                               '" class="view-user-details" data-url="' + url +
                               '" data-toggle="modal" data-target="#kolamDetailModal">' + data + '</a>';
                    }
                },
                { data: "tipe_kolam" },
                { data: "tambak.nama_tambak" },
                { data: "luas_kolam" },
            ],
            pagingType: "simple_numbers",
            dom: 'frtip',
            language: {
                search: ""
            }
        });

        // Event listener untuk menampilkan detail kolam
        $(document).on('click', '.view-user-details', function() {
            var url = $(this).data('url');
            currentKolamId = $(this).data('id'); // Simpan ID kolam saat ini
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.html) {
                        $('#user-detail-content').html(response.html);
                        $('#kolamDetailModal').modal('show');
                    } else {
                        alert('Gagal memuat detail kolam');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('Gagal memuat detail kolam');
                }
            });
        });

        // Tombol Edit
        $(document).on('click', '#btn-edit-kolam', function() {
            if (currentKolamId) {
                const editUrl = '{{ route('admin.kolam.edit', ':id') }}'.replace(':id', currentKolamId);
                window.location.href = editUrl; // Redirect ke halaman edit
            } else {
                alert('ID kolam tidak ditemukan');
            }
        });

        // Tombol Hapus
        $(document).on('click', '#btn-delete-kolam', function() {
    if (currentKolamId) {
        if (confirm('Apakah Anda yakin ingin menghapus data kolam ini?')) {
            const deleteUrl = '{{ route('admin.kolam.destroy', ':id') }}'.replace(':id', currentKolamId);

            $.ajax({
                url: deleteUrl,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": "DELETE"
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        window.location.href = "{{ route('admin.kolam.index') }}"; // Redirect ke halaman index
                    } else {
                        alert('Gagal menghapus kolam: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menghapus kolam');
                }
            });
        }
    } else {
        alert('ID kolam tidak ditemukan');
    }
});


        // Tambahkan tombol "Tambah" setelah kolom pencarian
        $("#table_manajemenKolam_filter").append(
            '<select class="form-control" name="id_tambak" id="id_tambak" style="margin-left: 30px; width: 150px;">' +
            '<option value="">- SEMUA -</option>' +
            '@foreach ($tambak as $item)' +
            '<option value="{{ $item->id_tambak }}">{{ $item->nama_tambak }}</option>' +
            '@endforeach' +
            '</select>' +
            '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
        );

        // Event listener untuk tombol tambah
        $("#btn-tambah").on('click', function() {
            window.location.href = "{{ url('kolam/create') }}";
        });

        // Filter berdasarkan tambak
        $('#id_tambak').on('change', function() {
            dataManajemenKolam.ajax.reload();
        });

        // Placeholder pada search
        $('input[type="search"]').attr('placeholder', 'Cari data Kolam...');
    });
</script>
@endpush
