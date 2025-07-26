@extends('layouts._index')

@section('content')
<section id="input-style">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create Akun</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('akunpeleton.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nama</label>
                                    <input type="text" id="name" name="name" class="form-control square"
                                        placeholder="Input Nama" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control square"
                                        placeholder="Input Email" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="" disabled selected>-- Pilih Role --</option>
                                        <option value="superadmin">Superadmin</option>
                                        <option value="peleton">Peleton</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" class="form-control square"
                                        placeholder="Input Password" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control square" placeholder="Confirm Password" required>
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