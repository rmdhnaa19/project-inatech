@extends('layouts.template')
@section('title', 'Kelola Gudang')
@section('content')
    <div class="card">
        <div class="card-header">Data Gudang</div>
        <div class="card-body">
            <table class="table mb-3" id="table_kelolaGudang">
                <thead>
                    <tr class="text-center">
                        <th style="display: none">ID</th>
                        <th>NAMA</th>
                        <th>ALAMAT</th>
                        <th>LUAS</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="gudangDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel160">Detail Gudang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    {{-- Modal Detail --}}
                    <div id="gudang-detail-content" class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <img id="gambar" class="img-fluid rounded mb-3" src="" alt="Foto Gudang"
                                    style="max-width: 100%; height: auto;">
                            </div>
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Nama : </th>
                                        <td id="nama"></td>
                                    </tr>
                                    <tr>
                                        <th>Panjang : </th>
                                        <td id="panjang"></td>
                                    </tr>
                                    <tr>
                                        <th>Lebar : </th>
                                        <td id="lebar"></td>
                                    </tr>
                                    <tr>
                                        <th>Luas : </th>
                                        <td id="luas"></td>
                                    </tr>
                                    <tr>
                                        <th>Alamat : </th>
                                        <td id="alamat"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    {{-- <button type="button" class="btn btn-danger" id="btn-delete-gudang">Hapus</button> --}}
                    <button type="button" class="btn btn-primary" id="btn-edit-gudang">Edit</button>
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
                    data: "id_gudang",
                    visible: false
                }, {
                    data: "nama",
                    className: "", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        var url = '{{ route('kelolaGudang.show', ':id') }}';
                        url = url.replace(':id', row.id_gudang);
                        return '<a href="javascript:void(0);" data-id="' + row.id_gudang +
                            '" class="view-gudang-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#gudangDetailModal">' + data +
                            '</a>';
                    }
                }, {
                    data: "alamat",
                    className: "", // Jika tidak ada class, hapus baris ini
                    orderable: false,
                    searchable: true
                }, {
                    data: "luas",
                    className: "", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: false
                }],
                pagingType: "simple_numbers", // Tambahkan ini untuk menampilkan angka pagination
                dom: 'frtip', // Mengatur layout DataTables
                language: {
                    search: "" // Menghilangkan teks "Search"
                }
            });

            // Event listener untuk menampilkan detail gudang
            $(document).on('click', '.view-gudang-details', function() {
                var url = $(this).data('url');
                currentGudangId = $(this).data('id');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            // Load konten detail ke modal
                            $('#gudang-detail-content').html(response.html);
                            $('#gudangDetailModal').modal('show');

                            // Tambahkan tombol edit secara dinamis
                            var editButton =
                                '<button type="button" class="btn btn-primary" id="btn-edit-user">Edit</button>';
                            $('#gudang-detail-content').append(editButton);
                        } else {
                            alert('Gagal memuat detail user');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail gudang');
                    }
                });
            });

            // Fungsi tombol edit gudang
            $(document).on('click', '#btn-edit-gudang', function() {
                if (currentGudangId) {
                    var editUrl = '{{ route('kelolaGudang.edit', ':id') }}'.replace(':id', currentGudangId);
                    window.location.href = editUrl;
                } else {
                    alert('ID Gudang tidak ditemukan');
                }
            });

            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_kelolaGudang_filter").append(
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
            );

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
