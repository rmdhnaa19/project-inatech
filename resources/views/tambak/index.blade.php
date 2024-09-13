@extends('layouts.template')
@section('title', 'Tambak')
@section('content')
    <div class="card">
        <div class="card-header">Manajemen Tambak</div>
        <div class="card-body">
            <table class="table" id="table_manajemenTambak">
                <thead>
                    <tr class="text-center">
                        <th>NAMA TAMBAK</th>
                        <th>NAMA GUDANG</th>
                        <th>LUAS LAHAN</th>
                        <th>LUAS TAMBAK</th>
                        <th>LOKASI TAMBAK</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade text-left" id="tambakDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document" style="max-width: 500px;">
        <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
            <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title white" id="myModalLabel160">Detail Tambak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div id="user-detail-content" class="container text-center">
                </div>
            </div>
            <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
                <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Accept</span>
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
            var dataManajemenTambak = $('#table_manajemenTambak').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('tambak/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [{
                        data: "nama_tambak",
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            var url = '{{ route('tambak.show', ':id') }}';
                            url = url.replace(':id', row.id); 
                            return '<a href="javascript:void(0);" data-id="' + row.id +
                                '" class="view-user-details" data-url="' + url +
                                '" data-toggle="modal" data-target="#tambakDetailModal">' + data +
                                '</a>';
                        }
                    },
                    {
                        data: "gudang.nama",
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: "luas_lahan",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "luas_tambak",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "lokasi_tambak",
                        orderable: true,
                        searchable: true
                    }
                ],
                pagingType: "simple_numbers",
                dom: 'frtip',
                language: {
                    search: ""
                }
            });

            // Event listener untuk menampilkan detail tambak
            $(document).on('click', '.view-user-details', function() {
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.html) {
                            $('#user-detail-content').html(response.html);
                            $('#tambakDetailModal').modal('show');
                        } else {
                            alert('Gagal memuat detail tambak');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        alert('Gagal memuat detail tambak');
                    }
                });
            });

            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_manajemenTambak_filter").append(
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
            );

            // Event listener untuk tombol tambah
            $("#btn-tambah").on('click', function() {
                window.location.href = "{{ url('tambak/create') }}";
            });

            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Tambak...');
        });
    </script>
@endpush
