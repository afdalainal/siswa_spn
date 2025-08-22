@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class='px-3 py-3'>
            <div class="row align-items-center g-3">
                <div class="col-12 col-md-auto">
                    <h6 class='card-title mb-0'>Laporan Bulanan - {{ $namaBulan }}</h6>
                </div>
                <div class="col-12 col-md">
                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-md-end">
                        <form method="GET" action="{{ route('laporan.index') }}" class="d-flex gap-2 flex-wrap">
                            <select name="bulan" class="form-select form-select-sm" required
                                style="width: auto; min-width: 120px;">
                                @foreach($bulanNames as $num => $name)
                                <option value="{{ $num }}" {{ $num == $bulan ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            <select name="tahun" class="form-select form-select-sm" required
                                style="width: auto; min-width: 100px;">
                                @for($i = date('Y') - 2; $i <= date('Y') + 2; $i++) <option value="{{ $i }}"
                                    {{ $i == $tahun ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                            </select>
                            <button type="submit" class="btn btn-outline-primary btn-sm px-3">Filter</button>
                        </form>
                        <a href="{{ route('laporan.laporan', ['bulan' => $bulan, 'tahun' => $tahun, 'download' => true]) }}"
                            target="_blank" class="btn btn-outline-secondary btn-sm px-4">
                            <i class="bi bi-printer"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(count($mingguGroups) > 0)
            <div class="table-responsive">
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Nosis</th>
                            @foreach($mingguGroups as $mingguKe => $group)
                            <th>Minggu {{ $mingguKe }}</th>
                            @endforeach
                            <th>Total Nilai</th>
                            <th>Rank</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporan as $item)
                        <tr class="{{ $item['memiliki_nilai'] ? '' : 'text-muted' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item['siswa']->nama }}</td>
                            <td>{{ $item['siswa']->nosis }}</td>
                            @foreach($mingguGroups as $mingguKe => $group)
                            <td>
                                @if(isset($item['nilai_mingguan'][$mingguKe]))
                                {{ number_format($item['nilai_mingguan'][$mingguKe]) }}
                                @if(isset($item['peleton'][$mingguKe]))
                                <br><small class="text-muted">({{ $item['peleton'][$mingguKe] }})</small>
                                @endif
                                @else
                                -
                                @endif
                            </td>
                            @endforeach
                            <td>
                                @if($item['memiliki_nilai'])
                                <strong>{{ number_format($item['total_nilai']) }}</strong>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($item['memiliki_nilai'])
                                {{ $item['rank'] }}
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info text-center">
                Tidak ada data laporan untuk ditampilkan pada bulan ini
            </div>
            @endif
        </div>
    </div>
</section>

<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between align-items-center'>
            <h6 class='card-title'>Grafik Rank Siswa - {{ $namaBulan }}</h6>
            <div class="chart-controls d-flex align-items-center gap-2">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-outline-primary" id="chartPrev">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="chartNext">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="chart-wrapper">
            <div id="rankChart"></div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
// Variable untuk pagination
let currentStartIndex = 0;
let studentsPerView = 5;
let totalStudents = 0;
let chartInstance = null;

document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($chartData);
    const mingguGroups = @json($mingguGroups);

    console.log('Chart Data:', chartData);
    console.log('Minggu Groups:', mingguGroups);
    console.log('Minggu Groups Keys:', Object.keys(mingguGroups));

    // Cek apakah ada data minggu (sama seperti kondisi tabel)
    if (!mingguGroups || Object.keys(mingguGroups).length === 0) {
        console.log('No minggu data - showing message');
        document.getElementById('rankChart').innerHTML =
            '<div class="alert alert-info text-center">Tidak ada data laporan untuk ditampilkan pada bulan ini</div>';
        return;
    }

    const allStudents = chartData.rankData;
    console.log('All Students:', allStudents);

    // Pastikan data siswa ada
    if (!allStudents || !Array.isArray(allStudents) || allStudents.length === 0) {
        console.log('No students data - showing message');
        document.getElementById('rankChart').innerHTML =
            '<div class="alert alert-info text-center">Tidak ada data laporan untuk ditampilkan pada bulan ini</div>';
        return;
    }

    totalStudents = allStudents.length;
    console.log('Proceeding to render chart...');

    // Function untuk render chart dengan data subset
    function renderChart(startIndex) {
        const endIndex = Math.min(startIndex + studentsPerView, totalStudents);
        const currentStudents = allStudents.slice(startIndex, endIndex);

        // Filter data
        const rankedStudents = allStudents.filter(s => s.rank !== null);
        const unrankedStudents = allStudents.filter(s => s.rank === null);
        const existingRanks = [...new Set(rankedStudents.map(s => s.rank))].sort((a, b) => a - b);
        const maxRank = existingRanks.length > 0 ? Math.max(...existingRanks) : 0;

        // Destroy chart sebelumnya jika ada
        if (chartInstance) {
            chartInstance.destroy();
        }

        // Konfigurasi grafik
        const rankChartOptions = {
            series: [{
                name: 'Peringkat',
                data: currentStudents.map(student => ({
                    x: student.name,
                    y: student.rank !== null ? student.rank : maxRank + 1,
                    rank: student.rank !== null ? student.rank : '-',
                    totalNilai: student.total_nilai || 0
                }))
            }],
            chart: {
                type: 'line',
                height: 'auto',
                width: '100%',
                toolbar: {
                    show: true
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    }
                }
            },
            colors: ['#3B82F6'],
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            markers: {
                size: 7,
                colors: currentStudents.map(s => s.rank !== null ? '#3B82F6' : '#94A3B8'),
                strokeColors: '#fff',
                strokeWidth: 2,
                hover: {
                    size: 9
                }
            },
            xaxis: {
                categories: currentStudents.map(s => s.name),
                labels: {
                    rotate: 0,
                    rotateAlways: false,
                    maxHeight: 80,
                    trim: false,
                    hideOverlappingLabels: false,
                    style: {
                        colors: currentStudents.map(s => s.rank !== null ? '#374151' : '#94A3B8'),
                        fontSize: '12px',
                        fontWeight: '600'
                    },
                    offsetY: 10,
                    formatter: function(value) {
                        // Potong nama jika terlalu panjang dan tambahkan ellipsis
                        if (value && value.length > 15) {
                            return value.substring(0, 15) + '...';
                        }
                        return value;
                    }
                },
                axisBorder: {
                    show: true,
                    color: '#E5E7EB',
                    height: 1
                },
                axisTicks: {
                    show: true,
                    color: '#E5E7EB',
                    height: 6
                }
            },
            yaxis: {
                show: false,
                title: {
                    text: ''
                },
                labels: {
                    show: false
                },
                min: 1,
                max: maxRank > 0 ? maxRank + 1 : 2,
                reversed: true,
                forceNiceScale: false
            },
            tooltip: {
                enabled: true,
                shared: false,
                followCursor: true,
                theme: 'light',
                custom: function({
                    series,
                    seriesIndex,
                    dataPointIndex,
                    w
                }) {
                    const student = currentStudents[dataPointIndex];
                    return '<div style="padding: 12px; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">' +
                        '<div style="font-weight: 600; font-size: 14px; color: #1F2937; margin-bottom: 8px; border-bottom: 1px solid #E5E7EB; padding-bottom: 4px;">' +
                        student.name + '</div>' +
                        '<div style="color: #4B5563; font-size: 12px; margin-bottom: 4px;">' +
                        '<strong>Peringkat :</strong> ' + (student.rank !== null ? '#' + student.rank :
                            '-') +
                        '</div>' +
                        '<div style="color: #4B5563; font-size: 12px;">' +
                        '<strong>Total Nilai :</strong> ' + (student.total_nilai ? student.total_nilai
                            .toLocaleString() : '0') +
                        '</div>' +
                        '</div>';
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    const student = currentStudents[opts.dataPointIndex];
                    return student.rank !== null ? student.rank : '-';
                },
                style: {
                    colors: ['#fff'],
                    fontWeight: 'bold',
                    fontSize: '10px'
                },
                background: {
                    enabled: true,
                    foreColor: function({
                        dataPointIndex
                    }) {
                        return currentStudents[dataPointIndex].rank !== null ? '#3B82F6' : '#94A3B8';
                    },
                    borderRadius: 2,
                    padding: 4,
                    opacity: 0.9,
                    borderWidth: 1,
                    borderColor: function({
                        dataPointIndex
                    }) {
                        return currentStudents[dataPointIndex].rank !== null ? '#3B82F6' : '#94A3B8';
                    },
                    dropShadow: {
                        enabled: false
                    }
                }
            },
            grid: {
                show: true,
                borderColor: '#F3F4F6',
                strokeDashArray: 0,
                position: 'back',
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false
                    }
                },
                padding: {
                    top: 20,
                    bottom: 50,
                    left: 80,
                    right: 80
                }
            },
            chart: {
                type: 'line',
                height: 500,
                width: '100%',
                toolbar: {
                    show: true
                },
                offsetY: 0,
                offsetX: 0
            },
            plotOptions: {
                line: {
                    isSlopeChart: false
                }
            },
            responsive: [{
                breakpoint: 768,
                options: {
                    xaxis: {
                        labels: {
                            style: {
                                fontSize: '11px'
                            },
                            maxHeight: 70,
                            formatter: function(value) {
                                if (value && value.length > 12) {
                                    return value.substring(0, 12) + '...';
                                }
                                return value;
                            }
                        }
                    },
                    grid: {
                        padding: {
                            left: 60,
                            right: 60,
                            bottom: 45
                        }
                    }
                }
            }, {
                breakpoint: 576,
                options: {
                    xaxis: {
                        labels: {
                            style: {
                                fontSize: '10px'
                            },
                            maxHeight: 60,
                            formatter: function(value) {
                                if (value && value.length > 10) {
                                    return value.substring(0, 10) + '...';
                                }
                                return value;
                            }
                        }
                    },
                    grid: {
                        padding: {
                            left: 50,
                            right: 50,
                            bottom: 40
                        }
                    }
                }
            }]
        };

        chartInstance = new ApexCharts(document.querySelector("#rankChart"), rankChartOptions);
        chartInstance.render();

        // Update button states
        updateNavigationButtons();
    }

    // Function untuk update navigation buttons
    function updateNavigationButtons() {
        const prevBtn = document.getElementById('chartPrev');
        const nextBtn = document.getElementById('chartNext');

        prevBtn.disabled = currentStartIndex <= 0;
        nextBtn.disabled = currentStartIndex + studentsPerView >= totalStudents;

        if (currentStartIndex <= 0) {
            prevBtn.classList.add('disabled');
        } else {
            prevBtn.classList.remove('disabled');
        }

        if (currentStartIndex + studentsPerView >= totalStudents) {
            nextBtn.classList.add('disabled');
        } else {
            nextBtn.classList.remove('disabled');
        }
    }

    // Event listeners untuk navigation
    document.getElementById('chartPrev').addEventListener('click', function() {
        if (currentStartIndex > 0) {
            currentStartIndex = Math.max(0, currentStartIndex - studentsPerView);
            renderChart(currentStartIndex);
        }
    });

    document.getElementById('chartNext').addEventListener('click', function() {
        if (currentStartIndex + studentsPerView < totalStudents) {
            currentStartIndex = Math.min(totalStudents - studentsPerView, currentStartIndex +
                studentsPerView);
            renderChart(currentStartIndex);
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'SELECT') {
            if (e.key === 'ArrowLeft' && currentStartIndex > 0) {
                currentStartIndex = Math.max(0, currentStartIndex - studentsPerView);
                renderChart(currentStartIndex);
            } else if (e.key === 'ArrowRight' && currentStartIndex + studentsPerView < totalStudents) {
                currentStartIndex = Math.min(totalStudents - studentsPerView, currentStartIndex +
                    studentsPerView);
                renderChart(currentStartIndex);
            }
        }
    });

    // Initial render
    renderChart(currentStartIndex);
});
</script>

<style>
.chart-wrapper {
    padding: 20px;
}

.chart-controls {
    flex-wrap: wrap;
    gap: 8px;
}

.chart-controls .btn {
    min-width: 36px;
    height: 36px;
    border-radius: 6px;
    transition: all 0.2s ease;
    border-color: #3B82F6;
    color: #3B82F6;
}

.chart-controls .btn:hover:not(.disabled) {
    background-color: #3B82F6;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
}

.chart-controls .btn.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

.chart-controls .btn i {
    font-size: 14px;
}

#rankChart {
    background: white;
    border-radius: 8px;
    min-height: 400px;
    width: 100%;
}

.apexcharts-canvas {
    background: white !important;
    border-radius: 8px;
}

.apexcharts-tooltip {
    border-radius: 8px !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
}

/* Memastikan semua elemen chart terlihat penuh */
.apexcharts-svg {
    overflow: visible !important;
}

.apexcharts-xaxis-texts-g text {
    text-anchor: middle !important;
    dominant-baseline: hanging !important;
}

@media (max-width: 768px) {
    .chart-wrapper {
        padding: 15px;
        border-radius: 8px;
    }

    .chart-controls {
        justify-content: center;
        width: 100%;
        margin-top: 10px;
    }

    .chart-controls .text-muted {
        order: -1;
        width: 100%;
        text-align: center;
        font-size: 12px;
        margin-bottom: 8px;
    }

    .chart-controls .btn-group {
        flex-shrink: 0;
    }

    #rankChart {
        min-height: 350px;
    }
}

@media (max-width: 576px) {
    .px-3.py-3 {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 15px;
    }

    .chart-controls {
        align-self: stretch;
        justify-content: space-between;
    }
}

/* Custom scrollbar untuk chart area jika diperlukan */
.chart-wrapper::-webkit-scrollbar {
    height: 6px;
}

.chart-wrapper::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.chart-wrapper::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.chart-wrapper::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endsection