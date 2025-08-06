@extends('layouts._index')
@section('content')
<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Grafik Penilaian Pengamatan - Perbandingan Antar Siswa</h6>
        </div>
        <div class="card-body">
            <!-- First Graph: Penilaian Mental Harian -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Perbandingan Penilaian Mental Siswa (7 Hari)</h6>
                <div id="mentalChart"></div>
            </div>

            <!-- Second Graph: Penilaian Watak Harian -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Perbandingan Penilaian Watak Siswa (7 Hari)</h6>
                <div id="watakChart"></div>
            </div>

            <!-- Third Graph: Penilaian Kepemimpinan Harian -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Perbandingan Penilaian Kepemimpinan Siswa (7 Hari)</h6>
                <div id="kepemimpinanChart"></div>
            </div>

            <!-- Fourth Graph: Penilaian Spiritual Harian -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Perbandingan Penilaian Spiritual Siswa (7 Hari)</h6>
                <div id="spiritualChart"></div>
            </div>

            <!-- Fifth Graph: Penilaian Ideologi Harian -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Perbandingan Penilaian Ideologi Siswa (7 Hari)</h6>
                <div id="ideologiChart"></div>
            </div>

            <!-- Sixth Graph: Penilaian Kejuangan Harian -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Perbandingan Penilaian Kejuangan Siswa (7 Hari)</h6>
                <div id="kejuanganChart"></div>
            </div>

            <!-- Seventh Graph: Penilaian Pribadi Harian -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Perbandingan Penilaian Pribadi Siswa (7 Hari)</h6>
                <div id="pribadiChart"></div>
            </div>

            <!-- Eighth Graph: Nilai Akhir Harian -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Perbandingan Nilai Akhir Siswa (7 Hari)</h6>
                <div id="nilaiAkhirChart"></div>
            </div>

            <!-- Ninth Graph: Peringkat Harian -->
            <div class="mb-5">
                <h6 class="text-center mb-3">Perbandingan Peringkat Siswa (7 Hari)</h6>

                <div id="rankChart"></div>
            </div>

            <!-- Information Panel -->
            <!-- <div class="mb-5">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">📊 Rumus Perhitungan Penilaian</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><strong>1. Penilaian Mental:</strong></h6>
                                <div class="alert alert-light">
                                    <p class="mb-1"><strong>Spiritual</strong> = (mental_spiritual_1 + mental_spiritual_2 + mental_spiritual_3) / 3</p>
                                    <p class="mb-1"><strong>Ideologi</strong> = (mental_ideologi_1 + mental_ideologi_2 + mental_ideologi_3) / 3</p>
                                    <p class="mb-1"><strong>Kejuangan</strong> = (mental_kejuangan_1 + mental_kejuangan_2 + mental_kejuangan_3 + mental_kejuangan_4) / 4</p>
                                    <p class="mb-0"><strong>Mental Score</strong> = (Spiritual + Ideologi + Kejuangan) / 3</p>
                                </div>

                                <h6><strong>2. Penilaian Watak:</strong></h6>
                                <div class="alert alert-light">
                                    <p class="mb-0"><strong>Watak Score</strong> = (watak_pribadi_1 + watak_pribadi_2 + watak_pribadi_3 + watak_pribadi_4) / 4</p>
                                </div>

                                <h6><strong>3. Penilaian Kepemimpinan:</strong></h6>
                                <div class="alert alert-light">
                                    <p class="mb-0"><strong>Kepemimpinan Score</strong> = (mental_kepemimpinan_1 + mental_kepemimpinan_2 + mental_kepemimpinan_3 + mental_kepemimpinan_4 + mental_kepemimpinan_5 + mental_kepemimpinan_6 + mental_kepemimpinan_7 + mental_kepemimpinan_8) / 8</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6><strong>4. Komponen Individual:</strong></h6>
                                <div class="alert alert-light">
                                    <p class="mb-1"><strong>Spiritual</strong> = Rata-rata 3 indikator spiritual</p>
                                    <p class="mb-1"><strong>Ideologi</strong> = Rata-rata 3 indikator ideologi</p>
                                    <p class="mb-1"><strong>Kejuangan</strong> = Rata-rata 4 indikator kejuangan</p>
                                    <p class="mb-0"><strong>Pribadi</strong> = Rata-rata 4 indikator watak pribadi</p>
                                </div>

                                <h6><strong>5. Nilai Akhir:</strong></h6>
                                <div class="alert alert-light">
                                    <p class="mb-1"><strong>Skor</strong> = Total semua indikator yang diisi</p>
                                    <p class="mb-1"><strong>Nilai Konversi</strong> = (Skor / Jumlah Indikator) × skala konversi</p>
                                    <p class="mb-0"><strong>Nilai Akhir</strong> = Nilai Konversi + Pelanggaran/Prestasi Plus - Pelanggaran/Prestasi Minus</p>
                                </div>

                                <h6><strong>6. Sistem Peringkat:</strong></h6>
                                <div class="alert alert-warning">
                                    <p class="mb-1">• <strong>Nilai Tertinggi</strong> = Peringkat 1</p>
                                    <p class="mb-1">• <strong>Nilai Sama</strong> = Peringkat berurutan</p>
                                    <p class="mb-0">• <strong>Update Otomatis</strong> per hari berdasarkan nilai_akhir</p>
                                </div>
                            </div>
                            <div class="alert alert-info mb-3">
                    <h6><strong>Rumus Perhitungan Peringkat:</strong></h6>
                    <p class="mb-1"><strong>RANK = RANK(nilai,$range) + COUNTIF($range,nilai) - 1</strong></p>
                    <p class="mb-1">• <strong>RANK(nilai,$range)</strong>: Menghitung berapa banyak nilai yang lebih tinggi + 1</p>
                    <p class="mb-1">• <strong>COUNTIF($range,nilai)</strong>: Menghitung berapa banyak nilai yang sama</p>
                    <p class="mb-0">• <strong>Formula Final</strong>: Rank dasar + posisi urutan untuk nilai yang sama - 1</p>
                </div>
                        </div>
                    </div>
                </div>
            </div> -->
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

    // Common chart options for Stacked Columns 100%
    function getChartOptions(seriesData, title, yAxisTitle) {
        return {
            series: seriesData.map((student, index) => ({
                name: student.name,
                data: student.data,
                color: colors[index % colors.length]
            })),
            chart: {
                type: 'bar',
                height: 450,
                stacked: true,
                stackType: '100%',
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
            responsive: [{
                breakpoint: 1200,
                options: {
                    chart: {
                        height: 400
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        fontSize: '11px'
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '70%'
                        }
                    }
                }
            }, {
                breakpoint: 768,
                options: {
                    chart: {
                        height: 350
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'left',
                        fontSize: '10px',
                        itemMargin: {
                            horizontal: 5,
                            vertical: 2
                        }
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '75%'
                        }
                    },
                    xaxis: {
                        labels: {
                            style: {
                                fontSize: '11px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontSize: '11px'
                            }
                        }
                    }
                }
            }, {
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'left',
                        fontSize: '9px',
                        itemMargin: {
                            horizontal: 3,
                            vertical: 1
                        }
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '80%'
                        }
                    },
                    xaxis: {
                        labels: {
                            style: {
                                fontSize: '10px'
                            },
                            rotate: -45
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                fontSize: '10px'
                            }
                        }
                    }
                }
            }],
            plotOptions: {
                bar: {
                    horizontal: false,
                    borderRadius: 0,
                    columnWidth: '60%'
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: chartData.days,
                title: {
                    text: 'Hari Ke-',
                    style: {
                        fontSize: '12px',
                        fontWeight: 'bold'
                    }
                },
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: yAxisTitle + ' (%)',
                    style: {
                        fontSize: '12px',
                        fontWeight: 'bold'
                    }
                },
                labels: {
                    formatter: function(val) {
                        return val + '%';
                    },
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'center',
                floating: false,
                fontSize: '12px',
                markers: {
                    width: 12,
                    height: 12
                },
                itemMargin: {
                    horizontal: 8,
                    vertical: 2
                }
            },
            tooltip: {
                y: {
                    formatter: function(val, opts) {
                        const seriesName = opts.w.globals.seriesNames[opts.seriesIndex];
                        // Calculate actual value from percentage
                        const totalForCategory = opts.w.globals.seriesTotals[opts.dataPointIndex];
                        const actualValue = (val * totalForCategory / 100);
                        return seriesName + ': ' + actualValue.toFixed(2) + ' (' + val.toFixed(1) + '%)';
                    }
                },
                style: {
                    fontSize: '12px'
                }
            },
            grid: {
                borderColor: '#e7e7e7',
                strokeDashArray: 3,
                padding: {
                    top: 10,
                    right: 20,
                    bottom: 10,
                    left: 10
                }
            },
            fill: {
                opacity: 0.8
            }
        };
    }



    // 1. Mental Chart
    const mentalChart = new ApexCharts(
        document.querySelector("#mentalChart"),
        getChartOptions(chartData.mentalData, 'Mental', 'Nilai Mental')
    );
    mentalChart.render();

    // 2. Watak Chart
    const watakChart = new ApexCharts(
        document.querySelector("#watakChart"),
        getChartOptions(chartData.watakData, 'Watak', 'Nilai Watak')
    );
    watakChart.render();

    // 3. Kepemimpinan Chart
    const kepemimpinanChart = new ApexCharts(
        document.querySelector("#kepemimpinanChart"),
        getChartOptions(chartData.kepemimpinanData, 'Kepemimpinan', 'Nilai Kepemimpinan')
    );
    kepemimpinanChart.render();

    // 4. Spiritual Chart
    const spiritualChart = new ApexCharts(
        document.querySelector("#spiritualChart"),
        getChartOptions(chartData.spiritualData, 'Spiritual', 'Nilai Spiritual')
    );
    spiritualChart.render();

    // 5. Ideologi Chart
    const ideologiChart = new ApexCharts(
        document.querySelector("#ideologiChart"),
        getChartOptions(chartData.ideologiData, 'Ideologi', 'Nilai Ideologi')
    );
    ideologiChart.render();

    // 6. Kejuangan Chart
    const kejuanganChart = new ApexCharts(
        document.querySelector("#kejuanganChart"),
        getChartOptions(chartData.kejuanganData, 'Kejuangan', 'Nilai Kejuangan')
    );
    kejuanganChart.render();

    // 7. Pribadi Chart
    const pribadiChart = new ApexCharts(
        document.querySelector("#pribadiChart"),
        getChartOptions(chartData.pribadiData, 'Pribadi', 'Nilai Pribadi')
    );
    pribadiChart.render();

    // 8. Nilai Akhir Chart
    const nilaiAkhirChart = new ApexCharts(
        document.querySelector("#nilaiAkhirChart"),
        getChartOptions(chartData.nilaiAkhirData, 'Nilai Akhir', 'Nilai Akhir')
    );
    nilaiAkhirChart.render();

    // 9. Rank Chart (using slope chart for better rank visualization)
    const rankChartOptions = {
        series: chartData.rankData.map((student, index) => ({
            name: student.name,
            data: student.data.map((rank, dayIndex) => ({
                x: chartData.days[dayIndex],
                y: rank || 0
            })),
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
        responsive: [{
            breakpoint: 1200,
            options: {
                chart: {
                    height: 400
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '11px'
                },
                dataLabels: {
                    style: {
                        fontSize: '9px'
                    }
                }
            }
        }, {
            breakpoint: 768,
            options: {
                chart: {
                    height: 350
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'left',
                    fontSize: '10px',
                    itemMargin: {
                        horizontal: 5,
                        vertical: 2
                    }
                },
                markers: {
                    size: 4
                },
                stroke: {
                    width: 2
                },
                dataLabels: {
                    style: {
                        fontSize: '8px'
                    }
                },
                xaxis: {
                    labels: {
                        style: {
                            fontSize: '11px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '11px'
                        }
                    }
                }
            }
        }, {
            breakpoint: 480,
            options: {
                chart: {
                    height: 300
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'left',
                    fontSize: '9px',
                    itemMargin: {
                        horizontal: 3,
                        vertical: 1
                    }
                },
                markers: {
                    size: 3
                },
                stroke: {
                    width: 1.5
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    labels: {
                        style: {
                            fontSize: '10px'
                        },
                        rotate: -45
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '10px'
                        }
                    }
                }
            }
        }],
        stroke: {
            width: 3,
            curve: 'straight'
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
            },
            labels: {
                style: {
                    fontSize: '12px'
                }
            }
        },
        yaxis: {
            title: {
                text: 'Peringkat',
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            },
            reversed: true,
            min: function(min) {
                return Math.max(1, Math.floor(min));
            },
            max: function(max) {
                return Math.ceil(max) + 1;
            },
            forceNiceScale: true,
            labels: {
                formatter: function(val) {
                    return Math.round(val);
                },
                style: {
                    fontSize: '12px'
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'center',
            floating: false,
            fontSize: '12px',
            markers: {
                width: 12,
                height: 12
            },
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
                    const seriesName = opts.w.globals.seriesNames[opts.seriesIndex];
                    return seriesName + ': Peringkat ' + Math.round(val);
                }
            },
            style: {
                fontSize: '12px'
            }
        },
        grid: {
            borderColor: '#e7e7e7',
            strokeDashArray: 3,
            padding: {
                top: 30,
                right: 20,
                bottom: 10,
                left: 10
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return Math.round(val);
            },
            style: {
                fontSize: '10px',
                colors: ['#000'],
                fontWeight: 'bold'
            },
            background: {
                enabled: true,
                foreColor: '#fff',
                borderRadius: 3,
                borderWidth: 1,
                borderColor: '#ccc',
                opacity: 0.9,
                padding: 2
            },
            offsetY: -5
        }
    };

    const rankChart = new ApexCharts(
        document.querySelector("#rankChart"),
        rankChartOptions
    );
    rankChart.render();
});
</script>
@endsection