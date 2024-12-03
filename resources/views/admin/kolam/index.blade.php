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
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Hapus</span>
                </button>
                <button type="button" class="btn btn-warning ml-1" id="edit-kolam" data-id="">
                    <span class="d-none d-sm-block">Edit</span>
                </button>
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
                        className: "",
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            var url = '{{ route('kolam.show', ':id') }}';
                            url = url.replace(':id', row.id_kolam);
                            return '<a href="javascript:void(0);" data-id="' + row.id_kolam +
                '" class="view-user-details" data-url="' + url +
                '" data-toggle="modal" data-target="#kolamDetailModal">' + data +
                '</a>';                                
                        }
                    },
                    {
                        data: "tipe_kolam",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "tambak.nama_tambak",
                        className: "",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "luas_kolam",
                        className: "",
                        orderable: true,
                        searchable: true
                    },
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
        var id_kolam = $(this).data('id'); // Ambil ID tambak dari id kolam jika di klik
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.html) {
                    $('#user-detail-content').html(response.html);
                    $('#edit-kolam').data('id', id_kolam);
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

    // Event listener untuk tombol Edit di dalam modal
    $(document).on('click', '#edit-kolam', function() {
        var id = $(this).data('id'); 
        if (id) {
            var url = '{{ route("kolam.edit", ":id") }}';
            url = url.replace(':id', id);
            window.location.href = url;
        }
    });

    // Tambahkan tombol "Tambah" setelah kolom pencarian
    $("#table_manajemenKolam_filter").append(
                '<select class="form-control" name="id_tambak" id="id_tambak" required style="margin-left: 30px; width: 150px;">' +
                '<option value="">- SEMUA -</option>' +
                '@foreach ($tambak as $item)' +
                '<option value="{{ $item->id_tambak }}">{{ $item->nama_tambak }}</option>' +
                '@endforeach' +
                '</select>' +
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');
                

            // Tambahkan event listener untuk tombol tambah 
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('kolam/create') }}"; 
            });
            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Kolam...');
            $('#id_tambak').on('change', function() {
                dataManajemenKolam.ajax.reload();
            })        
        });
    </script>
@endpush
