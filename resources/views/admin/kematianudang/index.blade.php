@extends('layouts.template')
@section('title', 'Kematian Udang')
@section('content')
    <div class="card">
        <div class="card-header">Kematian Udang</div>
        <div class="card-body">
            <table class="table" id="table_kematianudang">
                <thead>
                    <tr class="text-center">
                        <th>KODE KEMATIAN UDANG</th>
                        <th>SIZE UDANG</th>
                        <th>BERAT UDANG</th>
                        <th>CATATAN</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="kematianudangDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel160">Detail Kematian Udang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    {{-- Modal Detail --}}
                    <div id="user-detail-content" class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <img id="gambar" class="img-fluid rounded mb-3" src="" alt="gambar"
                                    style="max-width: 100%; height: auto;">
                            </div>
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Kode Kematian Udang : </th>
                                        <td id="kd_kematian_udang"></td>
                                    </tr>
                                    <tr>
                                        <th>Fase Kolam : </th>
                                        <td id="kd_fase_kolam"></td>
                                    </tr>
                                    <tr>
                                        <th>Size Udang : </th>
                                        <td id="size_udang"></td>
                                    </tr>
                                    <tr>
                                        <th>Berat Udang : </th>
                                        <td id="berat_udang"></td>
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
                    <button type="button" class="btn btn-danger" id="btn-delete-kematianudang">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-kematianudang">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        var currentKematianUdangId;
        $(document).ready(function() {
            var datakematianUdang = $('#table_kematianudang').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kematianUdang/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "kd_kematian_udang",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                        var url = '{{ route('kematianudang.show', ':id') }}';
                        url = url.replace(':id', row.id_kematian_udang);
                        return '<a href="javascript:void(0);" data-id="' + row.id_kematian_udang +
                            '" class="view-user-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#kematianudangDetailModal">' + data +
                            '</a>';
                        }
                    },
                    {
                        data: "size_udang",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "berat_udang",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "catatan",
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
                currentKematianUdangId = $(this).data('id');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            // Load konten detail ke modal
                            $('#user-detail-content').html(response.html);
                            $('#kematianudangDetailModal').modal('show');

                            // Setel action form penghapusan sesuai dengan ID pengguna
                            var deleteUrl = '{{ route('kematianudang.destroy', ':id') }}';
                            deleteUrl = deleteUrl.replace(':id', id_kematian_udang);
                            $('#form-delete-kematianudang').attr('action',
                                deleteUrl); // Setel action form
                        } else {
                            alert('Gagal memuat detail kematian udang');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail kematian udang');
                    }
                });
            });

            $(document).on('click', '#btn-edit-kematianudang', function() {
                if (currentKematianUdangId) {
                    var editUrl = '{{ route('kematianudang.edit', ':id') }}'.replace(':id', currentKematianUdangId);
                    window.location.href = editUrl;
                } else {
                    alert('ID Kematian Udang tidak ditemukan');
                }
            });

            $(document).on('click', '#btn-delete-kematianudang', function() {
                if (currentKematianUdangId) {
                    if (confirm('Apakah Anda yakin ingin menghapus data kematian udang ini?')) {
                        var deleteUrl = '{{ route('kematianudang.destroy', ':id') }}'.replace(':id',
                            currentKematianUdangId);

                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                $('#kematianudangDetailModal').modal('hide');
                                // Reload DataTable
                                $('#table_kematianudang').DataTable().ajax.reload();
                                alert('Data Kematian Udang berhasil dihapus');
                            },
                            error: function(xhr) {
                                alert('Gagal menghapus data kematian udang: ' + xhr.responseText);
                            }
                        });
                    }
                } else {
                    alert('Data Kematian Udang tidak ditemukan');
                }
            });


             // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_kematianudang_filter").append(
                '<select class="form-control" name="id_fase_tambak" id="id_fase_tambak" required style="margin-left: 30px; width: 150px;">' +
                '<option value="">- SEMUA -</option>' +
                '@foreach ($fase_kolam as $item)' +
                '<option value="{{ $item->id_fase_tambak }}">{{ $item->kd_fase_tambak }}</option>' +
                '@endforeach' +
                '</select>' +
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');
 
            // Tambahkan event listener untuk tombol
            $("#btn-tambah").on('click', function() {
                window.location.href =
                    "{{ url('kematianUdang/create') }}"; // Arahkan ke halaman tambah pengguna
            });

            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Kematian Udang...');
            $('#id_fase_tambak').on('change', function() {
                datakematianUdang.ajax.reload();
            })
        });
    </script>
@endpush
