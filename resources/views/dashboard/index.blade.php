@extends('layouts.template')
@section('title', 'Dashboard')
@section('content')
    <div class="card">
        <div class="card-header">Detail Pakan</div>
        <div class="card-body">
            <div id="chart"></div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        var options = {
            chart: {
                type: 'line'
            },
            series: [{
                name: 'sales',
                data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
            }],
            xaxis: {
                categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999]
            }
        }
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endpush
