@extends('layouts._index')

@section('content')
<section id="input-style">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Input Tugas Peleton</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tugaspeleton.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pengasuh_danton_id">Pilih Pengasuh Danton</label>
                                    <select class="choices form-select multiple-remove" id="pengasuh_danton_id"
                                        name="pengasuh_danton_id" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @foreach($pengasuh as $pengasuhs)
                                        <option value="{{ $pengasuhs->id }}">{{ $pengasuhs->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pengasuh_danki_id">Pilih Pengasuh Danki</label>
                                    <select class="choices form-select multiple-remove" id="pengasuh_danki_id"
                                        name="pengasuh_danki_id" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @foreach($pengasuh as $pengasuhs)
                                        <option value="{{ $pengasuhs->id }}">{{ $pengasuhs->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="pengasuh_danmen_id">Pilih Pengasuh Danmen</label>
                                    <select class="choices form-select multiple-remove" id="pengasuh_danmen_id"
                                        name="pengasuh_danmen_id" required>
                                        <option value="" disabled selected>-- Pilih --</option>

                                        @foreach($pengasuh as $pengasuhs)
                                        <option value="{{ $pengasuhs->id }}">{{ $pengasuhs->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="user_id">Pilih Peleton</label>
                                    <select class="choices form-select multiple-remove" id="user_id" name="user_id"
                                        required>
                                        <option value="" disabled selected>-- Pilih --</option>

                                        @foreach($user as $users)
                                        <option value="{{ $users->id }}">{{ $users->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="siswa_id">Pilih Siswa</label>
                                    <select class="choices form-select multiple-remove" id="siswa_id" name="siswa_id[]"
                                        multiple required>
                                        <option value="" disabled>-- Pilih --</option>
                                        @foreach($siswa as $siswas)
                                        <option value="{{ $siswas->id }}">{{ $siswas->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="ton_ki_yon">Ton/Ki/Yon</label>
                                    <input type="text" id="ton_ki_yon" name="ton_ki_yon" class="form-control square"
                                        placeholder="Input Ton/Ki/Yon" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="minggu_ke">Minggu Ke</label>
                                    <input type="text" id="minggu_ke" name="minggu_ke" class="form-control square"
                                        placeholder="Input minggu_ke" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="hari_tgl_1">hari_tgl_1</label>
                                    <input type="text" id="hari_tgl_1" name="hari_tgl_1" class="form-control square"
                                        placeholder="Input hari_tgl_1" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tempat_1">tempat_1</label>
                                    <input type="text" id="tempat_1" name="tempat_1" class="form-control square"
                                        placeholder="Input tempat_1" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="hari_tgl_2">hari_tgl_2</label>
                                    <input type="text" id="hari_tgl_2" name="hari_tgl_2" class="form-control square"
                                        placeholder="Input hari_tgl_2" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tempat_2">tempat_2</label>
                                    <input type="text" id="tempat_2" name="tempat_2" class="form-control square"
                                        placeholder="Input tempat_2" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="hari_tgl_3">hari_tgl_3</label>
                                    <input type="text" id="hari_tgl_3" name="hari_tgl_3" class="form-control square"
                                        placeholder="Input hari_tgl_3" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tempat_3">tempat_3</label>
                                    <input type="text" id="tempat_3" name="tempat_3" class="form-control square"
                                        placeholder="Input tempat_3" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="hari_tgl_4">hari_tgl_4</label>
                                    <input type="text" id="hari_tgl_4" name="hari_tgl_4" class="form-control square"
                                        placeholder="Input hari_tgl_4" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tempat_4">tempat_4</label>
                                    <input type="text" id="tempat_4" name="tempat_4" class="form-control square"
                                        placeholder="Input tempat_4" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="hari_tgl_5">hari_tgl_5</label>
                                    <input type="text" id="hari_tgl_5" name="hari_tgl_5" class="form-control square"
                                        placeholder="Input hari_tgl_5" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tempat_5">tempat_5</label>
                                    <input type="text" id="tempat_5" name="tempat_5" class="form-control square"
                                        placeholder="Input tempat_5" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="hari_tgl_6">hari_tgl_6</label>
                                    <input type="text" id="hari_tgl_6" name="hari_tgl_6" class="form-control square"
                                        placeholder="Input hari_tgl_6" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tempat_6">tempat_6</label>
                                    <input type="text" id="tempat_6" name="tempat_6" class="form-control square"
                                        placeholder="Input tempat_6" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="hari_tgl_7">hari_tgl_7</label>
                                    <input type="text" id="hari_tgl_7" name="hari_tgl_7" class="form-control square"
                                        placeholder="Input hari_tgl_7" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tempat_7">tempat_7</label>
                                    <input type="text" id="tempat_7" name="tempat_7" class="form-control square"
                                        placeholder="Input tempat_7" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="keterangan">keterangan</label>
                                    <input type="text" id="keterangan" name="keterangan" class="form-control square"
                                        placeholder="Input keterangan" required>
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