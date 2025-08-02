@extends('layouts._index')

@section('content')
<style>
.chart-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    padding: 15px;
}

.chart-container {
    position: relative;
    height: 350px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 15px;
}

.chart-title {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #2c3e50;
    text-align: center;
}

@media (max-width: 768px) {
    .chart-grid {
        grid-template-columns: 1fr;
    }

    .chart-container {
        height: 300px;
    }
}
</style>

<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Grafik Penilaian Pengamatan</h6>
        </div>
        <div class="card-body">
            <div class="chart-grid">
                <!-- Grafik Nilai Akhir -->
                <div class="chart-container">
                    <h5 class="chart-title">Nilai Akhir Siswa</h5>
                    <canvas id="nilaiAkhirChart"></canvas>
                </div>

                <!-- Grafik Nilai Konversi -->
                <div class="chart-container">
                    <h5 class="chart-title">Nilai Konversi</h5>
                    <canvas id="nilaiKonversiChart"></canvas>
                </div>

                <!-- Grafik Skor -->
                <div class="chart-container">
                    <h5 class="chart-title">Skor Siswa</h5>
                    <canvas id="skorChart"></canvas>
                </div>

                <!-- Grafik Rank -->
                <div class="chart-container">
                    <h5 class="chart-title">Rank Harian</h5>
                    <canvas id="rankChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data dari controller
    const grafikData = @json($grafikData ?? []);

    if (!grafikData || grafikData.length === 0) {
        console.warn('Data grafik tidak tersedia');
        return;
    }

    // Persiapan data
    const labels = grafikData.map(item => item.nama_siswa || 'Siswa');
    const configs = [{
            id: 'nilaiAkhirChart',
            data: grafikData.map(item => item.nilai_akhir || 0),
            title: 'Nilai Akhir Siswa',
            color: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            max: 100
        },
        {
            id: 'nilaiKonversiChart',
            data: grafikData.map(item => item.nilai_konversi || 0),
            title: 'Nilai Konversi',
            color: 'rgba(255, 99, 132, 0.7)',
            borderColor: 'rgba(255, 99, 132, 1)',
            max: 100
        },
        {
            id: 'skorChart',
            data: grafikData.map(item => item.skor || 0),
            title: 'Skor Siswa',
            color: 'rgba(75, 192, 192, 0.7)',
            borderColor: 'rgba(75, 192, 192, 1)'
        },
        {
            id: 'rankChart',
            data: grafikData.map(item => item.rank_harian || 0),
            title: 'Rank Harian (↓ lebih baik)',
            color: 'rgba(153, 102, 255, 0.7)',
            borderColor: 'rgba(153, 102, 255, 1)',
        }
    ];

    // Konfigurasi default Chart.js
    Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    Chart.defaults.font.size = 12;
    Chart.defaults.color = '#666';

    // Plugin untuk menampilkan nilai di dalam batang
    const barValuePlugin = {
        id: 'barValuePlugin',
        afterDatasetsDraw(chart, args, options) {
            const {
                ctx,
                data,
                chartArea: {
                    top,
                    bottom,
                    left,
                    right,
                    width,
                    height
                },
                scales: {
                    x,
                    y
                }
            } = chart;

            ctx.font = 'bold 12px sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            chart.data.datasets.forEach((dataset, i) => {
                const meta = chart.getDatasetMeta(i);
                meta.data.forEach((bar, index) => {
                    const value = dataset.data[index];
                    if (value === 0 || isNaN(value)) return;

                    // Ambil posisi batang
                    const barTop = bar.y;
                    const barBottom = y.getPixelForValue(0);
                    const barHeight = Math.abs(barBottom - barTop);

                    // Posisi X di tengah batang
                    const textX = bar.x;

                    // Posisi Y di tengah batang
                    // Jika batang positif, tengah antara top dan bottom
                    // Jika batang negatif, tetap di tengah
                    let textY;
                    if (value >= 0) {
                        textY = barTop + (barHeight / 2);
                    } else {
                        textY = barTop - (barHeight / 2);
                    }

                    // Cek apakah batang cukup tinggi untuk menampilkan teks
                    if (barHeight < 25) {
                        // Jika batang terlalu pendek, letakkan teks di atas batang
                        textY = barTop - 15;
                        ctx.fillStyle = '#333333';
                        ctx.strokeStyle = '#ffffff';
                    } else {
                        // Jika batang cukup tinggi, letakkan teks di dalam
                        ctx.fillStyle = '#ffffff';
                        ctx.strokeStyle = '#000000';
                    }

                    ctx.lineWidth = 1;

                    // Gambar teks dengan stroke untuk kontras
                    ctx.strokeText(value, textX, textY);
                    ctx.fillText(value, textX, textY);
                });
            });
        }
    };

    // Fungsi untuk membuat grafik dengan gaya seragam
    function createUniformChart(config) {
        const ctx = document.getElementById(config.id);
        if (!ctx) return null;

        return new Chart(ctx, {
            type: 'bar',
            plugins: [barValuePlugin],
            data: {
                labels: labels,
                datasets: [{
                    label: config.title,
                    data: config.data,
                    backgroundColor: config.color,
                    borderColor: config.borderColor,
                    borderWidth: 1,
                    borderRadius: 4,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            autoSkip: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        reverse: !!config.reverse,
                        max: config.max,
                        grid: {
                            drawBorder: false
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                },
                layout: {
                    padding: {
                        top: 20,
                        right: 10,
                        bottom: 20,
                        left: 10
                    }
                }
            }
        });
    }

    // Buat semua grafik
    const charts = {};
    configs.forEach(config => {
        charts[config.id] = createUniformChart(config);
    });

    // Handle resize
    window.addEventListener('resize', () => {
        configs.forEach(config => {
            if (charts[config.id]) {
                charts[config.id].resize();
            }
        });
    });
});
</script>
@endsection