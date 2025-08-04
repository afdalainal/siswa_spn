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
            <h6 class='card-title'>List Tugas Penilaian Mingguan</h6>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>No. Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tugasSiswa as $tugasSiswas)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tugasSiswas->siswa->nama ?? '-' }}</td>
                        <td>{{ $tugasSiswas->siswa->nosis ?? '-' }}</td>
                        <td>
                            @if($tugasSiswas->penilaianmingguan && $tugasSiswas->status == 'aktif')
                            <a href="{{ route('penilaianmingguan.edit', $tugasSiswas->penilaianmingguan->id) }}"
                                class="btn btn-outline-primary"><i data-feather="edit"></i></a>
                            </a>
                            @else
                            <span class="btn btn-outline-danger disabled" title="Siswa nonaktif">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection