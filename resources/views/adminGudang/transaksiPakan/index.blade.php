@extends('layouts.template')
@section('title', 'Kelola Transaksi Pakan')
@section('content')
    <div class="card">
        <div class="card-header">Data Transaksi Pakan</div>
        <div class="card-body">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="..." class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                                additional content. This content is a little bit longer.</p>
                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="transaksiPakanDetailModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel17">Detail Transaksi Pakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px; max-height: 70vh; overflow-y: hidden;">
                    <div id="transaksiPakan-detail-content" class="container-fluid">
                        <div class="text-center mb-3">
                            <h4 class="mb-4"></h4>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="image-container text-center" style="position: sticky; top: 20px;">
                                    <img src="" alt="Foto Pakan" class="img-fluid"
                                        style="width: auto; height: 30vh;">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                                    <p><strong>Kode : </strong></p>
                                    <p><strong>Nama Pakan : </strong></p>
                                    <p><strong>Tipe Transaksi : </strong></p>
                                    <p><strong>Quantity : </strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        var currentTransaksiPakanId;
        $(document).ready(function() {
            var dataKelolaTransaksiPakan = $('#table_kelolaTransaksiPakan').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kelolaTransaksiPakan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                    data: "id_transaksi_pakan",
                    visible: false
                }, {
                    data: "kd_transaksi_pakan",
                    className: "col-md-2 text-center", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.kelolaTransaksiPakan.show', ':id') }}';
                        url = url.replace(':id', row.id_transaksi_pakan);
                        return '<a href="javascript:void(0);" data-id="' + row
                            .id_transaksi_pakan +
                            '" class="view-transaksiPakan-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#transaksiPakanDetailModal">' +
                            data + '</a>';
                    }
                }, {
                    data: "created_at_formatted",
                    className: "col-md-2 text-center",
                    orderable: true,
                    searchable: false,
                }, {
                    data: "pakan_gudang",
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
            $(document).on('click', '.view-transaksiPakan-details', function() {
                var url = $(this).data('url');
                currentTransaksiPakanId = $(this).data('id');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            // Load konten detail ke modal
                            $('#transaksiPakan-detail-content').html(response.html);
                            $('#transaksiPakanDetailModal').modal('show');
                        } else {
                            alert('Gagal memuat detail transaksi pakan');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail transaksi pakan');
                    }
                });
            });

            $(document).on('click', '#btn-edit-transaksiPakan', function() {
                if (currentTransaksiPakanId) {
                    var editUrl = '{{ route('admin.kelolaTransaksiPakan.edit', ':id') }}'.replace(':id',
                        currentTransaksiPakanId);
                    window.location.href = editUrl;
                } else {
                    alert('ID transaksi pakan tidak ditemukan');
                }
            });

            $(document).on('click', '#btn-delete-transaksiPakan', function() {
                if (currentTransaksiPakanId) {
                    if (confirm('Apakah Anda yakin ingin menghapus transaksi pakan ini?')) {
                        var deleteUrl = '{{ route('admin.kelolaTransaksiPakan.destroy', ':id') }}'.replace(
                            ':id', currentTransaksiPakanId);

                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                $('#transaksiPakanDetailModal').modal('hide');
                                // Reload DataTable
                                $('#table_kelolaTransaksiPakan').DataTable().ajax.reload();
                                alert('Transaksi pakan berhasil dihapus');
                            },
                            error: function(xhr) {
                                alert('Gagal menghapus transaksi pakan: ' + xhr.responseText);
                            }
                        });
                    }
                } else {
                    alert('ID transaksi pakan tidak ditemukan');
                }
            });

            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_kelolaTransaksiPakan_filter").append(
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
            );

            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('kelolaTransaksiPakan/create') }}"; // Arahkan ke halaman tambah pengguna
            });

            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data transaksi pakan...');
            $('#id_role').on('change', function() {
                dataKelolaTransaksiPakan.ajax.reload();
            })
        });
    </script>
@endpush
