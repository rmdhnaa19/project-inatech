@extends('layouts.template')
@section('title', 'Kualitas Air')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Kualitas Air</div>
        <div class="card-body">
            <table class="table" id="table_kualitasAir">
                <thead>
                    <tr class="text-center">
                        <th>KODE KUALITAS AIR</th>
                        <th>TANGGAL CEK</th>
                        <th>PH AIR </th>
                        <th>KEJERNIHAN AIR</th>
                        <th>WARNA AIR</th>
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
            var dataAnco = $('#table_kualitasAir').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kualitasair/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "kd_kualitas_air",
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
                        data: "pH",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "kejernihan_air",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "warna_air",
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
            $("#table_kualitasAir_filter").append(
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
                    "{{ url('kualitasair/create') }}"; // Arahkan ke halaman tambah 
            });
            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data kualitas air...');
        
        });
    </script>
@endpush
