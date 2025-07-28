@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4>Edit Tugas Peleton</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('tugaspeleton.update', $tugaspeleton->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="pengasuh_danton_id">Pilih Pengasuh Danton</label>
                            <select class="choices form-select multiple-remove" id="pengasuh_danton_id"
                                name="pengasuh_danton_id" required>
                                <option value="" disabled selected>-- Pilih --</option>
                                @foreach($pengasuh as $pengasuhs)
                                <option value="{{ $pengasuhs->id }}"
                                    {{ old('pengasuh_danton_id', $tugaspeleton->pengasuh_danton_id) == $pengasuhs->id ? 'selected' : '' }}>
                                    {{ $pengasuhs->nama }}
                                </option>
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
                                <option value="{{ $pengasuhs->id }}"
                                    {{ old('pengasuh_danki_id', $tugaspeleton->pengasuh_danki_id) == $pengasuhs->id ? 'selected' : '' }}>
                                    {{ $pengasuhs->nama }}
                                </option>
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
                                <option value="{{ $pengasuhs->id }}"
                                    {{ old('pengasuh_danmen_id', $tugaspeleton->pengasuh_danmen_id) == $pengasuhs->id ? 'selected' : '' }}>
                                    {{ $pengasuhs->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="user_id">Pilih Peleton</label>
                            <select class="choices form-select multiple-remove" id="user_id" name="user_id" required>
                                <option value="" disabled selected>-- Pilih --</option>

                                @foreach($user as $users)
                                <option value="{{ $users->id }}"
                                    {{ old('user_id', $tugaspeleton->user_id) == $users->id ? 'selected' : '' }}>
                                    {{ $users->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="siswa_id">Pilih Siswa</label>
                            <select class="choices form-select multiple-remove" id="siswa_id" name="siswa_id[]" multiple
                                required>
                                <option value="" disabled>-- Pilih --</option>
                                @foreach($siswa as $siswas)
                                <option value="{{ $siswas->id }}"
                                    {{ in_array($siswas->id, old('siswa_id', $tugaspeleton->siswa->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $siswas->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="ton_ki_yon">Ton/Ki/Yon</label>
                            <input type="text" id="ton_ki_yon" name="ton_ki_yon" class="form-control square"
                                placeholder="Input Ton/Ki/Yon" required
                                value="{{ old('ton_ki_yon', $tugaspeleton->ton_ki_yon ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="minggu_ke">Minggu Ke</label>
                            <input type="text" id="minggu_ke" name="minggu_ke" class="form-control square"
                                placeholder="Input minggu_ke" required
                                value="{{ old('minggu_ke', $tugaspeleton->minggu_ke ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="hari_tgl_1">hari_tgl_1</label>
                            <input type="text" id="hari_tgl_1" name="hari_tgl_1"
                                class="form-control square formatted-field" readonly placeholder="Input hari_tgl_1"
                                required value="{{ old('hari_tgl_1', $tugaspeleton->hari_tgl_1 ?? '') }}">

                            <input type="date" id="picker_1" name="picker_1"
                                class="form-control square picker-field d-none" data-target="1"
                                value="{{ old('picker_1', $tugaspeleton->picker_1 ?? '') }}">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tempat_1">tempat_1</label>
                            <input type="text" id="tempat_1" name="tempat_1" class="form-control square"
                                placeholder="Input tempat_1" required
                                value="{{ old('tempat_1', $tugaspeleton->tempat_1 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="hari_tgl_2">hari_tgl_2</label>
                            <input type="text" id="hari_tgl_2" name="hari_tgl_2"
                                class="form-control square formatted-field" readonly placeholder="Input hari_tgl_2"
                                required value="{{ old('hari_tgl_2', $tugaspeleton->hari_tgl_2 ?? '') }}">
                            <input type="date" id="picker_2" name="picker_2"
                                class="form-control square picker-field d-none" data-target="2"
                                value="{{ old('picker_2', $tugaspeleton->picker_2 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tempat_2">tempat_2</label>
                            <input type="text" id="tempat_2" name="tempat_2" class="form-control square"
                                placeholder="Input tempat_2" required
                                value="{{ old('tempat_2', $tugaspeleton->tempat_2 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="hari_tgl_3">hari_tgl_3</label>
                            <input type="text" id="hari_tgl_3" name="hari_tgl_3"
                                class="form-control square formatted-field" readonly placeholder="Input hari_tgl_3"
                                required value="{{ old('hari_tgl_3', $tugaspeleton->hari_tgl_3 ?? '') }}">
                            <input type="date" id="picker_3" name="picker_3"
                                class="form-control square picker-field d-none" data-target="3"
                                value="{{ old('picker_3', $tugaspeleton->picker_3 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tempat_3">tempat_3</label>
                            <input type="text" id="tempat_3" name="tempat_3" class="form-control square"
                                placeholder="Input tempat_3" required
                                value="{{ old('tempat_3', $tugaspeleton->tempat_3 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="hari_tgl_4">hari_tgl_4</label>
                            <input type="text" id="hari_tgl_4" name="hari_tgl_4"
                                class="form-control square formatted-field" readonly placeholder="Input hari_tgl_4"
                                required value="{{ old('hari_tgl_4', $tugaspeleton->hari_tgl_4 ?? '') }}">
                            <input type="date" id="picker_4" name="picker_4"
                                class="form-control square picker-field d-none" data-target="4"
                                value="{{ old('picker_4', $tugaspeleton->picker_4 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tempat_4">tempat_4</label>
                            <input type="text" id="tempat_4" name="tempat_4" class="form-control square"
                                placeholder="Input tempat_4" required
                                value="{{ old('tempat_4', $tugaspeleton->tempat_4 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="hari_tgl_5">hari_tgl_5</label>
                            <input type="text" id="hari_tgl_5" name="hari_tgl_5"
                                class="form-control square formatted-field" readonly placeholder="Input hari_tgl_5"
                                required value="{{ old('hari_tgl_5', $tugaspeleton->hari_tgl_5 ?? '') }}">
                            <input type="date" id="picker_5" name="picker_5"
                                class="form-control square picker-field d-none" data-target="5"
                                value="{{ old('picker_5', $tugaspeleton->picker_5 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tempat_5">tempat_5</label>
                            <input type="text" id="tempat_5" name="tempat_5" class="form-control square"
                                placeholder="Input tempat_5" required
                                value="{{ old('tempat_5', $tugaspeleton->tempat_5 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="hari_tgl_6">hari_tgl_6</label>
                            <input type="text" id="hari_tgl_6" name="hari_tgl_6"
                                class="form-control square formatted-field" readonly placeholder="Input hari_tgl_6"
                                required value="{{ old('hari_tgl_6', $tugaspeleton->hari_tgl_6 ?? '') }}">
                            <input type="date" id="picker_6" name="picker_6"
                                class="form-control square picker-field d-none" data-target="6"
                                value="{{ old('picker_6', $tugaspeleton->picker_6 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tempat_6">tempat_6</label>
                            <input type="text" id="tempat_6" name="tempat_6" class="form-control square"
                                placeholder="Input tempat_6" required
                                value="{{ old('tempat_6', $tugaspeleton->tempat_6 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="hari_tgl_7">hari_tgl_7</label>
                            <input type="text" id="hari_tgl_7" name="hari_tgl_7"
                                class="form-control square formatted-field" readonly placeholder="Input hari_tgl_7"
                                required value="{{ old('hari_tgl_7', $tugaspeleton->hari_tgl_7 ?? '') }}">
                            <input type="date" id="picker_7" name="picker_7"
                                class="form-control square picker-field d-none" data-target="7"
                                value="{{ old('picker_7', $tugaspeleton->picker_7 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="tempat_7">tempat_7</label>
                            <input type="text" id="tempat_7" name="tempat_7" class="form-control square"
                                placeholder="Input tempat_7" required
                                value="{{ old('tempat_7', $tugaspeleton->tempat_7 ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="keterangan">keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" class="form-control square"
                                placeholder="Input keterangan" required
                                value="{{ old('keterangan', $tugaspeleton->keterangan ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 col-2 mx-auto">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection