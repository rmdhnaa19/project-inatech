@extends('layouts.template')
@section('title', 'Kelola Gudang')
@section('content')
    <div class="card">
        <div class="card-header">Data Gudang</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table mb-3" id="table_kelolaGudang">
                <thead>
                    <tr class="text-center">
                        <th style="display: none">ID</th>
                        <th class="text-center">NAMA</th>
                        <th class="text-center">ALAMAT</th>
                        <th class="text-center">LUAS</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="gudangDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel17">Detail Gudang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px; max-height: 70vh; overflow-y: hidden;">
                    <div id="gudang-detail-content" class="container-fluid">
                        <div class="text-center mb-3">
                            <h4 class="mb-4"></h4>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="image-container text-center" style="position: sticky; top: 20px;">
                                    <img src="" alt="Foto Gudang" class="img-fluid"
                                        style="width: auto; height: 30vh;">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                                    <p><strong>Panjang : </strong></p>
                                    <p><strong>Lebar : </strong></p>
                                    <p><strong>Luas : </strong></p>
                                    <p><strong>Alamat : </strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-danger" id="btn-delete-gudang">Hapus</button>
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
                    className: "col-md-3", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.kelolaGudang.show', ':id') }}';
                        url = url.replace(':id', row.id_gudang);
                        return '<a href="javascript:void(0);" data-id="' + row.id_gudang +
                            '" class="view-gudang-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#gudangDetailModal">' + data +
                            '</a>';
                    }
                }, {
                    data: "alamat",
                    className: "col-md-6", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: true
                }, {
                    data: "luas",
                    className: "col-md-3 text-center", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row) {
                        return data ? new Intl.NumberFormat('id-ID').format(data) + ' m²' : '-';
                    }
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
                        } else {
                            alert('Gagal memuat detail gudang');
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
                    var editUrl = '{{ route('admin.kelolaGudang.edit', ':id') }}'.replace(':id',
                        currentGudangId);
                    window.location.href = editUrl;
                } else {
                    alert('ID Gudang tidak ditemukan');
                }
            });

            $(document).ready(function() {
                $(document).on('click', '#btn-delete-gudang', function() {
                    if (typeof currentGudangId !== 'undefined' && currentGudangId) {
                        if (confirm('Apakah Anda yakin ingin menghapus gudang ini?')) {
                            var deleteUrl = '{{ route('admin.kelolaGudang.destroy', ':id') }}'
                                .replace(':id',
                                    currentGudangId);

                            $.ajax({
                                url: deleteUrl,
                                type: 'DELETE',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function(response) {
                                    if (response.success) {
                                        $('#GudangDetailModal').modal('hide');
                                        $('#table_kelolaGudang').DataTable().ajax
                                            .reload(); // Reload DataTable
                                        alert(response.message);
                                    } else {
                                        alert('Gagal menghapus gudang: ' + response
                                            .message);
                                    }
                                },
                                error: function(xhr) {
                                    let errorMsg = 'Gagal menghapus gudang.';
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMsg += ' ' + xhr.responseJSON.message;
                                    }
                                    alert(errorMsg);
                                }
                            });
                        }
                    } else {
                        alert('ID gudang tidak ditemukan');
                    }
                });
            })


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
