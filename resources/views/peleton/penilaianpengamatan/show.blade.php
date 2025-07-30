@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4>Penilaian Pengamatan - {{ $penilaianpengamatan->tugasSiswa->siswa->nama }}
                ( {{ $penilaianpengamatan->tugasSiswa->siswa->nosis }} )</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('penilaianpengamatan.update', $penilaianpengamatan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary">Mental Spiritual</h5>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mental_spiritual_1">Mental Spiritual 1</label>
                            <input type="number" id="mental_spiritual_1" name="mental_spiritual_1"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_spiritual_1', $penilaianpengamatan->mental_spiritual_1) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mental_spiritual_2">Mental Spiritual 2</label>
                            <input type="number" id="mental_spiritual_2" name="mental_spiritual_2"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_spiritual_2', $penilaianpengamatan->mental_spiritual_2) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mental_spiritual_3">Mental Spiritual 3</label>
                            <input type="number" id="mental_spiritual_3" name="mental_spiritual_3"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_spiritual_3', $penilaianpengamatan->mental_spiritual_3) }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary">Mental Ideologi</h5>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mental_ideologi_1">Mental Ideologi 1</label>
                            <input type="number" id="mental_ideologi_1" name="mental_ideologi_1"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_ideologi_1', $penilaianpengamatan->mental_ideologi_1) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mental_ideologi_2">Mental Ideologi 2</label>
                            <input type="number" id="mental_ideologi_2" name="mental_ideologi_2"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_ideologi_2', $penilaianpengamatan->mental_ideologi_2) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mental_ideologi_3">Mental Ideologi 3</label>
                            <input type="number" id="mental_ideologi_3" name="mental_ideologi_3"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_ideologi_3', $penilaianpengamatan->mental_ideologi_3) }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary">Mental Kejuangan</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mental_kejuangan_1">Mental Kejuangan 1</label>
                            <input type="number" id="mental_kejuangan_1" name="mental_kejuangan_1"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_kejuangan_1', $penilaianpengamatan->mental_kejuangan_1) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mental_kejuangan_2">Mental Kejuangan 2</label>
                            <input type="number" id="mental_kejuangan_2" name="mental_kejuangan_2"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_kejuangan_2', $penilaianpengamatan->mental_kejuangan_2) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mental_kejuangan_3">Mental Kejuangan 3</label>
                            <input type="number" id="mental_kejuangan_3" name="mental_kejuangan_3"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_kejuangan_3', $penilaianpengamatan->mental_kejuangan_3) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mental_kejuangan_4">Mental Kejuangan 4</label>
                            <input type="number" id="mental_kejuangan_4" name="mental_kejuangan_4"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_kejuangan_4', $penilaianpengamatan->mental_kejuangan_4) }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary">Watak Pribadi</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="watak_pribadi_1">Watak Pribadi 1</label>
                            <input type="number" id="watak_pribadi_1" name="watak_pribadi_1" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('watak_pribadi_1', $penilaianpengamatan->watak_pribadi_1) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="watak_pribadi_2">Watak Pribadi 2</label>
                            <input type="number" id="watak_pribadi_2" name="watak_pribadi_2" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('watak_pribadi_2', $penilaianpengamatan->watak_pribadi_2) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="watak_pribadi_3">Watak Pribadi 3</label>
                            <input type="number" id="watak_pribadi_3" name="watak_pribadi_3" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('watak_pribadi_3', $penilaianpengamatan->watak_pribadi_3) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="watak_pribadi_4">Watak Pribadi 4</label>
                            <input type="number" id="watak_pribadi_4" name="watak_pribadi_4" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('watak_pribadi_4', $penilaianpengamatan->watak_pribadi_4) }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary">Mental Kepemimpinan</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mental_kepemimpinan_1">Mental Kepemimpinan 1</label>
                            <input type="number" id="mental_kepemimpinan_1" name="mental_kepemimpinan_1"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_kepemimpinan_1', $penilaianpengamatan->mental_kepemimpinan_1) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mental_kepemimpinan_2">Mental Kepemimpinan 2</label>
                            <input type="number" id="mental_kepemimpinan_2" name="mental_kepemimpinan_2"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_kepemimpinan_2', $penilaianpengamatan->mental_kepemimpinan_2) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mental_kepemimpinan_3">Mental Kepemimpinan 3</label>
                            <input type="number" id="mental_kepemimpinan_3" name="mental_kepemimpinan_3"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_kepemimpinan_3', $penilaianpengamatan->mental_kepemimpinan_3) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mental_kepemimpinan_4">Mental Kepemimpinan 4</label>
                            <input type="number" id="mental_kepemimpinan_4" name="mental_kepemimpinan_4"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_kepemimpinan_4', $penilaianpengamatan->mental_kepemimpinan_4) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mental_kepemimpinan_5">Mental Kepemimpinan 5</label>
                            <input type="number" id="mental_kepemimpinan_5" name="mental_kepemimpinan_5"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_kepemimpinan_5', $penilaianpengamatan->mental_kepemimpinan_5) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mental_kepemimpinan_6">Mental Kepemimpinan 6</label>
                            <input type="number" id="mental_kepemimpinan_6" name="mental_kepemimpinan_6"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_kepemimpinan_6', $penilaianpengamatan->mental_kepemimpinan_6) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mental_kepemimpinan_7">Mental Kepemimpinan 7</label>
                            <input type="number" id="mental_kepemimpinan_7" name="mental_kepemimpinan_7"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_kepemimpinan_7', $penilaianpengamatan->mental_kepemimpinan_7) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="mental_kepemimpinan_8">Mental Kepemimpinan 8</label>
                            <input type="number" id="mental_kepemimpinan_8" name="mental_kepemimpinan_8"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('mental_kepemimpinan_8', $penilaianpengamatan->mental_kepemimpinan_8) }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary">Penilaian</h5>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="jumlah_indikator">Jumlah Indikator</label>
                            <input type="number" id="jumlah_indikator" name="jumlah_indikator"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('jumlah_indikator', $penilaianpengamatan->jumlah_indikator) }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="skor">Skor</label>
                            <input type="number" id="skor" name="skor" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('skor', $penilaianpengamatan->skor) }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="nilai_konversi">Nilai Konversi</label>
                            <input type="number" id="nilai_konversi" name="nilai_konversi" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_konversi', $penilaianpengamatan->nilai_konversi) }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="pelanggaran_prestasi_minus">Pelanggaran Prestasi Minus (-)</label>
                            <input type="number" id="pelanggaran_prestasi_minus" name="pelanggaran_prestasi_minus"
                                class="form-control square" placeholder="Input nilai" step="0.01"
                                value="{{ old('pelanggaran_prestasi_minus', $penilaianpengamatan->pelanggaran_prestasi_minus) }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="pelanggaran_prestasi_plus">Pelanggaran Prestasi Plus (+)</label>
                            <input type="number" id="pelanggaran_prestasi_plus" name="pelanggaran_prestasi_plus"
                                class="form-control square" placeholder="Input nilai" step="0.02"
                                value="{{ old('pelanggaran_prestasi_plus', $penilaianpengamatan->pelanggaran_prestasi_plus) }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="nilai_akhir">Nilai Akhir</label>
                            <input type="number" id="nilai_akhir" name="nilai_akhir" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_akhir', $penilaianpengamatan->nilai_akhir) }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="rank_harian">Rank Harian</label>
                            <input type="number" id="rank_harian" name="rank_harian" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('rank_harian', $penilaianpengamatan->rank_harian) }}">
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