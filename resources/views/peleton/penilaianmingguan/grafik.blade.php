@extends('layouts._index')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Grafik Perkembangan Nilai Mingguan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <canvas id="nilaiMingguanChart" height="400"></canvas>
                        </div>
                        <div class="col-md-3">
                            <canvas id="rankMingguanChart" height="400"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="perkembanganHarianChart" height="400"></canvas>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <canvas id="perbandinganHarianChart" height="400"></canvas>
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
    const labels = grafikData.map(item => item.nama_siswa);
    const hariLabels = ['Hari 1', 'Hari 2', 'Hari 3', 'Hari 4', 'Hari 5', 'Hari 6', 'Hari 7'];

    // Grafik Nilai Mingguan
    new Chart(document.getElementById('nilaiMingguanChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nilai Mingguan',
                data: grafikData.map(item => item.nilai_mingguan),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Nilai Mingguan'
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

    // Grafik Rank Mingguan
    new Chart(document.getElementById('rankMingguanChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rank Mingguan',
                data: grafikData.map(item => item.rank_mingguan),
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Rank Mingguan (↓ lebih baik)'
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

    // Grafik Perkembangan Harian
    new Chart(document.getElementById('perkembanganHarianChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: hariLabels,
            datasets: grafikData.map(item => {
                const color = getRandomColor();
                return {
                    label: item.nama_siswa,
                    data: [
                        item.nilai_hari_1,
                        item.nilai_hari_2,
                        item.nilai_hari_3,
                        item.nilai_hari_4,
                        item.nilai_hari_5,
                        item.nilai_hari_6,
                        item.nilai_hari_7
                    ],
                    backgroundColor: color.replace(')', ', 0.1)'),
                    borderColor: color,
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                };
            })
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Perkembangan Harian'
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

    // Grafik Perbandingan Harian
    new Chart(document.getElementById('perbandinganHarianChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [1, 2, 3, 4, 5, 6, 7].map(i => ({
                label: `Hari ${i}`,
                data: grafikData.map(item => item[`nilai_hari_${i}`]),
                backgroundColor: `rgba(${Math.floor(Math.random()*255)}, ${Math.floor(Math.random()*255)}, ${Math.floor(Math.random()*255)}, 0.7)`,
                borderColor: `rgba(${Math.floor(Math.random()*255)}, ${Math.floor(Math.random()*255)}, ${Math.floor(Math.random()*255)}, 1)`,
                borderWidth: 1
            }))
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Perbandingan Harian'
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

    function getRandomColor() {
        return `rgba(${Math.floor(Math.random()*255)}, ${Math.floor(Math.random()*255)}, ${Math.floor(Math.random()*255)})`;
    }
});
</script>
@endsection