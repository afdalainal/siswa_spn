@extends('layouts._index')

@section('content')

@if (session('message'))
<div class="alert alert-{{ session('alert-type', 'info') }} alert-dismissible fade show" role="alert"
    style="color: black;">
    {{ session('message') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Laporan</h6>
            <div class="card-right d-flex align-items-center">
                <div class="buttons">
                    <a href="" class="btn icon btn-primary">Filter</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengasuh</th>
                        <th>Nama Siswa</th>
                        <th>Rank Siswa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $loop->iteration ?? "-" }}</td>
                        <td>{{ "-" }}</td>
                        <td>{{ "-" }}</td>
                        <td>{{ "-" }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection