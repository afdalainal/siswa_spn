@extends('layouts._index')

@section('content')
<div class="page-title">
    <h5>Superadmin Dashboard</h5>
    <p class="text-muted">System Overview and Statistics</p>
</div>

<section class="section">
    <!-- Quick Stats -->
    <div class="row">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Users</h6>
                            <h3 class="mb-0">{{ $userStats['total'] }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-light text-dark me-2">
                            <i class="fas fa-user-shield me-1"></i> Superadmin: {{ $userStats['superadmin'] }}
                        </span>
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-user-tie me-1"></i> Peleton: {{ $userStats['peleton'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Students</h6>
                            <h3 class="mb-0">{{ $siswaStats['total'] }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-user-graduate text-success"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-check-circle me-1"></i> Active: {{ $siswaStats['active'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Pengasuh</h6>
                            <h3 class="mb-0">{{ $pengasuhStats }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-chalkboard-teacher text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Peleton Assignments</h6>
                            <h3 class="mb-0">{{ $tugasStats['total'] }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-tasks text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="badge bg-light text-dark me-2">
                            Active: {{ $tugasStats['active'] }}
                        </span>
                        <span class="badge bg-light text-dark">
                            Inactive: {{ $tugasStats['inactive'] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Assignments and Activities -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Peleton Assignments</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Week</th>
                                    <th>TON/KI/YON</th>
                                    <th>Danton</th>
                                    <th>Peleton</th>
                                    <th>Date</th>
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
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
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

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Activities</h5>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        @foreach($activities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon bg-primary">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div class="activity-content">
                                <h6>New Assignment Created</h6>
                                <p class="text-muted mb-1">Week {{ $activity->minggu_ke }} - {{ $activity->ton_ki_yon }}
                                </p>
                                <small>{{ $activity->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assignment by Week Chart -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Assignments by Week</h5>
                </div>
                <div class="card-body">
                    <canvas id="weekChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Week Chart
const weekCtx = document.getElementById('weekChart').getContext('2d');
const weekChart = new Chart(weekCtx, {
    type: 'bar',
    data: {
        labels: {
            !!json_encode($tugasStats['by_week'] - > pluck('minggu_ke')) !!
        },
        datasets: [{
            label: 'Assignments',
            data: {
                !!json_encode($tugasStats['by_week'] - > pluck('total')) !!
            },
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endsection

<style>
.stat-card {
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.activity-item {
    display: flex;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: white;
}

.activity-content {
    flex: 1;
}
</style>
@endsection