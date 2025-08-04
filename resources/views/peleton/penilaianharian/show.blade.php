@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4>Penilaian Harian - {{ $penilaianharian->tugasSiswa->siswa->nama }}
                ( {{ $penilaianharian->tugasSiswa->siswa->nosis }} )</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('penilaianharian.update', $penilaianharian->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary">Nilai Harian</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_harian_1">Nilai Harian 1</label>
                            <input type="number" id="nilai_harian_1" name="nilai_harian_1" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_harian_1', $penilaianharian->nilai_harian_1) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_harian_2">Nilai Harian 2</label>
                            <input type="number" id="nilai_harian_2" name="nilai_harian_2" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_harian_2', $penilaianharian->nilai_harian_2) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_harian_3">Nilai Harian 3</label>
                            <input type="number" id="nilai_harian_3" name="nilai_harian_3" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_harian_3', $penilaianharian->nilai_harian_3) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_harian_4">Nilai Harian 4</label>
                            <input type="number" id="nilai_harian_4" name="nilai_harian_4" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_harian_4', $penilaianharian->nilai_harian_4) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_harian_5">Nilai Harian 5</label>
                            <input type="number" id="nilai_harian_5" name="nilai_harian_5" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_harian_5', $penilaianharian->nilai_harian_5) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_harian_6">Nilai Harian 6</label>
                            <input type="number" id="nilai_harian_6" name="nilai_harian_6" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_harian_6', $penilaianharian->nilai_harian_6) }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nilai_harian_7">Nilai Harian 7</label>
                            <input type="number" id="nilai_harian_7" name="nilai_harian_7" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_harian_7', $penilaianharian->nilai_harian_7) }}" readonly>
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
                                value="{{ old('keterangan', $penilaianharian->keterangan ?? '') }}">
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