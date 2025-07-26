@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Table anggota</h6>
            <div class="card-right d-flex align-items-center">
                <div class="buttons">
                    <a href="{{ route('anggota.create') }}" class="btn icon btn-primary"><i data-feather="plus"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>anggota</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($anggota as $anggota)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $anggota->name }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-outline-primary">
                                    <i data-feather="edit"></i>
                                </a>

                                <form onclick="return confirm('Are you sure?')"
                                    action="{{ route('anggota.destroy', $anggota->id) }}" method="POST">
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