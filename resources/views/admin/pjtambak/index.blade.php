@extends('layouts.template')
@section('title', 'PjTambak')
@section('content')
    <div class="card">
        <div class="card-header">Penanggung Jawab Tambak</div>
        <div class="card-body">
            <table class="table" id="table_pjTambak">
                <thead>
                    <tr class="text-center">
                        <th>KODE PJ TAMBAK</th>
                        <th>NAMA PJ TAMBAK</th>
                        <th>NAMA TAMBAK</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    
    {{-- Modal Detail --}}
    <div class="modal fade text-left" id="pjTambakDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">Detail Penanggung Jawab Tambak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="user-detail-content">
                        <table class="table table-borderless">
                            <tr>
                                <th>Kode Pj Tambak:</th>
                                <td id="pjtambak-kode-pj-tambak"></td>
                            </tr>
                            <tr>
                                <th>Nama Pj Tambak:</th>
                                <td id="pjtambak-nama-pjtambak"></td>
                            </tr>
                            <tr>
                                <th>Nama Tambak:</th>
                                <td id="pjtambak-nama-tambak"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btn-delete-pjtambak">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-pjtambak">Edit</button>
                </div>      
            </div>
        </div>
    </div>

    @push('css')
    <style>
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table-borderless th, .table-borderless td {
            padding: 0.5rem;
        }

        #table_pjTambak_filter {
            display: flex;
            justify-content: space-between;
        }

        #btn-tambah {
            margin-left: 1rem;
        }
    </style>
    @endpush

@endsection

@push('js')
<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#table_pjTambak').DataTable({
        serverSide: true,
        ajax: {
            url: "{{ url('pjTambak/list') }}",
            type: "POST",
            dataType: "json",
            error: function(xhr, error, thrown) {
                console.error('Error fetching data:', thrown);
            }
        },
        columns: [
            {
                data: "kd_user_tambak",
                render: function(data, type, row) {
                    var url = '{{ route('admin.pjTambak.show', ':id') }}'.replace(':id', row.id_user_tambak);
                    return `<a href="javascript:void(0);" 
                                class="view-user-details" 
                                data-id="${row.id_user_tambak}" 
                                data-url="${url}" 
                                data-toggle="modal" 
                                data-target="#pjTambakDetailModal">${data}</a>`;
                }
            },
            { data: "user_nama", orderable: false },
            { data: "tambak_nama", orderable: false }
        ],
        pagingType: "simple_numbers",
        dom: 'frtip',
        language: {
            search: "Cari:"
        }
    });

    // Show detail modal
    $(document).on('click', '.view-user-details', function() {
        var url = $(this).data('url');
        var idPjTambak = $(this).data('id');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.html) {
                    $('#user-detail-content').html(response.html);
                    $('#btn-edit-pjtambak').data('id', idPjTambak);
                    $('#btn-delete-pjtambak').data('id', idPjTambak);
                } else {
                    alert('Gagal memuat detail');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Terjadi kesalahan saat memuat data.');
            }
        });
    });

    // Edit button
    $(document).on('click', '#btn-edit-pjtambak', function() {
        var id = $(this).data('id');
        if (id) {
            var url = '{{ route("admin.pjTambak.edit", ":id") }}'.replace(':id', id);
            window.location.href = url;
        } else {
            alert('ID tidak ditemukan.');
        }
    });

    // Delete button
    $(document).on('click', '#btn-delete-pjtambak', function() {
    var id = $(this).data('id');
    if (id && confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        $.ajax({
            url: '{{ route('admin.pjTambak.destroy', ":id") }}'.replace(':id', id),
            type: 'DELETE',
            data: { "_token": "{{ csrf_token() }}" },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    window.location.href = "{{ url('pjTambak') }}"; // Redirect ke halaman index
                } else {
                    alert('Gagal menghapus data.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Terjadi kesalahan saat menghapus data.');
            }
        });
    }
});


    // Tambah button
    $("#table_pjTambak_filter").append('<button id="btn-tambah" class="btn btn-primary">Tambah</button>');
    $(document).on('click', '#btn-tambah', function() {
        window.location.href = "{{ url('pjTambak/create') }}";
    });
});
</script>
@endpush
