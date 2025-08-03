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
                                class="form-control square" placeholder="Input nilai"
                                value="{{ old('jumlah_indikator', $penilaianpengamatan->jumlah_indikator) }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="skor">Skor</label>
                            <input type="number" id="skor" name="skor" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('skor', $penilaianpengamatan->skor) }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="nilai_konversi">Nilai Konversi</label>
                            <input type="number" id="nilai_konversi" name="nilai_konversi" class="form-control square"
                                placeholder="Input nilai" step="0.01"
                                value="{{ old('nilai_konversi', $penilaianpengamatan->nilai_konversi) }}" readonly>
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
                                value="{{ old('nilai_akhir', $penilaianpengamatan->nilai_akhir) }}" readonly>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Daftar semua input yang akan dihitung
    const inputFields = [
        'mental_spiritual_1', 'mental_spiritual_2', 'mental_spiritual_3',
        'mental_ideologi_1', 'mental_ideologi_2', 'mental_ideologi_3',
        'mental_kejuangan_1', 'mental_kejuangan_2', 'mental_kejuangan_3', 'mental_kejuangan_4',
        'watak_pribadi_1', 'watak_pribadi_2', 'watak_pribadi_3', 'watak_pribadi_4',
        'mental_kepemimpinan_1', 'mental_kepemimpinan_2', 'mental_kepemimpinan_3', 'mental_kepemimpinan_4',
        'mental_kepemimpinan_5', 'mental_kepemimpinan_6', 'mental_kepemimpinan_7', 'mental_kepemimpinan_8'
    ];

    // Tabel konversi (VLOOKUP table)
    const konversiTable = {
        1.0: 60,
        1.1: 60.5,
        1.2: 61,
        1.3: 61.5,
        1.4: 62,
        1.5: 62.5,
        1.6: 63,
        1.7: 63.5,
        1.8: 64,
        1.9: 64.5,
        2.0: 65,
        2.1: 65.5,
        2.2: 66,
        2.3: 66.5,
        2.4: 67,
        2.5: 67.5,
        2.6: 68,
        2.7: 68.5,
        2.8: 69,
        2.9: 69.5,
        3.0: 70,
        3.1: 70.5,
        3.2: 71,
        3.3: 71.5,
        3.4: 72,
        3.5: 72.5,
        3.6: 73,
        3.7: 73.5,
        3.8: 74,
        3.9: 74.5,
        4.0: 75,
        4.1: 75.5,
        4.2: 76,
        4.3: 76.5,
        4.4: 77,
        4.5: 77.5,
        4.6: 78,
        4.7: 78.5,
        4.8: 79,
        4.9: 79.5,
        5.0: 80
    };

    // Fungsi untuk menghitung total jumlah indikator
    function calculateTotal() {
        let total = 0;

        inputFields.forEach(fieldId => {
            const input = document.getElementById(fieldId);
            if (input && input.value) {
                total += parseFloat(input.value) || 0;
            }
        });

        // Update nilai jumlah indikator
        const jumlahIndikatorInput = document.getElementById('jumlah_indikator');
        if (jumlahIndikatorInput) {
            jumlahIndikatorInput.value = Math.round(total);
            calculateSkor(); // Panggil calculateSkor setelah update jumlah_indikator
        }
    }

    // Fungsi untuk menghitung skor
    function calculateSkor() {
        const jumlahIndikatorInput = document.getElementById('jumlah_indikator');
        const skorInput = document.getElementById('skor');

        if (jumlahIndikatorInput && skorInput) {
            const jumlahIndikator = parseFloat(jumlahIndikatorInput.value) || 0;
            const skor = Math.round((jumlahIndikator / 22) * 10) / 10; // Dibulatkan 1 desimal
            skorInput.value = skor.toFixed(1);
            calculateNilaiKonversi(); // Panggil calculateNilaiKonversi setelah update skor
        }
    }

    // Fungsi untuk menghitung nilai konversi (VLOOKUP)
    function calculateNilaiKonversi() {
        const skorInput = document.getElementById('skor');
        const nilaiKonversiInput = document.getElementById('nilai_konversi');

        if (skorInput && nilaiKonversiInput) {
            const skorValue = parseFloat(skorInput.value) || 0;

            // Cari nilai konversi berdasarkan skor
            let nilaiKonversi = 0;

            // Jika skor ada dalam tabel konversi
            if (konversiTable.hasOwnProperty(skorValue)) {
                nilaiKonversi = konversiTable[skorValue];
            } else {
                // Jika skor tidak ada dalam tabel, cari nilai terdekat (interpolasi sederhana)
                const keys = Object.keys(konversiTable).map(key => parseFloat(key)).sort((a, b) => a - b);

                if (skorValue < keys[0]) {
                    // Jika skor lebih kecil dari nilai minimum, gunakan nilai minimum
                    nilaiKonversi = konversiTable[keys[0]];
                } else if (skorValue > keys[keys.length - 1]) {
                    // Jika skor lebih besar dari nilai maksimum, gunakan nilai maksimum
                    nilaiKonversi = konversiTable[keys[keys.length - 1]];
                } else {
                    // Cari nilai terdekat yang lebih kecil atau sama dengan skor
                    for (let i = keys.length - 1; i >= 0; i--) {
                        if (skorValue >= keys[i]) {
                            nilaiKonversi = konversiTable[keys[i]];
                            break;
                        }
                    }
                }
            }

            nilaiKonversiInput.value = nilaiKonversi.toFixed(1);
            calculateNilaiAkhir(); // Panggil calculateNilaiAkhir setelah update nilai_konversi
        }
    }

    // Fungsi untuk menghitung nilai akhir (AB13-AC13+AD13)
    function calculateNilaiAkhir() {
        const nilaiKonversiInput = document.getElementById('nilai_konversi');
        const pelanggaranMinusInput = document.getElementById('pelanggaran_prestasi_minus');
        const pelanggaranPlusInput = document.getElementById('pelanggaran_prestasi_plus');
        const nilaiAkhirInput = document.getElementById('nilai_akhir');

        if (nilaiKonversiInput && pelanggaranMinusInput && pelanggaranPlusInput && nilaiAkhirInput) {
            const nilaiKonversi = parseFloat(nilaiKonversiInput.value) || 0;
            const pelanggaranMinus = parseFloat(pelanggaranMinusInput.value) || 0;
            const pelanggaranPlus = parseFloat(pelanggaranPlusInput.value) || 0;

            // Rumus: nilai_konversi - pelanggaran_minus + pelanggaran_plus
            const nilaiAkhir = nilaiKonversi - pelanggaranMinus + pelanggaranPlus;

            nilaiAkhirInput.value = nilaiAkhir.toFixed(1);
        }
    }

    // Tambahkan event listener ke semua input field
    inputFields.forEach(fieldId => {
        const input = document.getElementById(fieldId);
        if (input) {
            input.addEventListener('input', calculateTotal);
        }
    });

    // Tambahkan event listener untuk input pelanggaran prestasi
    const pelanggaranMinusInput = document.getElementById('pelanggaran_prestasi_minus');
    const pelanggaranPlusInput = document.getElementById('pelanggaran_prestasi_plus');

    if (pelanggaranMinusInput) {
        pelanggaranMinusInput.addEventListener('input', calculateNilaiAkhir);
    }

    if (pelanggaranPlusInput) {
        pelanggaranPlusInput.addEventListener('input', calculateNilaiAkhir);
    }

    // Hitung awal saat halaman dimuat
    calculateTotal();
});
</script>
@endsection