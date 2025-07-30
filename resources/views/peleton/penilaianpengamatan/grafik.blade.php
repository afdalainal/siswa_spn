@extends('layouts._index')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Grafik Perkembangan Nilai Pengamatan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <canvas id="nilaiAkhirChart" height="300"></canvas>
                        </div>
                        <div class="col-md-3">
                            <canvas id="nilaiKonversiChart" height="300"></canvas>
                        </div>
                        <div class="col-md-3">
                            <canvas id="skorChart" height="300"></canvas>
                        </div>
                        <div class="col-md-3">
                            <canvas id="rankChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const grafikData = @json($grafikData);

    // Data untuk chart
    const labels = grafikData.map(item => item.nama_siswa);
    const nilaiAkhirData = grafikData.map(item => item.nilai_akhir);
    const nilaiKonversiData = grafikData.map(item => item.nilai_konversi);
    const skorData = grafikData.map(item => item.skor);
    const rankData = grafikData.map(item => item.rank_harian);

    // Grafik Nilai Akhir
    const nilaiAkhirCtx = document.getElementById('nilaiAkhirChart').getContext('2d');
    new Chart(nilaiAkhirCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nilai Akhir',
                data: nilaiAkhirData,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Nilai Akhir Siswa'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Grafik Nilai Konversi
    const nilaiKonversiCtx = document.getElementById('nilaiKonversiChart').getContext('2d');
    new Chart(nilaiKonversiCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nilai Konversi',
                data: nilaiKonversiData,
                backgroundColor: 'rgba(243, 179, 193, 0.5)',
                borderColor: 'rgb(185, 98, 117)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Nilai Konversi'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Grafik Skor
    const skorCtx = document.getElementById('skorChart').getContext('2d');
    new Chart(skorCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Skor',
                data: skorData,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Skor Siswa'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Grafik Rank Harian (lebih rendah lebih baik)
    const rankCtx = document.getElementById('rankChart').getContext('2d');
    new Chart(rankCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rank Harian',
                data: rankData,
                backgroundColor: 'rgba(153, 102, 255, 0.5)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Rank Harian (↓ lebih baik)'
                }
            },
            scales: {
                y: {
                    reverse: true,
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection