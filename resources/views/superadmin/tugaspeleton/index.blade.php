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
            <h6 class='card-title'>Table pengasuh</h6>
            <div class="card-right d-flex align-items-center">
                <div class="buttons">
                    <a href="{{ route('pengasuh.create') }}" class="btn icon btn-primary"><i
                            data-feather="plus"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama pengasuh</th>
                        <th>Jabatan pengasuh</th>
                        <th>Pangkat/NRP pengasuh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengasuh as $pengasuh)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pengasuh->nama }}</td>
                        <td>{{ $pengasuh->jabatan }}</td>
                        <td>{{ $pengasuh->pangkat_nrp }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('pengasuh.edit', $pengasuh->id) }}" class="btn btn-outline-primary">
                                    <i data-feather="edit"></i>
                                </a>

                                <form onclick="return confirm('Are you sure?')"
                                    action="{{ route('pengasuh.destroy', $pengasuh->id) }}" method="POST">
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