@extends('layouts._index')

@section('content')
<div class="page-title">
    <h5>Dashboard Peleton</h5>
</div>

<section class="section">
    @if($currentTugas)
    <div class="row">
        <!-- Current Assignment Card -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tugas Peleton Saat Ini</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Siswa</span>
                                    <span class="info-box-number">{{ $siswaCount }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-calendar-week"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Minggu Ke</span>
                                    <span class="info-box-number">{{ $currentTugas->minggu_ke ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-map-marker-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">TON/KI/YON</span>
                                    <span class="info-box-number">{{ $currentTugas->ton_ki_yon ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <h6>Danton</h6>
                            <p>{{ $currentTugas->pengasuhDanton->nama ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6>Danki</h6>
                            <p>{{ $currentTugas->pengasuhDanki->nama ?? '-' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h6>Danmen</h6>
                            <p>{{ $currentTugas->pengasuhDanmen->nama ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assessment Progress -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Progress Penilaian Harian</h4>
                </div>
                <div class="card-body">
                    <div class="progress-container">
                        @for($i = 1; $i <= 7; $i++) <div class="day-progress mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Hari Ke-{{ $i}} ({{ $currentTugas->{'hari_tgl_'.$i} ?? 'Belum diisi' }})</span>
                                <span>{{ $penilaianStatus[$i] ?? 0 }}/{{ $siswaCount }} siswa dinilai</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ isset($penilaianStatus[$i]) ? ($penilaianStatus[$i] / $siswaCount * 100) : 0 }}%"
                                    aria-valuenow="{{ isset($penilaianStatus[$i]) ? ($penilaianStatus[$i] / $siswaCount * 100) : 0 }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            @if(isset($averageScores[$i]))
                            <small class="text-muted">Rata-rata nilai:
                                {{ number_format($averageScores[$i], 2) }}</small>
                            @endif
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Quick Links -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card quick-action-card">
                <div class="card-body text-center">
                    <i class="fas fa-clipboard-check fa-3x mb-3 text-primary"></i>
                    <h5>Penilaian Pengamatan</h5>
                    <p>Input penilaian harian siswa</p>
                    <a href="{{ route('penilaianpengamatan.index') }}" class="btn btn-primary btn-sm">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card quick-action-card">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-day fa-3x mb-3 text-success"></i>
                    <h5>Penilaian Harian</h5>
                    <p>Rekapitulasi nilai harian</p>
                    <a href="{{ route('penilaianharian.index') }}" class="btn btn-success btn-sm">Buka</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card quick-action-card">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-week fa-3x mb-3 text-info"></i>
                    <h5>Penilaian Mingguan</h5>
                    <p>Rekapitulasi nilai mingguan</p>
                    <a href="{{ route('penilaianmingguan.index') }}" class="btn btn-info btn-sm">Buka</a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-exclamation-circle fa-4x text-warning mb-4"></i>
                    <h3>Tidak Ada Tugas Peleton Aktif</h3>
                    <p class="text-muted">Anda belum memiliki tugas peleton yang aktif saat ini.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Assignments -->
    @if($allTugas->count() > 0)
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Riwayat Tugas Peleton</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Minggu Ke</th>
                                    <th>TON/KI/YON</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Jumlah Siswa</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allTugas as $tugas)
                                <tr>
                                    <td>{{ $tugas->minggu_ke ?? '-' }}</td>
                                    <td>{{ $tugas->ton_ki_yon ?? '-' }}</td>
                                    <td>{{ $tugas->hari_tgl_1 ?? '-' }}</td>
                                    <td>
                                        {{ $tugas->tugasSiswa()->count() }}
                                    </td>
                                    <td>
                                        @if(is_null($tugas->deleted_at))
                                        <span class="badge bg-success">Aktif</span>
                                        @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

<style>
.info-box {
    background: #f8f9fa;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.info-box-icon {
    float: left;
    height: 60px;
    width: 60px;
    text-align: center;
    font-size: 30px;
    line-height: 60px;
    border-radius: 5px;
    color: white;
    margin-right: 15px;
}

.info-box-content {
    padding-left: 75px;
}

.info-box-text {
    display: block;
    font-size: 14px;
    color: #6c757d;
}

.info-box-number {
    display: block;
    font-weight: bold;
    font-size: 18px;
}

.quick-action-card {
    transition: transform 0.2s;
    height: 100%;
}

.quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.day-progress {
    padding: 10px;
    border-radius: 5px;
    background: #f8f9fa;
}
</style>
@endsection