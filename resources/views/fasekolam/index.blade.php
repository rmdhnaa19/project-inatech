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
                        <th>DENSITAS</th>
                        <th>JUMLAH TEBAR</th>
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
            var datafaseKolam = $('#table_faseKolam').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('fasekolam/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "kd_fase_tambak",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
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
                    {
                        data: "densitas",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "jumlah_tebar",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: false,
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
        });
    </script>
@endpush
