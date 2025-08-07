@extends('layouts._index')

@section('content')
<div class="page-title">
    <h5>Dashboard Superadmin</h5>
</div>

<section class="section">
    <!-- Statistik  -->
    <div class="row g-3">
        <!-- Card Pengguna -->
        <div class="col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="me-2">
                            <h6 class="text-muted mb-1">Total Pengguna</h6>
                            <h3 class="mb-0">{{ $userStats['total'] }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-primary bg-opacity-10">
                                <i class="fas fa-user-shield me-1"></i> Superadmin: {{ $userStats['superadmin'] }}
                            </span>
                            <span class="badge bg-primary bg-opacity-10">
                                <i class="fas fa-user-tie me-1"></i> Peleton: {{ $userStats['peleton'] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Siswa -->
        <div class="col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="me-2">
                            <h6 class="text-muted mb-1">Total Siswa</h6>
                            <h3 class="mb-0">{{ $siswaStats['total'] }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-user-graduate fa-lg "></i>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <span class="badge bg-info bg-opacity-10 ">
                            <i class="fas fa-check-circle me-1"></i> Aktif: {{ $siswaStats['active'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Pengasuh -->
        <div class="col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="me-2">
                            <h6 class="text-muted mb-1">Total Pengasuh</h6>
                            <h3 class="mb-0">{{ $pengasuhStats }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-chalkboard-teacher fa-lg "></i>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <span class="badge bg-success bg-opacity-10 ">
                            <i class="fas fa-users me-1"></i> Pengasuh
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Penugasan -->
        <div class="col-md-3">
            <div class="card stat-card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="me-2">
                            <h6 class="text-muted mb-1">Penugasan Peleton</h6>
                            <h3 class="mb-0">{{ $tugasStats['total'] }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-tasks fa-lg"></i>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-warning bg-opacity-10">
                                Aktif: {{ $tugasStats['active'] }}
                            </span>
                            <span class="badge bg-secondary bg-opacity-10">
                                Nonaktif: {{ $tugasStats['inactive'] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Penugasan  -->
    <div class="card mt-4">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h5>Penugasan Peleton Terbaru</h5>
        </div>
        <div class="card-body">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>Minggu</th>
                        <th>TON/KI/YON</th>
                        <th>Danton</th>
                        <th>Peleton</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTugas as $tugas)
                    <tr>
                        <td>{{ $tugas->minggu_ke ?? '-' }}</td>
                        <td>{{ $tugas->ton_ki_yon ?? '-' }}</td>
                        <td>{{ $tugas->pengasuhDanton->nama ?? '-' }}</td>
                        <td>{{ $tugas->peleton->name ?? '-' }}</td>
                        <td>{{ $tugas->created_at->format('d M Y') }}</td>
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
</section>

<style>
.stat-card {
    transition: all 0.3s ease;
    border-radius: 0.5rem;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

.stat-card .card-body {
    padding: 1.25rem;
}

.stat-card h3 {
    font-weight: 700;
    font-size: 1.75rem;
}

.stat-card h6 {
    font-size: 0.875rem;
    letter-spacing: 0.5px;
}

.stat-card .rounded {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.badge {
    padding: 0.35em 0.65em;
    font-weight: 500;
    letter-spacing: 0.5px;
    font-size: 0.75rem;
}
</style>
@endsection