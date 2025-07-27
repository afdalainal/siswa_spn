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
            <h6 class='card-title'>Table Tugas Peleton</h6>
            <div class="card-right d-flex align-items-center">
                <div class="buttons">
                    <a href="{{ route('tugaspeleton.create') }}" class="btn icon btn-primary"><i
                            data-feather="plus"></i></a>
                </div>
            </div>
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
                        <th>Ton/Ki/Yon</th>
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
                        <td>{{ $tugaspeletons->ton_ki_yon }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <div class="btn-group btn-group-sm">
                                    @if($tugaspeletons->trashed())
                                    <form action="{{ route('tugaspeleton.restore', $tugaspeletons->id) }}" method="POST"
                                        style="display:inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success btn-sm"
                                            onclick="return confirm('Aktifkan kembali data ini?')">Aktifkan</button>
                                    </form>
                                    @else
                                    <a href="{{ route('tugaspeleton.edit', $tugaspeletons->id) }}"
                                        class="btn btn-outline-primary"><i data-feather="edit"></i></a>

                                    <form action="{{ route('tugaspeleton.destroy', $tugaspeletons->id) }}" method="POST"
                                        style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus permanen?')">Hapus Permanen</button>
                                    </form>

                                    <form action="{{ route('tugaspeleton.softdelete', $tugaspeletons->id) }}"
                                        method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-warning btn-sm"
                                            onclick="return confirm('Yakin nonaktifkan data ini?')">Nonaktifkan</button>
                                    </form>
                                    @endif
                                </div>
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