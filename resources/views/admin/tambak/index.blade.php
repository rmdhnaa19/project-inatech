@extends('layouts.template')
@section('title', 'Tambak')
@section('content')
    <div class="card">
        <div class="card-header">Manajemen Tambak</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table" id="table_manajemenTambak">
                <thead>
                    <tr class="text-center">
                        <th>NAMA TAMBAK</th>
                        <th>NAMA GUDANG</th>
                        <th>LUAS LAHAN (m²)</th>
                        <th>LUAS TAMBAK (m²)</th>
                        <th>LOKASI TAMBAK</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade text-left" id="tambakDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
            <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title white" id="myModalLabel160">Detail Tambak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                
                {{-- Modal Detail --}}
                <div id="user-detail-content" class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="tambak-foto" class="img-fluid rounded mb-3" src="" alt="Foto Tambak" style="max-width: 100%; height: auto;">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Nama Tambak:</th>
                                    <td id="tambak-nama"></td>
                                </tr>
                                <tr>
                                    <th>Gudang:</th>
                                    <td id="tambak-gudang"></td>
                                </tr>
                                <tr>
                                    <th>Luas Lahan:</th>
                                    <td id="tambak-luas-lahan"></td>
                                </tr>
                                <tr>
                                    <th>Luas Tambak:</th>
                                    <td id="tambak-luas-tambak"></td>
                                </tr>
                                <tr>
                                    <th>Lokasi:</th>
                                    <td id="tambak-lokasi"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
                <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-danger" id="btn-delete-tambak">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-tambak">Edit</button>
                </div>                
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
        var dataManajemenTambak = $('#table_manajemenTambak').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('tambak/list') }}",
                "dataType": "json",
                "type": "POST",
                "error": function(xhr, error, thrown) {
                    console.error('Error fetching data: ', thrown);
                }
            },
            columns: [
                {
                    data: "nama_tambak",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.tambak.show', ':id') }}';
                        url = url.replace(':id', row.id_tambak);
                        return '<a href="javascript:void(0);" data-id="' + row.id_tambak +
                            '" class="view-user-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#tambakDetailModal">' + data +
                            '</a>';
                    }
                },
                {
                    data: "gudang.nama",
                    orderable: false,
                    searchable: true
                },
                {
                    data: "luas_lahan",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "luas_tambak",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "lokasi_tambak",
                    orderable: true,
                    searchable: true
                }
            ],
            pagingType: "simple_numbers",
            dom: 'frtip',
            language: {
                search: ""
            }
        });

        var currentTambakId = null; // Variabel untuk menyimpan ID tambak

        // Event listener untuk menampilkan detail tambak
        $(document).on('click', '.view-user-details', function() {
            var url = $(this).data('url');
            currentTambakId = $(this).data('id'); // Simpan ID tambak
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.html) {
                        // Load konten detail ke modal
                        $('#user-detail-content').html(response.html);
                        $('#tambakDetailModal').modal('show');
                    } else {
                        alert('Gagal memuat detail tambak');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('Gagal memuat detail tambak');
                }
            });
        });

        // Event listener untuk tombol Edit di dalam modal
        $(document).on('click', '#btn-edit-tambak', function() {
            if (currentTambakId) {
                var editUrl = '{{ route('admin.tambak.edit', ':id') }}'.replace(':id', currentTambakId);
                window.location.href = editUrl; // Redirect ke halaman edit
            } else {
                alert('ID tambak tidak ditemukan');
            }
        });

        // Event listener untuk tombol Hapus di dalam modal
        $(document).on('click', '#btn-delete-tambak', function() {
    if (currentTambakId) {
        if (confirm('Apakah Anda yakin ingin menghapus data tambak ini?')) {
            var deleteUrl = '{{ route('admin.tambak.destroy', ':id') }}'.replace(':id', currentTambakId);
            $.ajax({
                url: deleteUrl,
                type: 'POST', // Masih POST karena perlu override
                data: {
                    "_token": "{{ csrf_token() }}",
                    "_method": "DELETE" // Override metode menjadi DELETE
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        window.location.href = "{{ route('admin.tambak.index') }}"; // Redirect ke index
                    } else {
                        alert('Gagal menghapus tambak: ' + response.message);
                    }
                },
                error: function(xhr) {
                    let errorMsg = 'Gagal menghapus tambak.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg += ' ' + xhr.responseJSON.message;
                    }
                    alert(errorMsg);
                }
            });
        }
    } else {
        alert('ID tambak tidak ditemukan');
    }
});


        // Tambahkan tombol "Tambah" setelah kolom pencarian
        $("#table_manajemenTambak_filter").append(
            '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
        );

        // Event listener untuk tombol tambah
        $("#btn-tambah").on('click', function() {
            window.location.href = "{{ url('tambak/create') }}";
        });

        // Menambahkan placeholder pada kolom search
        $('input[type="search"]').attr('placeholder', 'Cari data Tambak...');
    });
</script>


@endpush