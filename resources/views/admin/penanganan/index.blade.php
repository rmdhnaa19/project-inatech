@extends('layouts.template')
@section('title', 'Penanganan')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Penanganan</div>
        <div class="card-body">
            <table class="table" id="table_penanganan">
                <thead>
                    <tr class="text-center">
                        <th>KODE PENANGANAN</th>
                        <th>TANGGAL CEK</th>
                        <th>PEMBERIAN MINERAL</th>
                        <th>PEMBERIAN VITAMIN</th>
                        <th>PEMBERIAN OBAT</th>
                        <th>PENAMBAHAN AIR</th>
                        <th>PENGURANGAN AIR</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="penangananDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel160">Detail Penanganan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    {{-- Modal Detail --}}
                    <div id="user-detail-content" class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Kode Penanganan : </th>
                                        <td id="kd_penanganan"></td>
                                    </tr>
                                    <tr>
                                        <th>Fase Kolam : </th>
                                        <td id="kd_fase_kolam"></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Cek : </th>
                                        <td id="tanggal_cek"></td>
                                    </tr>
                                    <tr>
                                        <th>Waktu Cek : </th>
                                        <td id="waktu_cek"></td>
                                    </tr>
                                    <tr>
                                        <th>Pemberian Mineral : </th>
                                        <td id="pemberian_mineral"></td>
                                    </tr>
                                    <tr>
                                        <th>Pemberian Vitamin : </th>
                                        <td id="pemberian_vitamin"></td>
                                    </tr>
                                    <tr>
                                        <th>Pemberian Obat : </th>
                                        <td id="pemberian_obat"></td>
                                    </tr>
                                    <tr>
                                        <th>Penambahan Air : </th>
                                        <td id="penambahan_air"></td>
                                    </tr>
                                    <tr>
                                        <th>Pengurangan Air : </th>
                                        <td id="pengurangan_air"></td>
                                    </tr>
                                    <tr>
                                        <th>Catatan : </th>
                                        <td id="Catatan"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-danger" id="btn-delete-penanganan">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-penanganan">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        var currentPenangananId;
        $(document).ready(function() {
            var dataPenanganan = $('#table_penanganan').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('penanganan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "kd_penanganan",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                        var url = '{{ route('penanganan.show', ':id') }}';
                        url = url.replace(':id', row.id_penanganan);
                        return '<a href="javascript:void(0);" data-id="' + row.id_penanganan +
                            '" class="view-user-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#penangananDetailModal">' + data +
                            '</a>';
                        }
                    },
                    {
                        data: "tanggal_cek",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "pemberian_mineral",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "pemberian_vitamin",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "pemberian_obat",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "penambahan_air",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },{
                        data: "pengurangan_air",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                ],
                pagingType: "simple_numbers", // Tambahkan ini untuk menampilkan angka pagination
                dom: 'frtip', // Mengatur layout DataTables
                language: {
                    search: "" // Menghilangkan teks "Search"
                }
            });

            // Event listener untuk menampilkan detail tambak
            $(document).on('click', '.view-user-details', function() {
                var url = $(this).data('url');
                currentPenangananId = $(this).data('id');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            // Load konten detail ke modal
                            $('#user-detail-content').html(response.html);
                            $('#penangananDetailModal').modal('show');

                            
                        } else {
                            alert('Gagal memuat detail penanganan');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail penanganan');
                    }
                });
            });

            $(document).on('click', '#btn-edit-penanganan', function() {
                if (currentPenangananId) {
                    var editUrl = '{{ route('penanganan.edit', ':id') }}'.replace(':id', currentPenangananId);
                    window.location.href = editUrl;
                } else {
                    alert('ID Penanganan tidak ditemukan');
                }
            });

            $(document).on('click', '#btn-delete-penanganan', function() {
                if (currentPenangananId) {
                    if (confirm('Apakah Anda yakin ingin menghapus data penanganan ini?')) {
                        var deleteUrl = '{{ route('penanganan.destroy', ':id') }}'.replace(':id',
                            currentPenangananId);

                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                $('#penangananDetailModal').modal('hide');
                                // Reload DataTable
                                $('#table_penanganan').DataTable().ajax.reload();
                                alert('Data Penanganan berhasil dihapus');
                            },
                            error: function(xhr) {
                                alert('Gagal menghapus data penanganan: ' + xhr.responseText);
                            }
                        });
                    }
                } else {
                    alert('Data Penanganan tidak ditemukan');
                }
            });

            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_penanganan_filter").append(
                '<select class="form-control" name="id_fase_tambak" id="id_fase_tambak" required style="margin-left: 30px; width: 150px;">' +
                '<option value="">- SEMUA -</option>' +
                '@foreach ($fase_kolam as $item)' +
                '<option value="{{ $item->id_fase_tambak }}">{{ $item->kd_fase_tambak }}</option>' +
                '@endforeach' +
                '</select>' +
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');

            // Tambahkan event listener untuk tombol tambah 
            $("#btn-tambah").on('click', function() {
                window.location.href =
                
                    "{{ url('penanganan/create') }}"; // Arahkan ke halaman tambah pengguna
            });
            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data penanganan...');
            $('#id_fase_tambak').on('change', function() {
                dataPenanganan.ajax.reload();
            })
        });
    </script>
@endpush
