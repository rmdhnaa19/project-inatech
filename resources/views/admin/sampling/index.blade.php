@extends('layouts.template')
@section('title', 'Sampling')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Sampling</div>
        <div class="card-body">
            <table class="table" id="table_sampling">
                <thead>
                    <tr class="text-center">
                        <th>KODE SAMPLING</th>
                        <th>TANGGAL CEK</th>
                        <th>DOC</th>
                        <th>BERAT UDANG</th>
                        <th>SIZE UDANG</th>
                        <th>HARGA UDANG</th>
                        <th>BIOMASSA</th>
                        <th>POPULASI EKOR</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="samplingDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel160">Detail Sampling</h5>
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
                                        <th>Kode Sampling : </th>
                                        <td id="kd_sampling"></td>
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
                                        <th>Size Udang : </th>
                                        <td id="size_udang"></td>
                                    </tr>
                                    <tr>
                                        <th>Harga Udang : </th>
                                        <td id="harga_udang"></td>
                                    </tr>
                                    <tr>
                                        <th>Interval Hari : </th>
                                        <td id="interval_hari"></td>
                                    </tr>
                                    <tr>
                                        <th>Input FR : </th>
                                        <td id="input_fr"></td>
                                    </tr>
                                    <tr>
                                        <th>Total Pakan : </th>
                                        <td id="total_pakan"></td>
                                    </tr>
                                    <tr>
                                        <th>ADG Udang : </th>
                                        <td id="ADG_udang"></td>
                                    </tr>
                                    <tr>
                                        <th>Biomassa : </th>
                                        <td id="biomassa"></td>
                                    </tr>
                                    <tr>
                                        <th>Populasi Ekor : </th>
                                        <td id="populasi_ekor"></td>
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
                    <button type="button" class="btn btn-danger" id="btn-delete-sampling">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-sampling">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        var currentSamplingId;
        $(document).ready(function() {
            var datasampling = $('#table_sampling').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('sampling/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "kd_sampling",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                        var url = '{{ route('sampling.show', ':id') }}';
                        url = url.replace(':id', row.id_sampling);
                        return '<a href="javascript:void(0);" data-id="' + row.id_sampling +
                            '" class="view-user-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#samplingDetailModal">' + data +
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
                        data: "size_udang",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "harga_udang",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "biomassa",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "populasi_ekor",
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
                currentSamplingId = $(this).data('id');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            // Load konten detail ke modal
                            $('#user-detail-content').html(response.html);
                            $('#samplingDetailModal').modal('show');

                            
                        } else {
                            alert('Gagal memuat detail sampling');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail sampling');
                    }
                });
            });

            $(document).on('click', '#btn-edit-sampling', function() {
                if (currentSamplingId) {
                    var editUrl = '{{ route('sampling.edit', ':id') }}'.replace(':id', currentSamplingId);
                    window.location.href = editUrl;
                } else {
                    alert('ID sampling tidak ditemukan');
                }
            });

            $(document).on('click', '#btn-delete-sampling', function() {
                if (currentSamplingId) {
                    if (confirm('Apakah Anda yakin ingin menghapus data sampling ini?')) {
                        var deleteUrl = '{{ route('sampling.destroy', ':id') }}'.replace(':id',
                            currentSamplingId);

                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                $('#samplingDetailModal').modal('hide');
                                // Reload DataTable
                                $('#table_sampling').DataTable().ajax.reload();
                                alert('Data Sampling berhasil dihapus');
                            },
                            error: function(xhr) {
                                alert('Gagal menghapus data sampling: ' + xhr.responseText);
                            }
                        });
                    }
                } else {
                    alert('Data Sampling tidak ditemukan');
                }
            });


            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_sampling_filter").append(
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
                    "{{ url('sampling/create') }}"; // Arahkan ke halaman tambah pengguna
            });
            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data sampling...');
            $('#id_fase_tambak').on('change', function() {
                dataSampling.ajax.reload();
            })
        });
    </script>
@endpush
