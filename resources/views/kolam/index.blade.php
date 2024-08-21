@extends('layouts.template')
@section('title', 'Kolam')
@section('content')
    <div class="card">
        <div class="card-header">Manajemen Kolam</div>
        <div class="card-body">
            <table class="table" id="table_manajemenKolam">
                <thead>
                    <tr class="text-center">
                        <th>TIPE KOLAM</th>
                        <th>PANJANG KOLAM </th>
                        <th>LEBAR KOLAM</th>
                        <th>LUAS KOLAM</th>
                        <th>KEDALAMAN</th>
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
            var dataManajemenKolam = $('#table_manajemenKolam').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('manajemenKolam/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "tipe_kolam",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "panjang_kolam",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "lebar_kolam",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "luas_kolam",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kedalaman",
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
            $("#table_manajemenKolam_filter").append(
                // '<select class="form-control" name="id_tambak" id="id_role" required style="margin-left: 30px; width: 150px;">' +
                // '<option value="">- SEMUA -</option>' +
                // '@foreach ($tambak as $item)' +
                // '<option value="{{ $item->id_tambak }}">{{ $item->nama_tambak }}</option>' +
                // '@endforeach' +
                // '</select>' +
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');
            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('manajemenTambak/create') }}"; // Arahkan ke halaman tambah pengguna
            });
            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Kolam...');
        
        });
    </script>
@endpush
