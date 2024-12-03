@extends('layouts.template')
@section('title', 'Kelola Alat')
@section('content')
    <div class="card">
        <div class="card-header">Data Alat</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table mb-3" id="table_kelolaAlat">
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
    <div class="modal fade text-left" id="alatDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel17">Detail Alat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px; max-height: 70vh; overflow-y: hidden;">
                    <div id="alat-detail-content" class="container-fluid">
                        <div class="text-center mb-3">
                            <h4 class="mb-4"></h4>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="image-container text-center" style="position: sticky; top: 20px;">
                                    <img src="" alt="Foto Alat" class="img-fluid"
                                        style="width: auto; height: 30vh;">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                                    <p><strong>Harga Satuan : </strong></p>
                                    <p><strong>Satuan Berat : </strong></p>
                                    <p><strong>Deskripsi : </strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-danger" id="btn-delete-alat">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-alat">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        var currentAlatId;
        $(document).ready(function() {
            var dataKelolaAlat = $('#table_kelolaAlat').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kelolaAlat/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                    data: "id_alat",
                    visible: false
                }, {
                    data: "nama",
                    className: "col-md-6", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.kelolaAlat.show', ':id') }}';
                        url = url.replace(':id', row.id_alat);
                        return '<a href="javascript:void(0);" data-id="' + row.id_alat +
                            '" class="view-alat-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#alatDetailModal">' + data +
                            '</a>';
                    }
                }, {
                    data: "harga_satuan",
                    className: "col-md-3 text-center", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row) {
                        return data ? 'Rp ' + new Intl.NumberFormat('id-ID').format(data) : '-';
                    }
                }, {
                    data: "satuan",
                    className: "col-md-3 text-center", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: false
                }],
                pagingType: "simple_numbers", // Tambahkan ini untuk menampilkan angka pagination
                dom: 'frtip', // Mengatur layout DataTables
                language: {
                    search: "" // Menghilangkan teks "Search"
                }
            });

            // Event listener untuk menampilkan detail alat
            $(document).on('click', '.view-alat-details', function() {
                var url = $(this).data('url');
                currentAlatId = $(this).data('id');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            // Load konten detail ke modal
                            $('#alat-detail-content').html(response.html);
                            $('#alatDetailModal').modal('show');
                        } else {
                            alert('Gagal memuat detail alat');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail alat');
                    }
                });
            });

            $(document).on('click', '#btn-edit-alat', function() {
                if (currentAlatId) {
                    var editUrl = '{{ route('admin.kelolaAlat.edit', ':id') }}'.replace(':id',
                        currentAlatId);
                    window.location.href = editUrl;
                } else {
                    alert('ID alat tidak ditemukan');
                }
            });

            // $(document).on('click', '#btn-delete-alat', function() {
            //     if (currentAlatId) {
            //         if (confirm('Apakah Anda yakin ingin menghapus data alat ini?')) {
            //             var deleteUrl = '{{ route('admin.kelolaAlat.destroy', ':id') }}'.replace(':id',
            //                 currentAlatId);
            //             $.ajax({
            //                 url: deleteUrl,
            //                 type: 'POST', // Masih POST karena perlu override
            //                 data: {
            //                     "_token": "{{ csrf_token() }}",
            //                     "_method": "DELETE" // Override metode menjadi DELETE
            //                 },
            //                 success: function(response) {
            //                     if (response.success) {
            //                         alert(response.message);
            //                         window.location.href =
            //                             "{{ route('admin.kelolaAlat.index') }}"; // Redirect ke index
            //                     } else {
            //                         alert('Gagal menghapus alat: ' + response.message);
            //                     }
            //                 },
            //                 error: function(xhr) {
            //                     let errorMsg = 'Gagal menghapus alat.';
            //                     if (xhr.responseJSON && xhr.responseJSON.message) {
            //                         errorMsg += ' ' + xhr.responseJSON.message;
            //                     }
            //                     alert(errorMsg);
            //                 }
            //             });
            //         }
            //     } else {
            //         alert('ID alat tidak ditemukan');
            //     }
            // });

            $(document).on('click', '#btn-delete-alat', function() {
                if (currentAlatId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data alat ini akan dihapus secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var deleteUrl = '{{ route('admin.kelolaAlat.destroy', ':id') }}'
                                .replace(':id', currentAlatId);
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
                                                "{{ route('admin.kelolaAlat.index') }}"; // Redirect ke index
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Gagal!',
                                            text: 'Gagal menghapus alat: ' +
                                                response.message,
                                            icon: 'error'
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    let errorMsg = 'Gagal menghapus alat.';
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
                        text: 'ID alat tidak ditemukan',
                        icon: 'error'
                    });
                }
            });


            $("#table_kelolaAlat_filter").append(
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
            );

            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('kelolaAlat/create') }}"; // Arahkan ke halaman tambah pengguna
            });

            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data alat...');
        });
    </script>
@endpush
