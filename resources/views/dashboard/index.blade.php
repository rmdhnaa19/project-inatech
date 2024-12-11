@extends('layouts.template')
@section('title', 'Dashboard')
@section('content')
    <div class="row mb-2">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body p-0">
                    <div class="d-flex flex-column">
                        <div class='px-3 py-3 d-flex justify-content-between'>
                            <h3 class='card-title'>BALANCE</h3>
                            <div class="card-right d-flex align-items-center">
                                <p>$50 </p>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            {!! $balanceChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body p-0">
                    <div class="d-flex flex-column">
                        <div class='px-3 py-3 d-flex justify-content-between'>
                            <h3 class='card-title'>Revenue</h3>
                            <div class="card-right d-flex align-items-center">
                                <p>$532.2 </p>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            {!! $revenueChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {{ $balanceChart->script() }}
    {{ $revenueChart->script() }}
    {{ $ordersChart->script() }}
    {{ $salesTodayChart->script() }}
@endpush
