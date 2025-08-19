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
            <div class="alert alert-info">
                Tidak ada data penugasan untuk bulan {{ $namaBulan }}
            </div>
            @endif
        </div>
    </div>
</section>

<section class="section">
    <div class="card">
        <div class='px-3 py-3 d-flex justify-content-between'>
            <h6 class='card-title'>Grafik Rank Siswa</h6>
        </div>
        <div class="card-body">
            <div class="mb-5">
                <h6 class="text-center mb-3">Peringkat Siswa - {{ $namaBulan }}</h6>
                <div id="rankChart"></div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the data passed from controller
    const chartData = @json($chartData);

    // Ambil data semua siswa (sudah diurutkan dari controller berdasarkan rank)
    const allStudents = chartData.rankData;
    const siswaWithRank = allStudents.filter(student => student.rank !== null);
    const siswaTanpaRank = allStudents.filter(student => student.rank === null);

    // Jika tidak ada siswa dengan rank, tampilkan pesan
    if (siswaWithRank.length === 0) {
        document.getElementById('rankChart').innerHTML =
            '<div class="alert alert-info text-center">Tidak ada data rank untuk ditampilkan pada bulan ini</div>';
        return;
    }

    // Prepare data untuk chart (semua siswa)
    const categories = allStudents.map(student => student.name);
    const rankValues = allStudents.map(student => student.rank);

    // Dapatkan rank tertinggi untuk menentukan maksimum Y-axis
    const validRanks = rankValues.filter(rank => rank !== null);
    const maxRank = validRanks.length > 0 ? Math.max(...validRanks) : 1;

    // Konfigurasi ApexCharts Line Chart
    const rankChartOptions = {
        series: [{
            name: 'Peringkat',
            data: rankValues
        }],
        chart: {
            type: 'line',
            height: 450,
            toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true
                }
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
            size: function(val, opts) {
                // Siswa tanpa rank tidak ditampilkan markernya
                return rankValues[opts.dataPointIndex] !== null ? 6 : 0;
            },
            strokeWidth: 2,
            strokeColors: '#fff',
            fillOpacity: 1,
            hover: {
                size: 8
            }
        },
        xaxis: {
            categories: categories,
            title: {
                text: 'Nama Siswa',
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },
            labels: {
                rotate: -45,
                style: {
                    fontSize: '11px'
                },
                trim: true,
                maxHeight: 120
            }
        },
        yaxis: {
            title: {
                text: 'Peringkat',
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },
            reversed: true, // Rank 1 di atas, rank terburuk di bawah
            min: 1,
            max: maxRank,
            forceNiceScale: true,
            labels: {
                formatter: function(val) {
                    return 'Rank ' + Math.round(val);
                }
            },
            tickAmount: Math.min(maxRank - 1, 10) // Batasi jumlah tick maksimal 10
        },
        tooltip: {
            y: {
                formatter: function(val, opts) {
                    const studentName = categories[opts.dataPointIndex];
                    const studentData = allStudents.find(s => s.name === studentName);

                    if (val === null || !studentData.memiliki_nilai) {
                        return `
                            <div>
                                <strong>Tidak memiliki rank</strong><br>
                                Total Nilai: 0
                            </div>
                        `;
                    }

                    return `
                        <div>
                            <strong>Peringkat: ${val}</strong><br>
                            Total Nilai: ${studentData.total_nilai ? studentData.total_nilai.toLocaleString() : '0'}
                        </div>
                    `;
                }
            },
            x: {
                show: true
            }
        },
        grid: {
            borderColor: '#e7e7e7',
            strokeDashArray: 3,
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: true
                }
            }
        },
        colors: ['#3B82F6'],
        dataLabels: {
            enabled: true,
            formatter: function(val, opts) {
                // Hanya tampilkan label untuk siswa yang memiliki rank
                if (val === null) {
                    return '';
                }
                return 'Rank ' + Math.round(val);
            },
            style: {
                fontSize: '10px',
                colors: ['#fff'],
                fontWeight: 'bold'
            },
            background: {
                enabled: true,
                foreColor: '#3B82F6',
                borderRadius: 3,
                padding: 4,
                opacity: 0.9,
                borderWidth: 1,
                borderColor: '#3B82F6'
            },
            offsetY: -10
        },
        title: {
            text: `Grafik Peringkat Siswa (${siswaWithRank.length} dari ${allStudents.length} siswa memiliki rank)`,
            align: 'center',
            style: {
                fontSize: '16px',
                fontWeight: 'bold'
            }
        },
        subtitle: {
            text: siswaTanpaRank.length > 0 ?
                `${siswaTanpaRank.length} siswa tidak memiliki nilai (diurutkan berdasarkan rank)` :
                'Diurutkan berdasarkan rank terbaik ke terburuk',
            align: 'center',
            style: {
                fontSize: '12px',
                color: '#999'
            }
        }
    };

    // Render chart
    const rankChart = new ApexCharts(document.querySelector("#rankChart"), rankChartOptions);
    rankChart.render();

    // Responsive handling
    window.addEventListener('resize', function() {
        rankChart.updateOptions({
            chart: {
                height: window.innerWidth < 768 ? 350 : 450
            },
            xaxis: {
                labels: {
                    rotate: window.innerWidth < 768 ? -90 : -45
                }
            }
        });
    });
});
</script>
@endsection