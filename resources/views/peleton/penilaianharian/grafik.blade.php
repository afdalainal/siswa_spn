@extends('layouts._index')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Grafik Perkembangan Nilai Harian</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <canvas id="rataRataChart" height="400"></canvas>
                        </div>
                        <div class="col-md-4">
                            <canvas id="perbandinganIndikatorChart" height="400"></canvas>
                        </div>
                        <div class="col-md-4">
                            <canvas id="detailNilaiChart" height="400"></canvas>
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

    // Grafik Rata-rata
    const rataRataCtx = document.getElementById('rataRataChart').getContext('2d');
    new Chart(rataRataCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rata-rata Nilai',
                data: grafikData.map(item => item.rata_rata),
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
                    text: 'Rata-rata Nilai Harian'
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

    // Grafik Perbandingan Indikator
    const perbandinganCtx = document.getElementById('perbandinganIndikatorChart').getContext('2d');
    new Chart(perbandinganCtx, {
        type: 'radar',
        data: {
            labels: ['Indikator 1', 'Indikator 2', 'Indikator 3', 'Indikator 4', 'Indikator 5',
                'Indikator 6', 'Indikator 7'
            ],
            datasets: grafikData.map((item, index) => {
                const colors = [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(201, 203, 207, 0.5)'
                ];
                return {
                    label: item.nama_siswa,
                    data: [
                        item.nilai_harian_1,
                        item.nilai_harian_2,
                        item.nilai_harian_3,
                        item.nilai_harian_4,
                        item.nilai_harian_5,
                        item.nilai_harian_6,
                        item.nilai_harian_7
                    ],
                    backgroundColor: colors[index % colors.length],
                    borderColor: colors[index % colors.length].replace('0.5', '1'),
                    borderWidth: 1,
                    pointBackgroundColor: colors[index % colors.length].replace('0.5', '1')
                };
            })
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
                    text: 'Perbandingan Indikator'
                }
            },
            scales: {
                r: {
                    angleLines: {
                        display: true
                    },
                    suggestedMin: 0,
                    suggestedMax: 100
                }
            }
        }
    });

    // Grafik Detail Nilai
    const detailNilaiCtx = document.getElementById('detailNilaiChart').getContext('2d');
    new Chart(detailNilaiCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Indikator 1',
                    data: grafikData.map(item => item.nilai_harian_1),
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Indikator 2',
                    data: grafikData.map(item => item.nilai_harian_2),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Indikator 3',
                    data: grafikData.map(item => item.nilai_harian_3),
                    backgroundColor: 'rgba(255, 206, 86, 0.7)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Indikator 4',
                    data: grafikData.map(item => item.nilai_harian_4),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Indikator 5',
                    data: grafikData.map(item => item.nilai_harian_5),
                    backgroundColor: 'rgba(153, 102, 255, 0.7)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Indikator 6',
                    data: grafikData.map(item => item.nilai_harian_6),
                    backgroundColor: 'rgba(255, 159, 64, 0.7)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Indikator 7',
                    data: grafikData.map(item => item.nilai_harian_7),
                    backgroundColor: 'rgba(201, 203, 207, 0.7)',
                    borderColor: 'rgba(201, 203, 207, 1)',
                    borderWidth: 1
                }
            ]
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
                    text: 'Detail Nilai per Indikator'
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
});
</script>
@endsection