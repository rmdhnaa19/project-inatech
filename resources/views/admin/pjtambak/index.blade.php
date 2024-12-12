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
    let currentpjtambakId = null;

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
        currentpjtambakId = $(this).data('id'); // Set current ID

        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.html) {
                    $('#user-detail-content').html(response.html);
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
        if (currentpjtambakId) {
            var url = '{{ route("admin.pjTambak.edit", ":id") }}'.replace(':id', currentpjtambakId);
            window.location.href = url;
        } else {
            alert('ID tidak ditemukan.');
        }
    });

    // Delete button
    $(document).on('click', '#btn-delete-pjtambak', function() {
        if (currentpjtambakId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data Pj Tambak ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var deleteUrl = '{{ route('admin.pjTambak.destroy', ':id') }}'
                        .replace(':id', currentpjtambakId);
                    $.ajax({
                        url: deleteUrl,
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "DELETE"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: true
                                }).then(() => {
                                    window.location.href = "{{ route('admin.pjTambak.index') }}";
                                });
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: response.message,
                                    icon: 'error'
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus data.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'ID Pj Tambak tidak ditemukan',
                icon: 'error'
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
