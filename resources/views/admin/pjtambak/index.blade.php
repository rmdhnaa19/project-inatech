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
    
    {{-- modal --}}
    <div class="modal fade text-left" id="pjTambakDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel160">Detail Penanggung Jawab Tambak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    {{-- Modal Detail --}}
                    <div id="user-detail-content" class="container">
                        <div class="row">
                            <div class="col-md-8">
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
                    </div>
                </div>
                <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-danger" id="btn-delete-tambak">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-tambak">Edit</button>
                </div>      
            </div>
        </div>
    </div>

    @push('css')
    <style>
        .modal-dialog {
            max-width: 40%;
            margin: 5vh auto; 
        }

        .modal-content {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-height: 70vh; 
            overflow-y: auto; 
        }

        .table-borderless th, .table-borderless td {
            padding: 0.5rem 0.5rem;
        }
    </style>
    @endpush

@endsection

@push('js')
    <script>
    $(document).ready(function() {
        var dataPjTambak = $('#table_pjTambak').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('pjTambak/list') }}",
                "dataType": "json",
                "type": "POST",
                "error": function(xhr, error, thrown) {
                    console.error('Error fetching data: ', thrown);
                }
            },
            columns: [
                {
                    data: "kd_user_tambak",
                    render: function(data, type, row) {
                        var url = '{{ route('admin.pjTambak.show', ':id') }}';
                        url = url.replace(':id', row.id_user_tambak);
                        return '<a href="javascript:void(0);" data-id="' + row.id_user_tambak +
                            '" class="view-user-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#pjTambakDetailModal">' + data +
                            '</a>';
                    }
                },
                {
                    data: "user_nama",
                    orderable: false
                },
                {
                    data: "tambak_nama",
                    orderable: false
                }
            ],
            pagingType: "simple_numbers",
            dom: 'frtip',
            language: {
                search: ""
            }
        });

        // Event listener untuk menampilkan detail tambak
    $(document).on('click', '.view-user-details', function() {
        var url = $(this).data('url');
        var id_pjtambak = $(this).data('id'); // Ambil ID tambak dari elemen yang diklik
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.html) {
                    // Load konten detail ke modal
                    $('#user-detail-content').html(response.html);

                    // Set ID tambak ke tombol Edit
                    $('#edit-pjtambak').data('id', id_pjtambak);
                    $('#pjTambakDetailModal').modal('show');
                } else {
                    alert('Gagal memuat detail penanggung jawab tambak');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                alert('Gagal memuat detail  penanggung jawab tambak');
            }
        });
    });

    // Event listener untuk tombol Edit di dalam modal
    $(document).on('click', '#edit-pjtambak', function() {
        var id = $(this).data('id'); // Ambil ID tambak dari tombol Edit
        if (id) {
            var url = '{{ route("admin.pjTambak.edit", ":id") }}';
            url = url.replace(':id', id);
            window.location.href = url;
        }
    });

        // Tambah tombol "Tambah" setelah kotak pencarian
        $("#table_pjTambak_filter").append(
            '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
        );

        // Tambahkan event listener untuk tombol Tambah
        $(document).on('click', '#btn-tambah', function() {
            window.location.href = "{{ url('pjTambak/create') }}";
        });

        // Placeholder untuk input pencarian
        $('input[type="search"]').attr('placeholder', 'Cari data Penanggung Jawab Tambak...');
    });
    </script>
@endpush
