@extends('layouts.template')
@section('title', 'Kelola Penanggung Jawab Gudang')
@section('content')
    <div class="card">
        <div class="card-header">Data Penanggung Jawab Gudang</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table mb-3" id="table_kelolaPJGudang">
                <thead>
                    <tr class="text-center">
                        <th style="display: none">ID</th>
                        <th>KODE</th>
                        <th>NAMA GUDANG</th>
                        <th>NAMA PENANGGUNG JAWAB</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="PJGudangDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel17">Detail Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px; max-height: 70vh; overflow-y: hidden;">
                    <div id="PJGudang-detail-content" class="container-fluid">
                        <div class="text-center mb-3">
                            <h4 class="mb-4"></h4>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="image-container text-center" style="position: sticky; top: 20px;">
                                    <img src="" alt="Foto User" class="img-fluid"
                                        style="width: auto; height: 30vh;">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                                    <p><strong>Kode : </strong></p>
                                    <p><strong>Nama Gudang : </strong></p>
                                    <p><strong>Nama Penanggung Jawab Gudang : </strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-danger" id="btn-delete-PJGudang">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-PJGudang">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        var currentPJGudangId;
        $(document).ready(function() {
            var dataKelolaPJGudang = $('#table_kelolaPJGudang').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kelolaPJGudang/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.id_gudang = $('#id_gudang').val();
                    },
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                    data: "id_detail_user",
                    visible: false
                }, {
                    data: "kd_detail_user",
                    className: "", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.kelolaPJGudang.show', ':id') }}';
                        url = url.replace(':id', row.id_detail_user);
                        return '<a href="javascript:void(0);" data-id="' + row.id_detail_user +
                            '" class="view-PJGudang-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#PJGudangDetailModal">' + data +
                            '</a>';
                    }
                }, {
                    data: "gudang.nama",
                    className: "", // Jika tidak ada class, hapus baris ini
                    orderable: false,
                    searchable: true
                }, {
                    data: "user.nama",
                    className: "", // Jika tidak ada class, hapus baris ini
                    orderable: false,
                    searchable: true
                }],
                pagingType: "simple_numbers", // Tambahkan ini untuk menampilkan angka pagination
                dom: 'frtip', // Mengatur layout DataTables
                language: {
                    search: "" // Menghilangkan teks "Search"
                }
            });

            // Event listener untuk menampilkan detail tambak
            $(document).on('click', '.view-PJGudang-details', function() {
                var url = $(this).data('url');
                currentPJGudangId = $(this).data('id');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            // Load konten detail ke modal
                            $('#PJGudang-detail-content').html(response.html);
                            $('#PJGudangDetailModal').modal('show');

                            // Tambahkan tombol edit secara dinamis
                            var editButton =
                                '<button type="button" class="btn btn-primary" id="btn-edit-PJGudang">Edit</button>';
                            $('#PJGudang-detail-content').append(editButton);
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

            $(document).on('click', '#btn-edit-PJGudang', function() {
                if (currentPJGudangId) {
                    var editUrl = '{{ route('admin.kelolaPJGudang.edit', ':id') }}'.replace(':id',
                        currentPJGudangId);
                    window.location.href = editUrl;
                } else {
                    alert('ID penanggung jawab gudang tidak ditemukan');
                }
            });

            $(document).on('click', '#btn-delete-PJGudang', function() {
                if (currentPJGudangId) {
                    if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                        var deleteUrl = '{{ route('admin.kelolaPJGudang.destroy', ':id') }}'.replace(':id',
                            currentPJGudangId);

                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                $('#PJGudangDetailModal').modal('hide');
                                // Reload DataTable
                                $('#table_kelolaPJGudang').DataTable().ajax.reload();
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

            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_kelolaPJGudang_filter").append(
                '<select class="form-control" name="id_gudang" id="id_gudang" required style="margin-left: 30px; width: 150px;">' +
                '<option value="">- SEMUA -</option>' +
                '@foreach ($gudang as $item)' +
                '<option value="{{ $item->id_gudang }}">{{ $item->nama }}</option>' +
                '@endforeach' +
                '</select>' +
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
            );

            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('kelolaPJGudang/create') }}"; // Arahkan ke halaman tambah pengguna
            });

            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Penanggung Jawab Gudang...');
            $('#id_gudang').on('change', function() {
                dataKelolaPJGudang.ajax.reload();
            })
        });
    </script>
@endpush
