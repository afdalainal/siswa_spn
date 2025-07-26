@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4>Edit siswa</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama">Nama Siswa</label>
                            <input type="text" id="nama" name="nama" class="form-control square"
                                placeholder="Input Nama Lengkap Siswa" value="{{ $siswa->nama }}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama">Nosis Siswa</label>
                            <input type="number" id="nosis" name="nosis" class="form-control square"
                                placeholder="Input Nosis Siswa" value="{{ $siswa->nosis }}" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 center">
                    <div class="d-grid gap-2 col-2 mx-auto">
                        <button class="btn btn-success" type="submit" style="color: black;">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection