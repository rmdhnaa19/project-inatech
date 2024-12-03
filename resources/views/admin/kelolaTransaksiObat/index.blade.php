@extends('layouts.template')
@section('title', 'Kelola Transaksi Obat')
@section('content')
    <div class="card">
        <div class="card-header">Data Transaksi Obat</div>
        <div class="card-body">
            {{-- @if (session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif --}}
            <table class="table mb-3" id="table_kelolaTransaksiObat">
                <thead>
                    <tr>
                        <th style="display: none">ID</th>
                        <th class="text-center">KODE</th>
                        <th class="text-center">TANGGAL</th>
                        <th class="text-center">NAMA ALAT</th>
                        <th class="text-center">TIPE TRANSAKSI</th>
                        <th class="text-center">QUANTITY</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="transaksiObatDetailModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel17">Detail Transaksi Obat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px; max-height: 70vh; overflow-y: hidden;">
                    <div id="transaksiObat-detail-content" class="container-fluid">
                        <div class="text-center mb-3">
                            <h4 class="mb-4"></h4>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="image-container text-center" style="position: sticky; top: 20px;">
                                    <img src="" alt="Foto Obat" class="img-fluid"
                                        style="width: auto; height: 30vh;">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                                    <p><strong>Kode : </strong></p>
                                    <p><strong>Nama Obat : </strong></p>
                                    <p><strong>Tipe Transaksi : </strong></p>
                                    <p><strong>Quantity : </strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-danger" id="btn-delete-transaksiObat">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-transaksiObat">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        var currentTransaksiObatId;
        $(document).ready(function() {
            var dataKelolaTransaksiObat = $('#table_kelolaTransaksiObat').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kelolaTransaksiObat/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                    data: "id_transaksi_obat",
                    visible: false
                }, {
                    data: "kd_transaksi_obat",
                    className: "col-md-2 text-center", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.kelolaTransaksiObat.show', ':id') }}';
                        url = url.replace(':id', row.id_transaksi_obat);
                        return '<a href="javascript:void(0);" data-id="' + row
                            .id_transaksi_obat +
                            '" class="view-transaksiObat-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#transaksiObatDetailModal">' +
                            data + '</a>';
                    }
                }, {
                    data: "created_at_formatted",
                    className: "col-md-2 text-center",
                    orderable: true,
                    searchable: false,
                }, {
                    data: "obat_gudang",
                    className: "col-md-4", // Jika tidak ada class, hapus baris ini
                    orderable: false,
                    searchable: true
                }, {
                    data: "tipe_transaksi",
                    className: "col-md-2 text-center", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: true
                }, {
                    data: "quantity",
                    className: "col-md-2 text-center", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row) {
                        return data ? new Intl.NumberFormat('id-ID').format(data) : '-';
                    }
                }],
                pagingType: "simple_numbers", // Tambahkan ini untuk menampilkan angka pagination
                dom: 'frtip', // Mengatur layout DataTables
                language: {
                    search: "" // Menghilangkan teks "Search"
                }
            });

            // Event listener untuk menampilkan detail tambak
            $(document).on('click', '.view-transaksiObat-details', function() {
                var url = $(this).data('url');
                currentTransaksiObatId = $(this).data('id');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            // Load konten detail ke modal
                            $('#transaksiObat-detail-content').html(response.html);
                            $('#transaksiObatDetailModal').modal('show');
                        } else {
                            alert('Gagal memuat detail transaksi obat');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail transaksi obat');
                    }
                });
            });

            $(document).on('click', '#btn-edit-transaksiObat', function() {
                if (currentTransaksiObatId) {
                    var editUrl = '{{ route('admin.kelolaTransaksiObat.edit', ':id') }}'.replace(':id',
                        currentTransaksiObatId);
                    window.location.href = editUrl;
                } else {
                    alert('ID transaksi obat tidak ditemukan');
                }
            });

            $(document).on('click', '#btn-delete-transaksiObat', function() {
                if (currentTransaksiObatId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data transaksi obat ini akan dihapus secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var deleteUrl =
                                '{{ route('admin.kelolaTransaksiObat.destroy', ':id') }}'
                                .replace(':id', currentTransaksiObatId);
                            $.ajax({
                                url: deleteUrl,
                                type: 'POST',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "_method": "DELETE"
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: response.message,
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: true
                                        }).then(() => {
                                            window.location.href =
                                                "{{ route('admin.kelolaTransaksiObat.index') }}"; // Redirect ke index
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Gagal!',
                                            text: 'Gagal menghapus transaksi obat: ' +
                                                response.message,
                                            icon: 'error'
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    let errorMsg = 'Gagal menghapus transaksi obat.';
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMsg += ' ' + xhr.responseJSON.message;
                                    }
                                    Swal.fire({
                                        title: 'Error!',
                                        text: errorMsg,
                                        icon: 'error'
                                    });
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'ID transaksi obat tidak ditemukan',
                        icon: 'error'
                    });
                }
            });

            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_kelolaTransaksiObat_filter").append(
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
            );

            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('kelolaTransaksiObat/create') }}"; // Arahkan ke halaman tambah pengguna
            });

            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data transaksi obat...');
            $('#id_role').on('change', function() {
                dataKelolaTransaksiObat.ajax.reload();
            })
        });
    </script>
@endpush
