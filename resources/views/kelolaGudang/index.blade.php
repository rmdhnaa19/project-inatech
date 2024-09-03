@extends('layouts.template')
@section('title', 'Kelola Gudang')
@section('content')
    <div class="card">
        <div class="card-header">Data Gudang</div>
        <div class="card-body">
            <table class="table mb-3" id="table_kelolaGudang">
                <thead>
                    <tr class="text-center">
                        <th>NAMA</th>
                        <th>ALAMAT</th>
                        <th>LUAS</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            var dataKelolGudang = $('#table_kelolaGudang').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kelolaGudang/list') }}",
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
                        // render: function(data, type, row) {
                        //     // Menggunakan route yang lebih umum dengan hanya ID
                        //     return '<a href="{{ url('/') }}/' + id_user + '">' + data + '</a>';
                        // }
                    },
                    {
                        data: "alamat",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "luas",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: false
                    },
                ],
                pagingType: "simple_numbers", // Tambahkan ini untuk menampilkan angka pagination
                dom: 'frtip', // Mengatur layout DataTables
                language: {
                    search: "" // Menghilangkan teks "Search"
                }
            });
            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_kelolaGudang_filter").append(
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');
            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('kelolaGudang/create') }}"; // Arahkan ke halaman tambah gudang
            });
            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Gudang...');
        });
    </script>
@endpush
