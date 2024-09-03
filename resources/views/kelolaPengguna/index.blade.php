@extends('layouts.template')
@section('title', 'Kelola Pengguna')
@section('content')
    <div class="card">
        <div class="card-header">Data Pengguna</div>
        <div class="card-body">
            <table class="table mb-3" id="table_kelolaPengguna">
                <thead>
                    <a href=""></a>
                    <tr class="text-center">
                        <th>NAMA</th>
                        <th>NO HP</th>
                        <th>POSISI</th>
                        <th>ROLE</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!--primary theme Modal -->
    <!--primary theme Modal -->
    <div class="modal fade text-left" id="primary" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">Detail Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="user-detail-content" class="container text-center">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Accept</span>
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
            var dataKelolaPengguna = $('#table_kelolaPengguna').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kelolaPengguna/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                    data: "nama",
                    className: "", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        var url = '{{ route('kelolaPengguna.show', ':id') }}';
                        url = url.replace(':id', row
                            .id); // Menggunakan row.id untuk mendapatkan ID pengguna
                        return '<a href="javascript:void(0);" data-id="' + row.id +
                            '" class="view-user-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#primary">' + data +
                            '</a>';
                    }
                }, {
                    data: "no_hp",
                    className: "", // Jika tidak ada class, hapus baris ini
                    orderable: false,
                    searchable: false
                }, {
                    data: "posisi",
                    className: "", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: true
                }, {
                    data: "role.nama",
                    className: "", // Jika tidak ada class, hapus baris ini
                    orderable: false,
                    searchable: true
                }],
                pagingType: "simple_numbers", // Tambahkan ini untuk menampilkan angka pagination
                dom: 'frtip', // Mengatur layout DataTables
                language: {
                    search: "" // Menghilangkan teks "Search"
                }
            });

            // Event listener untuk menampilkan detail pengguna
            $(document).on('click', '.view-user-details', function() {
                var url = $(this).data('url');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#userDetailModal .modal-body').html(data);
                        $('#userDetailModal').modal('show');
                    },
                    error: function() {
                        alert('Gagal memuat detail pengguna');
                    }
                });
            });

            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_kelolaPengguna_filter").append(
                '<select class="form-control" name="id_role" id="id_role" required style="margin-left: 30px; width: 150px;">' +
                '<option value="">- SEMUA -</option>' +
                '@foreach ($role as $item)' +
                '<option value="{{ $item->id_role }}">{{ $item->nama }}</option>' +
                '@endforeach' +
                '</select>' +
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');
            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('kelolaPengguna/create') }}"; // Arahkan ke halaman tambah pengguna
            });
            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Pengguna...');
        });
    </script>
@endpush
