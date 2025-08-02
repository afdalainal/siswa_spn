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
            <h6 class='card-title'>Table Tugas Penilaian Pengamatan</h6>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Danton</th>
                        <th>Danki</th>
                        <th>Danmen</th>
                        <th>Peleton</th>
                        <th>Minggu Ke</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tugaspeleton as $tugaspeletons)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tugaspeletons->pengasuhDanton->nama ?? '-' }}</td>
                        <td>{{ $tugaspeletons->pengasuhDanki->nama ?? '-' }}</td>
                        <td>{{ $tugaspeletons->pengasuhDanmen->nama ?? '-' }}</td>
                        <td>{{ $tugaspeletons->peleton->name ?? '-' }}</td>
                        <td>{{ $tugaspeletons->minggu_ke ?? '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('penilaianpengamatan.show', $tugaspeletons->id) }}"
                                    class="btn btn-outline-primary"><i data-feather="eye"></i></a>
                                <a href="{{ route('penilaianpengamatan.grafik', $tugaspeletons->id) }}"
                                    class="btn btn-outline-warning"> <i class="bi bi-bar-chart-line"></i></a>
                                <a href="{{ route('penilaianpengamatan.laporan', ['id' => $tugaspeletons->id, 'download' => true]) }}"
                                    target="_blank" class="btn btn-outline-secondary">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection