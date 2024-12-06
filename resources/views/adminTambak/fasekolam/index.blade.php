@extends('layouts.template')
@section('title', 'Fase Kolam')
@section('content')
    <div class="card">
        <div class="card-header">Fase Kolam</div>
        <div class="card-body">
            <table class="table" id="table_fasekolamuser">
                <thead>
                    <tr class="text-center">
                        <th>KODE FASE KOLAM</th>
                        <th>KODE KOLAM</th>
                        <th>TANGGAL MULAI</th>
                        <th>TANGGAL PANEN</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {{-- modal --}}
    <div class="modal fade text-left" id="faseKolamDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
            <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                <h5 class="modal-title white" id="myModalLabel160">Detail Fase Tambak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body" style="padding: 20px;">
                {{-- Modal Detail --}}
                <div id="user-detail-content" class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="pjtambak-foto" class="img-fluid rounded mb-3" src="" alt="Foto Pj Tambak" style="max-width: 100%; height: auto;">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Kode Fase Kolam:</th>
                                    <td id="faseKolam-kode-fase-kolam"></td>
                                </tr>
                                <tr>
                                    <th>Kode Kolam:</th>
                                    <td id="faseKolam-kode-kolam"></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Mulai:</th>
                                    <td id="faseKolam-tanggal-mulai"></td>
                                </tr>
                                <tr>
                                    <th>Tanggal Panen:</th>
                                    <td id="faseKolam-tanggal-panen"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ route('user.fasekolam.index') }}'"
                        style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
            </div>
        </div>
    </div>
</div>

@push('css')
@endpush

@endsection

@push('js')
<script>
    $(document).ready(function() {
        var datafaseKolam = $('#table_fasekolamuser').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ route('user.fasekolam.list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.id_kolam = $('#id_kolam').val();
                },
                "error": function(xhr, error, thrown) {
                    console.error('Error fetching data: ', thrown);
                }
            },
            columns: [{
                    data: "kd_fase_tambak",
                    className: "", 
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.fasekolam.show', ':id') }}';
                        url = url.replace(':id', row.id_fase_tambak);
                        return '<a href="javascript:void(0);" data-id="' + row.id_fase_tambak +
                        '" class="view-user-details" data-url="' + url +
                        '" data-toggle="modal" data-target="#faseKolamDetailModal">' + data +
                        '</a>';
                    }
                },
                {
                    data: "kolam.kd_kolam",
                    className: "", 
                    orderable: false,
                    searchable: true
                },
                {
                    data: "tanggal_mulai",
                    className: "", 
                    orderable: false,
                    searchable: false
                },
                {
                    data: "tanggal_panen",
                    className: "", 
                    orderable: false,
                    searchable: false
                },
            ],
            pagingType: "simple_numbers", 
            dom: 'frtip', 
            language: {
                search: "" 
            }
        });

        $(document).on('click', '.view-user-details', function() {
            var url = $(this).data('url'); 
            var id_fase_tambak = $(this).data('id'); 
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.html) {
                        $('#user-detail-content').html(response.html); 
                        $('#edit-fasekolam').attr('data-id', id_fase_tambak); 
                        $('#faseKolamDetailModal').modal('show'); 
                    } else {
                        alert('Gagal memuat detail fase kolam');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('Gagal memuat detail fase kolam');
                }
            });
        });


        $("#table_fasekolamuser_filter").append(
            '<select class="form-control" name="id_kolam" id="id_kolam" required style="margin-left: 30px; width: 150px;">' +
            '<option value="">- SEMUA -</option>' +
            '@foreach ($kolam as $item)' +
            '<option value="{{ $item->id_kolam }}">{{ $item->kd_kolam}}</option>' +
            '@endforeach' +
            '</select>'            
        );

        // placeholder search
        $('input[type="search"]').attr('placeholder', 'Cari data Fase Kolam...');        
        
        $('#id_kolam').on('change', function() {
            datafaseKolam.ajax.reload();
        })    
    });
</script>
@endpush
