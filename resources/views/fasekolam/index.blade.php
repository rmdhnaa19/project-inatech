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
                        {{-- <th>DENSITAS</th>
                        <th>JUMLAH TEBAR</th> --}}
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- modal --}}
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
                
                {{-- Modal Detail --}}
                <div id="user-detail-content" class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="pjtambak-foto" class="img-fluid rounded mb-3" src="" alt="Foto Pj Tambak" style="max-width: 100%; height: auto;">
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
                            {{-- <tr>
                                <th>Jumlah Tebar:</th>
                                <td id="faseKolam-jumlah-tebar"></td>
                            </tr>
                            <tr>
                                <th>Densitas:</th>
                                <td id="faseKolam-densitas"></td>
                            </tr> --}}
                                    
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Delete</span>
                </button>
                <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Update</span>
                </button>
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
@push('css')
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            var datafaseKolam = $('#table_faseKolam').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('fasekolam/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.id_kolam = $('#id_kolam').val();
                    },
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "kd_fase_tambak",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            var url = '{{ route('fasekolam.show', ':id') }}';
                            url = url.replace(':id', row.id_fase_tambak);
                            return '<a href="javascript:void(0);" data-id="' + row.id_fase_tambak +
                            '" class="view-user-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#faseKolamDetailModal">' + data +
                            '</a>';
                        }
                    },
                    {
                        data: "kolam.kd_kolam",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "tanggal_mulai",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "tanggal_panen",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: false,
                        searchable: false
                    },
                    // {
                    //     data: "densitas",
                    //     className: "", // Jika tidak ada class, hapus baris ini
                    //     orderable: false,
                    //     searchable: true
                    // },
                    // {
                    //     data: "jumlah_tebar",
                    //     className: "", // Jika tidak ada class, hapus baris ini
                    //     orderable: false,
                    //     searchable: true
                    // },
                ],
                pagingType: "simple_numbers", // Tambahkan ini untuk menampilkan angka pagination
                dom: 'frtip', // Mengatur layout DataTables
                language: {
                    search: "" // Menghilangkan teks "Search"
                }
            });

             // Event listener untuk menampilkan detail tambak
            $(document).on('click', '.view-user-details', function() {
                var url = $(this).data('url'); // Ambil URL dari data-url
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            $('#user-detail-content').html(response.html); // Muat konten ke modal
                            $('#faseKolamDetailModal').modal('show'); // Tampilkan modal
                        } else {
                            alert('Gagal memuat detail fase kolam');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail fase kolam');
        }
    });
});

            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_faseKolam_filter").append(
                '<select class="form-control" name="id_kolam" id="id_kolam" required style="margin-left: 30px; width: 150px;">' +
                '<option value="">- SEMUA -</option>' +
                '@foreach ($kolam as $item)' +
                '<option value="{{ $item->id_kolam }}">{{ $item->kd_kolam}}</option>' +
                '@endforeach' +
                '</select>' +
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');

            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('fasekolam/create') }}"; // Arahkan ke halaman tambah pengguna
            });

            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Fase Kolam...');
            $('#id_kolam').on('change', function() {
                datafaseKolam.ajax.reload();
            })    
        });
    </script>
@endpush
