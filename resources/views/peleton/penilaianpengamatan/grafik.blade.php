@extends('layouts._index')
@section('content')
<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Grafik Penilaian Pengamatan</h6>
        </div>
        <div class="card-body">
            <!-- First Graph: Penilaian Mental, Watak, dan Kepemimpinan (Stacked Column) -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Penilaian Mental, Watak, dan Kepemimpinan Harian Siswa</h6>
                <div id="mentalWatakKepemimpinanChart"></div>
            </div>

            <!-- Second Graph: Perbandingan Nilai Karakter Siswa (Area) -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Perbandingan Nilai Karakter Siswa selama Satu Pekan</h6>
                <div id="nilaiKarakterChart"></div>
            </div>

            <!-- Third Graph: Nilai Akhir Harian Siswa (Area) -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Nilai Akhir Harian Siswa</h6>
                <div id="nilaiAkhirChart"></div>
            </div>

            <!-- Fourth Graph: Peringkat Harian Siswa (Area) -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Peringkat Harian Siswa</h6>
                <div id="peringkatChart"></div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the data passed from controller
    const chartData = @json($chartData);

    // Consistent colors for charts
    const colors = {
        mental: '#3B82F6',
        watak: '#10B981',
        kepemimpinan: '#F59E0B',
        nilaiAkhir: '#8B5CF6',
        rank: '#EC4899',
        spiritual: '#3B82F6',
        ideologi: '#10B981',
        kejuangan: '#F59E0B',
        pribadi: '#8B5CF6',
        pelanggaranMinus: '#EF4444',
        pelanggaranPlus: '#10B981'
    };

    // 1. Penilaian Mental, Watak, dan Kepemimpinan (Stacked Column)
    const mentalWatakKepemimpinanOptions = {
        series: [{
                name: 'Mental',
                data: chartData.mentalData,
                color: colors.mental
            },
            {
                name: 'Watak',
                data: chartData.watakData,
                color: colors.watak
            },
            {
                name: 'Kepemimpinan',
                data: chartData.kepemimpinanData,
                color: colors.kepemimpinan
            }
        ],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 4,
                columnWidth: '60%',
            },
        },
        xaxis: {
            type: 'category',
            categories: chartData.days,
            title: {
                text: 'Hari Ke-'
            }
        },
        yaxis: {
            title: {
                text: 'Nilai'
            },
            labels: {
                formatter: function(val) {
                    return val.toFixed(2);
                }
            }
        },
        legend: {
            position: 'right',
            offsetY: 40
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val.toFixed(2);
                }
            }
        }
    };

    const mentalWatakKepemimpinanChart = new ApexCharts(
        document.querySelector("#mentalWatakKepemimpinanChart"),
        mentalWatakKepemimpinanOptions
    );
    mentalWatakKepemimpinanChart.render();

    // 2. Perbandingan Nilai Karakter Siswa (Area)
    const nilaiKarakterOptions = {
        series: [{
                name: 'Spiritual',
                data: chartData.spiritualData,
                color: colors.spiritual
            },
            {
                name: 'Ideologi',
                data: chartData.ideologiData,
                color: colors.ideologi
            },
            {
                name: 'Kejuangan',
                data: chartData.kejuanganData,
                color: colors.kejuangan
            },
            {
                name: 'Pribadi',
                data: chartData.pribadiData,
                color: colors.pribadi
            }
        ],
        chart: {
            type: 'area',
            height: 350,
            stacked: false,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.5,
                opacityTo: 0,
                stops: [0, 90, 100]
            },
        },
        xaxis: {
            type: 'category',
            categories: chartData.days,
            title: {
                text: 'Hari Ke-'
            }
        },
        yaxis: {
            title: {
                text: 'Nilai'
            },
            labels: {
                formatter: function(val) {
                    return val.toFixed(2);
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val.toFixed(2);
                }
            }
        },
        legend: {
            position: 'top'
        }
    };

    const nilaiKarakterChart = new ApexCharts(
        document.querySelector("#nilaiKarakterChart"),
        nilaiKarakterOptions
    );
    nilaiKarakterChart.render();

    // 3. Nilai Akhir Harian Siswa (Area)
    const nilaiAkhirOptions = {
        series: [{
            name: 'Nilai Akhir',
            data: chartData.nilaiAkhirData,
            color: colors.nilaiAkhir
        }],
        chart: {
            type: 'area',
            height: 350,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.5,
                opacityTo: 0,
                stops: [0, 90, 100]
            },
        },
        xaxis: {
            type: 'category',
            categories: chartData.days,
            title: {
                text: 'Hari Ke-'
            }
        },
        yaxis: {
            title: {
                text: 'Nilai Akhir'
            },
            labels: {
                formatter: function(val) {
                    return val.toFixed(2);
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return val.toFixed(2);
                }
            }
        }
    };

    const nilaiAkhirChart = new ApexCharts(
        document.querySelector("#nilaiAkhirChart"),
        nilaiAkhirOptions
    );
    nilaiAkhirChart.render();

    // 4. Peringkat Harian Siswa (Area)
    const peringkatOptions = {
        series: [{
            name: 'Peringkat',
            data: chartData.rankData,
            color: colors.rank
        }],
        chart: {
            type: 'area',
            height: 350,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.5,
                opacityTo: 0,
                stops: [0, 90, 100]
            },
        },
        xaxis: {
            type: 'category',
            categories: chartData.days,
            title: {
                text: 'Hari Ke-'
            }
        },
        yaxis: {
            title: {
                text: 'Peringkat'
            },
            reversed: true,
            min: 1,
            forceNiceScale: true,
            labels: {
                formatter: function(val) {
                    return Math.round(val);
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return 'Peringkat: ' + Math.round(val);
                }
            }
        }
    };

    const peringkatChart = new ApexCharts(
        document.querySelector("#peringkatChart"),
        peringkatOptions
    );
    peringkatChart.render();
});
</script>
@endsection