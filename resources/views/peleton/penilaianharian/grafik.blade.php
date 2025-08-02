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

/* Perbaikan untuk Detail Nilai per Indikator - full width card */
.full-width-chart {
    grid-column: 1 / -1;
    /* Mengambil seluruh lebar grid */
    height: 400px;
    /* Tinggi lebih besar untuk menampung banyak data */
}

@media (max-width: 768px) {
    .chart-grid {
        grid-template-columns: 1fr;
    }

    .chart-container {
        height: 300px;
    }

    .full-width-chart {
        height: 350px;
    }
}
</style>

<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Grafik Penilaian Harian</h6>
        </div>
        <div class="card-body">
            <div class="chart-grid">
                <!-- Grafik Rata-rata -->
                <div class="chart-container">
                    <h5 class="chart-title">Rata-rata Nilai</h5>
                    <canvas id="rataRataChart"></canvas>
                </div>

                <!-- Grafik Perbandingan Indikator -->
                <div class="chart-container">
                    <h5 class="chart-title">Rata-rata per Indikator</h5>
                    <canvas id="perbandinganIndikatorChart"></canvas>
                </div>

                <!-- Grafik Detail Nilai - Full Width -->
                <div class="chart-container full-width-chart">
                    <h5 class="chart-title">Detail Nilai per Indikator</h5>
                    <canvas id="detailNilaiChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const grafikData = @json($grafikData ?? []);

    if (!grafikData || grafikData.length === 0) {
        console.warn('Data grafik tidak tersedia');
        return;
    }

    // Persiapan data
    const labels = grafikData.map(item => item.nama_siswa || 'Siswa');
    const indikatorLabels = ['Indikator 1', 'Indikator 2', 'Indikator 3', 'Indikator 4', 'Indikator 5',
        'Indikator 6', 'Indikator 7'
    ];

    // Konfigurasi default Chart.js
    Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    Chart.defaults.font.size = 12;
    Chart.defaults.color = '#666';

    // Plugin untuk menampilkan nilai di dalam batang dengan format desimal
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

            ctx.font = 'bold 11px sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            chart.data.datasets.forEach((dataset, i) => {
                const meta = chart.getDatasetMeta(i);
                meta.data.forEach((bar, index) => {
                    const rawValue = dataset.data[index];
                    if (rawValue === 0 || isNaN(rawValue)) return;

                    // Format nilai dengan desimal (contoh: 34,43)
                    const formattedValue = parseFloat(rawValue).toFixed(2).replace('.',
                        ',');

                    // Ambil posisi batang
                    const barTop = bar.y;
                    const barBottom = y.getPixelForValue(0);
                    const barHeight = Math.abs(barBottom - barTop);

                    // Posisi X di tengah batang
                    const textX = bar.x;

                    // Posisi Y di tengah batang
                    let textY;
                    if (rawValue >= 0) {
                        textY = barTop + (barHeight / 2);
                    } else {
                        textY = barTop - (barHeight / 2);
                    }

                    // Cek apakah batang cukup tinggi untuk menampilkan teks
                    if (barHeight < 30) {
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
                    ctx.strokeText(formattedValue, textX, textY);
                    ctx.fillText(formattedValue, textX, textY);
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
            data: config.data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: config.showLegend || false,
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            padding: 10
                        }
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                const value = parseFloat(context.parsed.y);
                                return context.dataset.label + ': ' + value.toFixed(2).replace('.',
                                    ',');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0,
                            autoSkip: false,
                            font: {
                                size: 10
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        reverse: !!config.reverse,
                        max: config.max,
                        grid: {
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toFixed(1).replace('.', ',');
                            }
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

    // Palette warna konsisten
    const colors = [
        'rgba(54, 162, 235, 0.7)', // Biru
        'rgba(255, 99, 132, 0.7)', // Merah
        'rgba(75, 192, 192, 0.7)', // Hijau
        'rgba(153, 102, 255, 0.7)', // Ungu
        'rgba(255, 159, 64, 0.7)', // Orange
        'rgba(199, 199, 199, 0.7)', // Abu-abu
        'rgba(255, 205, 86, 0.7)' // Kuning
    ];

    const borderColors = [
        'rgba(54, 162, 235, 1)',
        'rgba(255, 99, 132, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)',
        'rgba(199, 199, 199, 1)',
        'rgba(255, 205, 86, 1)'
    ];

    // 1. Grafik Rata-rata Nilai
    const rataRataData = grafikData.map(item => {
        const nilai = parseFloat(item.rata_rata || 0);
        return isNaN(nilai) ? 0 : nilai;
    });

    createUniformChart({
        id: 'rataRataChart',
        data: {
            labels: labels,
            datasets: [{
                label: 'Rata-rata Nilai',
                data: rataRataData,
                backgroundColor: colors[0],
                borderColor: borderColors[0],
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        max: 100
    });

    // 2. Grafik Rata-rata per Indikator
    const avgPerIndikator = indikatorLabels.map((_, index) => {
        const indikatorKey = `nilai_harian_${index + 1}`;
        let total = 0;
        let count = 0;

        grafikData.forEach(item => {
            const nilai = parseFloat(item[indikatorKey] || 0);
            if (!isNaN(nilai) && nilai > 0) {
                total += nilai;
                count++;
            }
        });

        return count > 0 ? parseFloat((total / count).toFixed(2)) : 0;
    });

    createUniformChart({
        id: 'perbandinganIndikatorChart',
        data: {
            labels: indikatorLabels,
            datasets: [{
                label: 'Rata-rata per Indikator',
                data: avgPerIndikator,
                backgroundColor: colors[1],
                borderColor: borderColors[1],
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        max: 100
    });

    // 3. Grafik Detail Nilai (Grouped Bar Chart) - Full Width
    const detailDatasets = indikatorLabels.map((indikator, index) => {
        const data = grafikData.map(item => {
            const nilai = parseFloat(item[`nilai_harian_${index + 1}`] || 0);
            return isNaN(nilai) ? 0 : nilai;
        });

        return {
            label: indikator,
            data: data,
            backgroundColor: colors[index % colors.length],
            borderColor: borderColors[index % borderColors.length],
            borderWidth: 1,
            borderRadius: 4,
            borderSkipped: false
        };
    });

    createUniformChart({
        id: 'detailNilaiChart',
        data: {
            labels: labels,
            datasets: detailDatasets
        },
        max: 100,
        showLegend: true
    });
});
</script>
@endsection