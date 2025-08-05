@extends('layouts._index')
@section('content')
<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Grafik Penilaian Pengamatan</h6>
            <div>
                <span class="badge bg-primary">Peleton: {{ $chartData['tugas_peleton']['peleton'] }}</span>
                <span class="badge bg-secondary ms-2">Minggu Ke: {{ $chartData['tugas_peleton']['minggu_ke'] }}</span>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="grafikTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="mental-tab" data-bs-toggle="tab" data-bs-target="#mental"
                        type="button" role="tab">
                        <i class="bi bi-activity"></i> Analisis Mental
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="watak-tab" data-bs-toggle="tab" data-bs-target="#watak" type="button"
                        role="tab">
                        <i class="bi bi-person-badge"></i> Analisis Watak
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="kepemimpinan-tab" data-bs-toggle="tab" data-bs-target="#kepemimpinan"
                        type="button" role="tab">
                        <i class="bi bi-star"></i> Analisis Kepemimpinan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="nilai-tab" data-bs-toggle="tab" data-bs-target="#nilai" type="button"
                        role="tab">
                        <i class="bi bi-graph-up"></i> Nilai Akhir
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="ranking-tab" data-bs-toggle="tab" data-bs-target="#ranking"
                        type="button" role="tab">
                        <i class="bi bi-trophy"></i> Ranking Harian
                    </button>
                </li>
            </ul>

            <div class="tab-content pt-4" id="grafikTabContent">
                <!-- Tab 1: Analisis Mental -->
                <div class="tab-pane fade show active" id="mental" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Analisis Penilaian Mental Siswa per Hari</h5>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="mentalStackToggle" checked>
                                        <label class="form-check-label" for="mentalStackToggle">Stacked</label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="mentalChart" style="min-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Trend Nilai Mental selama Pekan</h5>
                                </div>
                                <div class="card-body">
                                    <div id="mentalTrendChart" style="min-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Analisis Watak -->
                <div class="tab-pane fade" id="watak" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Grafik Nilai Watak Pribadi Siswa</h5>
                                </div>
                                <div class="card-body">
                                    <div id="watakChart" style="min-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Perkembangan Watak per Hari</h5>
                                </div>
                                <div class="card-body">
                                    <div id="watakTrendChart" style="min-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Analisis Kepemimpinan -->
                <div class="tab-pane fade" id="kepemimpinan" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Evaluasi Aspek Kepemimpinan</h5>
                                </div>
                                <div class="card-body">
                                    <div id="kepemimpinanChart" style="min-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Trend Nilai Kepemimpinan</h5>
                                </div>
                                <div class="card-body">
                                    <div id="kepemimpinanTrendChart" style="min-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 4: Nilai Akhir -->
                <div class="tab-pane fade" id="nilai" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Perkembangan Nilai Akhir Siswa</h5>
                                </div>
                                <div class="card-body">
                                    <div id="nilaiAkhirChart" style="min-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Perbandingan Nilai Akhir Antar Siswa</h5>
                                </div>
                                <div class="card-body">
                                    <div id="nilaiAkhirRadarChart" style="min-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 5: Ranking Harian -->
                <div class="tab-pane fade" id="ranking" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Peringkat Harian Siswa</h5>
                                </div>
                                <div class="card-body">
                                    <div id="rankingChart" style="min-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5>Trend Peringkat Harian</h5>
                                </div>
                                <div class="card-body">
                                    <div id="rankingTrendChart" style="min-height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data from controller
    const chartData = @json($chartData);

    // Helper function to generate random colors
    function getRandomColors(count) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            colors.push(`#${Math.floor(Math.random()*16777215).toString(16)}`);
        }
        return colors;
    }

    // Initialize all charts
    function initCharts() {
        // 1. Mental Chart (Stacked Column)
        const mentalChart = new ApexCharts(document.querySelector("#mentalChart"), {
            series: chartData.mental.series,
            chart: {
                type: 'bar',
                height: 400,
                stacked: true,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    borderRadius: 4,
                    columnWidth: '75%',
                },
            },
            colors: getRandomColors(chartData.siswa.length),
            xaxis: {
                categories: chartData.mental.categories,
                title: {
                    text: 'Hari'
                }
            },
            yaxis: {
                title: {
                    text: 'Nilai Mental'
                },
                min: 0,
                max: 100
            },
            legend: {
                position: 'right',
                offsetY: 40
            },
            fill: {
                opacity: 0.9
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toFixed(2) + " poin";
                    }
                }
            }
        });
        mentalChart.render();

        // 2. Mental Trend Chart (Line)
        const mentalTrendChart = new ApexCharts(document.querySelector("#mentalTrendChart"), {
            series: chartData.mental.series,
            chart: {
                type: 'line',
                height: 400,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                }
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            colors: getRandomColors(chartData.siswa.length),
            xaxis: {
                categories: chartData.mental.categories,
                title: {
                    text: 'Hari'
                }
            },
            yaxis: {
                title: {
                    text: 'Nilai Mental'
                },
                min: 0,
                max: 100
            },
            markers: {
                size: 5
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toFixed(2) + " poin";
                    }
                }
            }
        });
        mentalTrendChart.render();

        // 3. Watak Chart (Radar)
        const watakChart = new ApexCharts(document.querySelector("#watakChart"), {
            series: chartData.watak.series,
            chart: {
                type: 'radar',
                height: 400,
                toolbar: {
                    show: true
                }
            },
            colors: getRandomColors(chartData.siswa.length),
            xaxis: {
                categories: chartData.watak.categories
            },
            yaxis: {
                show: false,
                min: 0,
                max: 100
            },
            markers: {
                size: 5
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toFixed(2) + " poin";
                    }
                }
            }
        });
        watakChart.render();

        // 4. Watak Trend Chart (Area)
        const watakTrendChart = new ApexCharts(document.querySelector("#watakTrendChart"), {
            series: chartData.watak.series,
            chart: {
                type: 'area',
                height: 400,
                stacked: false,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                }
            },
            colors: getRandomColors(chartData.siswa.length),
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: chartData.watak.categories,
                title: {
                    text: 'Hari'
                }
            },
            yaxis: {
                title: {
                    text: 'Nilai Watak'
                },
                min: 0,
                max: 100
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toFixed(2) + " poin";
                    }
                }
            }
        });
        watakTrendChart.render();

        // 5. Kepemimpinan Chart (Bar)
        const kepemimpinanChart = new ApexCharts(document.querySelector("#kepemimpinanChart"), {
            series: chartData.kepemimpinan.series,
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: true
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    borderRadius: 4,
                    barHeight: '75%',
                },
            },
            colors: getRandomColors(chartData.siswa.length),
            xaxis: {
                categories: chartData.kepemimpinan.categories,
                title: {
                    text: 'Hari'
                }
            },
            yaxis: {
                title: {
                    text: 'Nilai Kepemimpinan'
                },
                min: 0,
                max: 100
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toFixed(2) + " poin";
                    }
                }
            }
        });
        kepemimpinanChart.render();

        // 6. Kepemimpinan Trend Chart (Line)
        const kepemimpinanTrendChart = new ApexCharts(document.querySelector("#kepemimpinanTrendChart"), {
            series: chartData.kepemimpinan.series,
            chart: {
                type: 'line',
                height: 400,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                }
            },
            stroke: {
                curve: 'stepline',
                width: 2
            },
            colors: getRandomColors(chartData.siswa.length),
            xaxis: {
                categories: chartData.kepemimpinan.categories,
                title: {
                    text: 'Hari'
                }
            },
            yaxis: {
                title: {
                    text: 'Nilai Kepemimpinan'
                },
                min: 0,
                max: 100
            },
            markers: {
                size: 5
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toFixed(2) + " poin";
                    }
                }
            }
        });
        kepemimpinanTrendChart.render();

        // 7. Nilai Akhir Chart (Line)
        const nilaiAkhirChart = new ApexCharts(document.querySelector("#nilaiAkhirChart"), {
            series: chartData.nilai_akhir.series,
            chart: {
                type: 'line',
                height: 400,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                }
            },
            stroke: {
                curve: 'straight',
                width: 3
            },
            colors: getRandomColors(chartData.siswa.length),
            xaxis: {
                categories: chartData.nilai_akhir.categories,
                title: {
                    text: 'Hari'
                }
            },
            yaxis: {
                title: {
                    text: 'Nilai Akhir'
                },
                min: 0,
                max: 100
            },
            markers: {
                size: 5
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toFixed(2) + " poin";
                    }
                }
            }
        });
        nilaiAkhirChart.render();

        // 8. Nilai Akhir Radar Chart
        const nilaiAkhirRadarChart = new ApexCharts(document.querySelector("#nilaiAkhirRadarChart"), {
            series: chartData.nilai_akhir.series,
            chart: {
                type: 'radar',
                height: 400,
                toolbar: {
                    show: true
                }
            },
            colors: getRandomColors(chartData.siswa.length),
            xaxis: {
                categories: chartData.nilai_akhir.categories
            },
            yaxis: {
                show: false,
                min: 0,
                max: 100
            },
            markers: {
                size: 5
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toFixed(2) + " poin";
                    }
                }
            }
        });
        nilaiAkhirRadarChart.render();

        // 9. Ranking Chart (Heatmap)
        const rankingChart = new ApexCharts(document.querySelector("#rankingChart"), {
            series: chartData.ranking.series,
            chart: {
                type: 'heatmap',
                height: 400,
                toolbar: {
                    show: true
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#000']
                }
            },
            colors: ["#008FFB"],
            xaxis: {
                categories: chartData.ranking.categories,
                title: {
                    text: 'Hari'
                }
            },
            plotOptions: {
                heatmap: {
                    shadeIntensity: 0.5,
                    radius: 0,
                    useFillColorAsStroke: true,
                    colorScale: {
                        ranges: [{
                                from: 1,
                                to: 1,
                                color: '#00E396',
                                name: 'Rank 1'
                            },
                            {
                                from: 2,
                                to: 2,
                                color: '#FEB019',
                                name: 'Rank 2'
                            },
                            {
                                from: 3,
                                to: 3,
                                color: '#FF4560',
                                name: 'Rank 3'
                            },
                            {
                                from: 4,
                                to: 20,
                                color: '#775DD0',
                                name: 'Rank 4+'
                            }
                        ]
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "Peringkat: " + val;
                    }
                }
            }
        });
        rankingChart.render();

        // 10. Ranking Trend Chart (Line - Reversed)
        const rankingTrendChart = new ApexCharts(document.querySelector("#rankingTrendChart"), {
            series: chartData.ranking.series,
            chart: {
                type: 'line',
                height: 400,
                toolbar: {
                    show: true
                },
                zoom: {
                    enabled: true
                }
            },
            stroke: {
                curve: 'straight',
                width: 3
            },
            colors: getRandomColors(chartData.siswa.length),
            xaxis: {
                categories: chartData.ranking.categories,
                title: {
                    text: 'Hari'
                }
            },
            yaxis: {
                title: {
                    text: 'Peringkat'
                },
                reversed: true,
                min: 1,
                forceNiceScale: true,
                tickAmount: Math.max(...chartData.ranking.series.map(s => Math.max(...s.data.filter(d =>
                    d !== null)))) - 1
            },
            markers: {
                size: 5
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "Peringkat: " + val;
                    }
                }
            }
        });
        rankingTrendChart.render();
    }

    // Initialize charts when page loads
    initCharts();

    // Toggle stacked/normal for mental chart
    document.getElementById('mentalStackToggle').addEventListener('change', function(e) {
        const mentalChart = document.querySelector("#mentalChart").__chart__;
        mentalChart.updateOptions({
            chart: {
                stacked: e.target.checked
            }
        });
    });

    // Reinitialize charts when tab changes (for responsive issues)
    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function() {
            setTimeout(() => {
                ApexCharts.exec('mentalChart', 'render');
                ApexCharts.exec('mentalTrendChart', 'render');
                ApexCharts.exec('watakChart', 'render');
                ApexCharts.exec('watakTrendChart', 'render');
                ApexCharts.exec('kepemimpinanChart', 'render');
                ApexCharts.exec('kepemimpinanTrendChart', 'render');
                ApexCharts.exec('nilaiAkhirChart', 'render');
                ApexCharts.exec('nilaiAkhirRadarChart', 'render');
                ApexCharts.exec('rankingChart', 'render');
                ApexCharts.exec('rankingTrendChart', 'render');
            }, 300);
        });
    });
});
</script>

<style>
.nav-tabs .nav-link {
    font-weight: 500;
}

.nav-tabs .nav-link.active {
    font-weight: bold;
}

.card-header h5 {
    margin-bottom: 0;
}

.apexcharts-tooltip {
    z-index: 1000;
}
</style>
@endsection