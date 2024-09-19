@extends('layouts.template')
@section('title', 'PjTambak')
@section('content')
    <div class="card">
        <div class="card-header">Penanggung Jawab Tambak</div>
        <div class="card-body">
            <table class="table" id="table_pjTambak">
                <thead>
                    <tr class="text-center">
                        <th>KODE PJ TAMBAK</th>
                        <th>NAMA PJ TAMBAK</th>
                        <th>NAMA TAMBAK</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    
     {{-- modal --}}
     <div class="modal fade text-left" id="pjTambakDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
     aria-hidden="true">
     <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
         <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
             <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                 <h5 class="modal-title white" id="myModalLabel160">Detail Tambak</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <i data-feather="x"></i>
                 </button>
             </div>
             <div class="modal-body" style="padding: 20px;">
                 
                 {{-- Modal Detail --}}
                 <div id="user-detail-content" class="container">
                     <div class="row">
                         {{-- <div class="col-md-4">
                             <img id="pjtambak-foto" class="img-fluid rounded mb-3" src="" alt="Foto Pj Tambak" style="max-width: 100%; height: auto;">
                         </div> --}}
                         <div class="col-md-8">
                             <table class="table table-borderless">
                                 <tr>
                                     <th>Kode Pj Tambak:</th>
                                     <td id="pjtambak-kode-pj-tambak"></td>
                                 </tr>
                                 <tr>
                                     <th>Nama Pj Tambak:</th>
                                     <td id="pjtambak-nama-pjtambak"></td>
                                 </tr>
                                 <tr>
                                    <th>Nama Tambak:</th>
                                    <td id="pjtambak-nama-tambak"></td>
                                </tr>
                                     
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
         overflow-y: auto; 
     }
 
     .table-borderless th, .table-borderless td {
         padding: 0.5rem 0.5rem;
     }
 </style>
 @endpush

@endsection
@push('css')
@endpush
@push('js')
    <script>
        $(document).ready(function() {
    var dataPjTambak = $('#table_pjTambak').DataTable({
        serverSide: true,
        ajax: {
            "url": "{{ url('pjTambak/list') }}",
            "dataType": "json",
            "type": "POST",
            "error": function(xhr, error, thrown) {
                console.error('Error fetching data: ', thrown);
            }
        },
        columns: [
            {
                data: "kd_user_tambak",
                render: function(data, type, row) {
                    var url = '{{ route('pjTambak.show', ':id') }}';
                    url = url.replace(':id', row.id_user_tambak);
                        return '<a href="javascript:void(0);" data-id="' + row.id_user_tambak +
                               '" class="view-user-details" data-url="' + url +
                               '" data-toggle="modal" data-target="#pjTambakDetailModal">' + data +
                               '</a>';
                }
            },
            {
                data: "user_nama",
                orderable: false
            },
            {
                data: "tambak_nama",
                orderable: false
            }
        ],
        pagingType: "simple_numbers",
        dom: 'frtip',
        language: {
            search: ""
        }
    });

    // Handle click event to fetch and display data in modal
    $('#table_pjTambak').on('click', '.view-user-details', function() {
        var url = $(this).data('url');
        $.get(url, function(data) {
            $('#user-detail-content').html(data.html); // Populate modal content
        }).fail(function() {
            $('#user-detail-content').html('<p>Error loading data.</p>');
        });
    });

    // Add button "Tambah" after search box
    $("#table_pjTambak_filter").append(
        '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');

    // Add event listener for button
    $("#btn-tambah").on('click', function() {
        window.location.href = "{{ url('pjTambak/create') }}";
    });

    // Placeholder text for search input
    $('input[type="search"]').attr('placeholder', 'Cari data Penanggung Jawab Tambak...');
});

    </script>
@endpush
