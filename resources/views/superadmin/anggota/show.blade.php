@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4>Edit anggota</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="anggota">anggota</label>
                    <input type="text" id="anggota" name="name" class="form-control square"
                        placeholder="Input Nama anggota" value="{{ old('anggota', $anggota->name) }}">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</section>
@endsection