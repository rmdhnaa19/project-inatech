@extends('layouts.template')
@section('title', 'Kelola Pengguna')
@section('content')
    <div class="card">
        <div class="card-header">Data Pengguna</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table mb-3" id="table_kelolaPengguna">
                <thead>
                    <tr>
                        <th style="display: none">ID</th>
                        <th class="text-center">NAMA</th>
                        <th class="text-center">NO HP</th>
                        <th class="text-center">POSISI</th>
                        <th class="text-center">ROLE</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
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
                    <div id="user-detail-content" class="container-fluid">
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
                                    <p><strong>Posisi : </strong></p>
                                    <p><strong>Username : </strong></p>
                                    <p><strong>Role : </strong></p>
                                    <p><strong>Nomor HP : </strong></p>
                                    <p><strong>Alamat : </strong></p>
                                    <p><strong>Gaji Pokok : </strong></p>
                                    <p><strong>Komisi : </strong></p>
                                    <p><strong>Tunjangan : </strong></p>
                                    <p><strong>Potongan Gaji : </strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-danger" id="btn-delete-user">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-user">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        var currentUserId;
        $(document).ready(function() {
            var dataKelolaPengguna = $('#table_kelolaPengguna').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kelolaPengguna/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.id_role = $('#id_role').val();
                    },
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                    data: "id_user",
                    visible: false
                }, {
                    data: "nama",
                    className: "col-md-4", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.kelolaPengguna.show', ':id') }}';
                        url = url.replace(':id', row.id_user);
                        return '<a href="javascript:void(0);" data-id="' + row.id_user +
                            '" class="view-user-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#userDetailModal">' + data +
                            '</a>';
                    }
                }, {
                    data: "no_hp",
                    className: "col-md-2 text-center", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: false
                }, {
                    data: "posisi",
                    className: "col-md-3 text-center", // Jika tidak ada class, hapus baris ini
                    orderable: true,
                    searchable: true
                }, {
                    data: "role.nama",
                    className: "col-md-3 text-center", // Jika tidak ada class, hapus baris ini
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
            $(document).on('click', '.view-user-details', function() {
                var url = $(this).data('url');
                currentUserId = $(this).data('id');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            // Load konten detail ke modal
                            $('#user-detail-content').html(response.html);
                            $('#userDetailModal').modal('show');
                        } else {
                            alert('Gagal memuat detail user');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail user');
                    }
                });
            });

            $(document).on('click', '#btn-edit-user', function() {
                if (currentUserId) {
                    var editUrl = '{{ route('admin.kelolaPengguna.edit', ':id') }}'.replace(':id',
                        currentUserId);
                    window.location.href = editUrl;
                } else {
                    alert('ID pengguna tidak ditemukan');
                }
            });

            $(document).on('click', '#btn-delete-user', function() {
                if (currentUserId) {
                    if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                        var deleteUrl = '{{ route('admin.kelolaPengguna.destroy', ':id') }}'.replace(':id',
                            currentUserId);

                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                $('#userDetailModal').modal('hide');
                                // Reload DataTable
                                $('#table_kelolaPengguna').DataTable().ajax.reload();
                                alert('Pengguna berhasil dihapus');
                            },
                            error: function(xhr) {
                                alert('Gagal menghapus pengguna: ' + xhr.responseText);
                            }
                        });
                    }
                } else {
                    alert('ID pengguna tidak ditemukan');
                }
            });

            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_kelolaPengguna_filter").append(
                '<select class="form-control" name="id_role" id="id_role" required style="margin-left: 30px; width: 150px;">' +
                '<option value="">- SEMUA -</option>' +
                '@foreach ($role as $item)' +
                '<option value="{{ $item->id_role }}">{{ $item->nama }}</option>' +
                '@endforeach' +
                '</select>' +
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
            );

            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('kelolaPengguna/create') }}"; // Arahkan ke halaman tambah pengguna
            });

            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Pengguna...');
            $('#id_role').on('change', function() {
                dataKelolaPengguna.ajax.reload();
            })
        });
    </script>
@endpush
