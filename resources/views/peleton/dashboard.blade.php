@extends('layouts._index')

@section('content')
<div class="page-title">
    <h5>Dashboard</h5>
</div>
<section class="section">
    <div class="row mb-2">

        <div class="col-12 col-md-12">
            <div class="card card-statistic">
                <div class="card-body p-0">
                    <div class="d-flex flex-column">
                        <div class='px-3 py-3 d-flex justify-content-between'>
                            <h6 class='card-title'>Informasi Progress Tahapan Evaluasi</h6>
                            <div class="card-right d-flex align-items-center">
                                <p>.</p>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="canvas1" style="height:100px !important"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row mb-4">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class='card-heading p-1 pl-3'>Sales</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="pl-3">
                                <h1 class='mt-5'>$21,102</h1>
                                <p class='text-xs'><span class="text-green"><i data-feather="bar-chart" width="15"></i>
                                        +19%</span> than last month</p>
                                <div class="legends">
                                    <div class="legend d-flex flex-row align-items-center">
                                        <div class='w-3 h-3 rounded-full bg-info me-2'></div><span class='text-xs'>Last
                                            Month</span>
                                    </div>
                                    <div class="legend d-flex flex-row align-items-center">
                                        <div class='w-3 h-3 rounded-full bg-blue me-2'></div><span
                                            class='text-xs'>Current Month</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <canvas id="bar"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection