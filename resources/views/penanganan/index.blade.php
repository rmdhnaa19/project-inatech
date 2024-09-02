@extends('layouts.template')
@section('title', 'Penanganan')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Penanganan</div>
        <div class="card-body">
            <table class="table" id="table_penanganan">
                <thead>
                    <tr class="text-center">
                        <th>KODE PENANGANAN</th>
                        <th>TANGGAL CEK</th>
                        <th>PEMBERIAN MINERAL</th>
                        <th>PEMBERIAN VITAMIN</th>
                        <th>PEMBERIAN OBAT</th>
                        <th>PENAMBAHAN AIR</th>
                        <th>PENGURANGAN AIR</th>
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
            var datapenanganan = $('#table_penanganan').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('penanganan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "kd_penanganan",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "tanggal_cek",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "pemberian_mineral",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "pemberian_vitamin",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "pemberian_obat",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "penambahan_air",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },{
                        data: "pengurangan_air",
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
            $("#table_penanganan_filter").append(
                '<select class="form-control" name="id_fase_tambak" id="id_fase_tambak" required style="margin-left: 30px; width: 150px;">' +
                '<option value="">- SEMUA -</option>' +
                '@foreach ($fase_kolam as $item)' +
                '<option value="{{ $item->id_fase_tambak }}">{{ $item->kd_fase_tambak }}</option>' +
                '@endforeach' +
                '</select>' +
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');

            // Tambahkan event listener untuk tombol tambah 
            $("#btn-tambah").on('click', function() {
                window.location.href =
                // "{{ route('kolam.create') }}"
                    "{{ url('penanganan/create') }}"; // Arahkan ke halaman tambah pengguna
            });
            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data penanganan...');
        
        });
    </script>
@endpush
