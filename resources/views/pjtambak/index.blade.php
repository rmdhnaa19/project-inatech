@extends('layouts.template')
@section('title', 'PjTambak')
@section('content')
    <div class="card">
        <div class="card-header">Penanggung Jawab Tambak</div>
        <div class="card-body">
            <table class="table" id="table_pjTambak">
                <thead>
                    <tr class="text-center">
                        <th>KODE USER TAMBAK</th>
                        <th>ID USER</th>
                        <th>ID TAMBAK</th>
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
                columns: [{
                        data: "kd_user_tambak",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "id_user",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "id_tambak",
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
            $("#table_pjTambak_filter").append(
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');

            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('pjTambak/create') }}"; // Arahkan ke halaman tambah pengguna
            });

            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Penanggung Jawab Tambak...');
        });
    </script>
@endpush
