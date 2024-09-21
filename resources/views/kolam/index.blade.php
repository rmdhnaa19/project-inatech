@extends('layouts.template')
@section('title', 'Kolam')
@section('content')
    <div class="card">
        <div class="card-header">Manajemen Kolam</div>
        <div class="card-body">
            <table class="table" id="table_manajemenKolam">
                <thead>
                    <tr class="text-center">
                        <th>KODE KOLAM</th>
                        <th>TIPE KOLAM</th>
                        <th>NAMA TAMBAK</th>
                        {{-- <th>PANJANG KOLAM </th>
                        <th>LEBAR KOLAM</th> --}}
                        <th>LUAS KOLAM</th>
                        {{-- <th>KEDALAMAN</th> --}}
                    </tr>
                </thead>
            </table>
        </div>
    </div>

   {{-- modal --}}
   <div class="modal fade text-left" id="kolamDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
   aria-hidden="true">
   <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
       <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
           <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
               <h5 class="modal-title white" id="myModalLabel160">Detail Kolam</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <i data-feather="x"></i>
               </button>
           </div>
           <div class="modal-body" style="padding: 20px;">
               
               {{-- Modal Detail --}}
               <div id="user-detail-content" class="container">
                   <div class="row">
                       <div class="col-md-4">
                           <img id="kolam-foto" class="img-fluid rounded mb-3" src="" alt="Foto Kolam" style="max-width: 100%; height: auto;">
                       </div>
                       <div class="col-md-8">
                           <table class="table table-borderless">
                               <tr>
                                   <th>Kode Kolam:</th>
                                   <td id="kolam-kode"></td>
                               </tr>
                               <tr>
                                   <th>Tipe Kolam:</th>
                                   <td id="kolam-tipe"></td>
                               </tr>
                               <tr>
                                   <th>Nama Tambak:</th>
                                   <td id="tambak-nama"></td>
                               </tr>
                               {{-- <tr>
                                   <th>Panjang Kolam:</th>
                                   <td id="kolam-panjang-kolam"></td>
                               </tr>
                               <tr>
                                   <th>Lebar Kolam:</th>
                                   <td id="kolam-lebar-kolam"></td>
                               </tr> --}}
                               <tr>
                                <th>Luas Kolam:</th>
                                <td id="kolam-luas-kolam"></td>
                            </tr>
                            {{-- <tr>
                                <th>Kedalaman:</th>
                                <td id="kolam-kedalaman"></td>
                            </tr> --}}
                           </table>
                       </div>
                   </div>
               </div>
           </div>
           <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
               <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                   <i class="bx bx-x d-block d-sm-none"></i>
                   <span class="d-none d-sm-block">Delete</span>
               </button>
               <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                   <i class="bx bx-check d-block d-sm-none"></i>
                   <span class="d-none d-sm-block">Update</span>
               </button>
           </div>
       </div>
   </div>
</div>
@endsection

@push('css')
<style>
    .modal-dialog {
        max-width: 40%;
        margin: 5vh auto; 
    }

    .modal-content {
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        max-height: 70vh; 
        overflow-y: auto; /* Tambahkan scrollbar jika konten terlalu panjang */
    }

    .table-borderless th, .table-borderless td {
        padding: 0.5rem 0.5rem;
    }
</style>
@endpush

@push('css')
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            var dataManajemenKolam = $('#table_manajemenKolam').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('kolam/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.id_tambak = $('#id_tambak').val();
                    },
                    "error": function(xhr, error, thrown) {
                        console.error('Error fetching data: ', thrown);
                    }
                },
                columns: [
                    {
                        data: "kd_kolam",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            var url = '{{ route('kolam.show', ':id') }}';
                            url = url.replace(':id', row.id_kolam);
                            return '<a href="javascript:void(0);" data-id="' + row.id_kolam +
                   '" class="view-user-details" data-url="' + url +
                   '" data-toggle="modal" data-target="#kolamDetailModal">' + data +
                   '</a>';                                
                        }
                    },
                    {
                        data: "tipe_kolam",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: "tambak.nama_tambak",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: false,
                        searchable: true
                    },
                    // {
                    //     data: "panjang_kolam",
                    //     className: "", 
                    //     orderable: true,
                    //     searchable: true
                    // },
                    // {
                    //     data: "lebar_kolam",
                    //     className: "", 
                    //     orderable: true,
                    //     searchable: true
                    // },
                    {
                        data: "luas_kolam",
                        className: "", // Jika tidak ada class, hapus baris ini
                        orderable: true,
                        searchable: true
                    },
                    // {
                    //     data: "kedalaman",
                    //     className: "", 
                    //     orderable: true,
                    //     searchable: true
                    // },
                ],
                pagingType: "simple_numbers", // Tambahkan ini untuk menampilkan angka pagination
                dom: 'frtip', // Mengatur layout DataTables
                language: {
                    search: "" // Menghilangkan teks "Search"
                }
            });

             // Event listener untuk menampilkan detail tambak
            $(document).on('click', '.view-user-details', function() {
    var url = $(this).data('url'); // Ambil URL dari data-url
    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            if (response.html) {
                $('#user-detail-content').html(response.html); // Muat konten ke modal
                $('#kolamDetailModal').modal('show'); // Tampilkan modal
            } else {
                alert('Gagal memuat detail kolam');
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
            alert('Gagal memuat detail kolam');
        }
    });
});


            // Tambahkan tombol "Tambah" setelah kolom pencarian
            $("#table_manajemenKolam_filter").append(
                '<select class="form-control" name="id_tambak" id="id_tambak" required style="margin-left: 30px; width: 150px;">' +
                '<option value="">- SEMUA -</option>' +
                '@foreach ($tambak as $item)' +
                '<option value="{{ $item->id_tambak }}">{{ $item->nama_tambak }}</option>' +
                '@endforeach' +
                '</select>' +
                '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');
                

            // Tambahkan event listener untuk tombol tambah 
            $("#btn-tambah").on('click', function() {
                window.location.href =
                // "{{ route('kolam.create') }}"
                    "{{ url('kolam/create') }}"; // Arahkan ke halaman tambah pengguna
            });
            // Menambahkan placeholder pada kolom search
            $('input[type="search"]').attr('placeholder', 'Cari data Kolam...');
            $('#id_tambak').on('change', function() {
                dataManajemenKolam.ajax.reload();
            })        
        });
    </script>
@endpush
