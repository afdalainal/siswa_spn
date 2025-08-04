@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Daftar Siswa - {{ $tugasPeleton->peleton->name ?? 'Peleton' }} - Minggu
                ke - {{ $tugasPeleton->minggu_ke }}</h6>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>No. Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tugasSiswa as $siswa)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $siswa->siswa->nama }}</td>
                        <td>{{ $siswa->siswa->nosis }}</td>
                        <td>
                            @if($siswa->status == 'aktif')
                            <a href="{{ route('penilaianpengamatan.harian', [$tugasPeleton->id, $siswa->id]) }}"
                                class="btn btn-outline-primary"><i data-feather="eye"></i>
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