@extends('layouts.template')
@section('title', 'Kelola Pakan')
@section('content')
    <div class="card">
        <div class="card-header">Data Pakan</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table mb-3" id="table_kelolaPakan">
                <thead>
                    <tr class="text-center">
                        <th style="display: none">ID</th>
                        <th class="text-center">NAMA</th>
                        <th class="text-center">HARGA SATUAN</th>
                        <th class="text-center">SATUAN BERAT</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="PakanDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel17">Detail Pakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px; max-height: 70vh; overflow-y: hidden;">
                    <div id="Pakan-detail-content" class="container-fluid">
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
                                    <p><strong>Nama : </strong></p>
                                    <p><strong>Harga Satuan : </strong></p>
                                    <p><strong>Satuan Berat : </strong></p>
                                    <p><strong>Deskripsi : </strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-danger" id="btn-delete-Pakan">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-Pakan">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        var currentPakanId;
        $(document).ready(function() {
            var dataKelolaPakan = $('#table_kelolaPakan').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kelolaPakan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                    data: "id_pakan",
                    visible: false
                }, {
                    data: "nama",
                    className: "col-md-6", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.kelolaPakan.show', ':id') }}';
                        url = url.replace(':id', row.id_detail_user);
                        return '<a href="javascript:void(0);" data-id="' + row.id_detail_user +
                            '" class="view-Pakan-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#PakanDetailModal">' + data +
                            '</a>';
                    }
                }, {
                    data: "harga_satuan",
                    className: "col-md-3", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row) {
                        return data ? 'Rp ' + new Intl.NumberFormat('id-ID').format(data) : '-';
                    }
                }, {
                    data: "satuan",
                    className: "col-md-3", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: false
                }],
                pagingType: "simple_numbers", // Tambahkan ini untuk menampilkan angka pagination
                dom: 'frtip', // Mengatur layout DataTables
                language: {
                    search: "" // Menghilangkan teks "Search"
                }
            });

            // Event listener untuk menampilkan detail tambak
            $(document).on('click', '.view-Pakan-details', function() {
                var url = $(this).data('url');
                currentPakanId = $(this).data('id');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            // Load konten detail ke modal
                            $('#Pakan-detail-content').html(response.html);
                            $('#PakanDetailModal').modal('show');

                            // Tambahkan tombol edit secara dinamis
                            var editButton =
                                '<button type="button" class="btn btn-primary" id="btn-edit-Pakan">Edit</button>';
                            $('#Pakan-detail-content').append(editButton);
                        } else {
                            alert('Gagal memuat detail penanggung jawab gudang');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail penanggung jawab gudang');
                    }
                });
            });

            $(document).on('click', '#btn-edit-Pakan', function() {
                if (currentPakanId) {
                    var editUrl = '{{ route('admin.kelolaPakan.edit', ':id') }}'.replace(':id',
                        currentPakanId);
                    window.location.href = editUrl;
                } else {
                    alert('ID penanggung jawab gudang tidak ditemukan');
                }
            });

            $(document).on('click', '#btn-delete-Pakan', function() {
                if (currentPakanId) {
                    if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                        var deleteUrl = '{{ route('admin.kelolaPakan.destroy', ':id') }}'.replace(':id',
                            currentPakanId);

                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                $('#PakanDetailModal').modal('hide');
                                // Reload DataTable
                                $('#table_kelolaPakan').DataTable().ajax.reload();
                                alert('Penanggung jawab gudang berhasil dihapus');
                            },
                            error: function(xhr) {
                                alert('Gagal menghapus penanggung jawab gudang: ' + xhr
                                    .responseText);
                            }
                        });
                    }
                } else {
                    alert('ID penanggung jawab gudang tidak ditemukan');
                }
            });

            $("#table_kelolaPakan_filter").append(
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
            );

            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('kelolaPakan/create') }}"; // Arahkan ke halaman tambah pengguna
            });

            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data pakan...');
        });
    </script>
@endpush
