@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4>Edit pengasuh</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('pengasuh.update', $pengasuh->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama">Nama pengasuh</label>
                            <input type="text" id="nama" name="nama" class="form-control square"
                                placeholder="Input Nama Lengkap pengasuh" value="{{ $pengasuh->nama }}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama">Jabatan pengasuh</label>
                            <input type="text" id="jabatan" name="jabatan" class="form-control square"
                                placeholder="Input jabatan pengasuh" value="{{ $pengasuh->jabatan }}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama">Pangkat/NRP pengasuh</label>
                            <input type="text" id="pangkat_nrp" name="pangkat_nrp" class="form-control square"
                                placeholder="Input pangkat/nrp pengasuh" value="{{ $pengasuh->pangkat_nrp }}" required>
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