@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <h4>Penilaian Pengamatan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('penilaianpengamatan.update', $penilaianpengamatan->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for=""></label>
                            <input type="text" id="" name="" class="form-control square" placeholder="Input " required
                                value="{{ old('', $penilaianpengamatan-> ?? '') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for=""></label>
                            <input type="text" id="" name="" class="form-control square" placeholder="Input " required
                                value="{{ old('', $penilaianpengamatan-> ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 col-2 mx-auto">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
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
            textInput.classList.remove('d-none');
        }
    });
});

// Event listener untuk semua input text yang sudah jadi formatted-field
document.querySelectorAll('.formatted-field').forEach(textInput => {
    textInput.addEventListener('click', function() {
        const id = this.id.split('_')[2];
        const picker = document.getElementById(`picker_${id}`);
        this.classList.add('d-none');
        picker.classList.remove('d-none');
        picker.focus();
    });
});
</script>
@endsection