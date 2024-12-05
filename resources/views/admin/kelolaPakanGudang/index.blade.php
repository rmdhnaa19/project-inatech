@extends('layouts.template')
@section('title', 'Kelola Pakan ke Gudang')
@section('content')
    <div class="card">
        <div class="card-header">Data Pakan ke Gudang</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table mb-3" id="table_kelolaPakanGudang">
                <thead>
                    <tr class="text-center">
                        <th style="display: none">ID</th>
                        <th class="text-center">KODE</th>
                        <th class="text-center">NAMA PAKAN</th>
                        <th class="text-center">NAMA GUDANG</th>
                        <th class="text-center">STOK PAKAN</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="pakanGudangDetailModal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel17">Detail Pakan ke Gudang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px; max-height: 70vh; overflow-y: hidden;">
                    <div id="pakanGudang-detail-content" class="container-fluid">
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
                                    <p><strong>Nama Gudang : </strong></p>
                                    <p><strong>Stok Pakan : </strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-danger" id="btn-delete-pakanGudang">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-pakanGudang">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        var currentPakanGudangId;
        $(document).ready(function() {
            var dataKelolaPakanGudang = $('#table_kelolaPakanGudang').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kelolaPakanGudang/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.id_pakan = $('#id_pakan').val();
                    },
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                    data: "id_detail_pakan",
                    visible: false
                }, {
                    data: "kd_detail_pakan",
                    className: "col-md-2 text-center", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: false,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.kelolaPakanGudang.show', ':id') }}';
                        url = url.replace(':id', row.id_detail_pakan);
                        return '<a href="javascript:void(0);" data-id="' + row.id_detail_pakan +
                            '" class="view-pakanGudang-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#pakanGudangDetailModal">' +
                            data + '</a>';
                    }
                }, {
                    data: "pakan.nama",
                    className: "col-md-4 text-center", // Jika tidak ada class, hapus baris ini
                    orderable: false,
                    searchable: true
                }, {
                    data: "gudang.nama",
                    className: "col-md-4 text-center", // Jika tidak ada class, hapus baris ini
                    orderable: false,
                    searchable: true
                }, {
                    data: "stok_pakan",
                    className: "col-md-2 text-center", // Jika tidak ada class, hapus baris ini
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
            $(document).on('click', '.view-pakanGudang-details', function() {
                var url = $(this).data('url');
                currentPakanGudangId = $(this).data('id');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            // Load konten detail ke modal
                            $('#pakanGudang-detail-content').html(response.html);
                            $('#pakanGudangDetailModal').modal('show');
                        } else {
                            alert('Gagal memuat detail pakan ke gudang');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail pakan ke gudang');
                    }
                });
            });

            $(document).on('click', '#btn-edit-pakanGudang', function() {
                if (currentPakanGudangId) {
                    var editUrl = '{{ route('admin.kelolaPakanGudang.edit', ':id') }}'.replace(':id',
                        currentPakanGudangId);
                    window.location.href = editUrl;
                } else {
                    alert('ID pakan ke gudang tidak ditemukan');
                }
            });

            $(document).on('click', '#btn-delete-pakanGudang', function() {
                if (currentPakanGudangId) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data pakan ke gudang ini akan dihapus secara permanen!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var deleteUrl = '{{ route('admin.kelolaPakanGudang.destroy', ':id') }}'
                                .replace(':id', currentPakanGudangId);
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
                                                "{{ route('admin.kelolaPakanGudang.index') }}"; // Redirect ke index
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Gagal!',
                                            text: 'Gagal menghapus pakan ke gudang: ' +
                                                response.message,
                                            icon: 'error'
                                        });
                                    }
                                },
                                error: function(xhr) {
                                    let errorMsg = 'Gagal menghapus pakan ke gudang.';
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
                        text: 'ID pakan ke gudang tidak ditemukan',
                        icon: 'error'
                    });
                }
            });

            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_kelolaPakanGudang_filter").append(
                '<select class="form-control" name="id_pakan" id="id_pakan" required style="margin-left: 30px; width: 150px;">' +
                '<option value="">- SEMUA -</option>' +
                '@foreach ($pakan as $item)' +
                '<option value="{{ $item->id_pakan }}">{{ $item->nama }}</option>' +
                '@endforeach' +
                '</select>' +
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
            );

            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('kelolaPakanGudang/create') }}"; // Arahkan ke halaman tambah pengguna
            });

            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Pakan ke Gudang...');
            $('#id_pakan').on('change', function() {
                dataKelolaPakanGudang.ajax.reload();
            })
        });
    </script>
@endpush
