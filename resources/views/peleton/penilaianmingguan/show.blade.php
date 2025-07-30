@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4>Penilaian Mingguan - {{ $penilaianmingguan->tugasSiswa->siswa->nama }}
                ( {{ $penilaianmingguan->tugasSiswa->siswa->nosis }} )</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('penilaianmingguan.update', $penilaianmingguan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary">Nilai Mingguan</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_mingguan_hari_1">Nilai Mingguan Hari 1</label>
                            <input type="number" id="nilai_mingguan_hari_1" name="nilai_mingguan_hari_1"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_mingguan_hari_1', $penilaianmingguan->nilai_mingguan_hari_1) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_mingguan_hari_2">Nilai Mingguan Hari 2</label>
                            <input type="number" id="nilai_mingguan_hari_2" name="nilai_mingguan_hari_2"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_mingguan_hari_2', $penilaianmingguan->nilai_mingguan_hari_2) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_mingguan_hari_3">Nilai Mingguan Hari 3</label>
                            <input type="number" id="nilai_mingguan_hari_3" name="nilai_mingguan_hari_3"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_mingguan_hari_3', $penilaianmingguan->nilai_mingguan_hari_3) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_mingguan_hari_4">Nilai Mingguan Hari 4</label>
                            <input type="number" id="nilai_mingguan_hari_4" name="nilai_mingguan_hari_4"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_mingguan_hari_4', $penilaianmingguan->nilai_mingguan_hari_4) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_mingguan_hari_5">Nilai Mingguan Hari 5</label>
                            <input type="number" id="nilai_mingguan_hari_5" name="nilai_mingguan_hari_5"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_mingguan_hari_5', $penilaianmingguan->nilai_mingguan_hari_5) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_mingguan_hari_6">Nilai Mingguan Hari 6</label>
                            <input type="number" id="nilai_mingguan_hari_6" name="nilai_mingguan_hari_6"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_mingguan_hari_6', $penilaianmingguan->nilai_mingguan_hari_6) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_mingguan_hari_7">Nilai Mingguan Hari 7</label>
                            <input type="number" id="nilai_mingguan_hari_7" name="nilai_mingguan_hari_7"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_mingguan_hari_7', $penilaianmingguan->nilai_mingguan_hari_7) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_mingguan">Nilai Mingguan Total</label>
                            <input type="number" id="nilai_mingguan" name="nilai_mingguan" class="form-control square"
                                placeholder="Input nilai total" step="0.01"
                                value="{{ old('nilai_mingguan', $penilaianmingguan->nilai_mingguan) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="rank_mingguan">Rank Mingguan</label>
                            <input type="number" id="rank_mingguan" name="rank_mingguan" class="form-control square"
                                placeholder="Input rank"
                                value="{{ old('rank_mingguan', $penilaianmingguan->rank_mingguan) }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary">Keterangan</h5>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" class="form-control square"
                                placeholder="Input keterangan" required
                                value="{{ old('keterangan', $penilaianmingguan->keterangan ?? '') }}">
                        </div>
                    </div>
                </div>


                <div class="d-grid gap-2 col-2 mx-auto mt-4">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection