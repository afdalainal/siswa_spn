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
            <h6 class='card-title'>Table siswa</h6>
            <div class="card-right d-flex align-items-center">
                <div class="buttons">
                    <a href="{{ route('siswa.create') }}" class="btn icon btn-primary"><i data-feather="plus"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama siswa</th>
                        <th>Nosis siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa as $siswa)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->nosis }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-outline-primary">
                                    <i data-feather="edit"></i>
                                </a>

                                <form onclick="return confirm('Are you sure?')"
                                    action="{{ route('siswa.destroy', $siswa->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger" type="submit">
                                        <i data-feather="delete"></i>
                                    </button>
                                </form>
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