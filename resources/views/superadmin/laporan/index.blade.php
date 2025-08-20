@extends('layouts._index')

@section('content')
<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Laporan Bulanan - {{ $namaBulan }}</h6>
            <div class="card-right d-flex align-items-center">
                <form method="GET" action="{{ route('laporan.index') }}" class="d-flex gap-2">
                    <select name="bulan" class="form-select" required>
                        @foreach($bulanNames as $num => $name)
                        <option value="{{ $num }}" {{ $num == $bulan ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    <select name="tahun" class="form-select" required>
                        @for($i = date('Y') - 2; $i <= date('Y') + 2; $i++) <option value="{{ $i }}"
                            {{ $i == $tahun ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
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
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Grafik Rank Siswa - {{ $namaBulan }}</h6>
        </div>
        <div class="card-body">
            <div class="mb-5">
                <div id="rankChart"></div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
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

    console.log('Proceeding to render chart...');

    // Filter data
    const rankedStudents = allStudents.filter(s => s.rank !== null);
    const unrankedStudents = allStudents.filter(s => s.rank === null);
    const existingRanks = [...new Set(rankedStudents.map(s => s.rank))].sort((a, b) => a - b);
    const maxRank = existingRanks.length > 0 ? Math.max(...existingRanks) : 0;

    // Konfigurasi grafik
    const rankChartOptions = {
        series: [{
            name: 'Peringkat',
            data: allStudents.map(student => ({
                x: student.name,
                y: student.rank !== null ? student.rank : maxRank + 1,
                rank: student.rank !== null ? student.rank : 'N/R',
                totalNilai: student.total_nilai || 0
            }))
        }],
        chart: {
            type: 'line',
            height: 500,
            toolbar: {
                show: true
            }
        },
        colors: ['#3B82F6'],
        stroke: {
            width: 3,
            curve: 'smooth'
        },
        markers: {
            size: 7,
            colors: allStudents.map(s => s.rank !== null ? '#3B82F6' : '#94A3B8')
        },
        xaxis: {
            categories: allStudents.map(s => s.name),
            labels: {
                rotate: -45,
                style: {
                    colors: allStudents.map(s => s.rank !== null ? '#374151' : '#94A3B8'),
                    fontSize: '11px'
                }
            }
        },
        yaxis: {
            title: {
                text: ''
            },
            labels: {
                show: false
            },
            min: 1, // Set minimum ke 1 (rank terbaik)
            max: maxRank > 0 ? maxRank + 1 : 2, // Set maksimum sesuai rank terburuk + unranked
            reversed: true, // Rank 1 di atas, rank besar di bawah
            forceNiceScale: false,
            show: false,
            // Hilangkan padding atas dan bawah
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        tooltip: {
            enabled: true,
            shared: false,
            followCursor: true,
            custom: function({
                series,
                seriesIndex,
                dataPointIndex,
                w
            }) {
                const student = allStudents[dataPointIndex];
                return '<div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">' +
                    student.name + '</div>' +
                    '<div class="apexcharts-tooltip-series-group apexcharts-active" style="order: 1; display: flex; flex-direction: column;">' +
                    '<span class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">' +
                    '<strong>Peringkat:</strong> ' + (student.rank !== null ? student.rank : 'N/R') +
                    '</span>' +
                    '<span class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">' +
                    '<strong>Total Nilai:</strong> ' + (student.total_nilai || 0) +
                    '</span>' +
                    '</div>';
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function(val, opts) {
                const student = allStudents[opts.dataPointIndex];
                return student.rank !== null ? student.rank : 'N/R';
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
                    return allStudents[dataPointIndex].rank !== null ? '#3B82F6' : '#94A3B8';
                },
                borderRadius: 2,
                padding: 4,
                opacity: 0.9,
                borderWidth: 1,
                borderColor: function({
                    dataPointIndex
                }) {
                    return allStudents[dataPointIndex].rank !== null ? '#3B82F6' : '#94A3B8';
                },
                dropShadow: {
                    enabled: false
                }
            }
        },
        grid: {
            yaxis: {
                lines: {
                    show: false
                }
            },
            xaxis: {
                lines: {
                    show: true
                }
            },
            padding: {
                top: 0,
                bottom: 0,
                left: 0,
                right: 0
            }
        },
        // Hilangkan margin chart untuk posisi marker yang tepat
        chart: {
            type: 'line',
            height: 500,
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
        }
    };

    const rankChart = new ApexCharts(document.querySelector("#rankChart"), rankChartOptions);
    rankChart.render();
});
</script>
@endsection