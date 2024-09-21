@extends('layouts.template')
@section('title', 'Pakan Harian')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Pakan Harian</div>
        <div class="card-body">
            <table class="table" id="table_pakanHarian">
                <thead>
                    <tr class="text-center">
                        <th>KODE PAKAN HARIAN</th>
                        <th>TANGGAL CEK</th>
                        <th>WAKTU CEK</th>
                        <th>DOC</th>
                        <th>BERAT UDANG</th>
                        <th>TOTAL PAKAN</th>
                        <th>CATATAN</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="pakanharianDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel160">Detail Pakan Harian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    {{-- Modal Detail --}}
                    <div id="user-detail-content" class="container">
                        <div class="row">
                            <!-- <div class="col-md-4">
                                <img id="foto" class="img-fluid rounded mb-3" src="" alt="Foto Pengguna"
                                    style="max-width: 100%; height: auto;">
                            </div> -->
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Kode Pakan Harian : </th>
                                        <td id="kd_pakan_harian"></td>
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
                                        <th>DOC : </th>
                                        <td id="DOC"></td>
                                    </tr>
                                    <tr>
                                        <th>Berat Udang : </th>
                                        <td id="berat_udang"></td>
                                    </tr>
                                    <tr>
                                        <th>Tatal Pakan : </th>
                                        <td id="total_pakan"></td>
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
                    <form id="form-delete-user" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            style="background-color: #DC3545; border-color: #DC3545" id="btn-hapus">Hapus</button>
                    </form>
                    <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">EDIT</span>
                    </button>
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
            var datapakanHarian = $('#table_pakanHarian').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('pakanHarian/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "kd_pakan_harian",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                        var url = '{{ route('pakanharian.show', ':id') }}';
                        url = url.replace(':id', row.id_pakan_harian);
                        return '<a href="javascript:void(0);" data-id="' + row.id_pakan_harian +
                            '" class="view-user-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#pakanharianDetailModal">' + data +
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
                        data: "waktu_cek",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "DOC",
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
                        data: "total_pakan",
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
                var id_pakan_harian = $(this).data('id');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            // Load konten detail ke modal
                            $('#user-detail-content').html(response.html);
                            $('#pakanharianDetailModal').modal('show');

                            // Setel action form penghapusan sesuai dengan ID pengguna
                            var deleteUrl = '{{ route('pakanharian.destroy', ':id') }}';
                            deleteUrl = deleteUrl.replace(':id', id_pakan_harian);
                            $('#form-delete-pakanharian').attr('action',
                                deleteUrl); // Setel action form
                        } else {
                            alert('Gagal memuat detail pakan harian');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail pakan harian');
                    }
                });
            });

            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_pakanHarian_filter").append(
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
                // "{{ route('kolam.create') }}"
                    "{{ url('pakanHarian/create') }}"; // Arahkan ke halaman tambah pengguna
            });
            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Pakan Harian...');
        
        });
    </script>
@endpush
