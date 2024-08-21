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
                        <th>LUAS LAHAN</th>
                        <th>LUAS TAMBAK</th>
                        <th>LOKASI</th>
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
            var dataManajemenTambak = $('#table_manajemenTambak').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('manajemenTambak/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "nama_tambak",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "luas_lahan",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "luas_tambak",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "lokasi_tambak",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                ],
                pagingType: "simple_numbers", // Tambahkan ini untuk menampilkan angka pagination
                dom: 'frtip', // Mengatur layout DataTables
                language: {
                    search: "" // Menghilangkan teks "Search"
                }
            });
            
            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_manajemenTambak_filter").append(
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');

            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('kelolaPengguna/create') }}"; // Arahkan ke halaman tambah pengguna
            });

            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Tambak...');
        });
    </script>
@endpush
