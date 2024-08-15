@extends('layouts.template')
@section('title', 'Kelola Pengguna')
@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table" id="table_kelolaPengguna">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>NAMA</th>
                        <th>NO HP</th>
                        <th>POSISI</th>
                        <th>ROLE</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
            </table>
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
                serverSide: true, // serverSide: true, jika ingin menggunakan server side processing
                ajax: {
                    "url": "{{ url('kelolaPengguna/list') }}",
                    "dataType": "json",
                    "type": "POST"
                },
                columns: [{
                    data: "DT_RowIndex", // nomor urut dari laravel datatable addIndexColumn() 
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }, {
                    data: "nama",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                }, {
                    data: "no_hp",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                }, {
                    data: "posisi",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                }, {
                    data: "role.nama",
                    className: "",
                    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                }, {
                    data: "aksi",
                    className: "text-center",
                    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: false // searchable: true, jika ingin kolom ini bisa dicari 
                }]
            });
        });
    </script>
@endpush
