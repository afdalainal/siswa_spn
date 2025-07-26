@extends('layouts._index')

@section('content')
<section id="input-style">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Input anggota</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('anggota.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="squareText">anggota</label>
                                    <input type="text" id="squareText" name="name" class="form-control square"
                                        placeholder="Input Nama anggota" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 center">
                            <div class="d-grid gap-2 col-2 mx-auto">
                                <button class="btn btn-success" type="submit" style="color: black;">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection