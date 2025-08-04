@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Hari Penilaian - {{ $tugasSiswa->siswa->nama }}
                ( {{ $tugasSiswa->siswa->nosis }} )</h6>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Hari / Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tugasSiswa->penilaianSiswaHarian as $harian)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tugasPeleton->{'hari_tgl_'.$harian->hari_ke} }}</td>
                        <td>
                            <a href="{{ route('penilaianpengamatan.edit', $harian->penilaianPengamatan->id) }}"
                                class="btn btn-outline-primary"><i data-feather="edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection