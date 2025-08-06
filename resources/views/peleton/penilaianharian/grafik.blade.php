@extends('layouts._index')
@section('content')
<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Grafik Penilaian Harian - Perbandingan Antar Siswa</h6>
        </div>
        <div class="card-body">
            <!-- First Graph: Nilai Harian Selama 7 Hari -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Perbandingan Nilai Harian Siswa (7 Hari)</h6>
                <div id="nilaiHarianChart"></div>
            </div>

            <!-- Second Graph: Progress/Perubahan Harian -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Perkembangan Nilai Harian Siswa (Hari 1-7)</h6>
                <div id="progressHarianChart"></div>
            </div>

            <!-- Fourth Graph: Analisis Trend (Radar Chart) -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Analisis Trend Performa Harian Siswa (Min, Max, Rata-rata)</h6>
                <div id="trendAnalysisChart"></div>
            </div>

            <!-- Fifth Graph: Konsistensi Performance -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Tingkat Konsistensi Performa Harian Siswa</h6>
                <div id="konsistensiChart"></div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the data passed from controller
    const chartData = @json($chartData);

    // Color palette for different students
    const colors = [
        '#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', '#EC4899',
        '#EF4444', '#06B6D4', '#84CC16', '#F97316', '#6366F1',
        '#14B8A6', '#F472B6', '#A855F7', '#22D3EE', '#FDE047'
    ];

    // 1. Nilai Harian Chart (Line Chart)
    const nilaiHarianChart = new ApexCharts(document.querySelector("#nilaiHarianChart"), {
        series: chartData.nilaiHarianData.map((student, index) => ({
            name: student.name,
            data: student.data,
            color: colors[index % colors.length]
        })),
        chart: {
            type: 'line',
            height: 450,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        stroke: {
            width: 3,
            curve: 'smooth'
        },
        markers: {
            size: 6,
            strokeWidth: 2,
            strokeColors: '#fff',
            fillOpacity: 1,
            hover: {
                size: 8
            }
        },
        xaxis: {
            categories: chartData.days,
            title: {
                text: 'Hari Ke-',
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            }
        },
        yaxis: {
            title: {
                text: 'Nilai Harian',
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            },
            labels: {
                formatter: function(val) {
                    return val.toFixed(1);
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center',
            fontSize: '12px',
            itemMargin: {
                horizontal: 8,
                vertical: 2
            }
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(val, opts) {
                    return opts.w.globals.seriesNames[opts.seriesIndex] + ': ' + val.toFixed(2);
                }
            }
        },
        grid: {
            borderColor: '#e7e7e7',
            strokeDashArray: 3
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val > 0 ? val.toFixed(1) : '';
            },
            style: {
                fontSize: '9px',
                colors: ['#000'],
                fontWeight: 'bold'
            },
            background: {
                enabled: true,
                foreColor: '#fff',
                borderRadius: 3,
                opacity: 0.8,
                padding: 1
            },
            offsetY: -8
        }
    });
    nilaiHarianChart.render();

    // 2. Progress Harian Chart (Line Chart with markers and annotations) - Sama persis dengan contoh
    const progressHarianChart = new ApexCharts(document.querySelector("#progressHarianChart"), {
        series: chartData.nilaiHarianData.map((student, index) => ({
            name: student.name,
            data: student.data,
            color: colors[index % colors.length]
        })),
        chart: {
            type: 'line',
            height: 450,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        stroke: {
            width: 3,
            curve: 'smooth'
        },
        markers: {
            size: 6,
            strokeWidth: 2,
            strokeColors: '#fff',
            fillOpacity: 1,
            hover: {
                size: 8
            }
        },
        xaxis: {
            categories: chartData.days,
            title: {
                text: 'Hari Ke-',
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            }
        },
        yaxis: {
            title: {
                text: 'Nilai Harian',
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            },
            labels: {
                formatter: function(val) {
                    return val.toFixed(1);
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center',
            fontSize: '12px',
            itemMargin: {
                horizontal: 8,
                vertical: 2
            }
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(val, opts) {
                    return opts.w.globals.seriesNames[opts.seriesIndex] + ': ' + val.toFixed(2);
                }
            }
        },
        grid: {
            borderColor: '#e7e7e7',
            strokeDashArray: 3
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val > 0 ? val.toFixed(1) : '';
            },
            style: {
                fontSize: '9px',
                colors: ['#000'],
                fontWeight: 'bold'
            },
            background: {
                enabled: true,
                foreColor: '#fff',
                borderRadius: 3,
                opacity: 0.8,
                padding: 1
            },
            offsetY: -8
        },
        annotations: {
            points: chartData.nilaiHarianData.flatMap((student, studentIndex) => {
                const points = [];
                for (let i = 1; i < student.data.length; i++) {
                    if (student.data[i] !== null && student.data[i - 1] !== null) {
                        const diff = student.data[i] - student.data[i - 1];
                        if (diff !== 0) {
                            points.push({
                                x: chartData.days[i],
                                y: student.data[i],
                                marker: {
                                    size: 6,
                                    fillColor: diff > 0 ? '#10B981' : '#EF4444',
                                    strokeColor: '#fff',
                                    radius: 2
                                },
                                label: {
                                    borderColor: diff > 0 ? '#10B981' : '#EF4444',
                                    style: {
                                        color: '#fff',
                                        background: diff > 0 ? '#10B981' : '#EF4444',
                                        fontSize: '10px'
                                    },
                                    text: diff > 0 ? `+${diff.toFixed(1)}` :
                                        `${diff.toFixed(1)}`,
                                    offsetY: -15
                                }
                            });
                        }
                    }
                }
                return points;
            })
        }
    });
    progressHarianChart.render();

    // 3. Trend Analysis Chart (Multi-series Column)
    const trendAnalysisChart = new ApexCharts(document.querySelector("#trendAnalysisChart"), {
        series: [{
                name: 'Rata-rata',
                data: chartData.trendAnalysisData.map(student => student.average)
            },
            {
                name: 'Nilai Minimum',
                data: chartData.trendAnalysisData.map(student => student.min)
            },
            {
                name: 'Nilai Maksimum',
                data: chartData.trendAnalysisData.map(student => student.max)
            }
        ],
        chart: {
            type: 'bar',
            height: 450,
            toolbar: {
                show: true
            },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                columnWidth: '75%',
                grouped: true
            }
        },
        xaxis: {
            categories: chartData.trendAnalysisData.map(student => student.name),
            title: {
                text: 'Siswa',
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            },
            labels: {
                rotate: -45,
                style: {
                    fontSize: '11px'
                }
            }
        },
        yaxis: {
            title: {
                text: 'Nilai',
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            },
            labels: {
                formatter: function(val) {
                    return val.toFixed(1);
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center',
            fontSize: '12px',
            itemMargin: {
                horizontal: 8,
                vertical: 2
            }
        },
        tooltip: {
            y: {
                formatter: function(val, opts) {
                    return opts.w.globals.seriesNames[opts.seriesIndex] + ': ' + val.toFixed(2);
                }
            }
        },
        grid: {
            borderColor: '#e7e7e7',
            strokeDashArray: 3
        },
        colors: ['#10B981', '#F59E0B', '#EF4444'],
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val > 0 ? val.toFixed(1) : '';
            },
            style: {
                fontSize: '9px',
                colors: ['#fff'],
                fontWeight: 'bold'
            },
            offsetY: -2
        }
    });
    trendAnalysisChart.render();

    // 5. Konsistensi Chart (Donut Chart)
    const konsistensiChart = new ApexCharts(document.querySelector("#konsistensiChart"), {
        series: chartData.trendAnalysisData.map(student => student.consistency),
        labels: chartData.trendAnalysisData.map(student => student.name),
        chart: {
            type: 'donut',
            height: 450,
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            fontSize: '14px',
                            fontWeight: 'bold'
                        },
                        value: {
                            show: true,
                            fontSize: '16px',
                            fontWeight: 'bold',
                            formatter: function(val) {
                                return val + '%';
                            }
                        },
                        total: {
                            show: true,
                            label: 'Rata-rata Konsistensi',
                            fontSize: '12px',
                            formatter: function(w) {
                                const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                return (total / w.globals.seriesTotals.length).toFixed(1) + '%';
                            }
                        }
                    }
                }
            }
        },
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '11px',
            itemMargin: {
                horizontal: 5,
                vertical: 2
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val.toFixed(1) + '% Konsistensi';
                }
            }
        },
        colors: colors,
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return val.toFixed(1) + '%';
            },
            style: {
                fontSize: '10px',
                colors: ['#fff'],
                fontWeight: 'bold'
            }
        }
    });
    konsistensiChart.render();

    // Responsive handling
    window.addEventListener('resize', function() {
        nilaiHarianChart.updateOptions({
            chart: {
                height: window.innerWidth < 768 ? 350 : 450
            }
        });
        progressHarianChart.updateOptions({
            chart: {
                height: window.innerWidth < 768 ? 350 : 450
            }
        });
        trendAnalysisChart.updateOptions({
            chart: {
                height: window.innerWidth < 768 ? 350 : 450
            }
        });
        konsistensiChart.updateOptions({
            chart: {
                height: window.innerWidth < 768 ? 350 : 450
            }
        });
    });
});
</script>
@endsection