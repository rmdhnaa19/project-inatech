@extends('layouts.template')
@section('title', 'Anco')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Anco</div>
        <div class="card-body">
            <table class="table" id="table_anco">
                <thead>
                    <tr class="text-center">
                        <th>KODE ANCO</th>
                        <th>TANGGAL CEK</th>
                        <th>JAM PEMBERIAN PAKAN </th>
                        <th>KONDISI PAKAN</th>
                        <th>KONDISI UDANG</th>
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
            var dataAnco = $('#table_anco').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('anco/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "kd_anco",
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
                        data: "jamPemberian_pakan",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kondisi_pakan",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kondisi_udang",
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
            $("#table_anco_filter").append(
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
                    "{{ url('anco/create') }}"; // Arahkan ke halaman tambah pengguna
            });
            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data anco...');
        
        });
    </script>
@endpush
