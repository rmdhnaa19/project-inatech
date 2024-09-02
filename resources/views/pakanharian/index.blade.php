@extends('layouts.template')
@section('title', 'Pakan Harian')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Pakan Harian</div>
        <div class="card-body">
            <table class="table" id="table_pakanHarian">
                <thead>
                    <tr class="text-center">
                        <th>KODE SAMPLING</th>
                        <th>TANGGAL CEK</th>
                        <th>DOC</th>
                        <th>BERAT UDANG</th>
                        <th>SIZE UDANG</th>
                        <th>HARGA UDANG</th>
                        <th>BIOMASSA</th>
                        <th>POPULASI EKOR</th>
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
            var datapakanHarian = $('#table_pakanHarian').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('sampling/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "kd_sampling",
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
                        data: "DOC",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "berat_udang",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "size_udang",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "harga_udang",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "biomassa",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "populasi_ekor",
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
            $("#table_pakanHarian_filter").append(
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
                    "{{ url('pakanharian/create') }}"; // Arahkan ke halaman tambah pengguna
            });
            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Pakan Harian...');
        
        });
    </script>
@endpush
