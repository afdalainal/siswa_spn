@extends('layouts._index')

@section('content')

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


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

                        <!-- Section 1: Pengasuh dan Peleton -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary">Pengasuh dan Peleton</h5>
                            </div>
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                            <div class="col-md-6">
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
                        </div>

                        <!-- Section 2: Siswa dan Info Dasar -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary">Siswa dan Informasi Dasar</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="siswa_id">Pilih Siswa</label>
                                    <select class="choices form-select multiple-remove" id="siswa_id" name="siswa_id[]"
                                        multiple required>
                                        <option value="" disabled>-- Pilih --</option>
                                        @foreach($siswa as $siswas)
                                        @php
                                        $status = $tugasSiswaStatus[$siswas->id] ?? null;
                                        @endphp
                                        <option value="{{ $siswas->id }}">
                                            {{ $siswas->nama }}{{ $status === 'nonaktif' ? ' - nonaktif' : '' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ton_ki_yon">Ton/Ki/Yon</label>
                                    <input type="text" id="ton_ki_yon" name="ton_ki_yon" class="form-control square"
                                        placeholder="Input Ton/Ki/Yon" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="minggu_ke">Minggu Ke</label>
                                    <input type="text" id="minggu_ke" name="minggu_ke" class="form-control square"
                                        placeholder="Input minggu_ke" required>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Tanggal dan Tempat -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary">Tanggal dan Tempat</h5>
                            </div>

                            <!-- Day 1 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hari_tgl_1">Hari Tanggal 1</label>
                                    <div class="input-group">
                                        <input type="text" id="hari_tgl_1" name="hari_tgl_1" class="form-control square"
                                            placeholder="Contoh: SENIN, 1 JANUARI 2023 atau PELANTIKAN" required>
                                        <button class="btn btn-outline-secondary picker-btn" type="button"
                                            data-target="1">
                                            <i class="bi bi-calendar3"></i>
                                        </button>
                                    </div>
                                    <input type="date" id="picker_1" name="picker_1"
                                        class="form-control square picker-field d-none mt-2" data-target="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_1">Tempat 1</label>
                                    <input type="text" id="tempat_1" name="tempat_1" class="form-control square"
                                        placeholder="Input tempat_1" required>
                                </div>
                            </div>

                            <!-- Day 2 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hari_tgl_2">Hari Tanggal 2</label>
                                    <div class="input-group">
                                        <input type="text" id="hari_tgl_2" name="hari_tgl_2" class="form-control square"
                                            placeholder="Contoh: SENIN, 1 JANUARI 2023 atau PELANTIKAN" required>
                                        <button class="btn btn-outline-secondary picker-btn" type="button"
                                            data-target="2">
                                            <i class="bi bi-calendar3"></i>
                                        </button>
                                    </div>
                                    <input type="date" id="picker_2" name="picker_2"
                                        class="form-control square picker-field d-none mt-2" data-target="2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_2">Tempat 2</label>
                                    <input type="text" id="tempat_2" name="tempat_2" class="form-control square"
                                        placeholder="Input tempat_2" required>
                                </div>
                            </div>

                            <!-- Day 3 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hari_tgl_3">Hari Tanggal 3</label>
                                    <div class="input-group">
                                        <input type="text" id="hari_tgl_3" name="hari_tgl_3" class="form-control square"
                                            placeholder="Contoh: SENIN, 1 JANUARI 2023 atau PELANTIKAN" required>
                                        <button class="btn btn-outline-secondary picker-btn" type="button"
                                            data-target="3">
                                            <i class="bi bi-calendar3"></i>
                                        </button>
                                    </div>
                                    <input type="date" id="picker_3" name="picker_3"
                                        class="form-control square picker-field d-none mt-2" data-target="3">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_3">Tempat 3</label>
                                    <input type="text" id="tempat_3" name="tempat_3" class="form-control square"
                                        placeholder="Input tempat_3" required>
                                </div>
                            </div>

                            <!-- Day 4 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hari_tgl_4">Hari Tanggal 4</label>
                                    <div class="input-group">
                                        <input type="text" id="hari_tgl_4" name="hari_tgl_4" class="form-control square"
                                            placeholder="Contoh: SENIN, 1 JANUARI 2023 atau PELANTIKAN" required>
                                        <button class="btn btn-outline-secondary picker-btn" type="button"
                                            data-target="4">
                                            <i class="bi bi-calendar3"></i>
                                        </button>
                                    </div>
                                    <input type="date" id="picker_4" name="picker_4"
                                        class="form-control square picker-field d-none mt-2" data-target="4">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_4">Tempat 4</label>
                                    <input type="text" id="tempat_4" name="tempat_4" class="form-control square"
                                        placeholder="Input tempat_4" required>
                                </div>
                            </div>

                            <!-- Day 5 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hari_tgl_5">Hari Tanggal 5</label>
                                    <div class="input-group">
                                        <input type="text" id="hari_tgl_5" name="hari_tgl_5" class="form-control square"
                                            placeholder="Contoh: SENIN, 1 JANUARI 2023 atau PELANTIKAN" required>
                                        <button class="btn btn-outline-secondary picker-btn" type="button"
                                            data-target="5">
                                            <i class="bi bi-calendar3"></i>
                                        </button>
                                    </div>
                                    <input type="date" id="picker_5" name="picker_5"
                                        class="form-control square picker-field d-none mt-2" data-target="5">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_5">Tempat 5</label>
                                    <input type="text" id="tempat_5" name="tempat_5" class="form-control square"
                                        placeholder="Input tempat_5" required>
                                </div>
                            </div>

                            <!-- Day 6 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hari_tgl_6">Hari Tanggal 6</label>
                                    <div class="input-group">
                                        <input type="text" id="hari_tgl_6" name="hari_tgl_6" class="form-control square"
                                            placeholder="Contoh: SENIN, 1 JANUARI 2023 atau PELANTIKAN" required>
                                        <button class="btn btn-outline-secondary picker-btn" type="button"
                                            data-target="6">
                                            <i class="bi bi-calendar3"></i>
                                        </button>
                                    </div>
                                    <input type="date" id="picker_6" name="picker_6"
                                        class="form-control square picker-field d-none mt-2" data-target="6">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_6">Tempat 6</label>
                                    <input type="text" id="tempat_6" name="tempat_6" class="form-control square"
                                        placeholder="Input tempat_6" required>
                                </div>
                            </div>

                            <!-- Day 7 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hari_tgl_7">Hari Tanggal 7</label>
                                    <div class="input-group">
                                        <input type="text" id="hari_tgl_7" name="hari_tgl_7" class="form-control square"
                                            placeholder="Contoh: SENIN, 1 JANUARI 2023 atau PELANTIKAN" required>
                                        <button class="btn btn-outline-secondary picker-btn" type="button"
                                            data-target="7">
                                            <i class="bi bi-calendar3"></i>
                                        </button>
                                    </div>
                                    <input type="date" id="picker_7" name="picker_7"
                                        class="form-control square picker-field d-none mt-2" data-target="7">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tempat_7">Tempat 7</label>
                                    <input type="text" id="tempat_7" name="tempat_7" class="form-control square"
                                        placeholder="Input tempat_7" required>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Keterangan -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-primary">Keterangan</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" id="keterangan" name="keterangan" class="form-control square"
                                        placeholder="Input keterangan" required>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-sm-12 center">
                                <div class="d-grid gap-2 col-2 mx-auto">
                                    <button class="btn btn-success" type="submit" style="color: black;">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
const hariIndo = ['MINGGU', 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU'];
const bulanIndo = [
    'JANUARI', 'FEBRUARI', 'MARET', 'APRIL', 'MEI', 'JUNI',
    'JULI', 'AGUSTUS', 'SEPTEMBER', 'OKTOBER', 'NOVEMBER', 'DESEMBER'
];

// Fungsi format tanggal ke string Indo
function formatTanggalIndo(date) {
    const hari = hariIndo[date.getDay()];
    const tanggal = date.getDate();
    const bulan = bulanIndo[date.getMonth()];
    const tahun = date.getFullYear();
    return `${hari}, ${tanggal} ${bulan} ${tahun}`;
}

// Event listener untuk semua date picker
document.querySelectorAll('.picker-field').forEach(picker => {
    picker.addEventListener('change', function() {
        const id = this.getAttribute('data-target');
        const textInput = document.getElementById(`hari_tgl_${id}`);
        const inputDate = new Date(this.value);

        if (!isNaN(inputDate)) {
            textInput.value = formatTanggalIndo(inputDate);
            this.classList.add('d-none');
        }
    });
});

// Event listener untuk tombol kalender
document.querySelectorAll('.picker-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-target');
        const picker = document.getElementById(`picker_${id}`);
        picker.classList.toggle('d-none');

        // Focus the picker when shown
        if (!picker.classList.contains('d-none')) {
            picker.focus();
        }
    });
});

// Close picker when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.picker-btn') && !e.target.closest('.picker-field')) {
        document.querySelectorAll('.picker-field').forEach(picker => {
            picker.classList.add('d-none');
        });
    }
});
</script>

@endsection