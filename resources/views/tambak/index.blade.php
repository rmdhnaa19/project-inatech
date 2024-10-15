@extends('layouts.template')
@section('title', 'Tambak')
@section('content')
    <div class="card">
        <div class="card-header">Manajemen Tambak</div>
        <div class="card-body">
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
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Delete</span>
                </button>
                <button type="button" class="btn btn-warning ml-1" id="edit-tambak" data-id="">
                    <span class="d-none d-sm-block">Edit</span>
                </button>
                
            </div>
        </div>
    </div>
</div>
@endsection

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
        columns: [{
                data: "nama_tambak",
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    var url = '{{ route('tambak.show', ':id') }}';
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

    // Event listener untuk menampilkan detail tambak
    $(document).on('click', '.view-user-details', function() {
        var url = $(this).data('url');
        var id_tambak = $(this).data('id'); // Ambil ID tambak dari elemen yang diklik
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.html) {
                    // Load konten detail ke modal
                    $('#user-detail-content').html(response.html);

                    // Set ID tambak ke tombol Edit
                    $('#edit-tambak').data('id', id_tambak);
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
    $(document).on('click', '#edit-tambak', function() {
        var id = $(this).data('id'); // Ambil ID tambak dari tombol Edit
        if (id) {
            var url = '{{ route("tambak.edit", ":id") }}';
            url = url.replace(':id', id);
            window.location.href = url;
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